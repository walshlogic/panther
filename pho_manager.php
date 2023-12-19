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
// END   |||| Screen Container Header Information ||||
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
    <title>
        <?php echo $screenTitle; ?>
    </title>
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
            /* Replace this with margin if gap is not working */
        }

        #userSelect,
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
    </style>
</head>

<body id='page-top'>
    <div id='wrapper'>
        <?php require './logic/sidebar.php';
        ?>
        <div id='content-wrapper'
            class='d-flex flex-column'>
            <div id='content'>
                <?php require './logic/topbar.php';
                ?>
                <div class='container-fluid'>
                    <?php require './logic/screentitlebar.php'; ?>
                    <div class='container-fluid'>
                        <input type="hidden"
                            name="selectedUsername"
                            id="selectedUsername">
                    </div>
                    <input type='file'
                        id='fileInput'
                        style='display: none;'
                        multiple>
                    <!-- <button id='uploadButton'
                        class='btn btn-primary'>UPLOAD</button> -->
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
                                    <select name="userSelect"
                                        id="userSelect"
                                        onchange="selectUser()">
                                        <option value=""></option>
                                        <?php
                                        $filePath = './data/appraisers.csv'; // Path to your CSV file
                                        $appraisers = [];

                                        if (($handle = fopen($filePath, "r")) !== FALSE) {
                                            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                                $active = $data[3]; // Assuming 'active' is in the fourth column
                                                if ($active == '1') { // Check if appraiser is active
                                                    $firstName = $data[1]; // Assuming first name is in the second column
                                                    $lastName = $data[2];  // Assuming last name is in the third column
                                                    $fullName = $lastName . ' ' . $firstName;
                                                    $appraisers[$data[0]] = $fullName; // Using ID as the key
                                                }
                                            }
                                            fclose($handle);
                                        }

                                        asort($appraisers); // Sort the array by full name
                                        
                                        foreach ($appraisers as $id => $name) {
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
                                        oninput='moveFocus(10, "numberVID", "numberParcel1")'>
                                </div>
                            </div>
                            <!-- Parcel ID Row -->
                            <div class='textbox-row'>
                                <div class='label-column'>Parcel #</div>
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
                                        oninput='moveFocus(4, "numberParcel6", "photoDate")'>
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
                        class='btn btn-primary'>Annotate</button>
                    <button id='saveAnnotatedImage'
                        class='btn btn-success'>Save Annotated Image</button>
                </div>
            </div>
            <?php require './logic/footer.php';
            ?>
        </div>
    </div><a class='scroll-to-top roun   ded'
        href='#page-top'><i class='fas fa-angle-up'></i></a>
    <div class='modal fade'
        id='logoutModal'
        tabindex='-1'
        role='dialog'
        aria-labelledby='exampleModalLabel'
        aria-hidden='true'>
        <div class='modal-dialog'
            role='document'>
            <div class='moda    l-content'>
                <div cla
                    ss='modal-header'>
                    <h5 class='modal-title'
                        id='exampleModalLabel'>Ready to Leave?</h5><button class='close'
                        type='button'
                        data-dismiss='modal'
                        aria-label='Close'><span aria-hidden='true'></span></button>
                </div>
                <div class=' modal-body'>Select 'Logout'below if you are ready to end your current session.</div>
                <div cla
                    ss='modal-footer'><button class='btn btn-secondary'
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
        function clearParcelInputs() {
            var numberVID = document.getElementById('numberVID');
            var numberParcelContainer = document.getElementsByClassName('numberParcelContainer')[0];
            var numberParcelInputs = numberParcelContainer.getElementsByTagName('input');
            // Clear all numberParcel textboxes
            Array.from(numberParcelInputs).forEach(function (input) {
                input.value = '';
            });
            // Reactivate numberVID textbox
            numberVID.value = '';
            numberVID.disabled = false; // Re-enable the textbox
            numberVID.style.backgroundColor = ''; // Clear any inline background color
            numberVID.style.borderColor = ''; // Clear any inline border color
            numberVID.classList.remove('grayed-out'); // Replace 'grayed-out' with the actual class name if used
            // Optionally, force the document to redraw/refresh the element
            numberVID.style.display = 'none';
            numberVID.offsetHeight; // No need to store this anywhere, the reference is enough
            numberVID.style.display = '';
            // Set focus to the first numberParcel input
            var numberParcel1 = document.getElementById('numberParcel1');
            numberParcel1.focus();
        }

        function clearOtherInputFields(currentField) {
            var numberVID = document.getElementById('numberVID');
            var numberParcelContainer = document.getElementsByClassName('numberParcelContainer')[0];
            var numberParcelInputs = numberParcelContainer.getElementsByTagName('input');
            if (currentField === 'numberVID' && numberVID.value.trim() !== '') {
                Array.from(numberParcelInputs).forEach(function (input) {
                    input.value = '';
                });
            } else if (currentField.startsWith('numberParcel') && Array.from(numberParcelInputs).some(input => input.value
                .trim() !== '')) {
                numberVID.value = '';
            }
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
        document.addEventListener('DOMContentLoaded', function () {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;
            document.getElementById('photoDate').value = today;
            document.getElementById('selectedImageContainer').classList.add('inactive');
            document.getElementById('uploadButton').addEventListener('click', function () {
                document.getElementById('fileInput').click();
            });
            // Handle file input change
            document.getElementById('fileInput').addEventListener('change', function (event) {
                var files = event.target.files;
                var imageContainer = document.getElementById('imageScrollContainer');
                var selectedImageContainer = document.getElementById('selectedImageContainer');
                var selectedImage = document.getElementById('selectedImage');
                if (files.length > 0) {
                    imageContainer.innerHTML = '';
                    selectedImageContainer.classList.remove('inactive');
                    Array.from(files).forEach(function (file, index) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var img = document.createElement('img');
                            img.src = e.target.result;
                            img.style = 'height: 100px; margin-right: 10px; cursor: pointer;';
                            img.onclick = function () {
                                selectedImage.src = e.target.result;
                            };
                            imageContainer.appendChild(img);
                            if (index === 0) {
                                selectedImage.src = e.target.result;
                                document.getElementById('userSelect').focus();
                            }
                        };
                        reader.readAsDataURL(file);
                    });
                }
            });
            var numberVID = document.getElementById('numberVID');
            var numberParcelContainer = document.getElementsByClassName('numberParcelContainer')[0];
            // Event listener for changes in numberVID
            numberVID.addEventListener('input', function () {
                if (this.value.trim() !== '') {
                    toggleNumberParcelInputs(true); // Disable numberParcelInputs
                } else {
                    toggleNumberParcelInputs(false); // Enable numberParcelInputs
                }
            });
            // Event listeners for changes in each numberParcel input
            Array.from(numberParcelContainer.getElementsByTagName('input')).forEach(input => {
                input.addEventListener('input', function () {
                    if (this.value.trim() !== '') {
                        numberVID.disabled = true;
                        numberVID.style.backgroundColor = '#e9ecef'; // grey out if disabled
                    } else {
                        // Check if all numberParcelInputs are empty
                        let allEmpty = Array.from(numberParcelContainer.getElementsByTagName(
                            'input')).every(input => input.value.trim() === '');
                        if (allEmpty) {
                            numberVID.disabled = false;
                            numberVID.style.backgroundColor = ''; // remove grey out
                        }
                    }
                });
            });
            document.getElementById('userSelect').addEventListener('change', function () {
                document.getElementById('selectedUsername').value = this.value;
                document.getElementById('numberVID').focus();
            });
        });
    </script>
</body>

</html>