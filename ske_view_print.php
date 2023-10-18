<?php

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


// Fetch file info based on query parameter
if (isset($_GET['file'])) {
    $file = urldecode($_GET['file']);
    $filename = basename($file);
    $filesize = filesize($file);
    $filemtime = date("d/m/Y g:i A", filemtime($file));
    $thumbnail = base64_encode(file_get_contents($file));
} else {
    // Handle missing file parameter
    exit('No file specified.');
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>PENDING SKETCH FILE INFORMATION</title>
</head>

<body>
    <!-- File information -->
    <p>Putnam County Property Appraiser | PANTHER System - Field Appraiser Sketch</p>
    <img src="data:image/jpeg;base64,<?php //echo $thumbnail; ?>"
        class="img-fluid mb-2"
        style="width:600px; height:600px;">
    <p>Filename:
        <?php //echo $filename; ?>
    </p>
    <p>File Size:
        <?php //echo formatSizeUnits($filesize); ?>
    </p>
    <p>Last Modified:
        <?php //echo $filemtime; ?>
    </p>
    <button onclick="closeWindow()">CLOSE</button>
    <button onclick="window.print()">PRINT</button>
</body>

</html>
<script type="text/javascript">
    function closeWindow() {
        window.close(); // Close the current window
    }
</script>