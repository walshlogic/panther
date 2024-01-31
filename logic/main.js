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
    
    window.addEventListener("DOMContentLoaded", (event) => {
        const photoDateInput = document.getElementById('photoDate');
        const currentDate = new Date();
        // Format the date in MM/dd/yyyy format
        const formattedDate = ('0' + (currentDate.getMonth() + 1)).slice(-2) + '/' + ('0' +
            currentDate.getDate()).slice(-2) + '/' + currentDate.getFullYear();
        photoDateInput.value = formattedDate;
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
});