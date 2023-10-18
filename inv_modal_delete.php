<?php require_once './logic/favicon.php'; ?>
<!-- /\/\/\/\/\/\/\/\ -->
<!-- inventory delete modal -->
<!-- \/\/\/\/\/\/\/\/ -->
<div class="modal fade"
    id="delete_inv_item_<?php //echo $row['inv_id']; ?>"
    tabindex="-1"
    aria-labelledby="ModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content"
            style="border-radius: 25px">
            <div class="modal-header">
                <h5 class="modal-title text-dark font-weight-bolder"
                    id="ModalLabel"> INVENTORY ITEM | DELETE </h5>
            </div>
            <div class="modal-body bg-primary">
                <p class="text-light font-weight-bolder text-center">This Action Will Delete The Inventory Item:</p>
                <h2 class="text-light font-weight-bolder text-center text-uppercase">
                    <?php //echo $row['inv_item_make'] . "<br>" . $row['inv_item_model']; ?>
                </h2>
                <p class="text-warning font-weight-bolder text-center">The Delete Process CAN NOT Be Undone!</p>
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-success btn-sm"
                    data-bs-dismiss="modal"> CLOSE </button>
                <a href="inventory_delete.php?inv_id=<?php //echo $row['inv_id']; ?>"
                    class="btn btn-danger btn-sm"> DELETE </a>
            </div>
        </div>
    </div>
</div>