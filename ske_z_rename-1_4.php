<?php
// Step 1: Define the path to the CSV file
$csvFilePath = 'ske_RealProp.csv';
// Step 2: Get the list of files from the directory
$directoryPath = '/mnt/paphotos/zSketches/';
$files = scandir($directoryPath);
// Array to keep track of the incremental number for each file prefix
$incrementalNumbers = array();
// Step 3: Read and process the CSV file
if (($handle = fopen($csvFilePath, "r")) !== false) {
    // Skip the header row
    fgetcsv($handle);
    // Loop through each row of the CSV file
    while (($data = fgetcsv($handle)) !== false) {
        [$oldPrefix, $newPrefix] = $data;
        // Keep track of the number of times we have encountered the same old prefix
        if (!isset($incrementalNumbers[$oldPrefix])) {
            $incrementalNumbers[$oldPrefix] = 1;
        }

        // Check if the old prefix matches the beginning portion of any file in the directory
        foreach ($files as $file) {
            $filePrefix = substr($file, 0, strpos($file, '_'));
            if ($filePrefix === $oldPrefix) {
                // Create the new file name using the new prefix, date, and incremental number
                $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                $dateStamp = date("ymd");
                $incrementalFormatted = sprintf(
                    '%03d', $incrementalNumbers[$oldPrefix]++
                );
                $newFileName = "{$newPrefix}.{$dateStamp}-{$incrementalFormatted}-s";
                $newFileNameWithExtension = "{$newFileName}.{$fileExtension}";
                // Print the original and new file names to the screen
                echo "File '{$file}' renamed to '{$newFileNameWithExtension}'<br>";
                $oldFilePath = $directoryPath . DIRECTORY_SEPARATOR . $file;
                $newFilePath = $directoryPath . DIRECTORY_SEPARATOR . $newFileNameWithExtension;
                // Perform the renaming
                if (rename($oldFilePath, $newFilePath)) {
                    echo "File '{$file}' renamed to '{$newFileNameWithExtension}'<br>";
                } else {
                    echo "Failed to rename file '{$file}'<br>";
                }
            }
        }
    }

    fclose($handle);
}
?>