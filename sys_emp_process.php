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
    $empElectedOffical = isset($_POST['empElectedOffical']) ? 1 : 0;
    $empFieldAppraiser = isset($_POST['empFieldAppraiser']) ? 1 : 0;
    $empDepartment = isset($_POST['empDepartment']) ? $_POST['empDepartment'] : '';
    $empTitle = isset($_POST['empTitle']) ? $_POST['empTitle'] : '';
    $empCerts = isset($_POST['empCerts']) ? $_POST['empCerts'] : '';
    $empUsername = isset($_POST['empUsername']) ? $_POST['empUsername'] : '';
    $empWorkArea = isset($_POST['empWorkArea']) ? $_POST['empWorkArea'] : '';
    $empWorkEmail = isset($_POST['empWorkEmail']) ? $_POST['empWorkEmail'] : '';
    $empDeskPhone = isset($_POST['empDeskPhone']) ? $_POST['empDeskPhone'] : '';
    $empWorkMobile = isset($_POST['empWorkMobile']) ? $_POST['empWorkMobile'] : '';
    $empPersonalMobile = isset($_POST['empPersonalMobile']) ? $_POST['empPersonalMobile'] : '';
    $empDateHire = isset($_POST['empDateHire']) ? $_POST['empDateHire'] : '';
    $empDateTerm = isset($_POST['empDateTerm']) ? $_POST['empDateTerm'] : '';

    $employeeData = [
        $empFirstName,
        $empLastName,
        $empActive,
        $empElectedOffical,
        $empFieldAppraiser,
        $empDepartment,
        $empTitle,
        $empCerts,
        $empUsername,
        $empWorkArea,
        $empWorkEmail,
        $empDeskPhone,
        $empWorkMobile,
        $empPersonalMobile,
        $empDateHire,
        $empDateTerm
    ];

    $filePath = './data/employees.csv';

    if ($empId !== null) { // Check if empId is not null
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
    $tempPath = 'sys_employees_temp.csv';

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

    echo "Debug: empId = $empId<br>";
    echo "Debug: found = " . ($found ? 'true' : 'false') . "<br>";

    if ($found) {
        if (!rename($tempPath, $filePath)) {
            echo "Error: unable to rename the file.<br>";
            // Display specific error details
            print_r(error_get_last());
        } else {
            echo "Debug: File renamed successfully.<br>";
        }
    } else {
        echo "Debug: Record with ID $empId not found in the original file.<br>";
    }
}


header('Location: sys_emp_manager.php');
exit;