<?php
require './util.php';

session_start();
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-info text-center' style='margin-top:20px;'>" . $_SESSION['message'] . "</div>";
    unset($_SESSION['message']);
}

// Determine if inactive departments should be included based on the query parameter
$includeInactive = filter_input(INPUT_GET, 'includeInactive', FILTER_VALIDATE_BOOLEAN);

// Path to the CSV file
$csvFilePath = './data/jobTitles.csv';

// Read data from CSV file, passing the $includeInactive flag to the function
$csvData = readTitlesCSV($csvFilePath, $includeInactive);

// Read departments from CSV file
function readTitlesCSV($csvFile, $includeInactive = false)
{
    $lines = [];
    if (($file_handle = fopen($csvFile, 'r')) !== FALSE) {
        while (($line = fgetcsv($file_handle, 1024)) !== FALSE) {
            // Skip inactive titles if not including them
            if (!$includeInactive && $line[2] == '0') {
                continue;
            }
            $lines[] = $line;
        }
        fclose($file_handle);

        // Sort by last name field
        usort($lines, function ($a, $b) {
            return strcmp($a[2], $b[2]);
        });
    }
    return $lines;
}


// Page setup - uniformed/unique page headers
$screenTitle = "PANTHER | JOB TITLES MANAGER";
$screenTitleMidText = "";
$screenTitleRightButtonIcon = "fa-plus";
$screenTitleRightButtonText = "ADD JOB TITLE";
$screenTitleRightButtonLink = "sys_job_form.php";
$screenTitleRightButtonId = "addJobTitleButton";
?>
<!DOCTYPE html>
<html lang="en">

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
    <title>PANTHER | Job Title Manager</title>
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
                    <!-- Start: Screen Title Bar (info displayed below top bar to identify screen) -->
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
                                            <!-- Headers for the job title table -->
                                            <th>JOB TITLE</th>
                                            <th>ACTIVE</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody> <?php foreach ($csvData as $index => $row): ?> <tr>
                                            <!-- job title name -->
                                            <td> <?= htmlspecialchars($row[1]) ?> </td>
                                            <!-- active -->
                                            <td> <?= $row[2] == 1 ? 'YES' : 'NO' ?> </td>
                                            <!-- edit button -->
                                            <td>
                                                <!-- Edit action button -->
                                                <a href='sys_job_form.php?edit=<?= htmlspecialchars($row[0]) ?>'
                                                    class='btn btn-primary'>Edit</a>
                                            </td>
                                        </tr> <?php endforeach; ?> </tbody>
                                </table>
                                <!-- Checkbox to include inactive job titles -->
                                <div class="include-inactive-container">
                                    <input type="checkbox"
                                        id="includeInactive"
                                        name="includeInactive"
                                        onclick="toggleInactiveJobTitles()">
                                    <label for="includeInactive">Include Inactive Job Titles in the List</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start: Footer --> <?php require "./logic/footer.php"; ?>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener for the 'addDepartmentButton' to open 'sys_dep_form.php' page
            document.getElementById('addJobTitleButton').addEventListener('click', function() {
                window.location.href = 'sys_job_form.php';
            });
        });
        </script>
        <script>
        // Script to toggle between only active employees and all employees
        function toggleInactiveJobTitles() {
            // Check the current state of the checkbox
            var includeInactive = document.getElementById('includeInactive').checked;
            // The value passed in the URL must be a string 'true' or 'false'
            window.location.href = '?includeInactive=' + (includeInactive ? 'true' : 'false');
        }
        // Set the checkbox state based on the URL parameter when the page loads
        document.getElementById('includeInactive').checked = new URLSearchParams(window.location.search).get(
            'includeInactive') === 'true';
        </script>
    </div>
</body>

</html>