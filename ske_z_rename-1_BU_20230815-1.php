<?php

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define constants for better code readability
define('CSV_FILE_PATH', 'ske_RealProp.csv');
define('DIRECTORY_PATH', '/mnt/paphotos/zSketches/');
define('START_NUMERIC_COUNTER', '00570528'); // 8-digit number with leading zeros
define('OUTPUT_CSV_DIRECTORY', 'output_csv_files/');
define('FINAL_DIRECTORY_PATH', '/mnt/paphotos/zSketches/zSketchFinal/'); // Added final directory path

// Read CSV data and create an associative array
function readCsvData($filePath)
{
    $csvData = array();
    if (($handle = fopen($filePath, "r")) !== false) {
        fgetcsv($handle); // Skip the header row
        while (($data = fgetcsv($handle)) !== false) {
            [$oldPrefix, $newPrefix] = $data;
            $csvData[$oldPrefix] = $newPrefix;
        }
        fclose($handle);
    }
    return $csvData;
}

// Generate new filenames based on CSV data
function generateNewFileName($csvData, $fileInfo, &$numericCounter, &$filePrefix)
{
    $filePrefix = explode('_', $fileInfo['filename'])[0];
    if (isset($csvData[$filePrefix])) {
        $newPrefix = $csvData[$filePrefix];
        $fileExtension = $fileInfo['extension'];
        $newNumericCounter = str_pad($numericCounter, 8, '0', STR_PAD_LEFT); // Ensure 8 digits with leading zeros
        return sprintf("%s.%s.%s", $newPrefix, $newNumericCounter, $fileExtension);
    }
    return false;
}

// Create directories in FINAL_DIRECTORY_PATH
function createDirectories($uniqueFolderNames)
{
    foreach ($uniqueFolderNames as $uniqueFolderName) {
        echo "Checking folder name: $uniqueFolderName<br>";

        $finalFolderPath = FINAL_DIRECTORY_PATH . $uniqueFolderName;

        if (!is_dir($finalFolderPath)) {
            if (mkdir($finalFolderPath, 0777, true)) {
                echo "Created directory: '{$finalFolderPath}'<br>";
            } else {
                echo "Failed to create directory: '{$finalFolderPath}' - " . error_get_last()['message'] . "<br>";
            }
        }
    }
}

// Rename files and update CSV
function renameAndUpdateCsv($files, $csvData)
{
    $numericCounter = intval(START_NUMERIC_COUNTER);
    $timestamp = date('Y-m-d_His');
    $outputCsvFilename = OUTPUT_CSV_DIRECTORY . 'renamed_files_' . $timestamp . '.csv';
    $csvOutput = fopen($outputCsvFilename, 'w');
    fputcsv(
        $csvOutput,
        ['VID', 'BID', 'file_type', 'org_filename', 'new_filename', 'folder_name']
    );

    $uniqueFolderNames = array(); // Store unique folder names

    foreach ($files as $file) {
        $fileInfo = pathinfo($file);
        $newFileName = generateNewFileName($csvData, $fileInfo, $numericCounter, $filePrefix);

        if ($newFileName !== false) {
            $oldFilePath = $file;
            $newFilePath = $fileInfo['dirname'] . DIRECTORY_SEPARATOR . $newFileName;

            if (rename($oldFilePath, $newFilePath)) {
                echo "File '{$fileInfo['basename']}' renamed to '{$newFileName}'<br>";

                $folderName = substr($newFileName, 3, 2) . substr($newFileName, 6, 2) . substr($newFileName, 0, 2);
                fputcsv(
                    $csvOutput,
                    [
                        'VID' => $filePrefix,
                        'BID' => $numericCounter,
                        'file_type' => $fileInfo['extension'],
                        'org_filename' => $fileInfo['basename'],
                        'new_filename' => $newFileName,
                        'folder_name' => $folderName,
                        'internal_note' => 'SKETCH IMPORT'
                    ]
                );

                // Collect unique folder names
                $uniqueFolderNames[] = $folderName;
            } else {
                echo "Failed to rename file '{$fileInfo['basename']}'<br>";
            }
            $numericCounter++;
        }
    }
    fclose($csvOutput);

    // Create directories in FINAL_DIRECTORY_PATH
    createDirectories($uniqueFolderNames);

    // Display unique folder names
    echo "<p>Unique Folder Names: " . implode(', ', $uniqueFolderNames) . "</p>";
}

// Get the list of files from the directory
$files = glob(DIRECTORY_PATH . '*.jpg'); // Adjust the extension as needed

// Read CSV data and create an associative array
$csvData = readCsvData(CSV_FILE_PATH);

// Batch rename files and update CSV
renameAndUpdateCsv($files, $csvData);