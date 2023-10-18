<?php
$start = $_GET['start'] ?? 0;
$limit = 50;

$directory = '/mnt/paphotos/Sketches/';
$files = array_slice(glob($directory . '*.jpg'), $start, $limit);

$output = [];

foreach ($files as $file) {
    $filename = basename($file);
    $filesize = filesize($file);
    $thumbnail = base64_encode(file_get_contents($file));

    $output[] = [
        'filename' => $filename,
        'filesize' => $filesize,
        'thumbnail' => $thumbnail
    ];
}

//echo json_encode($output);
?>