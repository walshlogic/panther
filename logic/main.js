document.addEventListener("DOMContentLoaded", function () {

// ECMAScript code ( jscript standard to ensure the interoperability of web pages across different browsers)
// Insert, Update, Fetch, & Delete code ALSO validates form with Bootstrap 5 methods

// from dcodemania.com/post/crud-app-php-oop-pdo-mysql-fetch-api-es6
const addForm = document.getElementById("add-parcel-form");
const updateForm = document.getElementById("edit-parcel-form");
const showAlert = document.getElementById("showAlert");
const addModal = new bootstrap.Modal(document.getElementById("addParcelModal"));
const editModal = new bootstrap.Modal(document.getElementById("editParcelModal"));
const tbody = document.querySelector("tbody");

// Initialize modals
addModal.initialize();
editModal.initialize();


// add new parcel ajax request
addForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(addForm);
    formData.append("add", 1);

    if (addForm.checkValidity() === false) {
        e.preventDefault();
        e.stopPropagation();
        addForm.classList.add("was-validated");
        return false;
    } else {
        document.getElementById("add-parcel-btn").value = "Please Wait...";

        const data = await fetch("action.php", {
            method: "POST",
            body: formData,
        });
        const response = await data.text();
        showAlert.innerHTML = response;
        document.getElementById("add-parcl-btn").value = "Add Parcel";
        addForm.reset();
        addForm.classList.remove("was-validated");
        addModal.hide();
        fetchAllParcels();
    }
});

// fetch all parcels ajax request
const fetchAllParcels = async () => {
    const data = await fetch("action.php?read=1", {
        method: "GET",
    });
    const response = await data.text();
    tbody.innerHTML = response;
};
fetchAllParcels();

// edit parcel ajax request
tbody.addEventListener("click", (e) => {
    if (e.target && e.target.matches("a.editLink")) {
        e.preventDefault();
        let visId = e.target.getAttribute("visId");
        editParcel(visId);
    }
});

const editParcel = async (visId) => {
    const data = await fetch(`action.php?edit=1&visId=${visId}`, {
        method: "GET",
    });
    const response = await data.json();
    document.getElementById("visId").value = response.visId;
    document.getElementById("numVid").value = response.numVid;
    document.getElementById("addStreet").value = response.addStreet;
    document.getElementById("addCity").value = response.addCity;
    document.getElementById("nameLast").value = response.nameLast;
    document.getElementById("dateLastVisit").value = response.dateLastVisit;
    document.getElementById("visitPurpose").value = response.visitPurpose;
};

// update parcel ajax request
updateForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(updateForm);
    formData.append("update", 1);

    if (updateForm.checkValidity() === false) {
        e.preventDefault();
        e.stopPropagation();
        updateForm.classList.add("was-validated");
        return false;
    } else {
        document.getElementById("edit-parcel-btn").value = "Please Wait...";

        const data = await fetch("action.php", {
            method: "POST",
            body: formData,
        });
        const response = await data.text();

        showAlert.innerHTML = response;
        document.getElementById("edit-parcel-btn").value = "Add Parcel";
        updateForm.reset();
        updateForm.classList.remove("was-validated");
        editModal.hide();
        fetchAllParcels();
    }
});

// delete parcel ajax request
tbody.addEventListener("click", (e) => {
    if (e.target && e.target.matches("a.deleteLink")) {
        e.preventDefault();
        let visId = e.target.getAttribute("visId");
        deleteParcel(visId);
    }
});

const deleteParcel = async (visId) => {
    const data = await fetch(`action.php?delete=1&visId=${visId}`, {
        method: "GET",
    });
    const response = await data.text();
    showAlert.innerHTML = response;
    fetchAllParcels();
};

//
// START - Photo Manager - Annotate Images
//



    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
        // Handle file upload here
        $target_dir = "uploads/";
        $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check if it's a valid image file (you can add more checks here)
        if (getimagesize($_FILES["fileToUpload"]["tmp_name"])) {
            // Move the uploaded file to your desired location
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
            // Load the image
            $image = imagecreatefromjpeg($target_file);
            // Original image dimensions
            $original_width = imagesx($image);
            $original_height = imagesy($image);
            // Calculate the desired size (80% of 8.5x11 inches) in pixels
            // Assuming a dpi of 300 (common print resolution)
            $width_in_inches = 8.5 * 0.8;
            $height_in_inches = 11 * 0.8;
            $desired_width = $width_in_inches * 300;
            $desired_height = $height_in_inches * 300;
            // Calculate the scaling factors for width and height
            $scale_factor_w = $desired_width / $original_width;
            $scale_factor_h = $desired_height / $original_height;
            // Use the smaller scaling factor to ensure the image fits within the desired size
            $scale_factor = min($scale_factor_w, $scale_factor_h);
            // Calculate the new dimensions
            $new_width = $original_width * $scale_factor;
            $new_height = $original_height * $scale_factor;
            // Create a new true color image
            $resized_image = imagecreatetruecolor($new_width, $new_height);
            // Resize the original image to new dimensions
            imagecopyresampled($resized_image, $image, 0, 0, 0, 0, $new_width, $new_height,
                $original_width, $original_height);
            // Set the annotation color
            $black = imagecolorallocate($resized_image, 0, 0, 0);
            // Add the annotation (adjust the coordinates as needed)
            $annotation_x = $x_value * $scale_factor;
            $annotation_y = $y_value * $scale_factor;
            imagestring($resized_image, 5, $annotation_x, $annotation_y, 'Your annotation text here',
                $black);
            // Save the new image
            $output_filename = 'annotated_image.jpg';
            imagejpeg($resized_image, $output_filename, 100);
            // Clean up
            imagedestroy($image);
            imagedestroy($resized_image);
            // Now call the function to format the image for printing.
            formatImageForPrinting();
        } else {
            // Handle invalid image file
        }
    }

    // Annotate an image
    function annotateImage() {
        const img = document.getElementById('selectedImage');
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        // Retrieve annotation values
        const fieldAppraiser = document.querySelector('[placeholder="Appraiser Username"]').value;
        const photoDate = document.getElementById('photoDate').value;
        const visionID = document.querySelector('[placeholder="Numeric Only"]').value;
        const visitPurpose = document.getElementById('visitPurpose').value;

        // Draw the original image on the canvas
        canvas.width = img.width;
        canvas.height = img.height;
        ctx.drawImage(img, 0, 0);

        // Set annotation properties
        ctx.font = '20px Arial';
        ctx.fillStyle = 'black'; // Annotation text color

        // Define annotation text
        const annotationText = `${visionID} | ${fieldAppraiser} | ${visitPurpose} | ${photoDate}`;

        // Draw the annotation text on the canvas
        ctx.fillText(annotationText, 10, img.height + 25);

        // Update the source of the image element
        img.src = canvas.toDataURL();
    }

    // Attach the annotation function to the "Annotate" button
    document.getElementById('annotateButton').addEventListener('click', function () {
        annotateImage();
    });

    function formatImageForPrinting() {
        let img = document.getElementById('selectedImage');
        let canvas = document.createElement('canvas');
        let ctx = canvas.getContext('2d');
        let paperWidth = 8.5 * 300; // Assuming 300 DPI (dots per inch)
        let paperHeight = 11 * 300;
        let maxWidth = 0.8 * paperWidth;
        let maxHeight = 0.8 * paperHeight;
        // Calculate new dimensions while maintaining aspect ratio
        let ratio = Math.min(maxWidth / img.width, maxHeight / img.height);
        let newWidth = img.width * ratio;
        let newHeight = img.height * ratio;
        // Center the image on the canvas
        let offsetX = (paperWidth - newWidth) / 2;
        let offsetY = (paperHeight - newHeight) / 2;
        canvas.width = paperWidth;
        canvas.height = paperHeight;
        ctx.fillStyle = "white";
        ctx.fillRect(0, 0, paperWidth, paperHeight);
        ctx.drawImage(img, offsetX, offsetY, newWidth, newHeight);
        // Annotate text below the image
        let fieldAppraiser = document.querySelector('[placeholder="Appraiser Username"]').value;
        let photoDate = document.getElementById('photoDate').value;
        let visionID = document.querySelector('[placeholder="Numeric Only"]').value;
        let visitPurpose = document.getElementById('visitPurpose').value;
        let annotationText = `${visionID} | ${fieldAppraiser} | ${visitPurpose} | ${photoDate}`;
        ctx.font = "20px Arial";
        let textWidth = ctx.measureText(annotationText).width;
        let textX = (paperWidth - textWidth) / 2;
        let textY = offsetY + newHeight + 30; // 30 is the gap between image and text
        ctx.fillText(annotationText, textX, textY);
        // Update the source of the image element
        img.src = canvas.toDataURL();
    }

    function saveAnnotatedImage() {
        let canvas = document.getElementById('hiddenCanvas');
        canvas.toBlob(function (blob) {
            let link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'annotated-image.png';
            link.click();
            URL.revokeObjectURL(link.href);
        });
    }
    window.addEventListener("DOMContentLoaded", (event) => {
        const photoDateInput = document.getElementById('photoDate');
        const currentDate = new Date();
        // Format the date in MM/dd/yyyy format
        const formattedDate = ('0' + (currentDate.getMonth() + 1)).slice(-2) + '/' + ('0' +
            currentDate.getDate()).slice(-2) + '/' + currentDate.getFullYear();
        photoDateInput.value = formattedDate;
    });

    document.getElementById('annotateButton').addEventListener('click', function () {
        // Your image
        let img = document.getElementById('selectedImage');
        // Your hidden canvas
        let canvas = document.getElementById('hiddenCanvas');
        let ctx = canvas.getContext('2d');
        // Retrieve textbox values
        let fieldAppraiser = document.querySelector('[placeholder="Appraiser Username"]').value;
        let photoDate = document.getElementById('photoDate').value;
        let visionID = document.querySelector('[placeholder="Numeric Only"]').value;
        let visitPurpose = document.querySelector('[placeholder="Site Visit Purpose"]').value;
        // Set canvas dimensions
        let addedHeight = 100; // Adjust as needed
        canvas.width = img.width;
        canvas.height = img.height + addedHeight;
        // Draw image and annotations
        ctx.drawImage(img, 0, 0);
        ctx.font = "20px Arial"; // Adjust font size and style as needed
        ctx.fillText(`Field Appraiser: ${fieldAppraiser}`, 10, img.height + 25);
        ctx.fillText(`Photo Date: ${photoDate}`, 10, img.height + 50);
        ctx.fillText(`Vision ID or Parcel ID: ${visionID}`, 10, img.height + 75);
        ctx.fillText(`Visit Purpose: ${visitPurpose}`, 10, img.height + 100);
        // Update image source with annotated version
        img.src = canvas.toDataURL();
    });

    document.getElementById('uploadButton').addEventListener('click', function () {
        document.getElementById('fileInput').click();
    });
    document.getElementById('fileInput').addEventListener('change', function () {
        const selectedFiles = this.files;
        const thumbnailContainer = document.getElementById('thumbnailContainer');
        thumbnailContainer.innerHTML = '';
        for (let i = 0; i < selectedFiles.length; i++) {
            const thumbnail = document.createElement('div');
            thumbnail.className = 'thumbnail';
            const img = document.createElement('img');
            img.src = URL.createObjectURL(selectedFiles[i]);
            img.className = 'custom-thumbnail';
            img.onload = function () {
                URL.revokeObjectURL(this.src);
            };
            thumbnail.appendChild(img);
            thumbnailContainer.appendChild(thumbnail);
            // Add click event to thumbnail images
            thumbnail.addEventListener('click', function () {
                document.getElementById('selectedImage').src = URL.createObjectURL(
                    selectedFiles[i]);
            });
        }
        if (selectedFiles.length > 0) {
            document.getElementById('selectedImage').src = URL.createObjectURL(selectedFiles[
                0]);
        }
    });
    document.getElementById('annotateButton').addEventListener('click', function () {
        annotateImage();
    });
    document.getElementById('saveAnnotatedImage').addEventListener('click', function () {
        saveAnnotatedImage();
    });
    //
    // END - Photo Manager - Annotate Images
    //
});