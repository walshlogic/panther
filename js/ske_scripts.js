// Helper function to remove existing event listeners from an element by cloning it
function removeEventListeners(element) {
    var newElement = element.cloneNode(true);
    element.parentNode.replaceChild(newElement, element);
    return newElement;
}

document.addEventListener("DOMContentLoaded", function() {
    console.log("DOM fully loaded. Adding event listener to the process button.");
    // Remove any existing event listeners and attach a new one
    var processButton = document.querySelector(".btn-process");
    processButton = removeEventListeners(processButton);
    processButton.addEventListener("click", processAndShowLoading, { once: true });
});

// Helper function to toggle display of an element
function toggleDisplay(elementId, displayStyle) {
    console.log(`Toggling display for element ${elementId} to ${displayStyle}`);
    const element = document.getElementById(elementId);
    element.style.display = displayStyle;
}

// Function to make an AJAX request
function makeAjaxRequest(url) {
    console.log(`Making AJAX request to ${url}`);
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onreadystatechange = function () {
            console.log(`AJAX request state changed: ${xhr.readyState}`);
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log('AJAX request successful.');
                    resolve();
                } else {
                    console.error('Failed to load data.');
                    reject(new Error('Failed to load data'));
                }
            }
        };

        xhr.send();
    });
}

// Function to process and show loading
async function processAndShowLoading(event) {
     console.log("processAndShowLoading called");
    if (event) {
        event.stopPropagation();
        console.log('processAndShowLoading function called.');
        toggleDisplay('modalBody', 'none');
        toggleDisplay('loadingGif', 'block');

        try {
            await makeAjaxRequest('ske_sketch_rename.php');
            showMessagePopup();
        } catch (error) {
            console.error('Something went wrong:', error);
        } finally {
            toggleDisplay('loadingGif', 'none');
            toggleDisplay('modalBody', 'block');
        }
    }
}

// Function to show the message popup
function showMessagePopup() {
    console.log('Showing message popup.');
    const popup = document.createElement('div');
    popup.className = 'modal fade';
    popup.id = 'MessagePopup';
    popup.tabIndex = '-1';
    popup.setAttribute('aria-labelledby', 'MessageLabel');
    popup.setAttribute('aria-hidden', 'true');

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
                    <button type="button" class="btn btn-primary btn-continue" data-dismiss="modal">Continue</button>
                </div>
            </div>
        </div>
    `;

    popup.innerHTML = popupContent;
    document.body.appendChild(popup);

    console.log('Initialized message popup. About to show it.');
    const popupModal = new bootstrap.Modal(popup);
    popupModal.show();

    console.log('Hiding the main processing modal.');

    console.log('Adding event listener for the Continue button.');
    var continueButton = popup.querySelector('.btn-continue');
    continueButton = removeEventListeners(continueButton);
    continueButton.addEventListener('click', function () {
        console.log('Continue button clicked. Redirecting to ske_manager.php');
        window.location.href = 'ske_manager.php';
    });
}
