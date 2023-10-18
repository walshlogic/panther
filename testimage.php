<?php
// Directory path
$directory = '/mnt/paphotos/Sketches/';

// Read files
$files = glob($directory . '*.jpg'); //adjust this to suit other image types if needed

// Display each file
foreach ($files as $file) {
    $filename = basename($file);
    $filesize = filesize($file);

    //echo "File Name: $filename <br>";
    //echo "File Size: " . formatSizeUnits($filesize) . "<br>";

    // Displaying thumbnail
    $thumbnail = base64_encode(file_get_contents($file));
    //echo "<img src='data:image/jpeg;base64,$thumbnail' width='100' height='100'><br><br>";
}

// Function to format file size
function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }
    return $bytes;
}
?>