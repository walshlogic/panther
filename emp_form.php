<?php
require './util.php';
// screen name text and button information to display top of this page
$screenTitle = "EMPLOYEE MANAGER";
$screenTitleMidText = "";
// title button icon sent to screentitlebar.
$screenTitleRightButtonIcon = "";
// title button text sent to screentitlebar.php
$screenTitleRightButtonText = "";
// title button action sent to screentitlebar.php
$screenTitleRightButtonLink = "";
// Check if editing an existing appraiser
$editing = isset($_GET['edit']);
if ($editing) {
    $employeeData = getExistingemployeeData($_GET['edit']);
} else {
    // Initialize with 14 empty values including empId
    $employeeData = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
}

function getExistingemployeeData($index)
{
    $filePath = './data/employees.csv';
    $file = fopen($filePath, 'r');
    $lineNumber = 0;

    while (($row = fgetcsv($file)) !== FALSE) {
        if ($lineNumber == $index) {
            fclose($file);
            // Ensure the returned array contains 14 elements including empId
            return $row;
        }
        $lineNumber++;
    }

    fclose($file);
    // Return an empty array with 14 placeholders if the record is not found
    return ['', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
}

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
    <title>PANTHER | Employee Manager</title>
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
    .form-container {
        background: #ffffff;
        padding: 20px;
        border-radius: 4px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin: 20px auto;
        max-width: 800px;
    }

    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        margin-right: 0;
    }

    .form-group label {
        flex-basis: 25%;
        justify-content: flex-end;
        margin-right: 10px;
        text-align: right;
        display: flex;
        align-items: center;
        margin-bottom: 0;
    }

    .form-group .checkbox-container {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        flex-grow: 2;
        padding-left: 0px;
        padding-right: 10px;
    }

    .form-group .checkbox-align input[type="checkbox"] {
        border: 1px solid #ced4da;
        /* This should match the border of text inputs */
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0px;
        transform: scale(2.5);
        margin-left: 8px;
    }

    .button-container {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    .button {
        background-color: #4e73df;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 18px;
        margin-top: 20px;
        min-width: 120px;
        width: auto;
        align-self: flex-start;
    }

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

    .input-container {
        flex-basis: 75%;
        display: flex;
        align-items: center;
    }

    .input-container input,
    .input-container select {
        box-sizing: border-box;
        width: 100%;
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        margin-bottom: 0;
    }

    /* Removed the specific checkbox-align input[type="checkbox"] styling */
    input[type="submit"] {
        background-color: #4e73df;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 18px;
        margin-top: 20px;
        min-width: 120px;
        width: auto;
        align-self: flex-start;
    }

    @media (max-width: 768px) {
        .form-group {
            flex-direction: column;
            align-items: flex-start;
        }

        .form-group label,
        .input-container {
            flex-basis: 100%;
        }

        .form-container {
            width: 90%;
        }
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
                    <!-- Start: Screen Title Bar (info displayed below top bar identifiy screen) -->
                    <?php require "./logic/screentitlebar.php"; ?>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="form-container">
                            <!-- This div wraps the entire form and applies the container styling -->
                            <form action="emp_process.php"
                                method="post">
                                <input type="hidden"
                                    name="empId"
                                    value="<?php echo htmlspecialchars($employeeData[0]); ?>">
                                <div class="form-group">
                                    <label for="empFirstName">FIRST NAME</label>
                                    <div class="input-container">
                                        <input type="text"
                                            id="empFirstName"
                                            name="empFirstName"
                                            value="<?php echo $employeeData[1]; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="empLastName">LAST NAME</label>
                                    <div class="input-container">
                                        <input type="text"
                                            id="empLastName"
                                            name="empLastName"
                                            value="<?php echo $employeeData[2]; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="empActive">ACTIVE</label>
                                    <div class="checkbox-container">
                                        <div class="checkbox-align">
                                            <input type="checkbox"
                                                id="empActive"
                                                name="empActive"
                                                <?php echo $employeeData[3] ? 'checked' : ''; ?>
                                                value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="empPhotoManager">APPRAISER</label>
                                    <div class="checkbox-container">
                                        <div class="checkbox-align">
                                            <input type="checkbox"
                                                id="empPhotoManager"
                                                name="empPhotoManager"
                                                <?php echo $employeeData[4] ? 'checked' : ''; ?>
                                                value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="empDepartment">DEPARTMENT</label>
                                    <div class="input-container">
                                        <input type="text"
                                            id="empDepartment"
                                            name="empDepartment"
                                            value="<?php echo $employeeData[5]; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="empTitle">JOB TITLE</label>
                                    <div class="input-container">
                                        <input type="text"
                                            id="empTitle"
                                            name="empTitle"
                                            value="<?php echo $employeeData[6]; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="empUsername">NETWORK USERNAME</label>
                                    <div class="input-container">
                                        <input type="text"
                                            id="empUsername"
                                            name="empUsername"
                                            value="<?php echo $employeeData[7]; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="empWorArea">WORK AREA #</label>
                                    <div class="input-container">
                                        <input type="text"
                                            id="empWorkArea"
                                            name="empWorkArea"
                                            value="<?php echo $employeeData[8]; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="empWorkEmail">WORK EMAIL</label>
                                    <div class="input-container">
                                        <input type="text"
                                            id="empWorkEmail"
                                            name="empWorkEmail"
                                            value="<?php echo $employeeData[9]; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="empDeskPhone">DESK PHONE</label>
                                    <div class="input-container">
                                        <input type="text"
                                            id="empDeskPhone"
                                            name="empDeskPhone"
                                            value="<?php echo $employeeData[10]; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="empWorkMobile">WORK MOBILE</label>
                                    <div class="input-container">
                                        <input type="text"
                                            id="empWorkMobile"
                                            name="empWorkMobile"
                                            value="<?php echo $employeeData[11]; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="empPersonalMobile">PERSONAL MOBILE</label>
                                    <div class="input-container">
                                        <input type="text"
                                            id="empPersonalMobile"
                                            name="empPersonalMobile"
                                            value="<?php echo $employeeData[12]; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="empDateHire">HIRE DATE</label>
                                    <div class="input-container">
                                        <input type="date"
                                            id="empDateHire"
                                            name="empDateHire"
                                            value="<?php echo htmlspecialchars($employeeData[13]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="empDateTerm">TERM DATE</label>
                                    <div class="input-container">
                                        <input type="date"
                                            id="empDateTerm"
                                            name="empDateTerm"
                                            value="<?php echo htmlspecialchars($employeeData[14]); ?>">
                                    </div>
                                </div>
                                <!-- Buttons at the bottom -->
                                <input type="submit"
                                    value="<?php echo $editing ? 'UPDATE EMPLOYEE' : 'ADD EMPLOYEE'; ?>"
                                    class="button">
                                <button type="button"
                                    onclick="location.href='emp_manager.php'"
                                    class="button cancel">CANCEL</button>
                                <button type="button"
                                    onclick="clearFormFields()"
                                    class="button clear">CLEAR FIELDS</button>
                        </div>
                        </form>
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
    <script>
    window.onload = function() {
        document.getElementById('empFirstName').focus();
    };
    </script>
    <script>
    function clearFormFields() {
        // This will clear all text input fields
        document.querySelectorAll('.form-container input[type="text"], .form-container input[type="email"]').forEach(
            input => input.value = '');
        // Uncheck the active checkbox
        document.getElementById('active').checked = false;
        // Set focus to the 'First Name' textbox
        document.getElementById('empFirstName').focus();
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