<?php
require './util.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $jobTitle = $_POST['jobTitle']; // Correct variable name
    $active = isset($_POST['active']) ? 1 : 0;

    $csvFilePath = './data/jobTitles.csv';
    $csvData = readJobTitlesCSV($csvFilePath);

    if ($id !== '') {
        // Edit existing job title
        foreach ($csvData as $index => $row) {
            if ($row[0] == $id) {
                $csvData[$index] = [$id, $jobTitle, $active]; // Update all columns
                break;
            }
        }
    } else {
        // Add new job title
        $csvData[] = [count($csvData), $jobTitle, $active];
    }

    writeJobTitlesCSV($csvFilePath, $csvData);

    // Redirect back to the job title manager page
    header('Location: sys_job_manager.php');
    exit;
}

// Function to read data from the CSV file
function readJobTitlesCSV($csvFile)
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

function writeJobTitlesCSV($csvFile, $data)
{
    $file_handle = fopen($csvFile, 'w');
    foreach ($data as $row) {
        fputcsv($file_handle, $row);
    }
    fclose($file_handle);
}