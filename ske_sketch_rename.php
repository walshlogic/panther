<?php
// Turn on error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db/dbconn_vision.php';

// Constants
define('CSV_FILE_PATH', './ske_RealProp.csv');
define('DIRECTORY_PATH', '/mnt/paphotos/Sketches/');
define('FINAL_DIRECTORY_PATH', '/mnt/paphotos/photos/');
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

function batchRenameCopyMoveAndUpdateCsv($files, $csvData, $startNumericCounter)
{
    $numericCounter = intval($startNumericCounter);
    $uniqueFolderNames = [];

    foreach ($files as $file) {
        $fileInfo = pathinfo($file);
        $newFileName = generateNewFileName($csvData, $fileInfo, $numericCounter);

        echo "Generated new file name: " . $newFileName . "\n";

        if ($newFileName) {
            $oldFilePath = $file;
            $newFilePath = $fileInfo['dirname'] . DIRECTORY_SEPARATOR . $newFileName;

            createBackup($oldFilePath, BACKUP_DIRECTORY);

            $renameSuccess = renameFile($oldFilePath, $newFilePath);

            if ($renameSuccess) {
                $folderName = substr($newFileName, 3, 2) . substr($newFileName, 6, 2) . substr($newFileName, 0, 2);
                $uniqueFolderNames[] = $folderName;

                $finalFolderPath = FINAL_DIRECTORY_PATH . $folderName . DIRECTORY_SEPARATOR;
                createDirectory($finalFolderPath);

                $finalFilePath = $finalFolderPath . $newFileName;

                if (!file_exists($finalFilePath)) {
                    if (rename($newFilePath, $finalFilePath)) { // Replace the copy operation with a move operation
                        echo "Successfully moved {$newFilePath} to {$finalFilePath}\n";
                    } else {
                        echo "Failed to move {$newFilePath} to {$finalFilePath}\n";
                    }
                } else {
                    echo "File {$finalFilePath} already exists. Skipped moving.\n";
                }

                $numericCounter++;
            }
        }
    }

    echo "Unique folder names generated: " . implode(", ", $uniqueFolderNames) . "\n";

    return $uniqueFolderNames;
}

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

    if (!$uniqueFolderNames || empty($uniqueFolderNames)) {
        throw new Exception("The batch rename and copy operation didn't produce unique folder names or failed.");
    }

    echo json_encode(["status" => "success", "message" => "Processing completed successfully"]);
}
catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "An error occurred: " . $e->getMessage()]);
}
finally {
    $conn = null; // close the connection
}
?>