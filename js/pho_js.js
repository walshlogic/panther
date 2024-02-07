function handleVisitCodeChange(selectElement) {
    var visitCode = selectElement.value;
    console.log('Selected Visit Code:', visitCode);
}
// >>>>>> DOMContentLoaded <<<<<<  //
document.addEventListener('DOMContentLoaded', function () {
    updateCharacterCount();
    setPhotoDateToToday();
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById('photoDate').value = today;
    document.getElementById('selectedImageContainer').classList.add('inactive');
    document.getElementById('uploadButton').addEventListener('click', function () {
        document.getElementById('fileInput').click();
        resetForm();
    });

    document.getElementById('photoDate').addEventListener('change', function () {
        updatePhotoDateDisplay(this.value);
    });
    document.getElementById('fileInput').addEventListener('change', handleFileInputChange);
    document.getElementById('numberVID').addEventListener('input', handleNumberVIDInput);
     // Event listener for the 'resetForm' button
    document.getElementById('resetForm').addEventListener('click', resetForm);
    document.getElementById('numberParcel6').addEventListener('blur', fetchParcelDataByAccountNumber);

    document.getElementById('numberVID').addEventListener('blur', function () {
        var value = this.value.trim();
        if (value) {
            document.getElementById('photoDate').focus();
        } else {
            document.getElementById('numberParcel1').focus();
        }
    });

    function toggleFormElementsBasedOnImagePresence() {
    var imageContainer = document.getElementById('imageScrollContainer');
    var formElements = document.querySelectorAll('#photoWorkingContainer input, #photoWorkingContainer select, #photoWorkingContainer textarea, #photoWorkingContainer button');
    var isEmpty = imageContainer.innerHTML.trim() === '';

    formElements.forEach(function(element) {
        element.disabled = isEmpty; // Disable if empty, enable otherwise
    });
}


    
    
    function formatDate(dateString) {
        var date = new Date(dateString);
        var formattedDate = ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear();
        return formattedDate;
    }
});

function handleVIDBlur() {
    var numberVIDValue = document.getElementById('numberVID').value.trim();
    // If numberVID is empty, set a waiting message or clear the text.
    if (numberVIDValue === '') {
        document.getElementById('parcelAddress').textContent = '';
    } else {
        // adding logic here later  needed.
    }
}

function fetchParcelDataOnBlur() {
    var numberVIDValue = document.getElementById('numberVID').value.trim();
    if (numberVIDValue && !isNaN(numberVIDValue)) {
        fetchParcelData(function() {
            var parcelNumber = constructAccountNumber();
            console.log(`Updating textContent with: ${parcelNumber} |`); // Debugging line
            document.querySelector('.image-infoBottom').textContent = `${parcelNumber}`;
        });
    }
}


function handleNumberVIDInput(event) {
    var numberVIDElement = event.target;
    var numberVIDValue = numberVIDElement.value.trim();
    
    // Validate input and provide feedback
    if (!/^[0-9]*$/.test(numberVIDValue)) {
        alert('Invalid input. Please enter numbers only.');
        numberVIDElement.value = '';
        return;
    }
   
    numberVIDValue = numberVIDValue.replace(/[^0-9]/g, '');
    numberVIDElement.value = numberVIDValue;
    // Disable or enable the numberParcel inputs based on numberVID input
    toggleNumberParcelInputs(numberVIDValue.length > 0);
    // Reset parcelAddress text if numberVID is empty
    if (numberVIDValue === '') {
        document.getElementById('parcelAddress').textContent = '';
    }
     // Update the vidDisplay element with the current numberVID value
    var vidNumber = document.getElementById('numberVID').value;
    document.getElementById('vidDisplay').textContent = "VID:" + vidNumber;
    // Update the visitCodeDisplay element with the current visitCode dropdown value
    var visitCode = document.getElementById.textContent = visitCode;
    document.getElementById('visitCodeDisplay').textContent = visitCode;
}


function fetchParcelData() {
    var numberVID = document.getElementById('numberVID').value;
    var accountNumber = constructAccountNumber();
    var dataToSend = numberVID ? 'numberVID=' + numberVID : 'accountNumber=' + accountNumber;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                var response = JSON.parse(this.responseText);
                if (response.error) {
                    document.getElementById('parcelAddress').textContent = response.error;
                    document.getElementById('selectedImageParcelNumber').textContent = response.error; // Add this line
                } else {
                    // Update parcel address
                    if (response.address) {
                        document.getElementById('parcelAddress').textContent = response.address;
                    }

                    // Update numberVID
                    var numberVIDField = document.getElementById('numberVID');
                    var wasDisabled = numberVIDField.disabled;
                    numberVIDField.disabled = false;

                    if (!numberVID || (response.numberVID && response.numberVID !== numberVID)) {
                        numberVIDField.value = response.numberVID;
                    }

                    numberVIDField.disabled = wasDisabled;

                    // Update parcel number fields
                    if (response.accountNum && accountNumber !== response.accountNum) {
                        var accountNumParts = response.accountNum.split('-');
                        if (accountNumParts.length === 6) {
                            for (let i = 1; i <= 6; i++) {
                                document.getElementById('numberParcel' + i).value = accountNumParts[i - 1];
                            }
                        }
                    }
                }
            } catch (e) {
                console.error('Caught exception:', e);
                document.getElementById('parcelAddress').textContent = 'An error occurred while processing the response.';
                document.getElementById('selectedImageParcelNumber').textContent = 'An error occurred while processing the response.'; // Add this line
            }
        }
    };

    xhttp.open('POST', 'pho_fetch_address.php', true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(dataToSend);
}
// END: 2024-01-10 | Fetch address after leaving numberVID textbox
function resetNumberInputs() {
    var numberVID = document.getElementById('numberVID')
    numberVID.value = ''
    numberVID.disabled = false
    numberVID.style.backgroundColor = ''
    numberVID.style.borderColor = ''
    var numberParcelInputs = document
        .getElementsByClassName('numberParcelContainer')[0]
        .getElementsByTagName('input')
    Array.from(numberParcelInputs).forEach(function (input) {
        input.value = ''
        input.disabled = false
        input.style.backgroundColor = ''
    })
}

function clearParcelInputs() {
    resetNumberInputs()
    // reset focus to the VID textbox
    document.getElementById('numberVID').focus()
    document.getElementById('parcelAddress').textContent = ''
    document.getElementById('imageTextBottom').textContent = ''
    document.getElementById('vidDisplay').textContent = ''
}



function resetForm() {
    resetNumberInputs()
    // Clear text and date inputs
    var textInputs = document.querySelectorAll(
        '#textboxesContainer input[type="text"], #textboxesContainer input[type="date"]'
    );
    textInputs.forEach(function (input) {
        input.value = '';
    });
    // Clear select dropdowns
    var selectInputs = document.querySelectorAll('#textboxesContainer select');
    selectInputs.forEach(function (select) {
        select.selectedIndex = 0; // This sets the dropdown back to its first option
    });
    // Clear appraiser username
    document.getElementById('photoUsername').textContent = '';
    // Set the photoDate to today's date
    setPhotoDateToToday();
    // Reset the parcelAddress text
    document.getElementById('parcelAddress').textContent = '';
    // Clear the text content of 'VID:'
    document.getElementById('vidDisplay').textContent = '';
    // Clear the text content of 'imageTextBottom'
    document.getElementById('imageTextBottom').textContent = '';
    // Set focus to the 'Appraiser' dropdown
    document.getElementById('empSelect').focus();
    // Uncheck the primaryPhoto checkbox
    document.getElementById('primaryPhoto').checked = false;
}


function setPhotoDateToToday() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
    var yyyy = today.getFullYear();
    var formattedDate = yyyy + '-' + mm + '-' + dd;

    // Set the photoDate input value
    var photoDateInput = document.getElementById('photoDate');
    photoDateInput.value = formattedDate;

    // Update the photoDateDisplay
    updatePhotoDateDisplay(today); // Pass the Date object directly
}

function updatePhotoDateDisplay(dateString, isFromDatePicker = false) {
    var date;

    if (typeof dateString === 'string') {
        var parts = dateString.split('-');
        var year = parseInt(parts[0], 10);
        var month = parseInt(parts[1], 10) - 1; // Months are 0-indexed
        var day = parseInt(parts[2], 10);

        if (isFromDatePicker) {
            // Treat the date as a UTC date when selected from date picker
            date = new Date(Date.UTC(year, month, day));
        } else {
            // Regular Date object for other uses
            date = new Date(year, month, day);
        }
    } else {
        // Directly use the Date object if not a string
        date = dateString;
    }

    // Format the date to MM/DD/YYYY
    var formattedDate = ((date.getUTCMonth() + 1) > 9 ? (date.getUTCMonth() + 1) : ('0' + (date.getUTCMonth() + 1))) + '/' + ((date.getUTCDate() > 9 ? date.getUTCDate() : ('0' + date.getUTCDate()))) + '/' + date.getUTCFullYear();

    // Update the text content
    document.getElementById('photoDateDisplay').textContent = formattedDate;
}

// Ensure to pass 'true' for isFromDatePicker when the date is selected from the date picker
document.getElementById('photoDate').addEventListener('change', function () {
    updatePhotoDateDisplay(this.value, true);
});


// Ensure to pass 'true' for isFromDatePicker when the date is selected from the date picker
document.getElementById('photoDate').addEventListener('change', function () {
    updatePhotoDateDisplay(this.value, true);
});

// Event listener for changes in the date picker
document.getElementById('photoDate').addEventListener('change', function () {
    updatePhotoDateDisplay(this.value, true);
});


// Event listener for changes in the date picker
document.getElementById('photoDate').addEventListener('change', function () {
    updatePhotoDateDisplay(this.value, true);
});



// Event listener for changes in the date picker
document.getElementById('photoDate').addEventListener('change', function () {
    updatePhotoDateDisplay(this.value, true);
});


// Event listener for changes in the date picker
document.getElementById('photoDate').addEventListener('change', function () {
    updatePhotoDateDisplay(this.value, true);
});


// Event listener for changes in the date picker
document.getElementById('photoDate').addEventListener('change', function () {
    updatePhotoDateDisplay(this.value);
});


document.addEventListener('DOMContentLoaded', function () {
    setPhotoDateToToday();

    // Event listener for changes in the date picker
    document.getElementById('photoDate').addEventListener('change', function () {
        updatePhotoDateDisplay(this.value);
    });
});



function moveFocus(maxLength, currentField, nextFieldId) {
    var currentElement = document.getElementById(currentField)
    if (currentElement.value.length >= maxLength) {
        var nextElement = document.getElementById(nextFieldId)
        if (nextElement) {
            nextElement.focus()
        }
    }
}
// Function to toggle the disabled state and background color of numberParcel inputs
function toggleNumberParcelInputs(disable) {
    var numberParcelInputs = document
        .getElementsByClassName('numberParcelContainer')[0]
        .getElementsByTagName('input')
    Array.from(numberParcelInputs).forEach(input => {
        input.disabled = disable
        input.style.backgroundColor = disable ? '#e9ecef' : '' // grey out if disabled
    })
}

function handleFileInputChange(event) {
    var files = event.target.files
    var imageContainer = document.getElementById('imageScrollContainer')
    var selectedImageContainer = document.getElementById('selectedImageContainer')
    var selectedImage = document.getElementById('selectedImage')
    if (files.length > 0) {
        imageContainer.innerHTML = ''
        selectedImageContainer.classList.remove('inactive')
        Array.from(files).forEach(function (file, index) {
            var reader = new FileReader()
            reader.onload = function (e) {
                var img = document.createElement('img')
                img.src = e.target.result
                img.style = 'height: 100px; margin-right: 10px; cursor: pointer;'
                img.onclick = function () {
                    selectedImage.src = e.target.result
                }
                imageContainer.appendChild(img)
                if (index === 0) {
                    selectedImage.src = e.target.result
                    document.getElementById('empSelect').focus()
                }
            }
            reader.readAsDataURL(file)
        })
    }
}

function handleEmpSelectChange() {
    document.getElementById('selectedUsername').value = this.value
    document.getElementById('numberVID').focus()
}
// 2024-01-10 | Function to move focus to next field
function moveFocus(currentFieldId, nextFieldId) {
    var currentField = document.getElementById(currentFieldId)
    var nextField = document.getElementById(nextFieldId)
    if (
        currentField &&
        nextField &&
        currentField.value.length === parseInt(currentField.maxLength)
    ) {
        nextField.focus()
    }
}
// 2024-01-10 | Attach this function to the input event of each numberParcel input
document
    .querySelectorAll('.numberParcelContainer input')
    .forEach(function (input) {
        input.addEventListener('input', function () {
            moveFocus(this.id, this.dataset.nextFieldId)
        })
    })
// 2024-01-10 | When the last parcel field is left, check if all fields are filled and trigger the database query
document.getElementById('numberParcel6').addEventListener('blur', function () {
    // 2024-01-10 | Check if all parcel fields are filled
    var allFilled = Array.from(
        document.querySelectorAll('.numberParcelContainer input')
    ).every(function (input) {
        return input.value.trim().length === parseInt(input.maxLength)
    })
    if (allFilled) {
        // 2024-01-10 | Construct the account number from filled fields
        var accountNumber = constructAccountNumber()
        // 2024-01-10 | Query the database with accountNumber
        fetchParcelInfo(accountNumber)
    }
})

function constructAccountNumber() {
    var accountNumber = ''
    for (var i = 1; i <= 6; i++) {
        var value = document.getElementById('numberParcel' + i).value.trim()
        accountNumber += value
        // Add hyphens after the 1st, 2nd, 3rd, 4th, and 5th input boxes
        if (i < 6) {
            accountNumber += '-'
        }
    }
    return accountNumber // This will correctly format the account number as XX-XX-XX-XXXX-XXXX-XXXX
}

function fetchParcelInfo(accountNumber) {
    // Implement the AJAX call here to fetch numberVID and parcelAddress
    // Make sure to handle the response and update the DOM elements accordingly
}

function moveFocus(maxLength, currentFieldId, nextFieldId) {
    var currentField = document.getElementById(currentFieldId)
    if (currentField.value.length >= maxLength) {
        var nextField = document.getElementById(nextFieldId)
        if (nextField) {
            nextField.focus()
        }
    }
}

function checkParcelInputs() {
    var isAnyParcelInputFilled = Array.from(
        document.querySelectorAll('.numberParcelContainer input')
    ).some(input => input.value.trim().length > 0)
    var numberVID = document.getElementById('numberVID')
    numberVID.disabled = isAnyParcelInputFilled
    numberVID.style.backgroundColor = isAnyParcelInputFilled ? '#e9ecef' : ''
}
// Attach this function to the input event of each numberParcel input
document
    .querySelectorAll('.numberParcelContainer input')
    .forEach(function (input) {
        input.addEventListener('input', function () {
            checkParcelInputs()
            moveFocus(this.id, this.dataset.nextFieldId)
        })
    })

function fetchParcelDataByAccountNumber() {
    var accountNumber = constructAccountNumber()
    if (accountNumber) {
        var xhttp = new XMLHttpRequest()
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    try {
                        var response = JSON.parse(this.responseText)
                        if (response.address) {
                            document.getElementById('parcelAddress').textContent =
                                response.address
                        } else if (response.error) {
                            console.error('Error from server: ', response.error)
                            document.getElementById('parcelAddress').textContent =
                                response.error
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e)
                    }
                } else {
                    console.error('Failed to fetch data. Status: ', this.status)
                }
            }
        }
        xhttp.open('POST', 'pho_fetch_address.php', true)
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
        xhttp.send('accountNumber=' + encodeURIComponent(accountNumber))
    } else {
    }
}

// Attach this function to the blur event of the last parcel number textbox
document
    .getElementById('numberParcel6')
    .addEventListener('blur', fetchParcelDataByAccountNumber)

    function fetchParcelData() {
    var numberVID = document.getElementById('numberVID').value
    var accountNumber = constructAccountNumber()
    var dataToSend = numberVID
        ? 'numberVID=' + numberVID
        : 'accountNumber=' + accountNumber

    var xhttp = new XMLHttpRequest()
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                var response = JSON.parse(this.responseText)
                if (response.error) {
                    document.getElementById('parcelAddress').textContent = response.error
                } else {
                    // Update parcel address
                    if (response.address) {
                        document.getElementById('parcelAddress').textContent =
                            response.address
                         document.getElementById('imageTextBottom').textContent =
                            response.accountNum
                    }

                    // Update numberVID
                    var numberVIDField = document.getElementById('numberVID')
                    var wasDisabled = numberVIDField.disabled
                    numberVIDField.disabled = false

                    if (
                        !numberVID ||
                        (response.numberVID && response.numberVID !== numberVID)
                    ) {
                        numberVIDField.value = response.numberVID
                    }

                    numberVIDField.disabled = wasDisabled

                    // Update parcel number fields
                    if (response.accountNum && accountNumber !== response.accountNum) {
                        var accountNumParts = response.accountNum.split('-')
                        if (accountNumParts.length === 6) {
                            for (let i = 1; i <= 6; i++) {
                                document.getElementById('numberParcel' + i).value =
                                    accountNumParts[i - 1]
                            }
                        }
                    }
                }
            } catch (e) {
                console.error('Caught exception:', e)
                document.getElementById('parcelAddress').textContent =
                    'An error occurred while processing the response.'
            }
        }
    }

    xhttp.open('POST', 'pho_fetch_address.php', true)
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
    xhttp.send(dataToSend)
}

// Counter for the photo uploader photo comment textbox in photo manager 2024-01-11
 function updateCharacterCount() {
        var commentInput = document.getElementById('photoComment');
        var charCountElement = document.getElementById('charCount');
        var currentLength = commentInput.value.length;
        charCountElement.textContent = currentLength + '/30';
}

// JavaScript Function to Remove the Image
function removeSelectedPhoto() {
    var selectedImageSrc = document.getElementById('selectedImage').src;
    var imagesInScrollContainer = document.getElementById('imageScrollContainer').getElementsByTagName('img');

    // Iterate through images to find a match and remove it
    for (var i = 0; i < imagesInScrollContainer.length; i++) {
        if (imagesInScrollContainer[i].src === selectedImageSrc) {
            imagesInScrollContainer[i].parentNode.removeChild(imagesInScrollContainer[i]);
            break; // Break the loop once the image is found and removed
        }
    }

    // Check if there are any images left in the scroll container
    if (document.getElementById('imageScrollContainer').getElementsByTagName('img').length > 0) {
        // If there are remaining images, display the first one in the selectedImageContainer
        var firstImageSrc = document.getElementById('imageScrollContainer').getElementsByTagName('img')[0].src;
        document.getElementById('selectedImage').src = firstImageSrc;
    } else {
        // If there are no images left, revert to the placeholder image
        document.getElementById('selectedImage').src = 'assets/imageBase/paSeal.png';
    }
}

// Attach Event Listener to "Remove Photo" Button
document.getElementById('removePhoto').addEventListener('click', removeSelectedPhoto);


