<?php

// Turn on error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db/dbconn_vision.php';

// Constants
define('CSV_FILE_PATH', '/ske_RealProp.csv');
define('DIRECTORY_PATH', '/mnt/paphotos/Sketches/');
define('FINAL_DIRECTORY_PATH', '/mnt/paphotos/SketchFinal/');
define('SKETCH_IDENTIFIER', 'S');
define('BACKUP_DIRECTORY', '/mnt/paphotos/SketchFinal/OriginalBackups/');

$dbConnection = new Connection();
$conn = $dbConnection->getConnection(); // Updated the method name here

if (!$conn) {
    logMessage("Failed to establish database connection.");
    die("Database connection failed!");
}

$startNumericCounter = null; // Variable name updated to camelCase

try {
    $query = "SELECT MAX(RIM_ID) AS max_id FROM REAL_PROP.REIMAGES";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        throw new Exception("Failed to fetch the maximum RIM_ID value.");
    }

    $startNumericCounter = strval($result['max_id'] + 1); // Variable name updated to camelCase
}
catch (Exception $e) {
    logMessage("ERROR retrieving highest RIM_ID: " . $e->getMessage());
    echo "An error occurred: " . $e->getMessage();
    die($e->getMessage());
}

function logMessage($message, $logFilePath = './logs/log.txt')
{
    $timestamp = date('Y-m-d H:i:s');
    $formattedMessage = "[$timestamp] $message\n";
    file_put_contents($logFilePath, $formattedMessage, FILE_APPEND);
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

// Additional function to handle renaming of files
function renameFile($oldFilePath, $newFilePath)
{
    if (rename($oldFilePath, $newFilePath)) {
        logMessage("File '" . basename($oldFilePath) . "' renamed to '" . basename($newFilePath) . "'");
        return true;
    } else {
        logMessage("Failed to rename file '" . basename($oldFilePath) . "'");
        return false;
    }
}

// Additional function to handle file copy
function copyFileToDestination($srcPath, $destPath)
{
    if (copy($srcPath, $destPath)) {
        logMessage("File '" . basename($srcPath) . "' copied to '" . $destPath . "'");
        return true;
    } else {
        logMessage("Failed to copy file '" . basename($srcPath) . "' to '" . $destPath . "'");
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

        if ($newFileName) {
            $oldFilePath = $file;
            $newFilePath = $fileInfo['dirname'] . DIRECTORY_SEPARATOR . $newFileName;

            createBackup($oldFilePath, BACKUP_DIRECTORY);

            if (renameFile($oldFilePath, $newFilePath)) {
                $folderName = substr($newFileName, 3, 2) . substr($newFileName, 6, 2) . substr($newFileName, 0, 2);
                $uniqueFolderNames[] = $folderName;

                $finalFolderPath = FINAL_DIRECTORY_PATH . $folderName . DIRECTORY_SEPARATOR;
                createDirectory($finalFolderPath);

                $finalFilePath = $finalFolderPath . $newFileName;

                if (!file_exists($finalFilePath)) {
                    copyFileToDestination($newFilePath, $finalFilePath);
                } else {
                    logMessage("File '{$newFileName}' already exists in the final folder.");
                }

                $numericCounter++;
            }
        }
    }

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

    // Process unique folder names if needed
}
catch (Exception $e) {
    logMessage("ERROR: " . $e->getMessage());
    echo "An error occurred: " . $e->getMessage();
}
finally {
    $conn = null; // close the connection
}


function createBackup($filePath, $backupDirectory)
{
    if (!is_dir($backupDirectory)) {
        createDirectory($backupDirectory);
    }
    $backupFilePath = $backupDirectory . basename($filePath);
    return copy($filePath, $backupFilePath);
}

function createDirectory($path)
{
    if (!is_dir($path)) {
        return mkdir($path, 0755, true);
    }
    return true;
}

?>
<script type="text/javascript">
    // Function to trigger the PHP script and handle the response
    function processAndShowLoading() {
        console.log("processAndShowLoading called");
        // Your existing code for showing loading etc.
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'ske_sketch_rename.php', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4) { // Request is complete
                console.log("AJAX request state changed: " + xhr.readyState);
                if (xhr.status == 200) { // Request was successful
                    console.log("AJAX request successful.");
                    console.log("Server Response: " + xhr.responseText); // Print out the server response
                    // Your code to handle the server response
                } else {
                    console.log("AJAX request failed. Status: " + xhr.status);
                }
            } else {
                console.log("AJAX request state changed: " + xhr.readyState);
            }
        };
        // Assuming you want to send some form data
        var formData = new FormData();
        formData.append('key', 'value');
        // Add more form data if needed
        xhr.send(formData);
    }
    // Assume you have a button with id 'processBtn' that will trigger the AJAX when clicked
    document.getElementById('processBtn').addEventListener('click', processAndShowLoading);
</script>