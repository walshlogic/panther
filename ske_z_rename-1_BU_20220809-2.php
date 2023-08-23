<?php
// Define constants for better code readability
define('CSV_FILE_PATH', 'ske_RealProp.csv');
define('DIRECTORY_PATH', '/mnt/paphotos/zSketches/');
define('START_NUMERIC_COUNTER', 570528);
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
$files = scandir(DIRECTORY_PATH);
// Step 3: Initialize numeric counter
$numericCounter = START_NUMERIC_COUNTER;
// Step 4: Rename files based on CSV data
foreach ($files as $file) {
    if ($file === '.' || $file === '..') {
        continue; // Skip current and parent directory entries
    }

    $underscorePosition = strpos($file, '_');
    if ($underscorePosition !== false) {
        $filePrefix = substr($file, 0, $underscorePosition);
        $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
        if (isset($csvData[$filePrefix])) {
            $newPrefix = $csvData[$filePrefix];
            $textAfterUnderscore = substr(
                $file, $underscorePosition + 1, -strlen($fileExtension) - 1
            );
            // Create the new file name
            $newFileName = "{$newPrefix}.{$textAfterUnderscore}.S.{$numericCounter}.{$fileExtension}";
            $oldFilePath = DIRECTORY_PATH . $file;
            $newFilePath = DIRECTORY_PATH . $newFileName;
            // Perform the renaming
            if (rename($oldFilePath, $newFilePath)) {
                echo "File '{$file}' renamed to '{$newFileName}'<br>";
            } else {
                echo "Failed to rename file '{$file}'<br>";
            }

            // Increment the numeric counter
            $numericCounter++;
        }
    }
}