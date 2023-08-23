<?php
// Define constants for better code readability
define('CSV_FILE_PATH', 'ske_RealProp.csv');
define('DIRECTORY_PATH', '/mnt/paphotos/zSketches/');
define('START_NUMERIC_COUNTER', 570528);
define('OUTPUT_CSV_FILE', 'panther_process_scketch.csv');
// Step 1: Read CSV file and create an associative array
$csvData = array();
if (($handle = fopen(CSV_FILE_PATH, "r")) !== false) {
    fgetcsv($handle); // Skip the header row
    while (($data = fgetcsv($handle)) !== false) {
        [$oldPrefix, $newPrefix] = $data;
        $csvData[$oldPrefix] = $newPrefix;
    }
    fclose($handle);
}

// Step 2: Get the list of files from the directory
$files = glob(DIRECTORY_PATH . '*.jpg'); // Adjust the extension as needed
// Step 3: Initialize numeric counter
$numericCounter = START_NUMERIC_COUNTER;
// Initialize data for the new CSV file
$csvOutput = fopen(OUTPUT_CSV_FILE, 'w');
fputcsv($csvOutput, ['VID', 'BID', 'file_type', 'org_filename', 'new_filename']);
// Step 4: Batch rename files based on CSV data
$batchSize = 100; // Adjust the batch size as needed
$fileBatches = array_chunk($files, $batchSize);
foreach ($fileBatches as $fileBatch) {
    foreach ($fileBatch as $file) {
        $fileInfo = pathinfo($file);
        $filePrefix = explode('_', $fileInfo['filename'])[0];
        if (isset($csvData[$filePrefix])) {
            $newPrefix = $csvData[$filePrefix];
            $textAfterUnderscore = substr(
                $fileInfo['filename'], strpos($fileInfo['filename'], '_') + 1
            );
            $fileExtension = $fileInfo['extension'];
            $newFileName = "{$newPrefix}.{$textAfterUnderscore}.S.{$numericCounter}.{$fileExtension}";
            $oldFilePath = $file;
            $newFilePath = $fileInfo['dirname'] . '/' . $newFileName;
            if (rename($oldFilePath, $newFilePath)) {
                echo "File '{$fileInfo['basename']}' renamed to '{$newFileName}'<br>";
                // Write data to the CSV file
                fputcsv(
                    $csvOutput,
                    [
                        'VID' => $filePrefix,
                        'BID' => explode('.', $textAfterUnderscore)[0],
                        'file_type' => $fileExtension,
                        'org_filename' => $fileInfo['basename'],
                        'new_filename' => $newFileName
                    ]
                );
            } else {
                echo "Failed to rename file '{$fileInfo['basename']}'<br>";
            }

            $numericCounter++;
        }
    }
}

// Close the CSV file
fclose($csvOutput);
?>