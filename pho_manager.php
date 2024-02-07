<?php
// START ||  || Screen Container Header Information ||  ||
// Unique text for the title in the page's container
$screenTitle = 'PANTHER | Photo Manager';
// Unique text for the middle text section of the page's container
$screenTitleMidText = '';
// Unique icon for the page's container action button (right side)
$screenTitleRightButtonIcon = 'fa-upload';
// Unique text/title for the page's container action button ( right side )
$screenTitleRightButtonText = ' UPLOAD';
// Unique ID for the page's container action button (right side)
// This ID links the button's action to the script ( bottom of page )
$screenTitleRightButtonId = 'uploadButton';
// END   ||  || Screen Container Header Information || |
//include 'logic/db/dbconn_vision.php';

// Function to read visit codes from CSV and return active codes

function getPropertyAppraiserInfo($filePath)
{
    $name = '';
    $certs = '';
    if (($handle = fopen($filePath, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            if ($data[4] == '1') {
                // Check if the 5th field is equal to '1'
                $name = $data[1] . ' ' . $data[2];
                // Combine first name and last name
                $certs = $data[8];
                // Get the CERTS field value
                break;
                // Exit loop once the first match is found
            }
        }
        fclose($handle);
    }
    return ['name' => $name, 'certs' => $certs];
}

$propertyAppraiserInfo = getPropertyAppraiserInfo('./data/employees.csv');
$propertyAppraiserName = $propertyAppraiserInfo['name'];
$propertyAppraiserCerts = $propertyAppraiserInfo['certs'];

function generateEmployeeList()
{
    $filePath = './data/employees.csv';
    $employees = [];
    $employeeData = [];
    // Initialize an array to store employee data keyed by ID

    if (($handle = fopen($filePath, 'r')) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            $empId = $data[0];
            // Assuming the ID is in the first column
            $empActive = $data[3];
            // Active status
            $fieldAppraiserActive = $data[5];
            // Field Appraiser active status

            if ($empActive == '1' && $fieldAppraiserActive == '1') {
                $empFirstName = $data[1];
                // First name
                $empLastName = $data[2];
                // Last name
                $empFullName = $empLastName . ', ' . $empFirstName;
                $empUsername = $data[9];
                // Username, from your CSV structure
                $employees[$empId] = $empFullName;
                $employeeData[$empId] = $empUsername;
                // Store username in separate array
            }
        }
        fclose($handle);
    }

    asort($employees);
    // Sort employees by name

    return [$employees, $employeeData];
    // Return both arrays
}

// Usage of the function
list($employeeList, $employeeUsernames) = generateEmployeeList();
// Capture both returned arrays

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
    <title> <?php echo $screenTitle;
        ?> </title>
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
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        /* This ensures padding does not add to the width or height */
    }

    /* START - Selected photo working styles */
    #photoWorkingContainer {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        /* Align content to the top */
        padding: 0;
        /* Remove padding if any */
    }

    .photoColumn {
        flex: 1;
        /* This will now be overridden by specific flex settings on left and right columns */
    }

    .photoColumnLeft {
        flex: 0 0 auto;
        /* Do not grow, do not shrink, auto based on content size */
        padding: 0;
        /* Remove padding if any */
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        /* Align children to the center horizontally */
        margin: 0;
        margin-bottom: 0;
    }

    /* Set a fixed width for the infoTop and infoBottom sections */
    .infoTop-left,
    .infoTop-center,
    .infoTop-right,
    .infoBottom-left,
    .infoBottom-center,
    .infoBottom-right {
        display: inline-block;
        margin-top: 0;
        vertical-align: top;
        white-space: nowrap;
        width: 100px;
        /* Adjust to your desired fixed width */
    }

    .infoTop-left,
    .infoBottom-left {
        text-align: left;
        width: 120px;
    }

    .infoTop-center,
    .infoBottom-center {
        text-align: center;
        width: 300px;
    }

    .infoTop-right,
    .infoBottom-right {
        text-align: right;
        width: 120px;
        /* Set width to 25% for right-aligned elements */
    }

    .photoColumnRight {
        max-width: 50%;
        /* This ensures that the column does not exceed 50% width */
        display: flex;
        flex-direction: column;
        align-content: flex-start;
        padding-bottom: 0;
    }

    #selectedImageContainer {
        width: 100%;
        /* Set to the width you want, could be 100% if it should take the whole space */
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: flex-start;
        /* Align to the top */
        margin-top: 0;
        margin: 0;
        /* Remove margin if any */
    }

    /* Set a fixed width and height for the image */
    #selectedImage {
        width: 600px;
        /* Adjust to your desired width */
        height: 400px;
        /* Adjust to your desired height */
        object-fit: contain;
    }

    .image-info {
        width: 100%;
        text-align: center;
        /* Center the text horizontally */
        margin-top: 0;
        margin-bottom: 0;
    }

    .image-infoTop,
    .image-infoBottom {
        font-size: 0.875rem;
        display: block;
        /* Use block for text elements */
        width: auto;
        /* Let the size be determined by content */
        text-align: center;
        margin: 0;
        line-height: 1;
        white-space: nowrap;
    }

    /* Button styles */
    .buttonContainer {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        /* Align buttons to the left */
        gap: 10px;
        margin-top: 20px;
    }

    .actionButtons .btn {
        width: 200px;
        /* Fixed width for all buttons */
        margin-bottom: 10px;
        /* Space between buttons */
        /* Removed padding: 0; to ensure buttons have padding */
        /* Removed font-weight: bolder; if you want the font to be normal weight */
    }

    .checkbox-align input[type="checkbox"] {
        border: 1px solid #ced4da;
        /* This should match the border of text inputs */
        display: flex;
        align-items: center;
        justify-content: center;
        transform: scale(2);
        margin-right: 0px;
        margin-left: 8px;
        margin-top: 8px;
        margin-bottom: 8px;
    }

    #savePhoto,
    #resetForm,
    #removePhoto {
        margin-right: 44px;
    }

    /* Ensuring all buttons have the same width and height */
    .actionButtons .btn {
        width: 200px;
        /* Fixed width for all buttons */
        height: 50px;
        /* Fixed height for all buttons */
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 0;
        /* Remove padding to ensure text is centered based on width/height */
        color: white;
        font-weight: bolder;
    }

    #removePhoto {
        background-color: #E07907;
    }

    /* START | Action button modals */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal Content Box */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        /* Could be more or less, depending on screen size */
    }

    /* The Close Button */
    .modal-footer {
        text-align: center;
        padding: 20px;
    }

    /* END | Action button modals */
    .custom-thumbnail {
        max-width: none;
        max-height: 144px;
        width: auto;
        object-fit: contain;
    }

    #thumbnailContainer {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        white-space: nowrap !important;
        align-items: flex-start !important;
    }

    .thumbnail {
        display: inline-block !important;
        margin: 5px !important;
        overflow: hidden !important;
        min-width: 216px !important;
    }

    #selectedImageContainer.inactive {
        pointer-events: none;
        /* Prevents clicking on elements inside the container */
        opacity: 0.5;
        /* Dim the container to show it's inactive */
        max-width: 600px;
        /* Set to match the width of the image */
        max-height: 400px;
        /* Set to match the height of the image */
        object-fit: contain;
        /* This will ensure that the aspect ratio of the image is maintained without stretching */
        justify-content: center;
        align-items: top;
    }

    /* This wrapper will constrain the maximum width while maintaining the aspect ratio */
    /* Show the textboxes container and place it to the right */
    #textboxesContainer {
        display: block;
        /* Show the container */
        width: calc(20% - 10px);
        /* Adjust width, considering padding */
        margin-left: 10px;
        /* Space between image and textboxes */
        flex-shrink: 0;
        /* Prevent the container from shrinking */
        align-self: flex-start;
    }

    .textbox-row {
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        margin-bottom: 10px;
    }

    .label-column {
        text-align: right;
        flex: 0 0 120px;
        /* Adjust this value to fit your content */
        margin-right: 10px;
        /* Space between the label and the input */
    }

    .input-column {
        flex: 1;
        /* Take up the remaining space */
        display: flex;
        align-items: flex-start;
    }

    .input-column-user input {
        width: 19ch;
        /* Set the width to hold 30 characters */
    }

    .input-column input {
        width: 27ch;
        /* Set the width to hold 30 characters */
    }

    .input-column select {
        width: 100%;
        /* Ensure dropdowns take the full width of their parent */
    }

    /* Adjustments for specific input column widths */
    .input-column-narrow {
        flex: 0 0 40%;
        /* Set the width to 40% of its current width */
    }

    .input-column-wide {
        flex: 1;
        /* Allow it to take the remaining space */
    }

    .numberParcelContainer {
        display: flex;
        justify-content: flex-start;
        /* Align children to the start of the container */
        flex-wrap: nowrap;
        /* Prevent wrapping to a new line */
        gap: 4px;
        /* Gap between the parcel number textboxes */
        height: 30px;
        /* Height of the parcel number textboxes */
    }

    #empSelect,
    #photoDate,
    #visitCode,
    #imageType,
    #improveNumber,
    #numberVID {
        width: 260px;
    }

    .spacing {
        margin-right: 10px;
        /* margin-bottom: 10px;
    */
    }

    #textboxesContainer .two-digit-input {
        width: 30px !important;
        /* Adjust as needed for 2 digits */
        text-align: center;
    }

    #textboxesContainer .four-digit-input {
        width: 50px !important;
        /* Adjust as needed for 4 digits */
        text-align: center;
    }

    #uploadButton {
        margin-bottom: 10px;
    }

    .btn-fixed-width {
        width: 200px;
        /* Set your desired width here */
    }

    .text-display {
        display: inline-block;
        padding: 0;
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 800;
        color: #28a745 !important;
        /* Bootstrap 'success' green */
        line-height: 1.5;
        width: calc(100% - 0.0rem);
        /* Adjust width to account for padding */
        overflow: hidden;
        /* Hide overflow */
        text-overflow: ellipsis;
        /* Show ellipsis for overflowed text */
        white-space: nowrap;
        /* Prevent wrapping */
    }

    /* START | Restart Process modal */
    /* Modal styling adjustments */
    .modal-content {
        background-color: #fff;
        /* Light background for the modal */
        margin: 10% auto;
        /* Adjust margin for better positioning */
        padding: 20px;
        border: 1px solid #888;
        width: 40%;
        /* Adjust width to make the modal square-ish */
        border-radius: 5px;
        /* Rounded corners */
    }

    .modal-header,
    .modal-footer {
        padding: 1rem;
    }

    .modal-header {
        background-color: #ff5555;
        /* Red background for the header */
        color: white;
        /* White text color */
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .modal-title {
        font-weight: bolder;
        font-size: 1.5rem;
    }

    .modal-body {
        padding: 20px 0;
        /* Add some padding to the top and bottom */
    }

    /* Button styling adjustments */
    .modal-footer button {
        border: none;
        padding: 10px 20px;
        /* Padding for buttons */
        margin: 0 10px;
        /* Space between buttons */
        border-radius: 5px;
        /* Rounded corners for buttons */
        font-weight: bolder;
        /* Make text bolder */
        color: #fff;
        /* White text color */
        cursor: pointer;
        /* Cursor pointer to indicate clickable */
    }

    #continueBtn {
        background-color: #f44336;
        /* Green background for continue button */
    }

    #cancelBtn {
        background-color: #4CAF50;
        /* Red background for cancel button */
    }

    /* Additional styling to ensure buttons are visible */
    .modal-footer {
        text-align: center;
        /* Center the buttons */
    }

    /* If buttons are not displaying, ensure they are not set to display: none or color: white in other CSS */
    button.btn {
        display: inline-block;
        /* Ensure buttons are displayed */
    }

    /* END | Restart Process modal */
    </style>
</head>

<body id='page-top'>
    <!-- Canvas element ( hidden by default ) -->
    <canvas id='ImageCanvas'
        width='1024'
        height='768'
        style='display:none;'></canvas>
    <div id='wrapper'> <?php require './logic/sidebar.php';
        ?> <div id='content-wrapper'
            class='d-flex flex-column'>
            <div id='content'> <?php require './logic/topbar.php';
                ?> <div class='container-fluid'> <?php require './logic/screentitlebar.php';
                    ?> <div class='container-fluid'>
                        <input type='hidden'
                            name='selectedUsername'
                            id='selectedUsername'>
                    </div>
                    <input type='file'
                        id='fileInput'
                        style='display: none;'
                        multiple>
                    <div id='imageScrollContainer'
                        style='overflow-x: auto; white-space: nowrap;'>
                        <!-- Images will be displayed here in a horizontal scroll -->
                    </div>
                    <hr><!-- Dividing line under images / above selected image -->
                    <!-- Buttons -->
                    <div class='buttonContainer actionButtons'>
                        <button id='savePhoto'
                            class='btn btn-success'
                            type='button'
                            onclick="window.location.href='pho_uploader.php'">PHOTO UPLOAD</button>
                        <button id='resetForm'
                            class='btn btn-primary'
                            type='button'>UPLOAD ACTIVITY</button>
                        <button id='removePhoto'
                            class='btn btn-warning'
                            type='button'>REMOVE PHOTO</button>
                        <button id='restartProcess'
                            class='btn btn-danger'
                            type='button'
                            onclick="window.location.href='pho_stats.php'">PHOTO STATS</button>
                    </div>
                </div>
            </div>
        </div>
    </div> <?php require './logic/footer.php';
    ?> </div>
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