<!-- /\/\/\/\/\/\/\/\ -->
<!-- facility add modal -->
<!-- \/\/\/\/\/\/\/\/ -->
<div class="modal fade" id="fac_add_location" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content"  style="border-radius: 25px">
            <div class="modal-header">
                <h5 class="modal-title text-primary font-weight-bolder" id="ModalLabel">FACILITY | ADD LOCATION</h5>
            </div>
            <div class="modal-body bg-primary">
                <!-- /\/\/\/\/\/\/\/\ -->
                <!-- begin form for add facility text inputs -->
                <!-- \/\/\/\/\/\/\/\/ -->
                <form method="POST" action ="fac_action_add.php" enctype="multipart/form-data">
                    <!-- /\/\/\/\/\/\/\/\ -->
                    <!-- facility location number text input -->
                    <!-- \/\/\/\/\/\/\/\/ -->
                    <div class="mb-3 row">
                        <label class ="col-sm-3 col-form-label text-light font-weight-bolder text-right">LOCATION #</label>
                        <div class="col-sm">
                            <input type="text"  autocomplete="off" class="form-control font-weight-bolder text-uppercase" style="border-radius: 0.8rem" name="fac_loc_number"">
                        </div>
                    </div>
                    <!-- /\/\/\/\/\/\/\/\ -->
                    <!-- facility category text input -->
                    <!-- \/\/\/\/\/\/\/\/ -->
                    <div class="mb-3 row">
                        <label class ="col-sm-3 col-form-label text-light font-weight-bolder text-right">CATEGORY</label>
                        <div class="col-sm">
                            <input type="text"  autocomplete="off" class="form-control font-weight-bolder text-uppercase" style="border-radius: 0.8rem" name="fac_loc_type">
                        </div>
                    </div>
                    <!-- /\/\/\/\/\/\/\/\ -->
                    <!-- facility description text input -->
                    <!-- \/\/\/\/\/\/\/\/ -->
                    <div class="mb-3 row">
                        <label class ="col-sm-3 col-form-label text-light font-weight-bolder text-right">DESCRIPTION</label>
                        <div class="col-sm">
                            <input type="text"  autocomplete="off" class="form-control font-weight-bolder text-uppercase" style="border-radius: 0.8rem" name="fac_loc_description">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <!-- /\/\/\/\/\/\/\/\ -->
                <!-- close modal button code data-bs-dismiss -->
                <!-- \/\/\/\/\/\/\/\/ -->
                <button type="button" class="btn btn-sm btn-success font-weight-bolder" data-bs-dismiss="modal"> CLOSE </button>
                <button type="submit" name="add" class="btn btn-sm btn-primary font-weight-bolder"> ADD LOCATION </button>
                </form>
            </div>
        </div>
    </div>
</div>