<?php
require './db/dbconn.php';
require 'util.php';
// screen name text and button information to display top of this page
$screenTitle = "VISION+ | QUICK VIEW";
$screenTitleMidText = "";
$screenTitleRightButtonIcon = "fa-filter";
$screenTitleRightButtonText = " FILTER RECORDS";
?>
<!DOCTYPE html>
<html lang="en">

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
    <title>PANTHER | Vision+</title>
    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css"
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
        <!-- Nav Sidebar -->
        <?php require "./logic/sidebar.php"; ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper"
            class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php require "./logic/topbar.php"; ?>
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
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-light font-weight-bolder">VID</th>
                                            <th class="text-light font-weight-bolder">ACCOUNT NUMBER</th>
                                            <th class="text-light font-weight-bolder">ACCOUNT OWNER</th>
                                            <th class="text-light font-weight-bolder">STREET</th>
                                            <th class="text-light font-weight-bolder">CITY</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="bg-primary">
                                            <th class="text-light font-weight-bolder">VID</th>
                                            <th class="text-light font-weight-bolder">ACCOUNT NUMBER</th>
                                            <th class="text-light font-weight-bolder">ACCOUNT OWNER</th>
                                            <th class="text-light font-weight-bolder">STREET</th>
                                            <th class="text-light font-weight-bolder">CITY</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        // $start and $display essential for pagination
                                        $database = new Connection();
                                        $db = $database->open();
                                        try {
                                            $sql = 'SELECT * FROM vis_plus_index ORDER BY rem_acct_num ASC';
                                            foreach ($db->query($sql) as $row) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php //echo $row['REM_PID'] ?>
                                                    </td>
                                                    <td>
                                                        <?php //echo $row['REM_ACCT_NUM'] ?>
                                                    </td>
                                                    <td>
                                                        <?php //echo $row['REM_OWN_NAME'] ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if (
                                                            $row['REM_PRCL_LOCN']
                                                            == '00 Unassigned Location RE'
                                                        ) {
                                                            //echo '<i style="color:silver">>> NO ASSIGNED ADDRESS <<</i>';
                                                        } else {
                                                            //echo $row['REM_PRCL_LOCN'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php //echo $row['REM_PRCL_LOCN_CITY'] ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        catch (PDOException $e) {
                                            //echo "ERROR! Problem with Database Connection (PANTHER Error #DB100): " . $e->getMessage();
                                        }
                                        // close database connection
                                        $database->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Content -->
            <!-- Footer -->
            <?php require "./logic/footer.php"; ?>
        </div>
    </div>
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
    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
</body>

</html>