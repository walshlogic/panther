<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

print_r($_POST);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id']; // Will be empty for new entries
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $active = isset($_POST['active']) ? 1 : 0;
    $username = $_POST['username'];
    $workemail = $_POST['workemail'];
    $deskPhone = $_POST['deskPhone'];
    $workMobile = $_POST['workMobile'];
    $personalMobile = $_POST['personalMobile'];

    $appraiserData = [$firstName, $lastName, $active, $username, $workemail, $deskPhone, $workMobile, $personalMobile];

    if ($id) {
        // Update existing appraiser
        updateAppraiser($id, $appraiserData);
    } else {
        // Add new appraiser
        addAppraiser($appraiserData);
    }

    // Redirect back to the list view
    header('Location: app_view_index.php');
    exit;
}

function addAppraiser($data)
{
    $filePath = 'appraisers.csv'; // Correct path to your CSV file

    // Open the file in append mode
    $file = fopen($filePath, 'a');

    if ($file !== false) {
        fputcsv($file, $data); // Add the new appraiser's data to the file
        fclose($file);
    } else {
        // Error handling if the file can't be opened
        echo "Error: Unable to open the file.";
    }
}

function updateAppraiser($id, $data)
{
    $filePath = 'appraisers.csv'; // Correct path to your CSV file
    $tempPath = 'temp_appraisers.csv'; // Temporary file path for updating

    $originalFile = fopen($filePath, 'r');
    $tempFile = fopen($tempPath, 'w');

    if ($originalFile !== false && $tempFile !== false) {
        while (($appraiser = fgetcsv($originalFile)) !== false) {
            if ($appraiser[0] == $id) { // Assuming the ID is the first element
                fputcsv($tempFile, $data); // Update with new data
            } else {
                fputcsv($tempFile, $appraiser); // Copy old data
            }
        }
        fclose($originalFile);
        fclose($tempFile);

        // Replace old file with new file
        rename($tempPath, $filePath);
    } else {
        // Error handling if files can't be opened
        echo "Error: Unable to open the file.";
    }
}

// Redirect to the list view in case of direct access to this file
//-- Uncomment this later for debug only header('Location: app_view_index.php');
//-- Uncomment this later for debug only exit;
?>