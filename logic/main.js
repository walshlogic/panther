// ECMAScript code ( jscript standard to ensure the interoperability of web pages across different browsers)
// Insert, Update, Fetch, & Delete code ALSO validates form with Bootstrap 5 methods

// from dcodemania.com/post/crud-app-php-oop-pdo-mysql-fetch-api-es6
const addForm = document.getElementById("add-parcel-form");
const updateForm = document.getElementById("edit-parcel-form");
const showAlert = document.getElementById("showAlert");
const addModal = new bootstrap.Modal(document.getElementById("addParcelModal"));
const editModal = new bootstrap.Modal(document.getElementById("editParcelModal"));
const tbody = document.querySelector("tbody");

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
