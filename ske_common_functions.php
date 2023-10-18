<?php
function getUniqueCounter($prefix)
{
    global $prefixCounter;
    if (isset($prefixCounter[$prefix])) {
        $prefixCounter[$prefix]++;
    } else {
        $prefixCounter[$prefix] = 1;
    }
    return str_pad($prefixCounter[$prefix], 2, '0', STR_PAD_LEFT);
}
function generateUniqueID($filePrefix, $conn)
{
    global $prefixCounter;
    // Fetch the current sequential number and last update timestamp from the database
    $query = "SELECT SEQ_IMAGE_ID, SEQ_LAST_UPDATE FROM COMMON.SEQUENCES";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $sequentialNumber = $row['SEQ_IMAGE_ID'];
    $lastUpdateTimestamp = $row['SEQ_LAST_UPDATE'];
    // Increment the sequential number
    $sequentialNumber++;
    // Update the database with the new sequential number and last update timestamp
    $currentTimestamp = date('Y-m-d H:i:s.v');
    $updateQuery = "UPDATE COMMON.SEQUENCES SET SEQ_IMAGE_ID = :sequentialNumber, SEQ_LAST_UPDATE = :currentTimestamp";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bindParam(':sequentialNumber', $sequentialNumber, PDO::PARAM_INT);
    $updateStmt->bindParam(':currentTimestamp', $currentTimestamp, PDO::PARAM_STR);
    $updateStmt->execute();
    // Ensure the sequential number is always 7 digits long
    $formattedSequentialNumber = str_pad($sequentialNumber, 7, '0', STR_PAD_LEFT);
    return $formattedSequentialNumber;
}
function generateFolderName($uniqueID)
{
    $secondSet = substr($uniqueID, 2, 2); // 2nd set of 2 digits
    $thirdSet = substr($uniqueID, 4, 2); // 3rd set of 2 digits
    $firstSet = substr($uniqueID, 0, 2); // 1st set of 2 digits
    return $secondSet . $thirdSet . $firstSet;
}
function createBackup($filePath, $backupDirectory)
{
    if (!is_dir($backupDirectory)) {
        createDirectory($backupDirectory);
    }
    $backupFilePath = $backupDirectory . basename($filePath);
    if (!copy($filePath, $backupFilePath)) {
        //echo "Failed to create backup for {$filePath}\n";
    }
}
function createDirectory($path)
{
    if (!is_dir($path)) {
        if (!mkdir($path, 0755, true)) {
            //echo "Failed to create directory {$path}\n";
        }
    }
}
function readCsvData($filePath)
{
    $csvData = [];
    if (($handle = fopen($filePath, "r")) !== false) {
        fgetcsv($handle); // Skip header
        while (($data = fgetcsv($handle)) !== false) {
            [$oldPrefix, $newPrefix] = $data;
            $csvData[$oldPrefix] = $newPrefix;
        }
        fclose($handle);
    } else {
        //echo "Failed to open CSV file at {$filePath}\n";
    }
    return $csvData;
}
function renameFile($oldFilePath, $newFilePath)
{
    if (rename($oldFilePath, $newFilePath)) {
        return true;
    } else {
        //echo "Failed to rename {$oldFilePath} to {$newFilePath}\n";
        return false;
    }
}
function updateDatabase($pdo, $oldFilePath, $newFilePath, $newFileName, $bid)
{
    try {
        $sql = "UPDATE REAL_PROP.REIMAGES SET 
            RIM_FILE_PATH = :newFilePath,
            RIM_LAST_UPDATE = :lastUpdate,
            RIM_SUBTYPE = :subtype,
            RIM_DESC = :description,
            RIM_FILE_NAME = :filename,
            RIM_INTRNL_NOTE = :internalNote,
            RIM_ISPRIMARY = :isPrimary,
            RIM_CREATE_DATE = :createDate,
            RIM_BID = :bid
            WHERE RIM_FILE_PATH = :oldFilePath";
        $stmt = $pdo->prepare($sql);

        $lastUpdate = date("Y-m-d H:i:s");
        $subtype = "JPG";
        $description = "PANTHER SKETCH UPLOAD";
        $internalNote = "Panther Upload";
        $isPrimary = "0";
        $createDate = $lastUpdate; // Assuming the create date to be the same as the last update

        // Logging for debugging
        //echo "Attempting to update Database.\n";
        //echo "SQL Query: $sql\n";
        //echo "Old File Path: $oldFilePath\n";
        //echo "New File Path: $newFilePath\n";
        //echo "New File Name: $newFileName\n";
        //echo "BID: $bid\n";

        $stmt->bindParam(":newFilePath", $newFilePath, PDO::PARAM_STR);
        $stmt->bindParam(":lastUpdate", $lastUpdate, PDO::PARAM_STR);
        $stmt->bindParam(":subtype", $subtype, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":filename", $newFileName, PDO::PARAM_STR);
        $stmt->bindParam(":internalNote", $internalNote, PDO::PARAM_STR);
        $stmt->bindParam(":isPrimary", $isPrimary, PDO::PARAM_STR);
        $stmt->bindParam(":createDate", $createDate, PDO::PARAM_STR);
        $stmt->bindParam(":oldFilePath", $oldFilePath, PDO::PARAM_STR);
        $stmt->bindParam(":bid", $bid, PDO::PARAM_STR); // Bind the BID parameter
        if ($stmt->execute()) {
            //echo "Database updated successfully.\n";
        } else {
            print_r("Database update failed for file $oldFilePath.");
            print_r($stmt->errorInfo());
        }
    }
    catch (PDOException $e) {
        print_r("Caught Exception: " . $e->getMessage());
    }
}


function updateRealMastTable($conn, $vid, $newBid)
{
    try {
        $sql = "UPDATE REAL_PROP.REALMAST SET RIM_BID = :newBid WHERE REM_PID = :vid";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':newBid', $newBid, PDO::PARAM_STR);
        $stmt->bindParam(':vid', $vid, PDO::PARAM_STR);
        $stmt->execute();
        //echo "REALMAST table updated successfully for VID: {$vid}\n";
    }
    catch (PDOException $e) {
        //echo "Database update error: " . $e->getMessage() . "\n";
    }
}

function batchRenameCopyMoveAndUpdateDatabase($files, $conn)
{
    global $prefixCounter;

    // Define log file path
    $logFilePath = '/mnt/paphotos/photos/zPantherErrorLog/Sketchdebug_log.txt';

    $updatesForReImages = [];

    foreach ($files as $file) {
        // Logging the current file being processed
        file_put_contents($logFilePath, "Processing file: " . $file . PHP_EOL, FILE_APPEND);

        $fileInfo = pathinfo($file);
        $filePrefix = explode('_', $fileInfo['filename'])[0];

        $query = "SELECT REM_ACCT_NUM AS PID FROM REAL_PROP.REALMAST WHERE REM_PID = :vid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':vid', $filePrefix, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && isset($row['PID'])) {
            $newPrefix = $row['PID'];
            $fileExtension = $fileInfo['extension'];

            $sequentialNumber = generateUniqueID($newPrefix, $conn);
            $newFileName = "{$newPrefix}.S{$sequentialNumber}.{$fileExtension}";

            $bidQuery = "SELECT RIM_BID FROM REAL_PROP.REIMAGES WHERE RIM_PID = :vid";
            $stmtBid = $conn->prepare($bidQuery);
            $stmtBid->bindParam(':vid', $filePrefix, PDO::PARAM_STR);
            $stmtBid->execute();
            $rowBid = $stmtBid->fetch(PDO::FETCH_ASSOC);

            if ($rowBid && isset($rowBid['RIM_BID'])) {
                $newBid = $rowBid['RIM_BID'];

                $folderName = substr($newPrefix, 3, 2) . substr($newPrefix, 6, 2) . substr($newPrefix, 0, 2);
                $folderName = FINAL_DIRECTORY_PATH . $folderName;
                createDirectory($folderName);

                $newFilePath = $folderName . '/' . $newFileName;

                renameFile($file, $newFilePath);

                $updatesForReImages[] = [
                    'oldFilePath' => $file,
                    'newFilePath' => $newFilePath,
                    'newFileName' => $newFileName,
                    'newBid' => $newBid,
                ];

                // Logging the new file name
                file_put_contents($logFilePath, "Processed file: " . $file . " with new file name: " . $newFileName . PHP_EOL, FILE_APPEND);
            } else {
                // Logging if no matching BID found
                file_put_contents($logFilePath, "No matching BID found for VID: " . $filePrefix . PHP_EOL, FILE_APPEND);
            }
        } else {
            // Logging if no matching PID found
            file_put_contents($logFilePath, "No matching PID found for VID: " . $filePrefix . PHP_EOL, FILE_APPEND);
        }
    }

    // Logging the completion of batch processing
    file_put_contents($logFilePath, "Completed batch processing. Total files processed: " . count($files) . PHP_EOL, FILE_APPEND);

    // Now that we have gathered all updates, update REAL_PROP.REIMAGES table
    foreach ($updatesForReImages as $update) {
        updateDatabase($conn, $update['oldFilePath'], $update['newFilePath'], $update['newFileName'], $update['newBid']);
    }

    return $updatesForReImages;
}


?>