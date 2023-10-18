<!-- /\/\/\/\ -->
<!-- TEST: Error Modal -->
<!-- \/\/\/\/ -->
<div class="modal fade"
    id="errormodal"
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
                    id="ModalLabel"> ERROR | TEST </h5>
            </div>
            <div class="modal-body bg-primary">
                <form method="POST"
                    action="emp_action_view.php?id=<?php //echo $row['id']; ?>">
                    <div class="mb-3 row align-self-center">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">CURRENT
                            DATE/TIME:</label>
                        <div class="col-sm">
                            <label class="text-light font-weight-bolder text-left text-uppercase">
                                <?php //echo date("m-d-Y"); ?>
                            </label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-success btn-sm"
                    data-bs-dismiss="modal"> CLOSE </button>
            </div>
            </form>
        </div>
    </div>
</div>