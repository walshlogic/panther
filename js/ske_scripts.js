// Wrap your code in a DOMContentLoaded event to make sure that the document is fully loaded before attaching event listeners
document.addEventListener("DOMContentLoaded", function () {
  console.log("DOM fully loaded. Adding event listener to the process button.");

  // Unbind any existing event handlers and bind the new one for the "Process" button
  $(".btn-process").off("click").on("click", processAndShowLoading);
});

// Function to toggle the display property of an element
function toggleDisplay(elementId, displayValue) {
  console.log(`Toggling display for element ${elementId} to ${displayValue}`);
  document.getElementById(elementId).style.display = displayValue;
}

// Function to make the AJAX request
async function makeAjaxRequest(url) {
  console.log("Making AJAX request to " + url);
  return new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", url);
    xhr.onreadystatechange = function () {
      console.log(`AJAX request state changed: ${xhr.readyState}`);
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          console.log("AJAX request successful.");
          resolve(xhr.responseText);
        } else {
          console.log("AJAX request failed.");
          reject(xhr.status);
        }
      }
    };
    xhr.send();
  });
}

// Function to show the message popup
function showMessagePopup() {
  console.log("Showing message popup.");
  const popup = $("#messagePopup");
  if (popup.length > 0) {
    console.log("Initialized message popup. About to show it.");
    popup.modal("show");
    // Hiding the main processing modal
    console.log("Hiding the main processing modal.");
    $("#skeModalProcessing").modal("hide");

    // Unbind previous handlers and add a new one for the "Continue" button
    console.log("Adding event listener for the Continue button.");
    $(".btn-continue").off("click").one("click", function () {
      console.log("Continue button clicked.");
      popup.modal("hide");
    });
  }
}

// Function to process and show loading
async function processAndShowLoading(event) {
  console.log("processAndShowLoading called");
  if (event) {
    event.stopPropagation();
    console.log("processAndShowLoading function called.");
    toggleDisplay("modalBody", "none");
    toggleDisplay("loadingGif", "block");

    try {
      await makeAjaxRequest("ske_sketch_rename.php");
      showMessagePopup();
    } catch (error) {
      console.error("Something went wrong:", error);
    } finally {
      toggleDisplay("loadingGif", "none");
      toggleDisplay("modalBody", "block");
    }
  }
}
