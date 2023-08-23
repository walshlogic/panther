<?php
// This is a git comment #1
// screen name text and button information to display top of this page
$screenTitle = "Dashboard";
// collects current date and time
$currentDateTime = new DateTime('now', new DateTimeZone('America/New_York'));
// formats current date and time (l <-lower L=full day)(F=full month)(j=num date/S=suffix)(Y=full year)
$screenTitleMidText = ("Last Updated: ") . $currentDateTime->format("l, F jS, Y @ g:i A");
// this screen button icon
$screenTitleRightButtonIcon = "fa-recycle";
// this screen button text
$screenTitleRightButtonText = " Refresh";
// this screen button action = refresh page to update data and date/time
$screenTitleRightButtonAction = header("");
// places favicon from img/favicons/??color?? onto pages
// directory used to hold sketch files created by Vision. stored before moving to photos folder
//$tempdirectory = "G:/pa_photos/zSketches/";
$tempdirectory = "/mnt/paphotos/zSketches/";
// set variable to count the number of files within the sketches directory
$tempfilecount = count(glob($tempdirectory . "*"));
require './logic/favicon.php';
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
    <title>PANTHER | Home</title>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Start: Side Nav Bar --> <?php require "./logic/sidebar.php"; ?>
        <!-- End: Side Nav Bar -->
        <!-- Start: Content Wrapper -->
        <div id="content-wrapper"
            class="d-flex flex-column">
            <!-- Start: Main Content Area -->
            <div id="content">
                <!-- Start: Top Bar --> <?php require "./logic/topbar.php"; ?>
                <!-- End: Top Bar -->
                <!-- Start: Page Content -->
                <div class="container-fluid">
                    <!-- Start: Screen Title Bar (info displayed below top bar identifiy screen) -->
                    <!-- this screen display current date time of last refresh | see top PHP code -->
                    <?php require "./logic/screentitlebar.php"; ?>
                    <!-- End: Screen Title Bar -->
                    <!-- Content Row -->
                    <!-- Start: Pending Sketch Files Card -->
                    <div class="row">
                        <!-- Start: Pending Sketch Files Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1"> PENDING
                                                SKETCH FILES TO IMPORT </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php
                                                // Define the foldersize() and format_size() functions first
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

                                                    $endIndex = strpos($size, ".") + 2; // Adjusted endIndex to show two decimal places
                                                    return substr($size, 0, $endIndex) . ' ' . $units[$i];
                                                }

                                                if ($tempfilecount > 0) {
                                                    echo number_format($tempfilecount);
                                                    echo ' FILES (';
                                                    $units = explode(' ', 'B KB MB GB TB PB');
                                                    $SIZE_LIMIT = 5368709120; // 5 GB
                                                    $disk_used = foldersize("/mnt/paphotos/zSketches/");
                                                    //$disk_used = foldersize("G:/pa_photos/zSketches/");\\putnam-fl\dfsroot\GroupDirs\pa
                                                    $disk_remaining = $SIZE_LIMIT - $disk_used;
                                                    echo format_size($disk_used);
                                                    echo ')';
                                                } else {
                                                    echo "NO FILES TO PROCESS";
                                                }
                                                ?> </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-folder-open fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End: Pending Sketch Files Card -->
                        <!-- Start: Homestead vs All Residential Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                HOMESTEAD vs ALL RESIDENTIAL</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">43%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-secondary"
                                                            role="progressbar"
                                                            style="width: 50%"
                                                            aria-valuenow="50"
                                                            aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                GREENBELT (YTD)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-tree fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                                GREENBELT vs ALL LAND</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">19%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-secondary"
                                                            role="progressbar"
                                                            style="width: 50%"
                                                            aria-valuenow="50"
                                                            aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Appraised Value (YTD)</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle"
                                            href="#"
                                            role="button"
                                            id="dropdownMenuLink"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item"
                                                href="#">Current Month to Date</a>
                                            <a class="dropdown-item"
                                                href="#">Past Calendar Month</a>
                                            <a class="dropdown-item"
                                                href="#">Current Calendar Year</a>
                                            <a class="dropdown-item"
                                                href="#">Past Calendar Year</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item"
                                                href="#">Custom Date Range</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle"
                                            href="#"
                                            role="button"
                                            id="dropdownMenuLink"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item"
                                                href="#">Action</a>
                                            <a class="dropdown-item"
                                                href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item"
                                                href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Direct </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Social </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Referral </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">HOMESTEAD COMPLETION</h6>
                                </div>
                                <div class="card-body">
                                    <h4 class="small font-weight-bold">TERRITORY 1 <span class="float-right">67%</span>
                                    </h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-danger"
                                            role="progressbar"
                                            style="width: 67%"
                                            aria-valuenow="67"
                                            aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">TERRITORY 2 <span
                                            class="float-right">COMPLETE!</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-warning"
                                            role="progressbar"
                                            style="width: 100%"
                                            aria-valuenow="100"
                                            aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">TERRITORY 3 <span class="float-right">83%</span>
                                    </h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar"
                                            role="progressbar"
                                            style="width: 83%"
                                            aria-valuenow="83"
                                            aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">TERRITORY 4 <span class="float-right">19%</span>
                                    </h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar bg-info"
                                            role="progressbar"
                                            style="width: 19%"
                                            aria-valuenow="19"
                                            aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <h4 class="small font-weight-bold">TERRITORY 5 <span
                                            class="float-right">COMPLETE!</span></h4>
                                    <div class="progress">
                                        <div class="progress-bar bg-success"
                                            role="progressbar"
                                            style="width: 100%"
                                            aria-valuenow="100"
                                            aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Color System -->
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-primary text-white shadow">
                                        <div class="card-body"> Primary <div class="text-white-50 small">#4e73df</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-success text-white shadow">
                                        <div class="card-body"> Success <div class="text-white-50 small">#1cc88a</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-info text-white shadow">
                                        <div class="card-body"> Info <div class="text-white-50 small">#36b9cc</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-warning text-white shadow">
                                        <div class="card-body"> Warning <div class="text-white-50 small">#f6c23e</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-danger text-white shadow">
                                        <div class="card-body"> Danger <div class="text-white-50 small">#e74a3b</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-secondary text-white shadow">
                                        <div class="card-body"> Secondary <div class="text-white-50 small">#858796</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-light text-black shadow">
                                        <div class="card-body"> Light <div class="text-black-50 small">#f8f9fc</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="card bg-dark text-white shadow">
                                        <div class="card-body"> Dark <div class="text-white-50 small">#5a5c69</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <!-- Illustrations -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4"
                                            style="width: 25rem;"
                                            src="img/undraw_posting_photo.svg"
                                            alt="...">
                                    </div>
                                    <p>Text area with link <a target="_blank"
                                            rel="nofollow"
                                            href="https://undraw.co/">Link</a>, more text!</p>
                                </div>
                            </div>
                            <!-- Approach -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                                </div>
                                <div class="card-body">
                                    <p>Text Area.</p>
                                    <p class="mb-0">Text Area.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End: Main Content -->
            <!-- Start: Footer --> <?php require "./logic/footer.php"; ?>
            <!-- End: Footer -->
        </div>
        <!-- End: Content Wrapper -->
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
                <div class="modal-body">Select "Logout" to end your current session or "Cancel".</div>
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
    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
</body>

</html>