<?php
ini_set('display_errors', '0');
error_reporting(0);

$incomingData = file_get_contents('php://input');
error_log("Incoming data: $incomingData");


// screen name text and button information to display top of this page
$screenTitle = "VISION+ | 2023 TRIM Query";
$screenTitleMidText = "";
$screenTitleRightButtonIcon = "fa-upload";
$screenTitleRightButtonText = " Upload";
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"
        content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="">
    <meta name="author"
        content="">
    <title>PANTHER | Photo Manager</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css"
        rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css"
        rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Start: Side Nav Bar -->
        <?php require "./logic/sidebar.php"; ?>
        <!-- End: Side Nav Bar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper"
            class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Start: Top Bar -->
                <?php require "./logic/topbar.php"; ?>
                <!-- End: Top Bar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Start: Screen Title Bar (info displayed below top bar identifiy screen) -->
                    <?php require "./logic/screentitlebar.php"; ?>
                    <!-- End: Screen Title Bar -->
                </div>
                <!-- /.container-fluid -->
                <script>
                    console.log("About to send the request");
                </script>
                <textarea id="numbers"
                    rows="17"
                    cols="30"
                    style="margin-left: 22px;"></textarea>
                <button id="submit"
                    style="display: block; width: 100%; background-color: blue; font-weight: bold; margin-top: 10px; margin-left: 22px; color: white;">
                    Submit </button>
                <script>
                    document.getElementById("submit").addEventListener("click", function () {
                        const numbers = document.getElementById("numbers").value.split("\n");
                        console.log("Request sent");
                        try {
                            fetch("trim_2023_process.php", {
                                method: "POST",
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    numbers
                                })
                            }).then(response => {
                                // Clone the response to not interfere with the original response stream
                                const clonedResponse = response.clone();
                                // Log the text response to see what's actually coming back from the server
                                clonedResponse.text().then(text => console.log(text));
                                if (!response.ok) {
                                    return response.text().then(text => {
                                        throw new Error(text);
                                    });
                                }
                                return response
                                    .json(); // This assumes the server responds with JSON, which may not be the case!
                            }).then(data => {
                                alert("Query executed successfully");
                            }).catch(error => {
                                alert("An error occurred: " + error);
                            });
                        } catch (error) {
                            console.error("Caught error during fetch:", error);
                        }
                    });
                </script>
            </div>
            <!-- End of Main Content -->
            <!-- Start: Footer -->
            <?php require "./logic/footer.php"; ?>
            <!-- End: Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
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
</body>

</html>
<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        const numbersTextarea = document.getElementById("numbers");
        const submitButton = document.getElementById("submit");
        // Get the actual computed width of the textarea
        const computedStyle = window.getComputedStyle(numbersTextarea);
        const textareaWidth = computedStyle.width;
        // Set the button's width to match the textarea's computed width
        submitButton.style.width = textareaWidth;
    });
</script>