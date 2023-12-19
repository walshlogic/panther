<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<pre>POST Data:\n";
print_r($_POST);
echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $active = isset($_POST['active']) ? 1 : 0;
    $username = $_POST['username'];
    $workemail = $_POST['workemail'];
    $deskPhone = $_POST['deskPhone'];
    $workMobile = $_POST['workMobile'];
    $personalMobile = $_POST['personalMobile'];

    $appraiserData = [$firstName, $lastName, $active, $username, $workemail, $deskPhone, $workMobile, $personalMobile];

    $filePath = './data/appraisers.csv';

    if (!empty($id) && $id !== '0') {
        // Existing record: Update
        updateAppraiser($id, array_merge([$id], $appraiserData));
    } else {
        // New record: Add
        addAppraiser($appraiserData);
    }
}

function addAppraiser($data)
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

function updateAppraiser($id, $data)
{
    global $filePath;
    $tempPath = 'appraisers_temp.csv';

    $originalFile = fopen($filePath, 'r');
    $tempFile = fopen($tempPath, 'w');

    $found = false;
    while (($appraiser = fgetcsv($originalFile)) !== false) {
        if ($appraiser[0] == $id) {
            fputcsv($tempFile, $data);
            $found = true;
        } else {
            fputcsv($tempFile, $appraiser);
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


header('Location: app_view_index.php');
exit;
?>