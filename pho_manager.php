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
    <script src="logic/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
        crossorigin="anonymous"></script>
    <style>
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
        padding-top: 16px;
        padding-bottom: 16px;
    }

    #selectedImageContainer {
        display: flex;
        align-items: start;
        /* Aligns children to the top of the container */
        gap: 20px;
        padding-top: 16px;
        padding-bottom: 16px;
        /* Adds some space between the image and the textboxes */
    }

    #textboxesContainer {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
        /* Aligns items to the start of the flex container */
    }

    #selectedImage {
        max-width: 50%;
        /* Adjust as needed */
        max-height: 400px;
        object-fit: contain;
        margin-left: 0;
        /* Ensures the image is left-aligned */
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
        width: 19ch;
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
    </style>
</head>

<body id='page-top'>
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
                    <div id='selectedImageContainer'>
                        <img id='selectedImage'
                            src='assets/imageBase/paSeal.png'
                            alt='Selected Image Placeholder'
                            style='max-width: 100%; max-height: 400px; object-fit: contain;'>
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
                                        onblur='fetchAddressOnBlur()'>
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
                                        <i class='fas fa-backspace'></i>
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
                                        <option value=''></option>
                                        <option value='Test 1'>CYCLE</option>
                                        <option value='Test 2'>IMPROVEMENT</option>
                                        <option value='Test 3'>Test 3</option>
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
                        </div>
                    </div>
                    <button id='annotateButton'
                        class='btn btn-primary btn-fixed-width'>ANNOTATE PHOTO</button>
                    <button id='saveAnnotatedImage'
                        class='btn btn-success btn-fixed-width'>SAVE PHOTO</button>
                    <button id='clearTextInputs'
                        class='btn btn-warning btn-fixed-width'
                        onclick='clearTextInputs()'>CLEAR TEXT INPUTS</button>
                </div>
            </div> <?php require './logic/footer.php';
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
                        id='exampleModalLabel'>Ready to Leave?</h5><button class='close'
                        type='button'
                        data-dismiss='modal'
                        aria-label='Close'><span aria-hidden='true'></span></button>
                </div>
                <div class=' modal-body'>Select 'Logout'below if you are ready to end your current session.</div>
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
    <script>
    function handleVIDBlur() {
        var numberVIDValue = document.getElementById('numberVID').value.trim();
        // If numberVID is empty, set a waiting message or clear the text.
        if (numberVIDValue === '') {
            document.getElementById('parcelAddress').textContent = '';
        } else {}
    }
    // START: 2024-01-10 | Fetch address after leaving numberVID textbox
    function fetchAddressOnBlur() {
        var numberVIDValue = document.getElementById('numberVID').value.trim();
        if (numberVIDValue && !isNaN(numberVIDValue)) {
            fetchAddress();
        }
    }

    function handleNumberVIDInput(event) {
        var numberVIDElement = event.target;
        var numberVIDValue = numberVIDElement.value.trim();
        numberVIDValue = numberVIDValue.replace(/[^0-9]/g, '');
        numberVIDElement.value = numberVIDValue;
        // Reset parcelAddress text if numberVID is empty
        if (numberVIDValue === '') {
            document.getElementById('parcelAddress').textContent = 'WAITING FOR FETCH ADDRESS';
        }
    }

    function fetchAddress() {
        console.log("fetchAddress function called"); // Check if this gets logged in the console
        var numberVID = document.getElementById('numberVID').value;
        if (numberVID) {
            // AJAX request to PHP script
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4) {
                    try {
                        if (this.status == 200) {
                            document.getElementById('parcelAddress').textContent = this.responseText;
                        } else {
                            console.error('Error fetching address:', this.status, this.statusText);
                            document.getElementById('parcelAddress').textContent =
                                'Error fetching address. Status: ' + this.status;
                        }
                    } catch (e) {
                        console.error('Caught exception:', e);
                        document.getElementById('parcelAddress').textContent =
                            'An error occurred while processing the response.';
                    }
                }
            };
            xhttp.open("POST", "pho_fetch_address.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            console.log("Sending VID:", numberVID); // This should log the VID you're sending
            xhttp.send("numberVID=" + numberVID);
        }
    }
    // END: 2024-01-10 | Fetch address after leaving numberVID textbox
    function resetNumberInputs() {
        var numberVID = document.getElementById('numberVID');
        numberVID.value = '';
        numberVID.disabled = false;
        numberVID.style.backgroundColor = '';
        numberVID.style.borderColor = '';
        var numberParcelInputs = document.getElementsByClassName('numberParcelContainer')[0].getElementsByTagName(
            'input');
        Array.from(numberParcelInputs).forEach(function(input) {
            input.value = '';
            input.disabled = false;
            input.style.backgroundColor = '';
        });
    }

    function clearParcelInputs() {
        resetNumberInputs();
        // reset focus to the VID textbox
        document.getElementById('numberVID').focus();
    }

    function clearTextInputs() {
        resetNumberInputs();
        // Clear text and date inputs
        var textInputs = document.querySelectorAll(
            '#textboxesContainer input[type="text"], #textboxesContainer input[type="date"]');
        textInputs.forEach(function(input) {
            input.value = '';
        });
        // Clear select dropdowns
        var selectInputs = document.querySelectorAll('#textboxesContainer select');
        selectInputs.forEach(function(select) {
            select.selectedIndex = 0; // This sets the dropdown back to its first option
        });
        // Set the photoDate to today's date
        setPhotoDateToToday();
        // Reset the parcelAddress text
        document.getElementById('parcelAddress').textContent = '';
        // Set focus to the 'Appraiser' dropdown
        document.getElementById('empSelect').focus();
    }

    function setPhotoDateToToday() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById('photoDate').value = today;
    }

    function moveFocus(maxLength, currentField, nextFieldId) {
        var currentElement = document.getElementById(currentField);
        if (currentElement.value.length >= maxLength) {
            var nextElement = document.getElementById(nextFieldId);
            if (nextElement) {
                nextElement.focus();
            }
        }
    }
    // Function to toggle the disabled state and background color of numberParcel inputs
    function toggleNumberParcelInputs(disable) {
        var numberParcelInputs = document.getElementsByClassName('numberParcelContainer')[0].getElementsByTagName(
            'input');
        Array.from(numberParcelInputs).forEach(input => {
            input.disabled = disable;
            input.style.backgroundColor = disable ? '#e9ecef' : ''; // grey out if disabled
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        setPhotoDateToToday();
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById('photoDate').value = today;
        document.getElementById('selectedImageContainer').classList.add('inactive');
        document.getElementById('uploadButton').addEventListener('click', function() {
            document.getElementById('fileInput').click();
            clearTextInputs();
        });
        document.getElementById('fileInput').addEventListener('change', handleFileInputChange);
        document.getElementById('numberVID').addEventListener('input', handleNumberVIDInput);
        document.getElementById('numberVID').addEventListener('blur', handleVIDBlur);
        document.getElementById('empSelect').addEventListener('change', handleEmpSelectChange);
    });

    function handleFileInputChange(event) {
        var files = event.target.files;
        var imageContainer = document.getElementById('imageScrollContainer');
        var selectedImageContainer = document.getElementById('selectedImageContainer');
        var selectedImage = document.getElementById('selectedImage');
        if (files.length > 0) {
            imageContainer.innerHTML = '';
            selectedImageContainer.classList.remove('inactive');
            Array.from(files).forEach(function(file, index) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.style = 'height: 100px; margin-right: 10px; cursor: pointer;';
                    img.onclick = function() {
                        selectedImage.src = e.target.result;
                    };
                    imageContainer.appendChild(img);
                    if (index === 0) {
                        selectedImage.src = e.target.result;
                        document.getElementById('empSelect').focus();
                    }
                };
                reader.readAsDataURL(file);
            });
        }
    }

    function handleEmpSelectChange() {
        document.getElementById('selectedUsername').value = this.value;
        document.getElementById('numberVID').focus();
    }
    </script>
</body>

</html>