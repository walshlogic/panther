<?php
require './util.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // Assuming this is the row ID in the CSV file
    $visitCode = $_POST['visitCode']; // Capture the "Visit Code" from the form
    $visitDescription = $_POST['visitDescription'];
    $active = isset($_POST['active']) ? 1 : 0;

    $csvFilePath = './data/visitCodes.csv';
    $csvData = readVisitCodesCSV($csvFilePath);

    if ($id !== '') {
        // Edit existing code
        foreach ($csvData as $index => $row) {
            if ($row[0] == $id) {
                // Update the row with the new "Visit ID", description, and active status
                $csvData[$index] = [$id, $visitCode, $visitDescription, $active];
                break;
            }
        }
    } else {
        // Add new code
        // Use the next incremental ID for the new row, assuming $id is an auto-increment field
        $newId = count($csvData);
        $csvData[] = [$newId, $visitCode, $visitDescription, $active];
    }

    writeVisitCodesCSV($csvFilePath, $csvData);

    // Redirect back to the codes listing page
    header('Location: sys_pho_visit_codes.php');
    exit;
}

// Function to read data from the CSV file
function readVisitCodesCSV($csvFile)
{
    if (!file_exists($csvFile) || !is_readable($csvFile)) {
        return []; // Return an empty array if the file doesn't exist or isn't readable
    }

    $data = [];
    if (($handle = fopen($csvFile, 'r')) !== false) {
        while (($row = fgetcsv($handle, 1000, ",")) !== false) {
            $data[] = $row;
        }
        fclose($handle);
    }
    return $data;
}

function writeVisitCodesCSV($csvFile, $data)
{

    $file_handle = fopen($csvFile, 'w');
    foreach ($data as $row) {
        fputcsv($file_handle, $row);
    }
    fclose($file_handle);
}