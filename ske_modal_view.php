<?php
require_once './logic/favicon.php';
require_once 'ske_view_index.php';
?>
<!-- /\/\/\/\ -->
<!-- SKETCH: VIEW Modal -->
<!-- \/\/\/\/ -->
<div class="modal fade"
    id="ske_modal_view_<?php echo $filename ?>"
    tabindex="-1"
    aria-labelledby="ModalLabel"
    aria-hidden="true"
    data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content"
            style="border-radius: 25px">
            <div id="printableContent">
                <div class="modal-header">
                    <h5 class="modal-title text-primary font-weight-bolder"
                        id="ModalLabel"> SKETCH MANAGER | SKETCH VIEWER</h5>
                </div>
                <div class="modal-body bg-primary">
                    <form method="POST"
                        action="printModal()"
                        enctype="multipart/form-data">
                        <div class="text-center">
                            <br>
                            <img class="img-responsive"
                                src="<?php echo $sketchImage ?>"
                                id="<?php $sketchImage ?>">
                        </div>
                        <br>
                        <p class="text-center text-light text-uppercase font-weight-bolder"
                            style="font-size: 24px"> <?php echo 'SKETCH FILE: ' . $filename ?> </p>
                        <?php $tempName = $filename ?>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-success btn-sm"
                    data-bs-dismiss="modal"> CLOSE </button>
            </div>
        </div>
    </div>
</div>