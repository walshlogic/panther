<?php
// START |||| Screen Container Header Information ||||
// Unique text for the title in the page's container
$screenTitle = 'PANTHER | Photo Manager';
// Unique text for the middle text section of the page's container
$screenTitleMidText = '';
// Unique icon for the page's container action button (right side)
$screenTitleRightButtonIcon = 'fa-upload';
// Unique text/title for the page's container action button (right side)
$screenTitleRightButtonText = ' UPLOAD';
// Unique ID for the page's container action button (right side)
// This ID links the button's action to the script (bottom of page)
$screenTitleRightButtonId = "uploadButton";
// END   |||| Screen Container Header Information |||
include 'logic/db/dbconn_vision.php';

// Function to read visit codes from CSV and return active codes
function getActiveVisitCodes($filePath)
{
    $activeCodes = [];
    if (($handle = fopen($filePath, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[2] == '1') { // Check if the code is active
                $activeCodes[] = $data[1]; // 2 = visit code field
            }
        }
        fclose($handle);
    }
    asort($activeCodes); // Sort the array alphabetically
    return $activeCodes;
}
$visitCodes = getActiveVisitCodes('./data/photoVisitCodes.csv');
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"
        content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="">
    <meta name="author"
        content="Will Walsh | wbwalsh@gmail.com">
    <meta name="version"
        content="0.6">
    <title> <?php echo $screenTitle; ?> </title>
    <link href="vendor/fontawesome-free/css/all.min.css"
        rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css"
        rel="stylesheet">
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>
    <script src="logic/main.js"></script>
    <style>
    /* START - Selected photo working sytles */
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
        align-items: center;
        /* Align children to the center horizontally */
        margin: 0;
        /* Remove margin if any */
    }

    .photoColumnRight {
        /* flex: 1 0 50%; */
        /* This prevents the columns from growing or shrinking from 50% */
        max-width: 50%;
        /* This ensures that the column does not exceed 50% width */
        display: flex;
        flex-direction: column;
        align-content: center;
        padding-bottom: 0;
    }

    .photoColumn,
    .photoColumnLeft,
    .photoColumnRight {
        flex-grow: 0;
    }

    #selectedImageContainer {
        width: 100%;
        /* Set to the width you want, could be 100% if it should take the whole space */
        display: block;
        /* Use block to stack children vertically */
        align-items: flex-start;
        /* Align to the top */
        margin: 0;
        /* Remove margin if any */
    }

    #selectedImage {
        max-width: 100%;
        /* Let the image be as wide as the container allows */
        max-height: 420px;
        /* Set a max height to something that makes sense for your layout */
        object-fit: contain;
        /* Maintain aspect ratio without stretching */
        margin: 0;
        /* Remove margin if any */
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
        /* Remove margin if any */
    }

    /* Button styles */
    .buttonContainer {
        display: flex;
        flex-direction: row;
        /* Align buttons horizontally */
        align-items: center;
        /* Center buttons vertically */
        justify-content: center;
        /* Align buttons to the start of the container */
        flex-wrap: wrap;
        /* Allow buttons to wrap to next line if there's not enough space */
        gap: 20px;
        /* Add some space between the buttons */
        margin-top: 0px;
        /* Add some space above the button container */
    }

    .btn {
        margin-bottom: 0px;
        /* Add space between buttons */
    }

    /* END - Selected photo working sytles */
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
        max-width: 90%;
        /* Ensuring the image does not exceed the column width */
        max-height: 90%;
        /* Ensuring the image does not exceed the column height, adjust as necessary */
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
    }

    .textbox-row {
        display: flex;
        justify-content: flex-start;
        align-items: center;
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
        align-items: center;
    }

    .input-column-user input {
        width: 19ch;
        /* Set the width to hold 30 characters */
    }

    .input-column input {
        width: 27ch;
        /* Set the width to hold 30 characters */
    }

    .numberParcelContainer {
        display: flex;
        justify-content: flex-start;
        /* Align children to the start of the container */
        flex-wrap: nowrap;
        /* Prevent wrapping to a new line */
        gap: 4px;
        /* gap between the parcel number textboxes */
        height: 30px;
        /* heigth of the parcel number textboxes */
    }

    #empSelect,
    #photoDate,
    #visitCode,
    #imageType,
    #numberVID {
        width: 260px;
    }

    .spacing {
        margin-right: 10px;
        /* margin-bottom: 10px; */
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

    /* Style changes for buttons to ensure they are below the image and text */
    #saveImage,
    #clearTextInputs {
        z-index: 2;
        /* Ensure buttons are above other elements */
        position: relative;
        /* Position relative to their normal flow */
        margin-top: 8px;
        /* Space above the buttons */
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

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        /* This ensures padding does not add to the width or height */
    }

    .infoTop-left,
    .infoTop-center,
    .infoTop-right {
        display: inline-block;
        vertical-align: top;
    }

    .infoTop-left {
        width: 25%;
        text-align: left;
    }

    .infoTop-center {
        width: 50%;
        text-align: center;
    }

    .infoTop-right {
        width: 25%;
        text-align: right;
    }
    </style>
</head>

<body id='page-top'>
    <!-- Canvas element (hidden by default) -->
    <canvas id="ImageCanvas"
        width="1024"
        height="768"
        style="display:none;"></canvas>
    <div id='wrapper'> <?php require './logic/sidebar.php';
        ?> <div id='content-wrapper'
            class='d-flex flex-column'>
            <div id='content'> <?php require './logic/topbar.php';
                ?> <div class='container-fluid'> <?php require './logic/screentitlebar.php'; ?> <div
                        class='container-fluid'>
                        <input type="hidden"
                            name="selectedUsername"
                            id="selectedUsername">
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
                    <div id='photoWorkingContainer'>
                        <!-- Left column -->
                        <div class='photoColumn photoColumnLeft'>
                            <!-- Text top of selected image -->
                            <div class='image-infoTop'>
                                <div class="infoTop-left">
                                    <!-- Left aligned text -->
                                    <!-- Additional text goes here -->
                                </div>
                                <div class="infoTop-center">Tim Parker, C.F.A.</div> <!-- Center aligned text -->
                                <div class="infoTop-right"
                                    id="photoDateDisplay">
                                    <!-- Right aligned text -->
                                    <!-- Photo date will be displayed here -->
                                </div>
                            </div>
                            <div class='image-infoTop'>PUTNAM COUNTY PROPERTY APPRAISER</div>
                            <!-- Selected image container -->
                            <div id='selectedImageContainer'>
                                <img id='selectedImage'
                                    src='assets/imageBase/paSeal.png'
                                    alt='Selected Image Placeholder'>
                            </div>
                            <!-- Text bottom of selected image -->
                            <div class='image-infoBottom'>
                                <span id='imageTextBottom'></span>
                            </div>
                        </div>
                        <!-- Right column -->
                        <div class='photoColumn photoColumnRight'>
                            <div id='textboxesContainer'>
                                <div class='textbox-row'>
                                    <div class='label-column'>APPRAISER</div>
                                    <div class='input-column'>
                                        <select name="empSelect"
                                            id="empSelect"
                                            onchange="selectEmployee()">
                                            <option value=""></option> <?php
                                            $filePath = './data/employees.csv';
                                            $employees = [];

                                            if (($handle = fopen($filePath, "r")) !== FALSE) {
                                                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                                    $empActive = $data[3]; // 3 = active field
                                                    $empPhotoManager = $data[4]; // 4 = photo manager field
                                            
                                                    if ($empActive == '1' && $empPhotoManager == '1') { // Check if employee is active and photo manager is active
                                                        $empFirstName = $data[1]; // 1 = first name field
                                                        $empLastName = $data[2]; // 2 = last name field
                                                        $empFullName = $empLastName . ', ' . $empFirstName;
                                                        $employees[$data[0]] = $empFullName; // Using ID as the key
                                                    }
                                                }
                                                fclose($handle);
                                            }

                                            asort($employees); // Sort the array by full name
                                            
                                            foreach ($employees as $id => $name) {
                                                echo "<option value='{$id}'>$name</option>"; // Using ID as the value
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class='textbox-row'>
                                    <div class='label-column'>VID #</div>
                                    <div class='input-column'>
                                        <input type='text'
                                            id='numberVID'
                                            class='ten-digit-input'
                                            maxlength='10'
                                            oninput='handleNumberVIDInput(event)'
                                            onblur='fetchParcelDataOnBlur()'>
                                    </div>
                                </div>
                                <!-- Parcel ID Row -->
                                <div class='textbox-row'>
                                    <div class='label-column'>PARCEL #</div>
                                    <div class='numberParcelContainer'
                                        class='input-column'>
                                        <input type='text'
                                            id='numberParcel1'
                                            class='two-digit-input'
                                            maxlength='2'
                                            oninput='moveFocus(2, "numberParcel1", "numberParcel2")'>
                                        <input type='text'
                                            id='numberParcel2'
                                            class='two-digit-input'
                                            maxlength='2'
                                            oninput='moveFocus(2, "numberParcel2", "numberParcel3")'>
                                        <input type='text'
                                            id='numberParcel3'
                                            class='two-digit-input'
                                            maxlength='2'
                                            oninput='moveFocus(2, "numberParcel3", "numberParcel4")'>
                                        <input type='text'
                                            id='numberParcel4'
                                            class='four-digit-input'
                                            maxlength='4'
                                            oninput='moveFocus(4, "numberParcel4", "numberParcel5")'>
                                        <input type='text'
                                            id='numberParcel5'
                                            class='four-digit-input'
                                            maxlength='4'
                                            oninput='moveFocus(4, "numberParcel5", "numberParcel6")'>
                                        <input type='text'
                                            id='numberParcel6'
                                            class='four-digit-input'
                                            maxlength='4'
                                            oninput='moveFocus(4, "numberParcel6", "parcelAddress")'>
                                        <!-- Clear Button -->
                                        <button id='clearParcelButton'
                                            class='btn'
                                            onclick='clearParcelInputs()'
                                            tabindex="-1"
                                            style='font-size: 22px;'>
                                            <i class='fas fa-angle-double-left'></i>
                                        </button>
                                    </div>
                                </div>
                                <div class='textbox-row'>
                                    <div class='label-column'>ADDRESS</div>
                                    <div class='input-column'>
                                        <span id='parcelAddress'
                                            class='text-display'></span>
                                    </div>
                                </div>
                                <div class='textbox-row'>
                                    <div class='label-column'>PHOTO DATE</div>
                                    <div class='input-column'>
                                        <input id='photoDate'
                                            type='date'
                                            placeholder='Date Photo Taken'>
                                    </div>
                                </div>
                                <div class='textbox-row'>
                                    <div class='label-column'>VISIT CODE</div>
                                    <div class='input-column'>
                                        <select id='visitCode'>
                                            <option value=''></option> <?php foreach ($visitCodes as $code): ?> <option
                                                value='<?php echo htmlspecialchars($code); ?>'>
                                                <?php echo htmlspecialchars($code); ?> </option> <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class='textbox-row'>
                                    <div class='label-column'>IMAGE TYPE</div>
                                    <div class='input-column'>
                                        <select id='imageType'>
                                            <option value=''></option>
                                            <option value='TYPE:AG'>AG</option>
                                            <option value='TYPE:APEX'>APEX</option>
                                            <option value='TYPE:DAMAGE'>DAMAGE</option>
                                            <option value='TYPE:HX'>HX</option>
                                            <option value='TYPE:IMP'>IMP</option>
                                            <option value='TYPE:LAND'>LAND</option>
                                            <option value='TYPE:MISC'>MISC</option>
                                            <option value='TYPE:OBXF'>OBXF</option>
                                            <option value='TYPE:LAND'>LAND</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='textbox-row'>
                                    <div class='label-column'>COMMENT</div>
                                    <div class='input-column'>
                                        <input type='text'
                                            id='photoComment'
                                            class='wide-textbox'
                                            maxlength='30'
                                            oninput='updateCharacterCount()'>
                                        <span id='charCount'>0/30</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Buttons -->
                    <div class='buttonContainer'>
                        <button id='saveImage'
                            class='btn btn-success'>SAVE PHOTO</button>
                        <button id='clearTextInputs'
                            class='btn btn-warning'>CLEAR TEXT INPUTS</button>
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
                        href='login.html'>Logout</a></div>
            </div>
        </div>
    </div>
    <script src='vendor/jquery/jquery.min.js'></script>
    <script src='vendor/bootstrap/js/bootstrap.bundle.min.js'></script>
    <script src='vendor/jquery-easing/jquery.easing.min.js'></script>
    <script src='js/sb-admin-2.min.js'></script>
    <script src="js/pho_js.js"></script>
</body>

</html>