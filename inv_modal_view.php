<?php require_once './logic/favicon.php'; ?>
<!-- /\/\/\/\/\/\/\/\ -->
<!-- inventory view modal -->
<!-- \/\/\/\/\/\/\/\/ -->
<div class="modal fade"
    id="view_inv_item_<?php echo $row['inv_id']; ?>"
    tabindex="-1"
    aria-labelledby="ModalLabel"
    aria-hidden="true"
    data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content"
            style="border-radius: 25px">
            <div class="modal-header">
                <h5 class="modal-title text-dark font-weight-bolder"
                    id="ModalLabel"> INVENTORY | VIEW </h5>
            </div>
            <div class="modal-body bg-primary">
                <form method="POST"
                    action="inventory_view.php?inv_id=<?php echo $row['inv_id']; ?>">
                    <div class="mb-3 row align-self-center">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">STATUS</label>
                        <div class="col-sm">
                            <label class="text-light font-weight-bolder text-left text-uppercase">
                                <?php echo $row['inv_item_status']; ?>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 row align-self-center">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">MAKE</label>
                        <div class="col-sm">
                            <label class="text-light font-weight-bolder text-left text-uppercase">
                                <?php echo $row['inv_item_make']; ?>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 row align-self-center">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">MODEL</label>
                        <div class="col-sm">
                            <label class="text-light font-weight-bolder text-left text-uppercase">
                                <?php echo $row['inv_item_model']; ?>
                            </label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-success btn-sm"
                    data-bs-dismiss="modal"> CLOSE </button>
                <a href="#edit_inv_item_<?php echo $row['inv_id']; ?>"
                    class="btn btn-primary btn-sm"
                    data-bs-toggle="modal"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="EDIT ITEM"> EDIT </a>
            </div>
            </form>
        </div>
    </div>
</div>