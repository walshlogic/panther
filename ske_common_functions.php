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

    // Ensure the sequential number is always 6 digits long
    $formattedSequentialNumber = str_pad($sequentialNumber, 7, '0', STR_PAD_LEFT);

    return $formattedSequentialNumber;
}

function generateFolderName($uniqueID)
{
    $secondSet = substr($uniqueID, 2, 2); // MM - 2nd set of 2 digits
    $thirdSet = substr($uniqueID, 4, 2); // XX - 3rd set of 2 digits
    $firstSet = substr($uniqueID, 0, 2); // YY - 1st set of 2 digits
    return $secondSet . $thirdSet . $firstSet;
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

function createDirectory($path)
{
    if (!is_dir($path)) {
        if (!mkdir($path, 0755, true)) {
            //echo "Failed to create directory {$path}\n";
        }
    }
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
            //echo "Database update failed: " . json_encode($stmt->errorInfo()) . "\n";
        }
    }
    catch (PDOException $e) {
        //echo "Database update error: " . $e->getMessage() . "\n";
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

    $updatesForReImages = [];

    foreach ($files as $file) {
        $fileInfo = pathinfo($file);
        $filePrefix = explode('_', $fileInfo['filename'])[0];

        // Fetch the PID (REM_PID) based on the VID from the SQL table (REAL_PROP.REALMAST)
        $query = "SELECT REM_PID, REM_ACCT_NUM AS PID FROM REAL_PROP.REALMAST WHERE REM_PID = :vid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':vid', $filePrefix, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && isset($row['PID'])) {
            $REM_PID = $row['REM_PID']; // Store REM_PID

            $newPrefix = $row['PID'];
            $fileExtension = $fileInfo['extension'];

            $sequentialNumber = generateUniqueID($newPrefix, $conn);
            $newFileName = "{$newPrefix}.S{$sequentialNumber}.{$fileExtension}";

            // Fetch the BID based on the VID from the SQL table (REAL_PROP.REIMAGES)
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

                // Insert into REAL_PROP.REIMAGES
                insertRealMast_Reimages($conn, $newFileName, $REM_PID, $newBid, $sequentialNumber);

                $uniqueID = generateUniqueID($newPrefix, $conn);

                // Insert into COMMON.REIMAGESIMAGES
                insertCommonReimages($conn, $newFileName, $sequentialNumber, $newFilePath, $uniqueID);

                $updatesForReImages[] = [
                    'oldFilePath' => $file,
                    'newFilePath' => $newFilePath,
                    'newFileName' => $newFileName,
                    'newBid' => $newBid,
                    'REM_PID' => $REM_PID,
                    'REM_ID' => $sequentialNumber,
                ];
            }
        }
    }

    return $updatesForReImages;
}

function insertRealMast_Reimages($conn, $newFileName, $RIM_PID, $newBid, $REM_ID)
{
    // Calculate the next RIM_LINE_NUM
    $highestLineNumQuery = "SELECT MAX(RIM_LINE_NUM) AS max_line_num FROM REAL_PROP.REIMAGES WHERE RIM_PID = :RIM_PID AND RIM_BID = :RIM_BID";
    $stmtHighestLineNum = $conn->prepare($highestLineNumQuery);
    $stmtHighestLineNum->bindParam(':RIM_PID', $RIM_PID, PDO::PARAM_STR);
    $stmtHighestLineNum->bindParam(':RIM_BID', $newBid, PDO::PARAM_STR);
    $stmtHighestLineNum->execute();
    $rowHighestLineNum = $stmtHighestLineNum->fetch(PDO::FETCH_ASSOC);

    if ($rowHighestLineNum && isset($rowHighestLineNum['max_line_num'])) {
        $nextRimLineNum = $rowHighestLineNum['max_line_num'] + 1;
    } else {
        // If no existing records, start with 1
        $nextRimLineNum = 1;
    }

    // Use the $newFileName parameter directly in your SQL query
    $myRIM_MNC = 11054;
    $myRIM_TYPE = 'SKETCH';
    $myRIM_SUBTYPE = 'JPG';
    $myRIM_DESC = "SKETCH UPLOAD";
    $myRIM_FILE_NAME = $newFileName; // Use the parameter directly
    $myRIM_INTRNL_NOTE = 'PANTHER SYSTEM';
    $myRIM_IS_PPROP = 0;
    $myRIM_ISPRIMARY = 0;
    $myRIM_STATUS_DATE = date('Y-m-d H:i:s.v');
    $myRIM_IMG_DATE = date('Y-m-d H:i:s.v');
    $myRIM_CREATE_DATE = date('Y-m-d H:i:s.v');
    $myRIM_LAST_UPDATE = date('Y-m-d H:i:s.v');

    $insertQuery = "INSERT INTO REAL_PROP.REIMAGES 
                   (RIM_MNC, RIM_PID, RIM_BID, RIM_TYPE, RIM_SUBTYPE, RIM_DESC, RIM_FILE_NAME, RIM_INTRNL_NOTE, RIM_IS_PPROP, RIM_ISPRIMARY, RIM_STATUS_DATE, RIM_IMG_DATE, RIM_CREATE_DATE, RIM_LAST_UPDATE, RIM_ID, RIM_LINE_NUM) 
                   VALUES 
                   (:RIM_MNC, :RIM_PID, :RIM_BID, :RIM_TYPE, :RIM_SUBTYPE, :RIM_DESC, :RIM_FILE_NAME, :RIM_INTRNL_NOTE, :RIM_IS_PPROP, :RIM_ISPRIMARY, :RIM_STATUS_DATE, :RIM_IMG_DATE, :RIM_CREATE_DATE, :RIM_LAST_UPDATE, :RIM_ID, :RIM_LINE_NUM)";

    // Prepare the insert statement
    $stmt = $conn->prepare($insertQuery);

    // Bind values to placeholders
    $stmt->bindParam(':RIM_MNC', $myRIM_MNC, PDO::PARAM_INT);
    $stmt->bindParam(':RIM_PID', $RIM_PID, PDO::PARAM_STR);
    $stmt->bindParam(':RIM_BID', $newBid, PDO::PARAM_STR);
    $stmt->bindParam(':RIM_TYPE', $myRIM_TYPE, PDO::PARAM_STR);
    $stmt->bindParam(':RIM_SUBTYPE', $myRIM_SUBTYPE, PDO::PARAM_STR);
    $stmt->bindParam(':RIM_DESC', $myRIM_DESC, PDO::PARAM_STR);
    $stmt->bindParam(':RIM_FILE_NAME', $myRIM_FILE_NAME, PDO::PARAM_STR);
    $stmt->bindParam(':RIM_INTRNL_NOTE', $myRIM_INTRNL_NOTE, PDO::PARAM_STR);
    $stmt->bindParam(':RIM_IS_PPROP', $myRIM_IS_PPROP, PDO::PARAM_INT);
    $stmt->bindParam(':RIM_ISPRIMARY', $myRIM_ISPRIMARY, PDO::PARAM_INT);
    $stmt->bindParam(':RIM_STATUS_DATE', $myRIM_STATUS_DATE, PDO::PARAM_STR);
    $stmt->bindParam(':RIM_IMG_DATE', $myRIM_IMG_DATE, PDO::PARAM_STR);
    $stmt->bindParam(':RIM_CREATE_DATE', $myRIM_CREATE_DATE, PDO::PARAM_STR);
    $stmt->bindParam(':RIM_LAST_UPDATE', $myRIM_LAST_UPDATE, PDO::PARAM_STR);
    $stmt->bindParam(':RIM_ID', $REM_ID, PDO::PARAM_INT);
    $stmt->bindParam(':RIM_LINE_NUM', $nextRimLineNum, PDO::PARAM_INT);

    // Execute the insert
    $stmt->execute();
}
function insertCommonReimages($conn, $newFileName, $REM_ID, $newFilePath, $uniqueID)
{
    $myRIM_MNC = 11054;
    $myRIM_IMAGE = null;
    $myRIM_LOCATION_TYPE = 'F';
    $myRIM_CREATE_DATE = date('Y-m-d H:i:s.v');
    $myRIM_LAST_UPDATE = date('Y-m-d H:i:s.v');
    $myRIM_ISPRIMARY = 0;

    // Extract the folder name based on the 2nd, 3rd, and 1st set of 2 digits in the new file name
    $folderName = substr($newFileName, 3, 2) . substr($newFileName, 6, 2) . substr($newFileName, 0, 2);

    // Concatenate the directory name and the new file name with a directory separator
    $myRIM_LOCATION = $folderName . DIRECTORY_SEPARATOR . $newFileName;

    // Log the values to the server's error log for verification
    error_log('myRIM_MNC: ' . $myRIM_MNC);
    error_log('myRIM_IMAGE: ' . $myRIM_IMAGE);
    error_log('myRIM_LOCATION: ' . $myRIM_LOCATION);
    error_log('myRIM_LOCATION_TYPE: ' . $myRIM_LOCATION_TYPE);
    error_log('myRIM_CREATE_DATE: ' . $myRIM_CREATE_DATE);
    error_log('myRIM_LAST_UPDATE: ' . $myRIM_LAST_UPDATE);
    error_log('myRIM_ISPRIMARY: ' . $myRIM_ISPRIMARY);
    error_log('newFilePath: ' . $newFilePath);
    error_log('uniqueID: ' . $uniqueID);

    $insertQuery = "INSERT INTO COMMON.REIMAGESIMAGE 
                   (RIM_MNC, RIM_ID, RIM_IMAGE, RIM_LOCATION, RIM_LOCATION_TYPE, RIM_CREATE_DATE, RIM_LAST_UPDATE, RIM_ISPRIMARY) 
                   VALUES 
                   (:RIM_MNC, :RIM_ID, :RIM_IMAGE, :RIM_LOCATION, :RIM_LOCATION_TYPE, :RIM_CREATE_DATE, :RIM_LAST_UPDATE, :RIM_ISPRIMARY)";

    $stmt = $conn->prepare($insertQuery);

    $stmt->bindParam(':RIM_MNC', $myRIM_MNC, PDO::PARAM_INT);
    $stmt->bindParam(':RIM_ID', $REM_ID, PDO::PARAM_STR);
    $stmt->bindParam(':RIM_IMAGE', $myRIM_IMAGE, PDO::PARAM_STR);
    $stmt->bindParam(':RIM_LOCATION', $myRIM_LOCATION, PDO::PARAM_STR);
    $stmt->bindParam(':RIM_LOCATION_TYPE', $myRIM_LOCATION_TYPE, PDO::PARAM_STR);
    $stmt->bindParam(':RIM_CREATE_DATE', $myRIM_CREATE_DATE, PDO::PARAM_STR);
    $stmt->bindParam(':RIM_LAST_UPDATE', $myRIM_LAST_UPDATE, PDO::PARAM_STR);
    $stmt->bindParam(':RIM_ISPRIMARY', $myRIM_ISPRIMARY, PDO::PARAM_INT);

    $stmt->execute();
}

?>