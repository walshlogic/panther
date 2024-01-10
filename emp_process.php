<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<pre>POST Data:\n";
print_r($_POST);
echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $empId = isset($_POST['empId']) ? $_POST['empId'] : null;
    $empFirstName = isset($_POST['empFirstName']) ? $_POST['empFirstName'] : '';
    $empLastName = isset($_POST['empLastName']) ? $_POST['empLastName'] : '';
    $empActive = isset($_POST['empActive']) ? 1 : 0;
    $empPhotoManager = isset($_POST['empPhotoManager']) ? 1 : 0;
    $empDepartment = isset($_POST['empDepartment']) ? $_POST['empDepartment'] : '';
    $empTitle = isset($_POST['empTitle']) ? $_POST['empTitle'] : '';
    $empUsername = isset($_POST['empUsername']) ? $_POST['empUsername'] : '';
    $empWorkArea = isset($_POST['empWorkArea']) ? $_POST['empWorkArea'] : '';
    $empWorkEmail = isset($_POST['empWorkEmail']) ? $_POST['empWorkEmail'] : '';
    $empDeskPhone = isset($_POST['empDeskPhone']) ? $_POST['empDeskPhone'] : '';
    $empWorkMobile = isset($_POST['empWorkMobile']) ? $_POST['empWorkMobile'] : '';
    $empPersonalMobile = isset($_POST['empPersonalMobile']) ? $_POST['empPersonalMobile'] : '';
    $empDateHire = isset($_POST['empDateHire']) ? $_POST['empDateHire'] : '';
    $empDateTerm = isset($_POST['empDateTerm']) ? $_POST['empDateTerm'] : '';

    $employeeData = [
        $empFirstName, $empLastName, $empActive, $empPhotoManager, $empDepartment,
        $empTitle, $empUsername, $empWorkArea, $empWorkEmail,
        $empDeskPhone, $empWorkMobile, $empPersonalMobile,
        $empDateHire, $empDateTerm
    ];

    $filePath = './data/employees.csv';

    if (!empty($empId) && $empId !== '0') {
        // Existing record: Update
        updateEmployee($empId, array_merge([$empId], $employeeData));
    } else {
        // New record: Add
        addEmployee($employeeData);
    }
}

function addEmployee($data)
{
    global $filePath;
    $file = fopen($filePath, 'a+');
    $newId = getNewId($file);
    array_unshift($data, $newId);
    fputcsv($file, $data);
    fclose($file);
}

function getNewId($file)
{
    rewind($file);
    $lastId = 0;
    while (($row = fgetcsv($file)) !== FALSE) {
        $currentId = (int) $row[0];
        if ($currentId > $lastId) {
            $lastId = $currentId;
        }
    }
    return $lastId + 1;
}

function updateEmployee($empId, $data)
{
    global $filePath;
    $tempPath = 'employees_temp.csv';

    $originalFile = fopen($filePath, 'r');
    $tempFile = fopen($tempPath, 'w');

    $found = false;
    while (($employees = fgetcsv($originalFile)) !== false) {
        if ($employees[0] == $empId) {
            fputcsv($tempFile, $data);
            $found = true;
        } else {
            fputcsv($tempFile, $employees);
        }
    }

    fclose($originalFile);
    fclose($tempFile);

    if ($found) {
        if (!rename($tempPath, $filePath)) {
            echo "Error: unable to rename the file.";
            // Display specific error details
            print_r(error_get_last());
        }
    } else {
        echo "Record with ID $empId not found.\n";
    }
}


header('Location: emp_manager.php');
exit;
?>