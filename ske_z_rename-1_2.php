<?php
// Step 1: Define the path to the CSV file
$csvFilePath = 'ske_RealProp.csv';
// Step 2: Get the list of files from the directory
$directoryPath = '/mnt/paphotos/zSketches/';
$files = scandir($directoryPath);
// Step 3: Read and process the CSV file
if (($handle = fopen($csvFilePath, "r")) !== false) {
    // Skip the header row
    fgetcsv($handle);
    // Loop through each row of the CSV file
    while (($data = fgetcsv($handle)) !== false) {
        [$oldFileName, $newFileName] = $data;
        // Extract the part of the filename before the underscore
        $filenameParts = explode('_', $oldFileName);
        print $filenameParts;
        $prefix = $filenameParts[0];
        // Check if the old filename exists in the directory
        if (in_array($oldFileName, $files)) {
            $oldFilePath = $directoryPath . DIRECTORY_SEPARATOR . $oldFileName;
            $newFilePath = $directoryPath . DIRECTORY_SEPARATOR . $newFileName;
            // Perform the renaming
            if (rename($oldFilePath, $newFilePath)) {
                echo "File '{$oldFileName}' renamed to '{$newFileName}'<br>";
            } else {
                echo "Failed to rename file '{$oldFileName}'<br>";
            }
        }
    }
    fclose($handle);
}
?>