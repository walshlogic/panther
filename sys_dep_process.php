<?php
require './util.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $departmentName = $_POST['departmentName']; // Correct variable name
    $active = isset($_POST['active']) ? 1 : 0;

    $csvFilePath = './data/departments.csv';
    $csvData = readDepartmentNamesCSV($csvFilePath);

    if ($id !== '') {
        // Edit existing department
        foreach ($csvData as $index => $row) {
            if ($row[0] == $id) {
                $csvData[$index] = [$id, $departmentName, $active]; // Update all columns
                break;
            }
        }
    } else {
        // Add new department
        $csvData[] = [count($csvData), $departmentName, $active];
    }

    writeDepartmentNamesCSV($csvFilePath, $csvData);

    // Redirect back to the department manager page
    header('Location: sys_dep_manager.php');
    exit;
}

// Function to read data from the CSV file
function readDepartmentNamesCSV($csvFile)
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

function writeDepartmentNamesCSV($csvFile, $data)
{
    $file_handle = fopen($csvFile, 'w');
    foreach ($data as $row) {
        fputcsv($file_handle, $row);
    }
    fclose($file_handle);
}
