<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<pre>POST Data:\n";
print_r($_POST);
echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $visitCode = $_POST['visitCode'];
    $visitDescription = $_POST['visitDescription'];
    $active = isset($_POST['active']) ? 1 : 0;
    $visitData = [$visitCode, $visitDescription, $active];

    $filePath = './data/photoVisitCodes.csv';

    if (!empty($id) && $id !== '0') {
        // Existing record: Update
        updateVisitCode($id, array_merge([$id], $visitData));
    } else {
        // New record: Add
        addVisitCode($visitData);
    }
}

function addVisitCode($data)
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

function updateVisitCode($id, $data)
{
    global $filePath;
    $tempPath = 'visitCode_temp.csv';

    $originalFile = fopen($filePath, 'r');
    $tempFile = fopen($tempPath, 'w');

    $found = false;
    while (($photoVisitCodes = fgetcsv($originalFile)) !== false) {
        if ($photoVisitCodes[0] == $id) {
            fputcsv($tempFile, $data);
            $found = true;
        } else {
            fputcsv($tempFile, $photoVisitCodes);
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
        echo "Record with ID $id not found.\n";
    }
}


header('Location: set_visit_codes.php');
exit;
?>