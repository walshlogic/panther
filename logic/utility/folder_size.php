<?php
// Calculate the folder size
function foldersize($path)
{
    $total_size = 0;
    $files = scandir($path);
    $cleanPath = rtrim($path, '/') . '/';
    foreach ($files as $t) {
        if ($t !== "." && $t !== "..") {
            $currentFile = $cleanPath . $t;
            $total_size += is_dir($currentFile) ? foldersize($currentFile) : filesize($currentFile);
        }
    }
    return $total_size;
}

$units = explode(' ', 'B KB MB GB TB PB');

?>