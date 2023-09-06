<?php
require './util.php';
// /\/\/\/\/\/\/\/\
// screen name text and button information to display top of this page
// \/\/\/\/\/\/\/\/
$screenTitle = "ADMIN | INVENTORY ITEM MANAGER";
$screenTitleMidText = "";
// /\/\/\/\/\/\/\/\
// title button icon sent to screentitlebar.
// \/\/\/\/\/\/\/\/
$screenTitleRightButtonIcon = "fa-plus";
// /\/\/\/\/\/\/\/\
// title button text sent to screentitlebar.php
// \/\/\/\/\/\/\/\/
$screenTitleRightButtonText = " ADD INVENTORY ITEM";
// /\/\/\/\/\/\/\/\
// title button action sent to screentitlebar.php
// \/\/\/\/\/\/\/\/
$screenTitleRightButtonModal = "#addinventoryitem";
?>
<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (isset($_SESSION['message'])) {
    ?>
    <div class="alert alert-info text-center"
        style="margin-top:20px;">
        <?php echo $_SESSION['message']; ?>
    </div>
    <?php
    unset($_SESSION['message']);
}
?>

<head>
    <!-- /\/\/\/\/\/\/\/\ -->
    <!-- places favicon from img/favicons/??color?? onto tabs -->
    <!-- \/\/\/\/\/\/\/\/ -->
    <?php require_once './logic/favicon.php'; ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"
        content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="">
    <meta name="author"
        content="Will Walsh | wbwalsh@gmail.com">
    <!-- /\/\/\/\/\/\/\/\ -->
    <!-- browser tab title pulled from the var in above php code -->
    <!-- \/\/\/\/\/\/\/\/ -->
    <title>PANTHER | Inventory Manager</title>
    <!-- /\/\/\/\/\/\/\/\ -->
    <!-- custom fonts for this template -->
    <!-- \/\/\/\/\/\/\/\/ -->
    <link href="./vendor/fontawesome-free/css/all.min.css"
        rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- /\/\/\/\/\/\/\/\ -->
    <!-- custom styles for this template -->
    <!-- \/\/\/\/\/\/\/\/ -->
    <link href="css/sb-admin-2.min.css"
        rel="stylesheet">
    <!-- /\/\/\/\/\/\/\/\ -->
    <!-- custom styles for this page -->
    <!-- \/\/\/\/\/\/\/\/ -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css"
        rel="stylesheet">
</head>

<body id="page-top">
    <!-- /\/\/\/\/\/\/\/\ -->
    <!-- page wrapper -->
    <!-- \/\/\/\/\/\/\/\/ -->
    <div id="wrapper">
        <!-- /\/\/\/\/\/\/\/\ -->
        <!-- navigation sidebar -->
        <!-- \/\/\/\/\/\/\/\/ -->
        <?php require "./logic/sidebar.php"; ?>
        <!-- /\/\/\/\/\/\/\/\ -->
        <!-- content wrapper -->
        <!-- \/\/\/\/\/\/\/\/ -->
        <div id="content-wrapper"
            class="d-flex flex-column">
            <!-- /\/\/\/\/\/\/\/\ -->
            <!-- main content area -->
            <!-- \/\/\/\/\/\/\/\/ -->
            <!-- Main Content -->
            <div id="content">
                <!-- /\/\/\/\/\/\/\/\ -->
                <!-- page topbar -->
                <!-- \/\/\/\/\/\/\/\/ -->
                <?php require "./logic/topbar.php"; ?>
                <!-- /\/\/\/\/\/\/\/\ -->
                <!-- begin page content -->
                <!-- \/\/\/\/\/\/\/\/ -->
                <div class="container-fluid">
                    <!-- /\/\/\/\/\/\/\/\ -->
                    <!-- screen title bar (info displayed below top bar identifiy screen) -->
                    <!-- \/\/\/\/\/\/\/\/ -->
                    <?php require "./logic/screentitlebar.php"; ?>
                    <!-- /\/\/\/\/\/\/\/\ -->
                    <!-- inventory data table -->
                    <!-- \/\/\/\/\/\/\/\/ -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered"
                                    id="dataTable"
                                    width="100%"
                                    cellspacing="0">
                                    <!-- /\/\/\/\/\/\/\/\ -->
                                    <!-- inventory items table header and footer column headings -->
                                    <!-- \/\/\/\/\/\/\/\/ -->
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-light font-weight-bolder">
                                                <center>ASSET#</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>MAKE</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>MODEL</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>S/N</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>RECEIVED</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>COST</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>LOCATION</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>STATUS</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>ACTIONS</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tfoot class="bg-primary">
                                        <tr>
                                            <th class="text-light font-weight-bolder">
                                                <center>ASSET#</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>MAKE</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>MODEL</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>S/N</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>RECEIVED</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>COST</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>LOCATION</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>STATUS</center>
                                            </th>
                                            <th class="text-light font-weight-bolder">
                                                <center>ACTIONS</center>
                                            </th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        include_once('./db/dbconn.php');
                                        $database = new Connection();
                                        $db = $database->open();
                                        try {
                                            $sql = 'SELECT * FROM items ORDER BY inv_item_make ASC';
                                            foreach ($db->query($sql) as $row) {
                                                ?>
                                                <tr>
                                                    <td class="font-weight-bolder text-uppercase align-middle">
                                                        <center>
                                                            <?php echo $row['county_dept_num'] . "-" . $row['county_asset_id'] ?>
                                                        </center>
                                                    </td>
                                                    <td class="font-weight-bolder text-uppercase align-middle">
                                                        <center>
                                                            <?php echo $row['inv_item_make'] ?>
                                                        </center>
                                                    </td>
                                                    <td class="font-weight-bolder text-uppercase align-middle">
                                                        <center>
                                                            <?php echo $row['inv_item_model'] ?>
                                                        </center>
                                                    </td>
                                                    <td class="font-weight-bolder text-uppercase align-middle">
                                                        <center>
                                                            <?php echo $row['inv_item_sn'] ?>
                                                        </center>
                                                    </td>
                                                    <td class="font-weight-bolder text-lowercase align-middle">
                                                        <center>
                                                            <?php
                                                            $view_date = date(
                                                                "m-d-Y",
                                                                strtotime($row['inv_received_date'])
                                                            );
                                                            echo $view_date;
                                                            ?>
                                                        </center>
                                                    </td>
                                                    <td class="font-weight-bolder text-lowercase text-right align-middle">
                                                        <?php
                                                        // converts inventory item cost into currency format without decimal and rounding up/down as needed
                                                        $price = $row['inv_received_cost'];
                                                        echo '$' . number_format($price);
                                                        ?>
                                                        </center>
                                                    </td>
                                                    <td class="font-weight-bolder text-uppercase align-middle">
                                                        <center>
                                                            <?php echo $row['inv_item_location'] ?>
                                                        </center>
                                                    </td>
                                                    <td class="font-weight-bolder text-uppercase align-middle">
                                                        <center>
                                                            <?php
                                                            echo $row['inv_item_status']
                                                                ? "Active" : "Inactive"
                                                                ?>
                                                        </center>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <a href="#view_inv_item_<?php echo $row['inv_id']; ?>"
                                                                class="btn btn-success btn-sm align-middle"
                                                                data-bs-toggle="modal"
                                                                data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="VIEW ITEM">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    width="18"
                                                                    height="18"
                                                                    fill="currentColor"
                                                                    class="bi bi-eye-fill"
                                                                    viewBox="0 0 16 16">
                                                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                                                    <path
                                                                        d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                                                </svg>
                                                            </a>
                                                            <a href="#edit_inv_item_<?php echo $row['inv_id']; ?>"
                                                                class="btn btn-warning btn-sm align-middle"
                                                                data-bs-toggle="modal"
                                                                data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="EDIT ITEM"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    width="18"
                                                                    height="18"
                                                                    fill="currentColor"
                                                                    class="bi bi-pencil-fill"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                                                </svg></a>
                                                            <a href="#delete_inv_item_<?php echo $row['inv_id']; ?>"
                                                                class="btn btn-danger btn-sm align-middle"
                                                                data-bs-toggle="modal"
                                                                data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="DELETE ITEM"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    width="18"
                                                                    height="18"
                                                                    fill="currentColor"
                                                                    class="bi bi-trash3-fill"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                                                </svg></a>
                                                        </center>
                                                    </td>
                                                    <?php include('inv_modal_add.php'); ?>
                                                    <?php include('inv_modal_delete.php'); ?>
                                                    <?php include('inv_modal_edit.php'); ?>
                                                    <?php include('inv_modal_view.php'); ?>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        catch (PDOException $e) {
                                            echo "ERROR! Problem with Database Connection (PANTHER Error #DB100): " . $e->getMessage();
                                        }
                                        // close database connection
                                        $database->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /\/\/\/\/\/\/\/\ -->
                    <!-- footer -->
                    <!-- \/\/\/\/\/\/\/\/ -->
                    <?php require "./logic/footer.php"; ?>
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
        </div <!--
            Bootstrap
            core
            JavaScript-->
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