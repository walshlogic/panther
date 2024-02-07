<?php
require './util.php';
// screen name text and button information to display top of this page
$screenTitle = "ADMIN | DEPARTMENT MANAGER";
$screenTitleMidText = "";
// title button icon sent to screentitlebar.
$screenTitleRightButtonIcon = "";
// title button text sent to screentitlebar.php
$screenTitleRightButtonText = "";
// title button action sent to screentitlebar.php
$screenTitleRightButtonLink = "";
// Check if editing an existing department name
$editing = isset($_GET['edit']);
$departmentNamesData = $editing ? getExistingDepartmentNamesData($_GET['edit']) : ['', '', ''];

// Function to retrieve existing data from CSV based on the given ID
function getExistingDepartmentNamesData($id)
{
    $filePath = './data/departments.csv';
    $file = fopen($filePath, 'r');

    while (($row = fgetcsv($file)) !== FALSE) {
        if ($row[0] == $id) { // Check if the ID matches
            fclose($file);
            return $row;
        }
    }

    fclose($file);
    return []; // Return empty array if not found
}


// Check if editing an existing department names
$editing = isset($_GET['edit']);
if ($editing) {
    $departmentData = getExistingDepartmentNamesData($_GET['edit']);
} else {
    $departmentData = ['', '', ''];
}
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
    <title>PANTHER | Departments</title>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* General container styles */
        .form-container {
            background: #ffffff;
            padding: 20px;
            margin: 20px auto;
            min-width: 600px;
            max-width: 800px;
            /* Adjust the width as needed */
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Flexbox alignment for form groups */
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        /* Label styles */
        .form-group label {
            width: 35%;
            /* Adjust the width as needed */
            text-align: right;
            margin-right: 10px;
            font-weight: bold;
            /* Space between label and input */
        }

        /* Input container styles */
        .input-container {
            width: 65%;
            /* Adjust the width as needed */
            display: flex;
            align-items: center;
        }

        /* Text input and select box styles */
        .input-container input[type="text"],
        .input-container select {
            width: 100%;
            /* Full width of the input container */
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }

        /* Checkbox alignment */
        .form-group .checkbox-container {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            /* Right-align checkbox */
        }

        /* Checkbox styles */
        .form-group .checkbox-align input[type="checkbox"] {
            transform: scale(2.2);
            /* Adjust the size of the checkbox */
            margin-left: 10px;
            /* Adjust the space between the label and checkbox */
        }

        /* Button container styles */
        .button-container {
            display: flex;
            justify-content: center;
            /* Align buttons to the left */
            gap: 10px;
            margin-top: 20px;
        }

        /* Button styles */
        .button {
            padding: 10px 15px;
            min-width: 120px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
            margin-top: 20px;
            color: white;
            background-color: #4e73df;
        }

        /* Button hover effects */
        .button:hover {
            background-color: #2e59d9;
        }

        .button.cancel {
            background-color: #e74a3b;
        }

        .button.cancel:hover {
            background-color: #d6331c;
        }

        .button.clear {
            background-color: #E07907;
        }

        .button.clear:hover {
            background-color: #cc7000;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-group {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-group label,
            .input-container {
                width: 100%;
                /* Full width on small screens */
            }

            .form-container {
                width: 90%;
                /* Adjust form container width on small screens */
            }

            .form-group label {
                margin-bottom: 5px;
            }

            .button-container {
                justify-content: center;
            }
        }
    </style>
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
                        <div class="form-container">
                            <!-- This div wraps the entire form and applies the container styling -->
                            <form action="sys_dep_process.php"
                                method="post"
                                onsubmit="return validateForm()">
                                <input type="hidden"
                                    name="id"
                                    value="<?php echo htmlspecialchars($departmentData[0]); ?>">
                                <div class="form-group">
                                    <label for="departmentName">DEPARTMENT NAME</label>
                                    <div class="input-container">
                                        <input type="text"
                                            id="departmentName"
                                            name="departmentName"
                                            value="<?php echo $departmentData[1]; ?>"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="active">ACTIVE</label>
                                    <div class="checkbox-container">
                                        <div class="checkbox-align">
                                            <input type="checkbox"
                                                id="active"
                                                name="active"
                                                <?php echo $departmentData[2] ? 'checked' : ''; ?>
                                                value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="button-container">
                                    <input type="submit"
                                        value="<?php echo $editing ? 'UPDATE DEPARTMENT' : 'ADD DEPARTMENT'; ?>"
                                        class="button">
                                    <button type="button"
                                        onclick="location.href='sys_dep_manager.php'"
                                        class="button cancel">CANCEL</button>
                                    <button type="button"
                                        onclick="clearFormFields()"
                                        class="button clear">CLEAR FIELDS</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start: Footer -->
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
                                <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="modal-body">Select "Logout" below if you are ready to end your current session.
                        </div>
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
    </script>
    <script>
        function clearFormFields() {
            // This will clear all text input fields
            document.querySelectorAll('.form-container input[type="text"]').forEach(input => input.value = '');
            // Uncheck the active checkbox
            document.getElementById('active').checked = false;
            // Set focus to the 'department name' textbox
            document.getElementById('departmentName').focus();
        }

        function validateForm() {
            // Get the value of the "visitDescription" textbox
            var departmentName = document.getElementById('departmentName').value;
            // Check if it's empty
            if (departmentName.trim() === '') {
                // Display a customized alert using SweetAlert
                Swal.fire({
                    title: 'PANTHER MESSAGE',
                    text: 'Department Name Cannot Be Empty.',
                    icon: 'error',
                });
                // Prevent the form from being submitted
                return false;
            }
            // If the "Department Name" is not empty, allow the form to be submitted
            return true;
        }
    </script>
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