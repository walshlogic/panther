<?php require_once './logic/favicon.php'; ?>
<!-- /\/\/\/\/\/\/\/\ -->
<!-- inventory add modal -->
<!-- \/\/\/\/\/\/\/\/ -->
<div class="modal fade"
    id="addinventoryitem"
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
                    id="ModalLabel">INVENTORY | ADD ITEM</h5>
            </div>
            <div class="modal-body bg-primary">
                <!-- /\/\/\/\/\/\/\/\ -->
                <!-- begin form for add inventory item text inputs -->
                <!-- \/\/\/\/\/\/\/\/ -->
                <form method="POST"
                    action="inv_action_add.php"
                    enctype="multipart/form-data">
                    <!-- /\/\/\/\/\/\/\/\ -->
                    <!-- item county department number text area input -->
                    <!-- \/\/\/\/\/\/\/\/ -->
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">DEPT #</label>
                        <div class="col-sm">
                            <input type="text"
                                autocomplete="off"
                                class="form-control font-weight-bolder text-uppercase"
                                style="border-radius: 0.8rem"
                                name="county_dept_num"">
                        </div>
                    </div>
                    <!-- /\/\/\/\/\/\/\/\ -->
                    <!-- item category text area input -->
                    <!-- \/\/\/\/\/\/\/\/ -->
                    <div class="
                                mb-3
                                row">
                            <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">ASSET
                                #</label>
                            <div class="col-sm">
                                <input type="text"
                                    autocomplete="off"
                                    class="form-control font-weight-bolder text-uppercase"
                                    style="border-radius: 0.8rem"
                                    name="county_asset_id">
                            </div>
                        </div>
                        <!-- /\/\/\/\/\/\/\/\ -->
                        <!-- item category text area input -->
                        <!-- \/\/\/\/\/\/\/\/ -->
                        <div class="mb-3 row">
                            <label
                                class="col-sm-3 col-form-label text-light font-weight-bolder text-right">CATEGORY</label>
                            <div class="col-sm">
                                <input type="text"
                                    autocomplete="off"
                                    class="form-control font-weight-bolder text-uppercase"
                                    style="border-radius: 0.8rem"
                                    name="inv_item_category">
                            </div>
                        </div>
                        <!-- /\/\/\/\/\/\/\/\ -->
                        <!-- item make text input -->
                        <!-- \/\/\/\/\/\/\/\/ -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">MAKE</label>
                            <div class="col-sm">
                                <input type="text"
                                    autocomplete="off"
                                    class="form-control font-weight-bolder text-uppercase"
                                    style="border-radius: 0.8rem"
                                    name="inv_item_make">
                            </div>
                        </div>
                        <!-- /\/\/\/\/\/\/\/\ -->
                        <!-- item model text area input -->
                        <!-- \/\/\/\/\/\/\/\/ -->
                        <div class="mb-3 row">
                            <label
                                class="col-sm-3 col-form-label text-light font-weight-bolder text-right">MODEL</label>
                            <div class="col-sm">
                                <input type="text"
                                    autocomplete="off"
                                    class="form-control font-weight-bolder text-uppercase"
                                    style="border-radius: 0.8rem"
                                    name="inv_item_model">
                            </div>
                        </div>
                        <!-- /\/\/\/\/\/\/\/\ -->
                        <!-- item serial number text area input -->
                        <!-- \/\/\/\/\/\/\/\/ -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">S/N</label>
                            <div class="col-sm">
                                <input type="text"
                                    autocomplete="off"
                                    class="form-control font-weight-bolder text-uppercase"
                                    style="border-radius: 0.8rem"
                                    name="inv_item_sn">
                            </div>
                        </div>
                        <!-- /\/\/\/\/\/\/\/\ -->
                        <!-- date received text input -->
                        <!-- \/\/\/\/\/\/\/\/ -->
                        <div class="mb-3 row">
                            <label
                                class="col-sm-3 col-form-label text-light font-weight-bolder text-right">RECEIVED</label>
                            <div class="col-sm">
                                <input type="date"
                                    autocomplete="off"
                                    class="form-control font-weight-bolder text-uppercase"
                                    style="border-radius: 0.8rem"
                                    name="inv_received_date">
                            </div>
                        </div>
                        <!-- /\/\/\/\/\/\/\/\ -->
                        <!-- purchase price text input -->
                        <!-- \/\/\/\/\/\/\/\/ -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">COST</label>
                            <div class="col-sm">
                                <input type="decimal"
                                    autocomplete="off"
                                    class="form-control font-weight-bolder text-uppercase"
                                    style="border-radius: 0.8rem"
                                    name="inv_received_cost">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- /\/\/\/\/\/\/\/\ -->
                        <!-- close modal button code data-bs-dismiss -->
                        <!-- \/\/\/\/\/\/\/\/ -->
                        <button type="button"
                            class="btn btn-sm btn-success font-weight-bolder"
                            data-bs-dismiss="modal"> CLOSE </button>
                        <button type="submit"
                            name="add"
                            class="btn btn-sm btn-primary font-weight-bolder"> ADD ITEM </button>
                </form>
            </div>
        </div>
    </div>
</div>