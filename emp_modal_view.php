<?php require_once './logic/favicon.php'; ?>
<!-- ||||||||||||||||||||||||| EMPLOYEE AREA ||||||||||||||||||||||||| -->
<!-- /\/\/\/\ -->
<!-- EMPLOYEE: VIEW Modal -->
<!-- \/\/\/\/ -->
<div class="modal fade"
    id="view_<?php echo $row['id']; ?>"
    tabindex="-1"
    aria-labelledby="ModalLabel"
    aria-hidden="true"
    data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content"
            style="border-radius: 25px">
            <div class="modal-header">
                <h5 class="modal-title text-primary font-weight-bolder"
                    id="ModalLabel"> EMPLOYEE | VIEW </h5>
            </div>
            <div class="modal-body bg-primary">
                <form method="POST"
                    action="emp_action_view.php?id=<?php echo $row['id']; ?>">
                    <div class="mb-3 row align-self-center">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">FULL
                            NAME</label>
                        <div class="col-sm">
                            <label class="text-light font-weight-bolder text-left text-uppercase">
                                <?php echo $row['firstname'] . ' ' . $row['lastname']; ?>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 row align-self-center">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">INITIALS</label>
                        <div class="col-sm">
                            <label class="text-light font-weight-bolder text-left text-uppercase">
                                <?php echo $row['initialsname']; ?>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">TITLE</label>
                        <div class="col-sm">
                            <label class="text-light font-weight-bolder text-left text-uppercase">
                                <?php echo $row['emp_title']; ?>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">EMAIL</label>
                        <div class="col-sm">
                            <label class="text-light font-weight-bolder text-left text-lowercase">
                                <?php echo $row['email']; ?>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">LOGIN</label>
                        <div class="col-sm">
                            <label class="text-light font-weight-bolder text-left text-lowercase">
                                <?php echo $row['user_login']; ?>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">DESK #</label>
                        <div class="col-sm">
                            <label class="text-light font-weight-bolder text-left text-lowercase">
                                <?php echo $row['phone_work_desk']; ?>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">MOBILE #</label>
                        <div class="col-sm">
                            <label class="text-light font-weight-bolder text-left text-lowercase">
                                <?php echo $row['phone_work_mobile']; ?>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">PROFILE
                            PIC</label>
                        <div class="col-sm">
                            <label class="text-light font-weight-bolder text-left text-lowercase">
                                <?php echo $row['profile_pic']; ?>
                            </label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-success btn-sm"
                    data-bs-dismiss="modal"> CLOSE </button>
                <a href="#edit_<?php echo $row['id']; ?>"
                    class="btn btn-primary btn-sm"
                    data-bs-toggle="modal"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="EDIT EMPLOYEE"> EDIT </a>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /\/\/\/\-->
<!-- EMPLOYEE: EDIT Modal -->
<!-- \/\/\/\/ -->
<div class="modal fade"
    id="edit_<?php echo $row['id']; ?>"
    tabindex="-1"
    aria-labelledby="ModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content"
            style="border-radius: 25px">
            <div class="modal-header">
                <h5 class="modal-title text-primary font-weight-bolder"
                    id="ModalLabel"> EMPLOYEE | EDIT</h5>
            </div>
            <div class="modal-body bg-primary">
                <form method="POST"
                    action="emp_action_edit.php?id=<?php echo $row['id']; ?>">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">FIRST
                            NAME</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control  font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem"
                                name="firstname"
                                value="<?php echo $row['firstname']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-labe text-light font-weight-bolder text-right">LAST NAME</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem"
                                name="lastname"
                                value="<?php echo $row['lastname']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-labe text-light font-weight-bolder text-right">AKA NAME</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem"
                                name="akaname"
                                value="<?php echo $row['akaname']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-labe text-light font-weight-bolder text-right">INITIALS</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem"
                                name="initialsname"
                                value="<?php echo $row['initialsname']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">TITLE</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control  font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem"
                                name="emp_title"
                                value="<?php echo $row['emp_title']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">EMAIL</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control  font-weight-bolder text-lowercase"
                                style="border-radius: 0.8rem"
                                name="email"
                                value="<?php echo $row['email']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">USERNAME</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control  font-weight-bolder text-lowercase"
                                style="border-radius: 0.8rem"
                                name="user_login"
                                value="<?php echo $row['user_login']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">DESK #</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control  font-weight-bolder text-lowercase"
                                style="border-radius: 0.8rem"
                                name="phone_work_desk"
                                value="<?php echo $row['phone_work_desk']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">MOBILE #</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control  font-weight-bolder text-lowercase"
                                style="border-radius: 0.8rem"
                                name="phone_work_mobile"
                                value="<?php echo $row['phone_work_mobile']; ?>">
                        </div>
                    </div>
                    <!-- /\/\/\/\ -->
                    <!-- link employee with their office location -->
                    <!-- \/\/\/\/ -->
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">LOCATION</label>
                        <div class="col-sm">
                            <select name="emp_location">
                                <?php
                                // connect to database
                                $con = mysqli_connect(
                                    "localhost",
                                    "root",
                                    "Dixie!104",
                                    "panther"
                                );
                                // mysqli_connect("servername","username","password","database_name")
                                // get all the categories from category table
                                $sql = "SELECT * FROM `facility`";
                                $all_locations = mysqli_query($con, $sql);
                                // the following code checks if the submit button is clicked
                                // and inserts the data in the database accordingly
                                if (isset($_POST['submit'])) {
                                    // store the location name in a "location" variable
                                    $loc_num = mysqli_real_escape_string(
                                        $con, $_POST['loc_number']
                                    );
                                    // store the facility ID in a "id" variable
                                    $id = mysqli_real_escape_string(
                                        $con, $_POST['fac_id']
                                    );
                                    // creating an insert query using SQL syntax and
                                    // storing it in a variable.
                                    $sql_insert = "INSERT INTO `employee`(`location`)
            VALUES ('$loc_number')";
                                    // The following code attempts to execute the SQL query
                                    // if the query executes with no errors
                                    // a javascript alert message is displayed
                                    // which says the data is inserted successfully
                                    if (mysqli_query($con, $sql_insert)) {
                                        echo '<script>alert("Location Added To Employee Record Successfully")</script>';
                                    }
                                }
                                // use a while loop to fetch data
                                // from the $all_locations variable
                                // and individually display as an option
                                while (
                                    $location = mysqli_fetch_array(
                                        $all_locations,
                                        MYSQLI_ASSOC
                                    )
                                ):
                                    ;
                                    ?>
                                    <option value="<?php
                                    echo $location["loc_number"];
                                    // the value we usually set is the primary key
                                    ?>"> <?php
                                    echo $location["loc_number"] . " | " . $location["loc_description"];
                                    // to show the location name to the user
                                    ?> </option>
                                    <?php
                                endwhile;
                                // While loop must be terminated
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- ||| -->
                    <!-- profile picture selection -->
                    <!-- ||| -->
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">PROFILE
                            PIC</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control font-weight-bolder text-lowercase"
                                style="border-radius: 0.8rem"
                                name="profile_pic"
                                value="<?php echo $row['profile_pic']; ?>">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-success btn-sm"
                    data-bs-dismiss="modal"> CLOSE </button>
                <button type="submit"
                    name="edit"
                    class="btn btn-primary btn-sm"> UPDATE </a>
            </div>
            </form>
        </div>
        </form>
    </div>
</div>
<!-- /\/\/\/\ -->
<!-- EMPLOYEE: DELETE Modal -->
<!-- \/\/\/\/ -->
<div class="modal fade"
    id="delete_<?php echo $row['id']; ?>"
    tabindex="-1"
    aria-labelledby="ModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content"
            style="border-radius: 25px">
            <div class="modal-header">
                <h5 class="modal-title text-primary font-weight-bolder"
                    id="ModalLabel"> EMPLOYEE | DELETE </h5>
            </div>
            <div class="modal-body bg-primary">
                <p class="text-light font-weight-bolder text-center">This Action Will Delete The Employee Record For:
                </p>
                <h2 class="text-light font-weight-bolder text-center text-uppercase">
                    <?php echo $row['firstname'] . ' ' . $row['lastname']; ?>
                </h2>
                <p class="text-warning font-weight-bolder text-center">The Delete Process CAN NOT Be Undone!</p>
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-success btn-sm"
                    data-bs-dismiss="modal"> CLOSE </button>
                <a href="emp_action_delete.php?id=<?php echo $row['id']; ?>"
                    class="btn btn-danger btn-sm"> DELETE </a>
            </div>
        </div>
    </div>
</div>
<!-- ||||||||||||||||||||||||| SUGGESTION AREA ||||||||||||||||||||||||| -->
<!-- /\/\/\/\ -->
<!-- SUGGESTION: ADD Modal -->
<!-- \/\/\/\/ -->
<div class="modal fade"
    id="addsuggestion"
    tabindex="-1"
    role="dialog"
    aria-labelledby="ModalLabel"
    aria-hidden="true"
    data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered"
        role="document">
        <div class="modal-content"
            style="border-radius: 25px">
            <div class="modal-header">
                <h5 class="modal-title text-primary font-weight-bolder"
                    id="ModalLabel">SUGGESTION | ADD</h5>
            </div>
            <div class="modal-body bg-primary">
                <!-- ||| -->
                <!-- begin form for add suggestion text inputs -->
                <!-- ||| -->
                <form method="POST"
                    action="sug_action_add.php">
                    <!-- ||| -->
                    <!--  name text input -->
                    <!-- ||| -->
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">YOUR
                            NAME</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem"
                                name="name">
                        </div>
                    </div>
                    <!-- ||| -->
                    <!-- suggestion text area input -->
                    <!-- ||| -->
                    <div class="mb-3 row">
                        <label
                            class="col-sm-3 col-form-label text-light font-weight-bolder text-right">SUGGESTION</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem"
                                name="suggestion">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <!-- ||| -->
                <!-- close modal button code data-bs-dismiss -->
                <!-- ||| -->
                <button type="button"
                    class="btn btn-sm btn-success font-weight-bolder"
                    data-bs-dismiss="modal"> CLOSE </button>
                <button type="submit"
                    name="add"
                    class="btn btn-sm btn-primary font-weight-bolder"> SUBMIT </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /\/\/\/\ -->
<!-- SUGGESTION: VIEW Modal -->
<!-- \/\/\/\/ -->
<div class="modal fade"
    id="sug_action_view_<?php echo $row['id']; ?>"
    tabindex="-1"
    aria-labelledby="ModalLabel"
    aria-hidden="true"
    data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content"
            style="border-radius: 25px">
            <div class="modal-header">
                <h5 class="modal-title text-primary font-weight-bolder"
                    id="ModalLabel"> SUGGESTION | VIEW </h5>
            </div>
            <div class="modal-body bg-primary">
                <form method="POST"
                    action="sug_action_view.php?id=<?php echo $row['id']; ?>">
                    <div class="mb-3 row align-self-center">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">NAME</label>
                        <div class="col-sm">
                            <label class="text-light font-weight-bolder text-left text-uppercase">
                                <?php echo $row['name']; ?>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 row align-self-center">
                        <label
                            class="col-sm-3 col-form-label text-light font-weight-bolder text-right">SUGGESTION</label>
                        <div class="col-sm">
                            <label class="text-light font-weight-bolder text-left text-uppercase">
                                <?php echo $row['suggestion']; ?>
                            </label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-success btn-sm"
                    data-bs-dismiss="modal"> CLOSE </button>
                <a href="#sug_action_edit_<?php echo $row['id']; ?>"
                    class="btn btn-primary btn-sm"
                    data-bs-toggle="modal"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="EDIT SUGGESTION"> EDIT </a>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /\/\/\/\-->
<!-- SUGGESTION: EDIT Modal -->
<!-- \/\/\/\/ -->
<div class="modal fade"
    id="sug_action_edit_<?php echo $row['id']; ?>"
    tabindex="-1"
    aria-labelledby="ModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content"
            style="border-radius: 25px">
            <div class="modal-header">
                <h5 class="modal-title text-primary font-weight-bolder"
                    id="ModalLabel"> SUGGESTION | EDIT</h5>
            </div>
            <div class="modal-body bg-primary">
                <form method="POST"
                    action="sug_action_edit.php?id=<?php echo $row['id']; ?>">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">NAME</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control  font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem"
                                name="name"
                                value="<?php echo $row['name']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label
                            class="col-sm-3 col-form-labe text-light font-weight-bolder text-right">SUGGESTION</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem "
                                name="suggestion"
                                value="<?php echo $row['suggestion']; ?>">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-success btn-sm font-weight-bolder"
                    data-bs-dismiss="modal"> CLOSE </button>
                <button type="submit"
                    name="sug_action_edit"
                    class="btn btn-primary btn-sm font-weight-bolder"> UPDATE </a>
            </div>
            </form>
        </div>
        </form>
    </div>
</div>
<!-- /\/\/\/\ -->
<!-- SUGGESTION: DELETE Modal -->
<!-- \/\/\/\/ -->
<div class="modal fade"
    id="sug_action_delete_<?php echo $row['id']; ?>"
    tabindex="-1"
    aria-labelledby="ModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content"
            style="border-radius: 25px">
            <div class="modal-header">
                <h5 class="modal-title text-primary font-weight-bolder"
                    id="ModalLabel"> SUGGESTION | DELETE </h5>
            </div>
            <div class="modal-body bg-primary">
                <p class="text-light font-weight-bolder text-center">This Action Will Delete The Suggestion Submitted
                    By:</p>
                <h2 class="text-light font-weight-bolder text-center text-uppercase">
                    <?php echo $row['name']; ?>
                </h2>
                <p class="text-warning font-weight-bolder text-center">The Delete Process CAN NOT Be Undone!</p>
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-success btn-sm font-weight-bolder"
                    data-bs-dismiss="modal"> CLOSE </button>
                <a href="sug_action_delete.php?id=<?php echo $row['id']; ?>"
                    class="btn btn-sm  btn-danger font-weight-bolder"> DELETE </a>
            </div>
        </div>
    </div>
</div>