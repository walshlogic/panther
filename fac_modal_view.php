<!-- /\/\/\/\/\/\/\/\ -->
<!-- facility view modal -->
<!-- \/\/\/\/\/\/\/\/ -->
<div class="modal fade" id="fac_action_view_<?php echo $row['id'];?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content" style="border-radius: 25px">
            <div class="modal-header">
                <h5 class="modal-title text-primary font-weight-bolder" id="ModalLabel"> FACILITY  | LOCATION VIEW </h5>
            </div>
            <div class="modal-body bg-primary">
                <form method="POST" action="fac_action_view.php?id=<?php echo $row['id'];?>">
                    <div class="mb-3 row align-self-center">
                        <label class ="col-sm-3 col-form-label text-light font-weight-bolder text-right">CATEGORY</label>
                        <div class="col-sm">
                            <label class="text-light font-weight-bolder text-left text-uppercase"> <?php echo $row['fac_loc_type'];?></label>
                        </div>
                    </div>
                    <div class="mb-3 row align-self-center">
                        <label class ="col-sm-3 col-form-label text-light font-weight-bolder text-right">LOCATION #</label>
                        <div class="col-sm">
                            <label class="text-light font-weight-bolder text-left text-uppercase"> <?php echo $row['fac_loc_number'];?></label>
                        </div>
                    </div>
                    <div class="mb-3 row align-self-center">
                        <label class ="col-sm-3 col-form-label text-light font-weight-bolder text-right">DESCRIPTION</label>
                        <div class="col-sm">
                            <label class="text-light font-weight-bolder text-left text-uppercase"> <?php echo $row['fac_loc_description'];?></label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-sm" data-bs-dismiss="modal"> CLOSE </button>
                <a href="#edit_fac_item_<?php echo $row['id'];?>" class="btn btn-primary btn-sm" data-bs-toggle="modal"  data-toggle="tooltip" data-placement="top" title="EDIT LOCATION"> EDIT </a>
            </div>
            </form>
        </div>
    </div>
</div>