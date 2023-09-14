<!DOCTYPE html>
<html lang="en"> <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require './util.php';
require './ske_modal_view.php';
require './logic/favicon.php';

$screenTitle = "SKETCH MANAGER | PENDING UPLOAD FILES";
$screenTitleMidText = "";
$screenTitleRightButtonIcon = "fa-plus";
$screenTitleRightButtonText = " ";
$screenTitleRightButtonModal = "#addnew";

$sketchDirectory = '/mnt/paphotos/Sketches/';

// Pagination Logic
$itemsPerPage = 50;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

$allFiles = glob($sketchDirectory . '*.jpg');
// Define a custom sorting function
function customFileSort($a, $b)
{
    $aParts = explode('_', basename($a));
    $bParts = explode('_', basename($b));

    $aNumber = intval($aParts[0]);
    $bNumber = intval($bParts[0]);

    return $aNumber - $bNumber;
}

usort($allFiles, 'customFileSort'); // Sort the files using the custom function
$totalFiles = count($allFiles);
$totalPages = ceil($totalFiles / $itemsPerPage);

$files = array_slice($allFiles, $offset, $itemsPerPage);
$startRecord = $offset + 1;
$endRecord = $offset + count($files);

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-info text-center" style="margin-top:20px;">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
?>

<head>
    <link rel="icon"
        href="./img/favicons/white/favicon.ico"
        type="image/ico"
        sizes="16x16">
    <!-- places favicon from img/favicons/??color?? onto pages --> <?php require_once './logic/favicon.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"
        content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="">
    <meta name="author"
        content="">
    <!-- windows tab title pulled from the var in above php section -->
    <title>PANTHER | Sketch Manager</title>
    <!-- Custom fonts for this template -->
    <link href="./vendor/fontawesome-free/css/all.min.css"
        rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css"
        rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css"
        rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Start: Side Nav Bar --> <?php require "./logic/sidebar.php"; ?>
        <!-- End: Side Nav Bar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper"
            class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Start: Top Bar --> <?php require "./logic/topbar.php"; ?>
                <!-- End: Top Bar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Start: Screen Title Bar (info displayed below top bar identify screen) -->
                    <?php require "./logic/screentitlebar.php"; ?>
                    <!-- End: Screen Title Bar -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="pagination-container text-center">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <!-- First Page Link -->
                                            <li class="page-item <?php if ($page == 1): ?>disabled<?php endif; ?>">
                                                <a class="page-link bg-dark text-light font-weight-bolder"
                                                    href="?page=1">FIRST</a>
                                            </li>
                                            <!-- Previous Page Link -->
                                            <li class="page-item <?php if ($page == 1): ?>disabled<?php endif; ?>">
                                                <a class="page-link bg-dark text-light font-weight-bolder"
                                                    href="<?php if ($page > 1): ?>?page=<?php echo $page - 1; ?><?php endif; ?>">PREVIOUS</a>
                                            </li>
                                            <!-- Dynamic Page Links --> <?php
                                        $start = max($page - 5, 1);
                                        $end = min($page + 4, $totalPages);
                                        if ($page <= 6) {
                                            $end = min(10, $totalPages);
                                        }
                                        if ($page >= $totalPages - 5) {
                                            $start = max($totalPages - 9, 1);
                                        }

                                        for ($i = $start; $i <= $end; $i++):
                                            ?> <li class="page-item <?php if ($i == $page): ?>active<?php endif; ?>">
                                                <a class="page-link"
                                                    style="color: <?php echo ($i == $page) ? '#FFFFFF' : '#696969'; ?>;"
                                                    href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            </li> <?php endfor; ?>
                                            <!-- Next Page Link -->
                                            <li
                                                class="page-item <?php if ($page == $totalPages): ?>disabled<?php endif; ?>">
                                                <a class="page-link bg-dark text-light font-weight-bolder"
                                                    href="<?php if ($page < $totalPages): ?>?page=<?php echo $page + 1; ?><?php endif; ?>">NEXT</a>
                                            </li>
                                            <!-- Last Page Link -->
                                            <li
                                                class="page-item <?php if ($page == $totalPages): ?>disabled<?php endif; ?>">
                                                <a class="page-link bg-dark text-light font-weight-bolder"
                                                    href="?page=<?php echo $totalPages; ?>">LAST</a>
                                            </li>
                                            <p
                                                style="font-size: 1.2em; font-weight: bolder; text-align: center; color: #696969;">
                                                &nbsp;&nbsp;&nbsp;PAGE <?php echo $page; ?> OF
                                                <?php echo $totalPages; ?> PAGES &nbsp;&nbsp;|&nbsp;&nbsp;VIEWING
                                                RECORDS <?php echo $startRecord; ?> - <?php echo $endRecord; ?> </p>
                                        </ul>
                                    </nav>
                                </div>
                                <table class="table table-bordered"
                                    id="dataTable"
                                    width="100%"
                                    cellspacing="0">
                                    <thead class="bg-dark">
                                        <tr>
                                        <tr>
                                            <th class="text-light font-weight-bolder">
                                                <center>SKETCH</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>FILE NAME</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>SIZE</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>UPLOADED</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>ACTIONS</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody> <?php
                                        foreach ($files as $file) {
                                            $filename = basename($file);
                                            $filesize = filesize($file);
                                            $filemtime = date("d/m/Y g:i A", filemtime($file));
                                            $thumbnail = base64_encode(file_get_contents($file));

                                            // Unique identifier for modal
                                            $modalID = "modal" . md5($filename);

                                            echo "<tr>";
                                            echo '<td class="align-middle text-center">';
                                            echo "<img src='data:image/jpeg;base64,$thumbnail' class='my-auto' style='width:100px; height:100px;'><br><br>";
                                            echo "</td>";
                                            echo '<td class="font-weight-bolder text-uppercase align-middle">' . $filename . '</td>';
                                            echo '<td class="font-weight-bolder text-uppercase align-middle text-center">' . formatSizeUnits($filesize) . '</td>';
                                            echo '<td class="font-weight-bolder text-uppercase align-middle text-center">' . $filemtime . '</td>';
                                            echo '<td class="font-weight-bolder text-uppercase align-middle text-center">';
                                            echo '<button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#' . $modalID . '">VIEW</button>';
                                            echo '</td>';
                                            echo "</tr>";

                                            // Modal for each file
                                            include('ske_view_info.php');
                                        }


                                        ?> </tbody>
                                    <tfoot class="bg-dark">
                                        <tr>
                                            <th class="text-light font-weight-bolder">
                                                <center>SKETCH</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>FILE NAME</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>SIZE</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>UPLOADED</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>ACTIONS</center>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Start: Footer --> <?php require "./logic/footer.php"; ?> <script
                        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
                        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
                        crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
                        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
                        crossorigin="anonymous"></script>
                    <!-- bootstrap header to control table items by number to view and sort by each column with up/down arros -->
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
                                <div class="modal-body">Select "Logout" below if you are ready to end your current
                                    session. </div>
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
        <!-- <script src="vendor/datatables/jquery.dataTables.min.js"></script> -->
        <!-- <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script> -->
        <!-- Page level custom scripts -->
        <!-- <script src="js/demo/datatables-demo.js"></script> -->
        <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "retrieve": true,
                "paging": false,
                "pageLength": 50,
                "lengthChange": false,
                "lengthMenu": [
                    [50, 50, 50, 50],
                    [50, 50, 50, 50]
                ] // Show 50 rows only
            });
        });
        </script>
        <style>
        div.dataTables_length {
            display: none;
        }
        </style>
</body>

</html> <?php
// convert filesize into readable format using kb, mb, or gb
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