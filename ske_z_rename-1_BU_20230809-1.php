<?php
//\\//\\//\\//\\//\\//\\//\\
// Action: Look in pa_photos/Sketches folder and rename the file names from the original VID_BID.jpg to the PID.S.Timestamp.jpg (currently for testing the dir is pa_photos/zSketches
// This action gives us the correct filename to place in the
//\\//\\//\\//\\//\\//\\//\\
// Step 1: Define the path to the CSV file
$csvFilePath = 'ske_RealProp.csv';
// Step 2: Get the list of files from the directory
$directoryPath = '/mnt/paphotos/zSketches/';
$files = scandir($directoryPath);
// Step 3: Numberic counter starting from 570528
$numericCounter = 570528;
// Array to keep track of the incremental number for each file prefix
$incrementalNumbers = array();
// Step 4: Read and process the CSV file
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
// start: removed working code stored below
        foreach ($files as $file) {
            $filePrefix = substr($file, 0, strpos($file, '_'));
            if ($filePrefix === $oldPrefix) {
                // Extract text after underscore
                $underscorePosition = strpos($file, '_');
                if ($underscorePosition !== false) {
                    $textAfterUnderscore = substr($file, $underscorePosition + 1);
                    $extensionPosition = strpos($textAfterUnderscore, '.');
                    if ($extensionPosition !== false) {
                        $textAfterUnderscore = substr(
                            $textAfterUnderscore,
                            0,
                            $extensionPosition
                        );
                    }
                } else {
                    $textAfterUnderscore = '';
                }

                // Create the new file name using the new prefix, text after underscore, numeric counter, and ".s"
                $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                $newFileName = "{$newPrefix}.{$textAfterUnderscore}.S.{$numericCounter}";
                $newFileNameWithExtension = "{$newFileName}.{$fileExtension}";
                // Print the original and new file names to the screen
                //echo "File '{$file}' renamed to '{$newFileNameWithExtension}'<br>";
                $oldFilePath = $directoryPath . DIRECTORY_SEPARATOR . $file;
                $newFilePath = $directoryPath . DIRECTORY_SEPARATOR . $newFileNameWithExtension;
                // Perform the renaming
                if (rename($oldFilePath, $newFilePath)) {
                    echo "File '{$file}' renamed to '{$newFileNameWithExtension}'<br>";
                } else {
                    echo "Failed to rename file '{$file}'<br>";
                }

                // Increment the numeric counter
                $numericCounter++;
            }
        }

        // end: removed working code stored below
    }
    fclose($handle);
}


// original working below
//      foreach($files as $file){
//            $filePrefix=substr($file, 0, strpos($file, '_'));
//            if($filePrefix===$oldPrefix){
//                // Create the new file name using the new prefix, date, and incremental number
//                $fileExtension=pathinfo($file, PATHINFO_EXTENSION);
//                $newFileName="{$newPrefix}.s.{$numericCounter}";
//                $newFileNameWithExtension="{$newFileName}.{$fileExtension}";
//                // Print the original and new file names to the screen
//                //echo "File '{$file}' renamed to '{$newFileNameWithExtension}'<br>";
//                $oldFilePath=$directoryPath.DIRECTORY_SEPARATOR.$file;
//                $newFilePath=$directoryPath.DIRECTORY_SEPARATOR.$newFileNameWithExtension;
//                // Perform the renaming
//                if(rename($oldFilePath, $newFilePath)){
//                    echo "File '{$file}' renamed to '{$newFileNameWithExtension}'<br>";
//                }
//                else{
//                    echo "Failed to rename file '{$file}'<br>";
//                }
//                $numericCounter++;
//            }
//        }