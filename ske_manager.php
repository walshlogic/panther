<?php
/**
 * ske_manager.php
 * Sketch Manager for Panther application.
 *
 * @author Will Walsh | wbwalsh@gmail.com
 * @version 1.0
 */

// Define constants for file paths
define('SKETCH_FOLDER_PATH', '/mnt/paphotos/Sketches/');

// Error handling for missing or unreadable sketch folder
if (!is_dir(SKETCH_FOLDER_PATH) || !is_readable(SKETCH_FOLDER_PATH)) {
    die("Error: Sketch folder is missing or not readable.");
}

// Load favicon and modal processing
require './logic/favicon.php';
require_once './ske_modal_processing.php';

// Error handling for utility files
$folderSizeIncluded = include_once('./logic/utility/folder_size.php');
$formatFolderSizeIncluded = include_once('./logic/utility/format_folder_size.php');

if (!$folderSizeIncluded || !$formatFolderSizeIncluded) {
    die("Error: Failed to load utility files.");
}


// Utilities for calculating file count and folder size
require_once './logic/utility/folder_size.php';
require_once './logic/utility/format_folder_size.php';

// Page metadata
$screenTitle = "VISION+ | Sketch Manager";
$screenTitleMidText = "";
$screenTitleRightButtonIcon = "fa-refresh";
$screenTitleRightButtonText = " REFRESH";
$screenTitleRightButtonModal = "#yourModalID";

// Folder for sketch files
$tempdirectory = SKETCH_FOLDER_PATH;

// Error handling for counting files
try {
    $tempfilecount = count(glob($tempdirectory . "*"));
}
catch (Exception $e) {
    die("Error: Failed to count files in sketch folder. " . $e->getMessage());
}

// Calculate card text
$filesReadyText = ($tempfilecount > 0) ? number_format($tempfilecount) : "0";
$combinedSizeText = "0";

if ($tempfilecount > 0) {
    try {
        $disk_used = foldersize($tempdirectory);
        $combinedSizeText = format_size($disk_used, $units);
    }
    catch (Exception $e) {
        die("Error: Failed to calculate folder size. " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"
        content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="">
    <meta name="author"
        content="Will Walsh | wbwalsh@gmail.com">
    <meta name="version"
        content="0.6">
    <title> <?php echo $screenTitle; ?> </title>
    <link href="vendor/fontawesome-free/css/all.min.css"
        rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css"
        rel="stylesheet">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>
</head>

<body id="page-top">
    <div id="wrapper"> <?php require "./logic/sidebar.php"; ?> <div id="content-wrapper"
            class="d-flex flex-column">
            <div id="content"> <?php require "./logic/topbar.php"; ?> <div class="container-fluid">
                    <?php require "./logic/screentitlebar.php"; ?> </div>
                <div class="col mb-5">
                    <div class="card-deck"
                        style="width:36rem">
                        <div class="card bg-dark">
                            <div class="card-body text-center">
                                <p class="card-text text-light"
                                    style="font-size: 16px"><b>SKETCH IMPORT FOLDER:<br>PA/PA_PHOTOS/SKETCHES/</b></p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="card-deck"
                        style="width:36rem">
                        <div class="card bg-dark">
                            <div class="card-body text-center">
                                <p class="card-text text-light"><b>FILES READY FOR<br>PROCESSING</b></p>
                                <p class="card-text text-light"
                                    style="font-size: 40px"><b> <?php echo $filesReadyText; ?> </b></p>
                            </div>
                        </div>
                        <div class="card bg-dark">
                            <div class="card-body text-center">
                                <p class="card-text text-light"><b>COMBINED SIZE<br>OF ALL FILES</b></p>
                                <p class="card-text text-light"
                                    style="font-size: 40px"><b> <?php echo $combinedSizeText; ?> </b></p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- button to view sketch files -->
                    <!-- opens ske_view_index.php screen -->
                    <input type="button"
                        class="btn bg-secondary font-weight-bolder text-light"
                        style="font-size: 24px; width:34.5rem"
                        name="sketch_button_list"
                        id="sketch_button_list"
                        value=" VIEW FILE LIST "
                        onClick="<?php echo ($tempfilecount != 0) ? "parent.location='ske_view_index.php'" : ""; ?>"
                        <?php echo ($tempfilecount == 0) ? 'disabled' : ''; ?> />
                    <br><br>
                    <!-- button to process sketch files -->
                    <!-- opens the SketchProcessingModal -->
                    <input type="button"
                        class="btn btn-danger font-weight-bolder"
                        style="font-size: 24px; width:34.5rem"
                        name="sketch_button_process"
                        id="sketch_button_process"
                        value=" PROCESS SKETCHES "
                        data-toggle="modal"
                        data-target="#SketchProcessingModal"
                        data-backdrop='static'
                        <?php echo ($tempfilecount == 0) ? 'disabled' : ''; ?> />
                </div>
            </div> <?php require "./logic/footer.php"; ?>
        </div>
    </div>
    <a class="scroll-to-top rounded"
        href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <div class="modal fade"
        id="logoutModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close"
                        type="button"
                        data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary"
                        type="button"
                        data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary"
                        href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script>
    // JavaScript code for handling the modal
    $(document).ready(function() {
        $('#sketch_button_process').on('click', function() {
            $('#SketchProcessingModal').modal('show');
        });
    });
    </script>
</body>

</html>