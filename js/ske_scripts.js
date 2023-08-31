document.addEventListener("DOMContentLoaded", function() {
  document.querySelector(".btn-process").addEventListener("click", processAndShowLoading);
});


// Helper function to toggle display of an element
function toggleDisplay(elementId, displayStyle) {
    const element = document.getElementById(elementId);
    element.style.display = displayStyle;
}

// Function to make an AJAX request
function makeAjaxRequest(url) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    resolve();
                } else {
                    reject(new Error('Failed to load data'));
                }
            }
        };

        xhr.send();
    });
}

// Function to process and show loading
async function processAndShowLoading() {
    // Hide the modal body and show the loading GIF
    toggleDisplay('modalBody', 'none');
    toggleDisplay('loadingGif', 'block');

    try {
        // Make AJAX request
        await makeAjaxRequest('ske_sketch_rename.php');

        // Show message popup after successful AJAX request
        showMessagePopup();
    } catch (error) {
        console.error('Something went wrong:', error);
    } finally {
        // Revert the display settings
        toggleDisplay('loadingGif', 'none');
        toggleDisplay('modalBody', 'block');
    }
}

// Function to show the message popup
function showMessagePopup() {
    // Create the popup element
    const popup = document.createElement('div');
    popup.className = 'modal fade';
    popup.id = 'MessagePopup';
    popup.tabIndex = '-1';
    popup.setAttribute('aria-labelledby', 'MessageLabel');
    popup.setAttribute('aria-hidden', 'true');

    // Popup content
    const popupContent = `
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

    // Append content and the popup element to the body
    popup.innerHTML = popupContent;
    document.body.appendChild(popup);

    // Show the popup
    const popupModal = new bootstrap.Modal(popup);
    popupModal.show();

    // Close the main processing modal
    const processingModal = new bootstrap.Modal(document.getElementById('SketchProcessingModal'));
    processingModal.hide();

    // Handle the Continue button click to redirect
    popup.querySelector('.btn-primary').addEventListener('click', function () {
        window.location.href = 'ske_manager.php';
    });
}

// Attach event listener to the process button after DOM content is fully loaded
document.addEventListener('DOMContentLoaded', function () {
    const processButton = document.querySelector('.btn-process');
    if (processButton) {
        processButton.addEventListener('click', processAndShowLoading);
    }
});
