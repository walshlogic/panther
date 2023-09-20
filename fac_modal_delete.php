<!-- /\/\/\/\/\/\/\/\ -->
<!-- facility delete modal -->
<!-- \/\/\/\/\/\/\/\/ -->
<div class="modal fade"
    id="fac_action_delete_<?php echo $row['id']; ?>"
    tabindex="-1"
    aria-labelledby="ModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content"
            style="border-radius: 25px">
            <div class="modal-header">
                <h5 class="modal-title text-dark font-weight-bolder"
                    id="ModalLabel"> FACILITY | LOCATION DELETE </h5>
            </div>
            <div class="modal-body bg-primary">
                <p class="text-light font-weight-bolder text-center">This Action Will Delete The Facility Location Item:
                </p>
                <h2 class="text-light font-weight-bolder text-center text-uppercase">
                    <?php echo $row['fac_loc_number']; ?>
                </h2>
                <h2 class="text-light font-weight-bolder text-center text-uppercase">
                    <?php echo $row['fac_loc_description']; ?>
                </h2>
                <p class="text-warning font-weight-bolder text-center">The Delete Process CAN NOT Be Undone!</p>
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-success btn-sm"
                    data-bs-dismiss="modal"> CLOSE </button>
                <a href="fac_action_delete.php?id=<?php echo $row['id']; ?>"
                    class="btn btn-danger btn-sm"> DELETE </a>
            </div>
        </div>
    </div>
</div>