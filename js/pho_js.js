function handleVIDBlur() {
    var numberVIDValue = document.getElementById('numberVID').value.trim()
    // If numberVID is empty, set a waiting message or clear the text.
    if (numberVIDValue === '') {
        document.getElementById('parcelAddress').textContent = ''
    } else {
    }
}

function fetchParcelDataOnBlur() {
    var numberVIDValue = document.getElementById('numberVID').value.trim();
    if (numberVIDValue && !isNaN(numberVIDValue)) {
        // Fetch parcel data and then update the info text
        fetchParcelData(function() {
            // This callback function will be executed after the parcel data is fetched
            var parcelNumber = constructAccountNumber();
            var vidNumber = document.getElementById('numberVID').value;
            // Update the .image-infoBottom text content
            document.querySelector('.image-infoBottom').textContent = `${parcelNumber}[${vidNumber}]`;
        });
    }
}

function handleNumberVIDInput(event) {
    var numberVIDElement = event.target
    var numberVIDValue = numberVIDElement.value.trim()
    numberVIDValue = numberVIDValue.replace(/[^0-9]/g, '')
    numberVIDElement.value = numberVIDValue
    // Disable or enable the numberParcel inputs based on numberVID input
    toggleNumberParcelInputs(numberVIDValue.length > 0)
    // Reset parcelAddress text if numberVID is empty
    if (numberVIDValue === '') {
        document.getElementById('parcelAddress').textContent = ''
    }
}

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
                     document.getElementById('selectedImageParcelNumber').textContent = response.error; // Add this line
                } else {
                    // Update parcel address
                    if (response.address) {
                        document.getElementById('parcelAddress').textContent =
                            response.address
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
                document.getElementById('selectedImageParcelNumber').textContent = 'An error occurred while processing the response.'; // Add this line
           }
        }
    }

    xhttp.open('POST', 'pho_fetch_address.php', true)
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
    xhttp.send(dataToSend)
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
}

function clearTextInputs() {
    resetNumberInputs()
    // Clear text and date inputs
    var textInputs = document.querySelectorAll(
        '#textboxesContainer input[type="text"], #textboxesContainer input[type="date"]'
    )
    textInputs.forEach(function (input) {
        input.value = ''
    })
    // Clear select dropdowns
    var selectInputs = document.querySelectorAll('#textboxesContainer select')
    selectInputs.forEach(function (select) {
        select.selectedIndex = 0 // This sets the dropdown back to its first option
    })
    // Set the photoDate to today's date
    setPhotoDateToToday()
    // Reset the parcelAddress text
    document.getElementById('parcelAddress').textContent = ''
    // Set focus to the 'Appraiser' dropdown
    document.getElementById('empSelect').focus()
}

function setPhotoDateToToday() {
    var today = new Date()
    var dd = String(today.getDate()).padStart(2, '0')
    var mm = String(today.getMonth() + 1).padStart(2, '0') //January is 0!
    var yyyy = today.getFullYear()
    today = yyyy + '-' + mm + '-' + dd
    document.getElementById('photoDate').value = today
}

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
// >> DOMContentLoaded <<
document.addEventListener('DOMContentLoaded', function () {
    updateCharacterCount(); // Update photo comment counter on page load
    setPhotoDateToToday()
    var today = new Date()
    var dd = String(today.getDate()).padStart(2, '0')
    var mm = String(today.getMonth() + 1).padStart(2, '0')
    var yyyy = today.getFullYear()
    today = yyyy + '-' + mm + '-' + dd
    document.getElementById('photoDate').value = today
    document.getElementById('selectedImageContainer').classList.add('inactive')
    document
        .getElementById('uploadButton')
        .addEventListener('click', function () {
            document.getElementById('fileInput').click()
            clearTextInputs()
        })
    document
        .getElementById('fileInput')
        .addEventListener('change', handleFileInputChange)
    document
        .getElementById('numberVID')
        .addEventListener('input', handleNumberVIDInput)
    // Attach the function to the blur event of the last parcel number textbox
    document
        .getElementById('numberParcel6')
        .addEventListener('blur', fetchParcelDataByAccountNumber)
    // When the numberVID field is left, check the condition and move focus accordingly
    document.getElementById('numberVID').addEventListener('blur', function () {
        var value = this.value.trim()
        if (value) {
            // Focus on photoDate if numberVID is filled
            document.getElementById('photoDate').focus()
        } else {
            // Focus on the first parcel number field if numberVID is empty
            document.getElementById('numberParcel1').focus()
        }
    })
    // Photo date change event listener
   document.getElementById('photoDate').addEventListener('change', function() {
    var photoDate = this.value;
    if (photoDate) {
        var formattedDate = formatDate(photoDate); // Format date as needed
        document.getElementById('photoDateDisplay').textContent = formattedDate;
    }
});

function formatDate(dateString) {
    var date = new Date(dateString);
    var formattedDate = ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) + '/' + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + date.getFullYear();
    return formattedDate;
}

    document
        .getElementById('empSelect')
        .addEventListener('change', handleEmpSelectChange)
})

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

