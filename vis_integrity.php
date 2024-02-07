<?php
// START ||  || Screen Container Header Information ||  ||
// Unique text for the title in the page's container
$screenTitle = 'VISION+ | Integrity Checks';
// Unique text for the middle text section of the page's container
$screenTitleMidText = '';
// Unique icon for the page's container action button (right side)
$screenTitleRightButtonIcon = '';
// Unique text/title for the page's container action button ( right side )
$screenTitleRightButtonText = '';
// Unique ID for the page's container action button (right side)
// This ID links the button's action to the script ( bottom of page )
$screenTitleRightButtonId = '';
// END   ||  || Screen Container Header Information || |
//include 'logic/db/dbconn_vision.php';
// Function to read visit codes from CSV and return active codes

?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible'
        content='IE=edge'>
    <meta name='viewport'
        content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <meta name='description'
        content=''>
    <meta name='author'
        content='Will Walsh | wbwalsh@gmail.com'>
    <meta name='version'
        content='0.6'>
    <title>
        <?php echo $screenTitle;
        ?>
    </title>
    <link href='vendor/fontawesome-free/css/all.min.css'
        rel='stylesheet'
        type='text/css'>
    <link
        href='https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i'
        rel='stylesheet'>
    <link href='css/sb-admin-2.min.css'
        rel='stylesheet'>
    <script src='vendor/jquery/jquery.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js'
        integrity='sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE'
        crossorigin='anonymous'>
        </script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js'
        integrity='sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ'
        crossorigin='anonymous'>
        </script>
    <script src='logic/main.js'></script>
</head>

<body id='page-top'>
    <!-- Canvas element ( hidden by default ) -->
    <canvas id='ImageCanvas'
        width='1024'
        height='768'
        style='display:none;'></canvas>
    <div id='wrapper'>
        <?php require './logic/sidebar.php';
        ?>
        <div id='content-wrapper'
            class='d-flex flex-column'>
            <div id='content'>
                <?php require './logic/topbar.php';
                ?>
                <div class='container-fluid'>
                    <?php require './logic/screentitlebar.php';
                    ?>
                    <div class='container-fluid'>
                        <input type='hidden'
                            name='selectedUsername'
                            id='selectedUsername'>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require './logic/footer.php';
    ?>
    </div>
    </div><a class='scroll-to-top rounded'
        href='#page-top'><i class='fas fa-angle-up'></i></a>
    <div class='modal fade'
        id='logoutModal'
        tabindex='-1'
        role='dialog'
        aria-labelledby='exampleModalLabel'
        aria-hidden='true'>
        <div class='modal-dialog'
            role='document'>
            <div class='modal-content'>
                <div cla
                    ss='modal-header'>
                    <h5 class='modal-title'
                        id='exampleModalLabel'>Ready to leave Panther?</h5><button class='close'
                        type='button'
                        data-dismiss='modal'
                        aria-label='Close'><span aria-hidden='true'></span></button>
                </div>
                <div class=' modal-body'>Select Logout below if you are ready to end your current session.</div>
                <div class='modal-footer'><button class='btn btn-secondary'
                        type='button'
                        data-dismiss='modal'>Cancel</button><a class='btn btn-primary'
                        href='login.html'>Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Include Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous">
        </script>
    <!-- Include Popper.js (if required by Bootstrap 5) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous">
        </script>
    <script src='vendor/jquery/jquery.min.js'></script>
    <script src='vendor/bootstrap/js/bootstrap.bundle.min.js'></script>
    <script src='vendor/jquery-easing/jquery.easing.min.js'></script>
    <script src='js/sb-admin-2.min.js'></script>
    <script src='js/pho_js.js'></script>
</body>

</html>