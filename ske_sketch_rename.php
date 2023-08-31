<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
<?php

// Turn on error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'logic/dbconn_vision.php';

define('CSV_FILE_PATH', '/ske_RealProp.csv');
define('DIRECTORY_PATH', '/mnt/paphotos/Sketches/');
define('FINAL_DIRECTORY_PATH', '/mnt/paphotos/SketchFinal/');
define('SKETCH_IDENTIFIER', 'S');
define('BACKUP_DIRECTORY', '/mnt/paphotos/SketchFinal/OriginalBackups/');

$dbConnection = new Connection();
$conn = $dbConnection->open();

if (!$conn) {
    logMessage("Failed to establish database connection.");
    echo "<script>alert('Database connection failed!');</script>";
    die();
}

// Check if connection is indeed open
if ($conn) {
    logMessage("Database connected successfully.", 'database_connection.log');
} else {
    logMessage("Database connection failed.", 'database_connection.log');
    die();
}

try {
    $query = "SELECT MAX(RIM_ID) AS max_id FROM REAL_PROP.REIMAGES";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch();

    if (!$result) {
        die("Failed to fetch the maximum RIM_ID value.");
    }

    define('START_NUMERIC_COUNTER', strval($result['max_id'] + 1));
}
catch (PDOException $e) {
    die("ERROR retrieving highest RIM_ID: " . $e->getMessage());
}

function readCsvData($filePath)
{
    logMessage("Reading CSV data from {$filePath}.");
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
    logMessage("Generating new file name.");
    $filePrefix = explode('_', $fileInfo['filename'])[0];
    if (isset($csvData[$filePrefix])) {
        $newPrefix = $csvData[$filePrefix];
        $fileExtension = $fileInfo['extension'];
        $newNumericCounter = str_pad($numericCounter, 8, '0', STR_PAD_LEFT);
        return sprintf("%s.%s.%s.%s", $newPrefix, SKETCH_IDENTIFIER, $newNumericCounter, $fileExtension);
    }
    return false;
}

function createDirectory($path)
{
    logMessage("Attempting to create directory: {$path}");
    if (!is_dir($path)) {
        return mkdir($path, 0755, true);
    }
    return true;
}

function logMessage($message, $logFilePath = './logs/log.txt')
{
    $timestamp = date('Y-m-d H:i:s');
    $formattedMessage = "[$timestamp] $message\n";
    echo $formattedMessage; // To display in the browser for immediate feedback
    file_put_contents($logFilePath, $formattedMessage, FILE_APPEND);
}

function createBackup($filePath, $backupDirectory)
{
    logMessage("Creating backup for {$filePath}");
    if (!is_dir($backupDirectory)) {
        createDirectory($backupDirectory);
    }
    $backupFilePath = $backupDirectory . basename($filePath);
    copy($filePath, $backupFilePath);
}

function batchRenameCopyMoveAndUpdateCsv($files, $csvData)
{
    logMessage("Starting batch rename, copy, move, and update operations.");
    $numericCounter = intval(START_NUMERIC_COUNTER);
    $uniqueFolderNames = [];

    foreach ($files as $file) {
        $fileInfo = pathinfo($file);
        $newFileName = generateNewFileName($csvData, $fileInfo, $numericCounter);

        if ($newFileName) {
            $oldFilePath = $file;
            $newFilePath = $fileInfo['dirname'] . DIRECTORY_SEPARATOR . $newFileName;
            createBackup($oldFilePath, BACKUP_DIRECTORY);

            if (rename($oldFilePath, $newFilePath)) {
                logMessage("File '{$fileInfo['basename']}' renamed to '{$newFileName}'");

                $folderName = substr($newFileName, 3, 2) . substr($newFileName, 6, 2) . substr($newFileName, 0, 2);
                $uniqueFolderNames[] = $folderName;

                $finalFolderPath = FINAL_DIRECTORY_PATH . $folderName . DIRECTORY_SEPARATOR;
                createDirectory($finalFolderPath);

                $finalFilePath = $finalFolderPath . $newFileName;

                if (!file_exists($finalFilePath)) {
                    if (copy($newFilePath, $finalFilePath)) {
                        logMessage("File '{$newFileName}' copied to '{$finalFolderPath}'");
                    } else {
                        logMessage("Failed to copy file '{$newFileName}' to '{$finalFolderPath}'");
                    }
                } else {
                    logMessage("File '{$newFileName}' already exists in '{$finalFolderPath}'");
                }

                unlink($newFilePath);
            } else {
                logMessage("Failed to rename file '{$fileInfo['basename']}'");
            }

            $numericCounter++;
        }
    }

    return $uniqueFolderNames;
}

$csvData = readCsvData(CSV_FILE_PATH);
$files = glob(DIRECTORY_PATH . '*.jpg');
$uniqueFolderNames = batchRenameCopyMoveAndUpdateCsv($files, $csvData);
echo "<p>Unique Folder Names: " . implode(', ', $uniqueFolderNames) . "</p>";

$dbConnection->close();
?>