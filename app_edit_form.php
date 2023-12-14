<?php
// Check if editing an existing appraiser
$editing = isset($_GET['edit']);
$appraiserData = $editing ? getExistingAppraiserData($_GET['edit']) : ['', '', '', '', '', '', '', ''];

function getExistingAppraiserData($id)
{
    // Logic to retrieve existing data from CSV based on the given ID
    // For simplicity, this example assumes a blank array
    return []; // Replace with actual fetching logic
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- [Include necessary CSS and JS files] -->
</head>

<body>
    <div>
        <form action="app_add_process.php"
            method="post">
            <input type="hidden"
                name="id"
                value="<?php echo $editing ? $_GET['edit'] : ''; ?>">
            <div>
                <label>First Name:</label>
                <input type="text"
                    name="firstName"
                    value="<?php echo $appraiserData[0]; ?>">
            </div>
            <div>
                <label>Last Name:</label>
                <input type="text"
                    name="lastName"
                    value="<?php echo $appraiserData[1]; ?>">
            </div>
            <div>
                <label>Active:</label>
                <input type="checkbox"
                    name="active"
                    <?php echo $appraiserData[2] ? 'checked' : ''; ?>
                    value="1">
            </div>
            <div>
                <label>Username:</label>
                <input type="text"
                    name="username"
                    value="<?php echo $appraiserData[3]; ?>">
            </div>
            <div>
                <label>Work Email:</label>
                <input type="text"
                    name="workemail"
                    value="<?php echo $appraiserData[4]; ?>">
            </div>
            <div>
                <label>Desk Phone Number:</label>
                <input type="text"
                    name="deskPhone"
                    value="<?php echo $appraiserData[5]; ?>">
            </div>
            <div>
                <label>Work Mobile Phone:</label>
                <input type="text"
                    name="workMobile"
                    value="<?php echo $appraiserData[6]; ?>">
            </div>
            <div>
                <label>Personal Mobile Phone:</label>
                <input type="text"
                    name="personalMobile"
                    value="<?php echo $appraiserData[7]; ?>">
            </div>
            <div>
                <input type="submit"
                    value="<?php echo $editing ? 'Update' : 'Add'; ?> Appraiser">
            </div>
        </form>
    </div>
</body>

</html>