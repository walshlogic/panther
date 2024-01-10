<?php
require './util.php';
// screen name text and button information to display top of this page
$screenTitle = "ADMIN | PHOTO MANAGER - SITE VISIT CODES";
$screenTitleMidText = "";
// title button icon sent to screentitlebar.
$screenTitleRightButtonIcon = "fa-plus";
// title button text sent to screentitlebar.php
$screenTitleRightButtonText = " ADD VISIT CODE";
// title button action sent to screentitlebar.php
$screenTitleRightButtonLink = "set_visit_codes_form.php";
// This ID links the button's action to the script (bottom of page)
$screenTitleRightButtonId = "addVisitCodeButton";


session_start();
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-info text-center' style='margin-top:20px;'>" . $_SESSION['message'] . "</div>";
    unset($_SESSION['message']);
}

// Read data from CSV file
$csvFilePath = './data/photoVisitCodes.csv';
$csvData = readVisitCodesCSV($csvFilePath); // Add this line to define $csvData

// Function to read data from the new CSV file
function readVisitCodesCSV($csvFile)
{
    $file_handle = fopen($csvFile, 'r');
    $lines = [];
    while (!feof($file_handle)) {
        $line = fgetcsv($file_handle, 1024);
        if ($line) {
            $lines[] = $line;
        }
    }
    fclose($file_handle);

    // Sort the array based on the Visit Code field
    usort($lines, function ($a, $b) {
        return strcmp($a[1], $b[1]);
    });

    return $lines;
}


?>

<head>
    <!-- places favicon from img/favicons/??color?? onto pages -->
    <?php require_once './logic/favicon.php'; ?>
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
        <!-- START: Nav Sidebar -->
        <?php require "./logic/sidebar.php"; ?>
        <!-- END: Nav Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper"
            class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- START: Topbar -->
                <?php require "./logic/topbar.php"; ?>
                <!-- END: Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Start: Screen Title Bar (info displayed below top bar identifiy screen) -->
                    <?php require "./logic/screentitlebar.php"; ?>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered"
                                    id="dataTable"
                                    width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Visit Code</th>
                                            <th>Visit Text</th>
                                            <th>Active</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($csvData as $index => $row): ?>
                                            <tr>
                                                <td>
                                                    <?= htmlspecialchars($row[1]) ?>
                                                </td>
                                                <td>
                                                    <?= htmlspecialchars($row[2]) ?>
                                                </td>
                                                <td>
                                                    <?= $row[3] == 1 ? 'Yes' : 'No' ?>
                                                </td>
                                                <td>
                                                    <!-- Actions like Edit/Delete based on your application logic -->
                                                    <a href="edit_visit_code.php?edit=<?= $index ?>"
                                                        class="btn btn-primary">Edit</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
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
            <!-- Start: Footer -->
            <?php require "./logic/footer.php"; ?>
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
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Event listener for the 'addVisitCodeButton' to open 'emp_form.php' page
                document.getElementById('addVisitCodeButton').addEventListener('click', function () {
                    window.location.href = 'set_visit_codes_form.php';
                });
            });
        </script>
</body>

</html>