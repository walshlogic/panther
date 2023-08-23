<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>Sketch Processing Modal</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <!-- Modal HTML -->
    <div class="modal fade"
        id="SketchProcessingModal"
        tabindex="-1"
        aria-labelledby="ModalLabel"
        aria-hidden="true"
        data-backdrop="static"
        data-keyboard="false"
        role="dialog">
        <div class="modal-dialog modal-md modal-dialog-centered"
            role="document">
            <div class="modal-content"
                style="border-radius: 25px">
                <div class="modal-header">
                    <h5 class="modal-title text-primary font-weight-bolder"
                        id="ModalLabel"> SKETCH MANAGER | PROCESSOR </h5>
                </div>
                <div class="modal-body bg-primary text-light text-uppercase font-weight-bolder text-center"
                    id="modalBody"> Select 'PROCESS' To Initiate Sketch Import <br>
                    <br>
                    <div class="modal-body bg-danger text-uppercase font-weight-bolder text-center"> The Process Will
                        Take Several Minutes <br>
                        <br> Do Not Make Another Selection <br> While The Process Is Running <br>
                    </div>
                    <br>
                    <div class="modal-footer"
                        style="background-color: white;">
                        <button type="button"
                            class="btn btn-success btn-sm"
                            data-dismiss="modal"> CANCEL </button>
                        <button type="button"
                            class="btn btn-primary btn-sm btn-process"
                            onclick="processAndShowLoading()"> PROCESS </button>
                    </div>
                </div>
                <div id="loadingGif"
                    style="display: none; text-align: center;">
                    <img src="img/pantherLoading1.gif"
                        alt="Loading..."
                        style="display: block; margin: 0 auto;">
                </div>
            </div>
        </div>
    </div>
    <!-- Include Bootstrap JS and your JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Function to process and show loading
        function processAndShowLoading() {
            // Hide the modal body
            var modalBody = document.getElementById('modalBody');
            modalBody.style.display = 'none';
            // Show the loading GIF
            var loadingGif = document.getElementById('loadingGif');
            loadingGif.style.display = 'block';
            // Make an AJAX request to the PHP script
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'ske_z_rename-1.php', true); // Updated to 'ske_z_rename-1.php'
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    // Hide the loading GIF
                    loadingGif.style.display = 'none';
                    // Show the modal body again
                    modalBody.style.display = 'block';
                    // Show the message popup
                    showMessagePopup();
                }
            };
            xhr.send();
        }
        // Function to show the message popup
        function showMessagePopup() {
            // Create the popup element
            var popup = document.createElement('div');
            popup.className = 'modal fade';
            popup.id = 'MessagePopup';
            popup.tabIndex = '-1';
            popup.setAttribute('aria-labelledby', 'MessageLabel');
            popup.setAttribute('aria-hidden', 'true');
            var popupContent = `
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="MessageLabel">Sketch Processing Completed</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>The sketch process has been completed.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Continue</button>
                    </div>
                </div>
            </div>
        `;
            popup.innerHTML = popupContent;
            // Append the popup element to the body
            document.body.appendChild(popup);
            // Show the popup
            var popupModal = new bootstrap.Modal(popup);
            popupModal.show();
            // Close the main processing modal
            var processingModal = new bootstrap.Modal(document.getElementById('SketchProcessingModal'));
            processingModal.hide();
            // Handle the Continue button click to redirect
            popup.querySelector('.btn-primary').addEventListener('click', function () {
                window.location.href = 'ske_manager.php';
            });
        }
    </script>
</body>

</html>