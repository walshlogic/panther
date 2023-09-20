<!-- /\/\/\/\/\/\/\/\ -->
<!-- facility edit modal -->
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
    id="fac_action_edit_<?php echo $row['id']; ?>"
    tabindex="-1"
    aria-labelledby="ModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content"
            style="border-radius: 25px">
            <div class="modal-header">
                <h5 class="modal-title text-dark font-weight-bolder"
                    id="ModalLabel"> FACILITY | LOCATION EDIT</h5>
            </div>
            <div class="modal-body bg-primary">
                <form method="POST"
                    action="fac_action_edit.php?id=<?php echo $row['id']; ?>">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">LOCATION
                            #</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control  font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem"
                                name="fac_loc_number"
                                value="<?php echo $row['fac_loc_number']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">CATEGORY</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control  font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem"
                                name="fac_loc_type"
                                value="<?php echo $row['fac_loc_type']; ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label
                            class="col-sm-3 col-form-label text-light font-weight-bolder text-right">DESCRIPTION</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control  font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem"
                                name="fac_loc_description"
                                value="<?php echo $row['fac_loc_description']; ?>">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-success btn-sm"
                    data-bs-dismiss="modal"> CLOSE </button>
                <button type="submit"
                    name="fac_action_edit"
                    class="btn btn-primary btn-sm"> UPDATE </a>
            </div>
            </form>
        </div>
        </form>
    </div>
</div>