<?php require_once './logic/favicon.php'; ?>
<!-- /\/\/\/\/\/\/\/\ -->
<!-- inventory edit modal -->
<!-- \/\/\/\/\/\/\/\/ -->
<!-- toggle switch style from https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_switch -->
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 160px;
        height: 40px;
    }

    .switch input {
        display: none;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #f0ad4e;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 32px;
        width: 32px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #5cb85c;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(120px);
        -ms-transform: translateX(120px);
        transform: translateX(120px);
    }

    /*------ ADDED CSS ---------*/
    .on {
        display: none;
    }

    .on,
    .off {
        color: white;
        position: absolute;
        transform: translate(-50%, -50%);
        top: 50%;
        left: 50%;
        font-size: 16px;
        font-weight: bolder;
        letter-spacing: 1.1px;
        font-family: Nonito, sans-serif;
    }

    input:checked+.slider .on {
        display: block;
    }

    input:checked+.slider .off {
        display: none;
    }

    /*--------- END --------*/
    /* Rounded sliders */
    .slider.round {
        border-radius: 15px;
    }

    .slider.round:before {
        border-radius: 38%;
    }
</style>
<div class="modal fade"
    id="edit_inv_item_<?php echo $row['inv_id']; ?>"
    tabindex="-1"
    aria-labelledby="ModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content"
            style="border-radius: 25px">
            <div class="modal-header">
                <h5 class="modal-title text-dark font-weight-bolder"
                    id="ModalLabel"> INVENTORY ITEM | EDIT</h5>
            </div>
            <div class="modal-body bg-primary">
                <form method="POST"
                    action="inv_action_edit.php?inv_id=<?php echo $row['inv_id']; ?>">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">STATUS</label>
                        <div class="col-sm">
                            <!-- /\/\/\/\/\/\ -->
                            <!-- toggle switch - inventory status active/inactive - changes color and label text on click -->
                            <!-- \/\/\/\/\/\/ -->
                            <label class="switch">
                                <input type="checkbox"
                                    name="checkboxStatus"
                                    id="checkboxStatus"
                                    <?php
                                    echo $row['inv_item_status'] == true ? "checked" : "";
                                    ?>>
                                <div class="slider round">
                                    <span class="on">ACTIVE</span>
                                    <span class="off">INACTIVE</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">DEPT #</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control  font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem"
                                name="county_dept_num"
                                value="<?php echo $row['county_dept_num']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">ASSET #</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control  font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem"
                                name="county_asset_id"
                                value="<?php echo $row['county_asset_id']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">MAKE</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control  font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem"
                                name="inv_item_make"
                                value="<?php echo $row['inv_item_make']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-labe text-light font-weight-bolder text-right">MODEL</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem "
                                name="inv_item_model"
                                value="<?php echo $row['inv_item_model']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">S/N</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control  font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem"
                                name="inv_item_sn"
                                value="<?php echo $row['inv_item_sn']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">LOCATION</label>
                        <div class="col-sm">
                            <select name="inv_item_location">
                                <?php
                                // connect to database
                                $con = mysqli_connect(
                                    "localhost",
                                    "root",
                                    "Lady!104Misty!104",
                                    "panther"
                                );
                                // mysqli_connect("servername","username","password","database_name")
                                // get all the categories from category table
                                $sql = "SELECT * FROM `facility` ORDER BY fac_loc_number ASC";
                                $all_locations = mysqli_query($con, $sql);
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
                                    <option value="<?php echo $location["fac_loc_number"]; ?>">
                                        <?php
                                        echo $location["fac_loc_number"] . " | " . $location["fac_loc_description"];
                                        // to show the location name to the user
                                        ?>
                                    </option>
                                    <?php
                                    // while loop must be terminiated
                                endwhile;
                                ?>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-success btn-sm"
                    data-bs-dismiss="modal"> CLOSE </button>
                <button type="submit"
                    name="inv_action_edit"
                    class="btn btn-primary btn-sm"> UPDATE </a>
            </div>
            </form>
        </div>
        </form>
    </div>
</div>