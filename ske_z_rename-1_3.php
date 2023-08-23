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
        [$oldPrefix, $newPrefix] = $data;
        // Check if the old prefix matches the beginning portion of any file in the directory
        foreach ($files as $file) {
            if (strpos($file, $oldPrefix . '_') === 0) {
                // Extract the file extension
                $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                // Create the new file name using the new prefix and the same file extension
                $newFileName = $newPrefix . substr($file, strlen($oldPrefix));
                $newFileNameWithExtension = $newFileName . '.' . $fileExtension;
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

// Print all new file names to the screen
echo "<br>New File Names:<br>";
foreach ($newFileNames as $newFileName) {
    echo $newFileName . "<br>";
}
?>