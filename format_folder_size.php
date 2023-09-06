<?php
// Format the folder size untis
function format_size($size, $units)
{
    $mod = 1024;
    for ($i = 0; $size > $mod; $i++) {
        $size /= $mod;
    }
    return
        round($size, 2) . ' ' . $units[$i];
}
?>