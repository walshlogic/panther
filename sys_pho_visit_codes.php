<?php
require './util.php';
$util = new Util();

// Initialize the session and check for any flash messages
session_start();
$flashMessage = '';
if (isset($_SESSION['message'])) {
    $flashMessage = $_SESSION['message'];
    unset($_SESSION['message']);
}

// Determine if inactive codes should be included based on the query parameter
$includeInactive = filter_input(INPUT_GET, 'includeInactive', FILTER_VALIDATE_BOOLEAN);

// Define the path to the CSV file
$csvFilePath = './data/visitCodes.csv';

// Read data from CSV file, passing the $includeInactive flag to the function
$csvData = readVisitCodesCSV($csvFilePath, $includeInactive);

// Visit Codes Function to read visit codes from CSV file
function readVisitCodesCSV($csvFile, $includeInactive = false)
{
    $lines = [];
    if (($file_handle = fopen($csvFile, 'r')) !== FALSE) {
        while (($line = fgetcsv($file_handle, 1024)) !== FALSE) {
            // Skip inactive codes if not including them
            if (!$includeInactive && $line[3] == '0') {
                continue;
            }
            $lines[] = $line;
        }
        fclose($file_handle);

        // Sort by Visit Code field
        usort($lines, function ($a, $b) {
            return strcmp($a[1], $b[1]);
        });
    }
    return $lines;
}

// Page setup - uniformed/unique page headers
$screenTitle = "ADMIN | PHOTO MANAGER - SITE VISIT CODES";
$screenTitleMidText = "";
$screenTitleRightButtonIcon = "fa-plus";
$screenTitleRightButtonText = "ADD VISIT CODE";
$screenTitleRightButtonLink = "sys_pho_visit_codes_form.php";
$screenTitleRightButtonId = "addVisitCodeButton";
?>
<!DOCTYPE html>
<html lang="en">

<head>
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
    <title>PANTHER | Appraiser Manager</title>
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
    <style>
        .include-inactive-container {
            display: flex;
            align-items: center;
            margin-top: 20px;
            font-size: 1.2em;
            color: blue;
        }

        #includeInactive {
            margin: 0 10px 0 0;
            padding: 0;
            width: 24px;
            height: 24px;
            cursor: pointer;
        }

        .include-inactive-container label {
            font-weight: bold;
            margin: 0;
            cursor: pointer;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php require "./logic/sidebar.php"; ?>
        <div id="content-wrapper"
            class="d-flex flex-column">
            <div id="content">
                <?php require "./logic/topbar.php"; ?>
                <div class="container-fluid">
                    <?php require "./logic/screentitlebar.php"; ?>
                    <?php if ($flashMessage): ?>
                        <div class='alert alert-info text-center'
                            style='margin-top:20px;'>
                            <?= $flashMessage ?>
                        </div>
                    <?php endif; ?>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered"
                                    id="dataTable"
                                    width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>VISIT DESCRIPTION</th>
                                            <th>VISIT CODE</th>
                                            <th>ACTIVE</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($csvData as $index => $row): ?>
                                            <tr>
                                                <td>
                                                    <?= htmlspecialchars($row[2]) ?>
                                                </td>
                                                <td>
                                                    <?= htmlspecialchars($row[1]) ?>
                                                </td>
                                                <td>
                                                    <?= $row[3] == 1 ? 'Yes' : 'No' ?>
                                                </td>
                                                <td>
                                                    <!-- Actions like Edit/Delete based on your application logic -->
                                                    <a href="sys_pho_visit_codes_form.php?edit=<?= htmlspecialchars($row[0]) ?>"
                                                        class="btn btn-primary">EDIT</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <!-- Checkbox to include Inactive codes -->
                                <div class="include-inactive-container">
                                    <input type="checkbox"
                                        id="includeInactive"
                                        name="includeInactive"
                                        onclick="toggleInactiveCodes()">
                                    <label for="includeInactive">Include Inactive Codes in the List</label>
                                </div>
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
                // Event listener for the 'addVisitCodeButton' to open 'sys_emp_form.php' page
                document.getElementById('addVisitCodeButton').addEventListener('click', function () {
                    window.location.href = 'sys_pho_visit_codes_form.php';
                });
            });
        </script>
        <script>
            // Script to toggle between only active codes and all codes
            function toggleInactiveCodes() {
                // Check the current state of the checkbox
                var includeInactive = document.getElementById('includeInactive').checked;
                // Redirect to the same page with the 'includeInactive' parameter
                // The value passed in the URL must be a string 'true' or 'false'
                window.location.href = '?includeInactive=' + (includeInactive ? 'true' : 'false');
            }
            // Set the checkbox state based on the URL parameter when the page loads
            document.getElementById('includeInactive').checked = new URLSearchParams(window.location.search).get(
                'includeInactive') === 'true';
        </script>
</body>

</html>