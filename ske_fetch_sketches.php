<?php
function formatSizeUnits($bytes)
{
    // your existing function to format size
}

// get page parameter from query string
$page = $_GET['page'] ?? 1;
$itemsPerPage = 50; // Change this as per your need

$sketchDirectory = '/mnt/paphotos/Sketches/';

$allFiles = glob($sketchDirectory . '*.jpg');
$totalFiles = count($allFiles);

$offset = ($page - 1) * $itemsPerPage;
$files = array_slice($allFiles, $offset, $itemsPerPage);

$output = [];

foreach ($files as $file) {
    $filename = basename($file);
    $filesize = filesize($file);
    $thumbnail = base64_encode(file_get_contents($file));
    $filetime = date("d/m/Y g:i A", filemtime($file));

    $output[] = [
        'filename' => $filename,
        'formatted_size' => formatSizeUnits($filesize),
        'thumbnail' => $thumbnail,
        'uploaded' => $filetime,
    ];
}

header('Content-Type: application/json');
echo json_encode(['totalFiles' => $totalFiles, 'files' => $output,]);
?>