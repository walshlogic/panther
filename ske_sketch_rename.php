<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db/dbconn_vision.php';

define('CSV_FILE_PATH', './ske_RealProp.csv');
define('DIRECTORY_PATH', '/mnt/paphotos/Sketches/');
define('FINAL_DIRECTORY_PATH', '/mnt/paphotos/zSketchesDumpTest/');
define('SKETCH_IDENTIFIER', 'S');
define('BACKUP_DIRECTORY', '/mnt/paphotos/SketchFinal/OriginalBackups/');
// Add the counter file path as a constant
define('COUNTER_FILE', './counter.txt');

try {
    $dbConnection = Connection::getInstance();
    $conn = $dbConnection->getConnection();
}
catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}

function createBackup($filePath, $backupDirectory)
{
    if (!is_dir($backupDirectory)) {
        createDirectory($backupDirectory);
    }
    $backupFilePath = $backupDirectory . basename($filePath);
    if (!copy($filePath, $backupFilePath)) {
        echo "Failed to create backup for {$filePath}\n";
    }
}

function createDirectory($path)
{
    if (!is_dir($path)) {
        if (!mkdir($path, 0755, true)) {
            echo "Failed to create directory {$path}\n";
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
        echo "Failed to open CSV file at {$filePath}\n";
    }
    return $csvData;
}

// New function to get and update counter
function getCounterValue($counterFile)
{
    $counter = 0;
    if (file_exists($counterFile)) {
        $counter = file_get_contents($counterFile);
    }
    $counter = ($counter + 1) % 100;
    file_put_contents($counterFile, $counter);
    return str_pad($counter, 2, '0', STR_PAD_LEFT);
}


function generateNewFileName($csvData, $fileInfo, $counterFile)
{
    $filePrefix = explode('_', $fileInfo['filename'])[0];
    if (isset($csvData[$filePrefix])) {
        $newPrefix = $csvData[$filePrefix];
        $fileExtension = $fileInfo['extension'];

        // Generate the unique 6-character identifier
        $year = date('y');
        $month = date('m');
        $counter = getCounterValue($counterFile);
        $uniqueID = $year . $month . $counter;

        return sprintf("%s.%s.%s.%s", $newPrefix, SKETCH_IDENTIFIER, $uniqueID, $fileExtension);
    }
    return false;
}

function renameFile($oldFilePath, $newFilePath)
{
    if (rename($oldFilePath, $newFilePath)) {
        return true;
    } else {
        echo "Failed to rename {$oldFilePath} to {$newFilePath}\n";
        return false;
    }
}

function copyFileToDestination($srcPath, $destPath)
{
    if (copy($srcPath, $destPath)) {
        return true;
    } else {
        echo "Failed to copy {$srcPath} to {$destPath}\n";
        return false;
    }
}

function updateDatabase($pdo, $oldFilePath, $newFilePath)
{
    try {
        $sql = "UPDATE REAL_PROP.REIMAGES SET 
            RIM_FILE_PATH = :newFilePath,
            RIM_LAST_UPDATE = :lastUpdate
            WHERE RIM_FILE_PATH = :oldFilePath";
        $stmt = $pdo->prepare($sql);

        $lastUpdate = date("Y-m-d H:i:s");

        $stmt->bindParam(":newFilePath", $newFilePath, PDO::PARAM_STR);
        $stmt->bindParam(":lastUpdate", $lastUpdate, PDO::PARAM_STR);
        $stmt->bindParam(":oldFilePath", $oldFilePath, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Database updated successfully\n";
        } else {
            echo "Database update failed: " . json_encode($stmt->errorInfo()) . "\n";
        }
    }
    catch (PDOException $e) {
        echo "Database update error: " . $e->getMessage() . "\n";
    }
}



function batchRenameCopyMoveAndUpdateCsv($files, $csvData, $conn)
{
    $uniqueFolderNames = [];

    foreach ($files as $file) {
        $fileInfo = pathinfo($file);
        $counterFilePath = COUNTER_FILE;
        $newFileName = generateNewFileName($csvData, $fileInfo, $counterFilePath);

        echo "Generated new file name: " . $newFileName . "\n";

        if ($newFileName) {
            $oldFilePath = $file;
            $newFilePath = $fileInfo['dirname'] . DIRECTORY_SEPARATOR . $newFileName;

            createBackup($oldFilePath, BACKUP_DIRECTORY);

            $renameSuccess = renameFile($oldFilePath, $newFilePath);

            if ($renameSuccess) {
                $folderName = substr($newFileName, 3, 2) . substr($newFileName, 6, 2) . substr($newFileName, 0, 2);
                $uniqueFolderNames[] = $folderName;

                updateDatabase($conn, $oldFilePath, $newFilePath);

                $finalFolderPath = FINAL_DIRECTORY_PATH . $folderName . DIRECTORY_SEPARATOR;
                createDirectory($finalFolderPath);

                $finalFilePath = $finalFolderPath . $newFileName;

                if (!file_exists($finalFilePath)) {
                    if (rename($newFilePath, $finalFilePath)) {
                        echo "Successfully moved {$newFilePath} to {$finalFilePath}\n";
                    } else {
                        echo "Failed to move {$newFilePath} to {$finalFilePath}\n";
                    }
                } else {
                    echo "File {$finalFilePath} already exists. Skipped moving.\n";
                }
            }
        }
    }

    echo "Unique folder names generated: " . implode(", ", $uniqueFolderNames) . "\n";

    return $uniqueFolderNames;
}


try {
    $files = glob(DIRECTORY_PATH . '*.*');
    if (!$files || empty($files)) {
        echo json_encode(["status" => "completed", "message" => "No more files to process."]);
        exit;
    }

    $csvData = readCsvData(CSV_FILE_PATH);

    if (!$csvData || empty($csvData)) {
        throw new Exception("Failed to read or parse the CSV file.");
    }

    batchRenameCopyMoveAndUpdateCsv($files, $csvData, $conn);
    echo json_encode(["status" => "success", "message" => "Processing completed successfully"]);
}
catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "An error occurred: " . $e->getMessage()]);
}
finally {
    $conn = null;
}
?>