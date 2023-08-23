<?php
// places favicon from img/favicons/??color?? onto pages
require './logic/favicon.php';
require_once './ske_modal_processing.php';
// Utilities needed to calculate file count and folder size
require_once './logic/utilities.php';
// screen name text and button information to display top of this page
$screenTitle = "VISION+ | Sketch Manager";
$screenTitleMidText = "";
$screenTitleRightButtonIcon = "fa-refresh";
$screenTitleRightButtonText = " REFRESH";
$screenTitleRightButtonModal = "#yourModalID";
// directory used to hold sketch files created by Vision. stored before moving to photos folder
$tempdirectory = "/mnt/paphotos/zSketches/";
// set variable to count the number of files within the sketches directory
$tempfilecount = count(glob($tempdirectory . "*"));
// set variable to reset file time to zero
$latest_file_time = 0;
// set variable to hold file info
$arrSketchFiles = array();
// set variable of directory location
$handle = opendir('/mnt/paphotos/zSketches/');
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
    <title>PANTHER | Sketch Manager</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css"
        rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css"
        rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Start: Side Nav Bar -->
        <?php require "./logic/sidebar.php"; ?>
        <!-- End: Side Nav Bar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper"
            class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Start: Top Bar -->
                <?php require "./logic/topbar.php"; ?>
                <!-- End: Top Bar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Start: Screen Title Bar (info displayed below top bar identify screen) -->
                    <?php require "./logic/screentitlebar.php"; ?>
                    <!-- End: Screen Title Bar -->
                </div>
                <div class="col mb-5">
                    <div class="card-deck"
                        style="width:36rem">
                        <div class="card bg-primary">
                            <div class="card-body">
                                <center>
                                    <p class="card-text text-light"
                                        style="font-size: 16px"><b>SKETCH FOLDER<br>
                                            <?php echo $tempdirectory ?>
                                        </b>
                                    </p>
                                </center>
                            </div>
                        </div>
                        <div class="col mb-5">
                            <br>
                            <div class="card-deck"
                                style="width:36rem">
                                <div class="card bg-primary">
                                    <div class="card-body text-center">
                                        <p class="card-text text-light"><b>FILES READY FOR<br>PROCESSING</b></p>
                                        <p class="card-text text-light"
                                            style="font-size: 40px"><b>
                                                <?php if ($tempfilecount > 0) {
                                                    echo number_format($tempfilecount);
                                                } else {
                                                    echo "0";
                                                } ?>
                                            </b></p>
                                    </div>
                                </div>
                                <div class="card bg-primary">
                                    <div class="card-body text-center">
                                        <p class="card-text text-light"><b>COMBINED SIZE<br>OF ALL FILES</b></p>
                                        <p class="card-text text-light"
                                            style="font-size: 40px"><b>
                                                <?php if ($tempfilecount > 0) {
                                                    $units = explode(' ', 'B KB MB GB TB PB');
                                                    $SIZE_LIMIT = 5368709120; // 5 GB
                                                    $disk_used = foldersize("/mnt/paphotos/zSketches/");
                                                    $disk_remaining = $SIZE_LIMIT - $disk_used;
                                                    echo (format_size($disk_used));
                                                } else {
                                                    echo "0";
                                                }

                                                function foldersize($path)
                                                {
                                                    $total_size = 0;
                                                    $files = scandir($path);
                                                    $cleanPath = rtrim($path, '/') . '/';
                                                    foreach ($files as $t) {
                                                        if ($t <> "." && $t <> "..") {
                                                            $currentFile = $cleanPath . $t;
                                                            if (is_dir($currentFile)) {
                                                                $size = foldersize($currentFile);
                                                                $total_size += $size;
                                                            } else {
                                                                $size = filesize($currentFile);
                                                                $total_size += $size;
                                                            }
                                                        }
                                                    }
                                                    return $total_size;
                                                }

                                                function format_size($size)
                                                {
                                                    global $units;
                                                    $mod = 1024;
                                                    for ($i = 0; $size > $mod; $i++) {
                                                        $size /= $mod;
                                                    }

                                                    $endIndex = strpos($size, ".") + 0;
                                                    return substr($size, 0, $endIndex) . ' ' . $units[$i];
                                                }
                                                ?>
                                            </b></p>
                                    </div>
                                </div>
                            </div>
                            <!-- </div> -->
                            <div class="modal fade"
                                tabindex="-1"
                                role="dialog">
                                <div class="modal-dialog modal-dialog-centered justify-content-center"
                                    role="document">
                                    <span class="fa fa-spinner fa-spin fa-3x"></span>
                                </div>
                            </div>
                            <br>
                            <input type="button"
                                class="btn btn-primary font-weight-bolder"
                                style="font-size: 24px; width:34.5rem"
                                name="sketch_button_list"
                                id="sketch_button_list"
                                value=" VIEW FILE LIST "
                                onClick="<?php if ($tempfilecount != 0)
                                    echo "parent.location = 'ske_view_index.php'"; ?>"
                                <?php if ($tempfilecount == 0)
                                    echo 'disabled'; ?> />
                            <br>
                            <br>
                            <input type="button"
                                class="btn btn-danger font-weight-bolder"
                                style="font-size: 24px; width:34.5rem"
                                name="sketch_button_process"
                                id="sketch_button_process"
                                value=" PROCESS SKETCHES "
                                data-toggle="modal"
                                data-target="#SketchProcessingModal"
                                data-backdrop='static'
                                <?php if ($tempfilecount == 0)
                                    echo 'disabled'; ?> />
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <!-- Start: Footer -->
        <?php require "./logic/footer.php"; ?>
        <!-- End: Footer -->
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
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>