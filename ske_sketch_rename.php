<?php
// Turn on error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db/dbconn_vision.php';

// Constants
define('CSV_FILE_PATH', './ske_RealProp.csv');
define('DIRECTORY_PATH', '/mnt/paphotos/Sketches/');
define('FINAL_DIRECTORY_PATH', '/mnt/paphotos/SketchFinal/');
define('SKETCH_IDENTIFIER', 'S');
define('BACKUP_DIRECTORY', '/mnt/paphotos/SketchFinal/OriginalBackups/');

// Initialize database connection and handle errors
try {
    $dbConnection = Connection::getInstance();
    $conn = $dbConnection->getConnection();
}
catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}

$startNumericCounter = 1; // or any default starting point

////
function createBackup($filePath, $backupDirectory)
{
    if (!is_dir($backupDirectory)) {
        createDirectory($backupDirectory);
    }
    $backupFilePath = $backupDirectory . basename($filePath);
    if (!copy($filePath, $backupFilePath)) {
        //logMessage("Failed to create backup for: $filePath");
    }
}

////
function createDirectory($path)
{
    if (!is_dir($path)) {
        if (!mkdir($path, 0755, true)) {
            //logMessage("Failed to create directory: $path");
        }
    }
}

////
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
    }
    return $csvData;
}

function generateNewFileName($csvData, $fileInfo, &$numericCounter)
{
    $filePrefix = explode('_', $fileInfo['filename'])[0];
    if (isset($csvData[$filePrefix])) {
        $newPrefix = $csvData[$filePrefix];
        $fileExtension = $fileInfo['extension'];
        $newNumericCounter = str_pad($numericCounter, 8, '0', STR_PAD_LEFT);
        return sprintf("%s.%s.%s.%s", $newPrefix, SKETCH_IDENTIFIER, $newNumericCounter, $fileExtension);
    }
    return false;
}

// function logMessage($message)
// {
//     file_put_contents("log.txt", $message . PHP_EOL, FILE_APPEND);
// }


// Additional function to handle renaming of files
function renameFile($oldFilePath, $newFilePath)
{
    if (rename($oldFilePath, $newFilePath)) {
        //logMessage("File '" . basename($oldFilePath) . "' renamed to '" . basename($newFilePath) . "'");
        return true;
    } else {
        //logMessage("Failed to rename file '" . basename($oldFilePath) . "'");
        return false;
    }
}

// Additional function to handle file copy
function copyFileToDestination($srcPath, $destPath)
{
    if (copy($srcPath, $destPath)) {
        //logMessage("File '" . basename($srcPath) . "' copied to '" . $destPath . "'");
        return true;
    } else {
        //logMessage("Failed to copy file '" . basename($srcPath) . "' to '" . $destPath . "'");
        return false;
    }
}

function batchRenameCopyMoveAndUpdateCsv($files, $csvData, $startNumericCounter)
{
    $numericCounter = intval($startNumericCounter);
    $uniqueFolderNames = [];

    foreach ($files as $file) {
        $fileInfo = pathinfo($file);
        $newFileName = generateNewFileName($csvData, $fileInfo, $numericCounter);
        var_dump($newFileName); // for debugging - can remove as needed

        if ($newFileName) {
            $oldFilePath = $file;
            $newFilePath = $fileInfo['dirname'] . DIRECTORY_SEPARATOR . $newFileName;

            createBackup($oldFilePath, BACKUP_DIRECTORY);

            $renameSuccess = renameFile($oldFilePath, $newFilePath); // Calling renameFile() only once
            var_dump($renameSuccess); // Debug line

            if ($renameSuccess) { // Moved the "if" check here
                $folderName = substr($newFileName, 3, 2) . substr($newFileName, 6, 2) . substr($newFileName, 0, 2);
                $uniqueFolderNames[] = $folderName;

                $finalFolderPath = FINAL_DIRECTORY_PATH . $folderName . DIRECTORY_SEPARATOR;
                createDirectory($finalFolderPath);

                $finalFilePath = $finalFolderPath . $newFileName;

                if (!file_exists($finalFilePath)) {
                    copyFileToDestination($newFilePath, $finalFilePath);
                } else {
                    //logMessage("File '{$newFileName}' already exists in the final folder.");
                }

                $numericCounter++;
            }
        }
    }
    var_dump($uniqueFolderNames); // Debug line

    return $uniqueFolderNames;
}


$files = glob(DIRECTORY_PATH . '*.*');
var_dump($files); // Debug line

$csvData = readCsvData(CSV_FILE_PATH);
var_dump($csvData); // Debug line


try {
    $files = glob(DIRECTORY_PATH . '*.*');

    if (!$files || empty($files)) {
        throw new Exception("No files found in directory: " . DIRECTORY_PATH);
    }

    $csvData = readCsvData(CSV_FILE_PATH);

    if (!$csvData || empty($csvData)) {
        throw new Exception("Failed to read or parse the CSV file.");
    }

    $uniqueFolderNames = batchRenameCopyMoveAndUpdateCsv($files, $csvData, $startNumericCounter);
    var_dump($uniqueFolderNames); // Debug line


    if (!$uniqueFolderNames || empty($uniqueFolderNames)) {
        throw new Exception("The batch rename and copy operation didn't produce unique folder names or failed.");
    }

    echo json_encode(["status" => "success", "message" => "Processing completed successfully"]);
}
catch (Exception $e) {
    //logMessage("ERROR: " . $e->getMessage());
    echo json_encode(["status" => "error", "message" => "An error occurred: " . $e->getMessage()]);
}
finally {
    $conn = null; // close the connection
}
?>