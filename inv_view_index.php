<?php
session_start();
include_once('./db/db_config.php');
include_once('./db/db_conn.php');

$screenTitle = "ADMIN | INVENTORY ITEM MANAGER";
$screenTitleMidText = "";
$screenTitleRightButtonIcon = "fa-plus";
$screenTitleRightButtonText = " ADD INVENTORY ITEM";
$screenTitleRightButtonModal = "#addinventoryitem";
?>
<!DOCTYPE html>
<html lang="en">

<head> <?php
    if (isset($_SESSION['message'])):
        ?> <div class="alert alert-info text-center mt-4"> <?= $_SESSION['message']; ?> </div> <?php
        unset($_SESSION['message']);
    endif;

    require_once './logic/favicon.php';
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"
        content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="">
    <meta name="author"
        content="Will Walsh | wbwalsh@gmail.com">
    <title>PANTHER | Inventory Manager</title>
    <link href="./vendor/fontawesome-free/css/all.min.css"
        rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css"
        rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css"
        rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper"> <?php require "./logic/sidebar.php"; ?> <div id="content-wrapper"
            class="d-flex flex-column">
            <div id="content"> <?php require "./logic/topbar.php"; ?> <div class="container-fluid">
                    <?php require "./logic/screentitlebar.php"; ?> <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered"
                                    id="dataTable"
                                    width="100%"
                                    cellspacing="0">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">ASSET#</th>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">MAKE</th>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">MODEL</th>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">S/N</th>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">RECEIVED</th>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">COST</th>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">LOCATION</th>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">STATUS</th>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="bg-primary">
                                        <tr>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">ASSET#</th>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">MAKE</th>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">MODEL</th>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">S/N</th>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">RECEIVED</th>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">COST</th>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">LOCATION</th>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">STATUS</th>
                                            <th class="text-light font-weight-bolder"
                                                style="text-align:center;">ACTIONS</th>
                                        </tr>
                                    </tfoot>
                                    <tbody> <?php
                                    $database = new Database($dsn, $username, $password);
                                    $db = $database->connect();
                                      try {$sql = 'SELECT * FROM items ORDER BY inv_item_make ASC';
                                        foreach ($db->query($sql) as $row):
                                                ?> <tr>
                                            <td class="font-weight-bolder text-uppercase align-middle"
                                                style="text-align:center;">
                                                <?= $row['county_dept_num'] . "-" . $row['county_asset_id']; ?> </td>
                                            <td class="font-weight-bolder text-uppercase align-middle"
                                                style="text-align:center;"> <?= $row['inv_item_make']; ?> </td>
                                            <td class="font-weight-bolder text-uppercase align-middle"
                                                style="text-align:center;"> <?= $row['inv_item_model']; ?> </td>
                                            <td class="font-weight-bolder text-uppercase align-middle"
                                                style="text-align:center;"> <?= $row['inv_item_serial_num']; ?> </td>
                                            <td class="font-weight-bolder text-uppercase align-middle"
                                                style="text-align:center;"> <?= $row['inv_item_date_received']; ?> </td>
                                            <td class="font-weight-bolder text-uppercase align-middle"
                                                style="text-align:center;"> <?= "$" . $row['inv_item_cost']; ?> </td>
                                            <td class="font-weight-bolder text-uppercase align-middle"
                                                style="text-align:center;"> <?= $row['inv_item_location']; ?> </td>
                                            <td class="font-weight-bolder text-uppercase align-middle"
                                                style="text-align:center;"> <?= $row['inv_item_status']; ?> </td>
                                            <td class="align-middle"
                                                style="text-align:center;">
                                                <!-- Action buttons -->
                                                <!-- ... (your action buttons here) -->
                                            </td>
                                        </tr> <?php
                                            endforeach;
                                        }
                                    catch (PDOException $e) {
                                        error_log("ERROR! Problem with Database Connection (PANTHER Error #DB100): " . $e->getMessage());
                                    }
                                    $database->disconnect();

                                    ?> </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <?php require "./logic/footer.php"; ?> <script src="./vendor/jquery/jquery.min.js"></script>
                    <script src="./vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                    <script src="./vendor/jquery-easing/jquery.easing.min.js"></script>
                    <script src="js/sb-admin-2.min.js"></script>
                    <script src="./vendor/datatables/jquery.dataTables.min.js"></script>
                    <script src="./vendor/datatables/dataTables.bootstrap4.min.js"></script>
                    <script src="js/demo/datatables-demo.js"></script>
                </div>
            </div>
        </div>
    </div>
</body>

</html>