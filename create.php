<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $address = $salary = "";
$name_err = $address_err = $salary_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate First Name
    $input_name = trim($_POST["namefirst"]);
    if (empty($input_name)) {
        $first_name_err = "Please Enter a First Name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $first_name_err = "Please Enter a Valid First Name! (No Special Characters).";
    } else {
        $last_name = $input_first_name;
    }


    // Validate Last Name
    $input_name = trim($_POST["namelast"]);
    if (empty($input_name)) {
        $last_name_err = "Please Enter a Last Name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $last_name_err = "Please Enter a Valid Last Name! (No Special Characters Including - and ').";
    } else {
        $last_name = $input_last_name;
    }
//    // Validate address
//    $input_address = trim($_POST["address"]);
//    if (empty($input_address)) {
//        $address_err = "Please enter an address.";
//    } else {
//        $address = $input_address;
//    }
//
//    // Validate salary
//    $input_salary = trim($_POST["salary"]);
//    if (empty($input_salary)) {
//        $salary_err = "Please enter the salary amount.";
//    } elseif (!ctype_digit($input_salary)) {
//        $salary_err = "Please enter a positive integer value.";
//    } else {
//        $salary = $input_salary;
//    }

    // Check input errors before inserting in database
    if (empty($firstname_err) && empty($lastnmae_err) ) {
        // Prepare an insert statement
        $sql = "INSERT INTO employees (firstname, lastname) VALUES (?, ?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_firstname, $param_lastname);

            // Set parameters
            $param_first_name = $firstname;
            $param_last_name = $lastname;
  

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Create Record</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            .wrapper{
                width: 600px;
                margin: 0 auto;
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="mt-5">Create Record</h2>
                        <p>Please fill this form and submit to add employee record to the database.</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="namefirst" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>">
                                <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="namelast" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>">
                                <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="jobtitle" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>">
                                <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                        </form>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>