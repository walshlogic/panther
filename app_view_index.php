<?php
require './util.php';
// screen name text and button information to display top of this page
$screenTitle = "ADMIN | APPRAISER MANAGER";
$screenTitleMidText = "";
// title button icon sent to screentitlebar.
$screenTitleRightButtonIcon = "fa-plus";
// title button text sent to screentitlebar.php
$screenTitleRightButtonText = " ADD APPRAISER";
// title button action sent to screentitlebar.php
$screenTitleRightButtonLink = "app_edit_form.php";
?>
<!DOCTYPE html>
<html lang="en"> <?php
session_start();
if (isset($_SESSION['message'])) {
    ?> <div class="alert alert-info text-center"
    style="margin-top:20px;"> <?php echo $_SESSION['message']; ?> </div> <?php
    unset($_SESSION['message']);
}
?>

<head>
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
    <title>PANTHER | Appraiser Manager</title>
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
        <!-- START: Nav Sidebar --> <?php require "./logic/sidebar.php"; ?>
        <!-- END: Nav Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper"
            class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- START: Topbar --> <?php require "./logic/topbar.php"; ?>
                <!-- END: Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Start: Screen Title Bar (info displayed below top bar identifiy screen) -->
                    <?php require "./logic/screentitlebar.php"; ?>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <!-- //////////////////////////////////// -->
                                <!-- //////////////////////////////////// -->
                                <tbody> <?php
                                    // Path to the CSV file
                                    $csvFilePath = 'appraisers.csv';

                                    // Function to read CSV file
                                    function readCSV($csvFile)
                                    {
                                        $file_handle = fopen($csvFile, 'r');
                                        while (!feof($file_handle)) {
                                            $line_of_text[] = fgetcsv($file_handle, 1024);
                                        }
                                        fclose($file_handle);
                                        return $line_of_text;
                                    }

                                    // Read data from CSV file
                                    $csvData = readCSV($csvFilePath);

                                    // Remove the first row if it's headers
                                    array_shift($csvData);

                                    // Loop through the data and populate the table
                                    foreach ($csvData as $row) {
                                        if (is_array($row)) {
                                            echo "<tr>";
                                            echo "<td class='w-25 font-weight-bolder text-uppercase align-middle'><img class='img img-profile w-25' src='./img/emp/" . $row[0] . "' alt=''>" . $row[1] . "</td>";
                                            echo "<td class='font-weight-bolder text-uppercase align-middle'><center>" . $row[2] . "</center></td>";
                                            echo "<td class='font-weight-bolder text-uppercase align-middle'>" . $row[3] . "</td>";
                                            echo "<td class='font-weight-bolder text-uppercase align-middle'><center>" . $row[4] . "</center></td>";
                                            // Actions column (edit this according to your requirement)
                                            echo "<td class='align-middle'><center> [Action buttons here] </center></td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?> </tbody>
                                <!-- //////////////////////////////////// -->
                                <!-- //////////////////////////////////// -->
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
                                    session.</div>
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
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Page level custom scripts -->
        <script src="js/demo/datatables-demo.js"></script>
</body>

</html>