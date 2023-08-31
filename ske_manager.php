<?php
/**
 * index.php
 * Dashboard for Panther application.
 * 
 * @author Will Walsh | wbwalsh@gmail.com
 * @version 0.6
 */

// Load favicon and modal processing
require './logic/favicon.php';
require_once './ske_modal_processing.php';

// Utilities for calculating file count and folder size
require_once './logic/utilities.php';

// Page metadata
$screenTitle = "VISION+ | Sketch Managersss";
$screenTitleMidText = "";
$screenTitleRightButtonIcon = "fa-refresh";
$screenTitleRightButtonText = " REFRESH";
$screenTitleRightButtonModal = "#yourModalID";

// Folder for sketch files
$tempdirectory = "/mnt/paphotos/Sketches/";

// Count the files in the sketches directory
$tempfilecount = count(glob($tempdirectory . "*"));

// Initialize variables
$latest_file_time = 0;
$arrSketchFiles = array();
$handle = opendir('/mnt/paphotos/Sketches/');
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
    <title>
        <?php echo $screenTitle; ?>
    </title>
    <!-- Custom fonts and styles -->
    <link href="vendor/fontawesome-free/css/all.min.css"
        rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css"
        rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Side Nav Bar -->
        <?php require "./logic/sidebar.php"; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper"
            class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Top Bar -->
                <?php require "./logic/topbar.php"; ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Screen Title Bar -->
                    <?php require "./logic/screentitlebar.php"; ?>
                </div>
                <!-- Cards and Info -->
                <div class="col mb-5">
                    <div class="card-deck"
                        style="width:36rem">
                        <!-- Directory Card -->
                        <div class="card bg-primary">
                            <div class="card-body text-center">
                                <p class="card-text text-light"
                                    style="font-size: 16px">
                                    <b>SKETCH IMPORT FOLDER:<br>PA/PA_PHOTOS/SKETCHES/</b>
                                </p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <?php
                    // Include utility functions
                    require_once './logic/utility/folder_size.php';
                    require_once './logic/utility/format_folder_size.php';

                    // Initialize or fallback values
                    if (!isset($tempfilecount)) {
                        $tempfilecount = 0;
                    }

                    // Initialize card text variables
                    $filesReadyText = ($tempfilecount > 0) ? number_format($tempfilecount) : "0";
                    $combinedSizeText = "0";

                    // Calculate combined size if files exist
                    if ($tempfilecount > 0) {
                        $disk_used = foldersize($tempdirectory);
                        $combinedSizeText = format_size($disk_used, $units);
                    }
                    ?>
                    <!-- Stats Cards -->
                    <div class="card-deck"
                        style="width:36rem">
                        <!-- Files Ready Card -->
                        <div class="card bg-primary">
                            <div class="card-body text-center">
                                <p class="card-text text-light"><b>FILES READY FOR<br>PROCESSING</b></p>
                                <p class="card-text text-light"
                                    style="font-size: 40px">
                                    <b>
                                        <?php echo $filesReadyText; ?>
                                    </b>
                                </p>
                            </div>
                        </div>
                        <!-- Combined Size Card -->
                        <div class="card bg-primary">
                            <div class="card-body text-center">
                                <p class="card-text text-light"><b>COMBINED SIZE<br>OF ALL FILES</b></p>
                                <p class="card-text text-light"
                                    style="font-size: 40px">
                                    <b>
                                        <?php echo $combinedSizeText; ?>
                                    </b>
                                </p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- Action Buttons -->
                    <input type="button"
                        class="btn btn-primary font-weight-bolder"
                        style="font-size: 24px; width:34.5rem"
                        name="sketch_button_list"
                        id="sketch_button_list"
                        value=" VIEW FILE LIST "
                        onClick="<?php echo ($tempfilecount != 0) ? "parent.location='ske_view_index.php'" : ""; ?>"
                        <?php echo ($tempfilecount == 0) ? 'disabled' : ''; ?> />
                    <br><br>
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
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <?php require "./logic/footer.php"; ?>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded"
        href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
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
    <!-- Script Includes -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>