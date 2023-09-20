<!-- ||||||||||||||||||||||||| ADD IMAGE MODAL ||||||||||||||||||||||||| -->
<div class="modal fade"
    id="addnew"
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
                <h5 class="modal-title text-dark font-weight-bolder"
                    id="ModalLabel">EMPLOYEE | ADD IMAGE</h5>
            </div>
            <div class="modal-body bg-primary">
                <!-- ||| -->
                <!-- begin form for add employee text inputs -->
                <!-- ||| -->
                <form method="POST"
                    action="emp_action_add.php"
                    enctype="multipart/form-data">
                    <!-- ||| -->
                    <!-- profile picture selection -->
                    <!-- ||| -->
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label text-light font-weight-bolder text-right">PROFILE
                            PIC</label>
                        <div class="col-sm">
                            <input type="file"
                                class="form-control font-weight-bolder text-lowercase"
                                name="profile_pic">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <!-- ||| -->
                <!-- close modal button code data-bs-dismiss -->
                <!-- ||| -->
                <button type="button"
                    class="btn btn-sm btn-success font-weight-bolder"
                    data-bs-dismiss="modal"> CLOSE </button>
                <button type="submit"
                    name="add"
                    class="btn btn-sm btn-primary font-weight-bolder"> SAVE </button>
                </form>
            </div>
        </div>
    </div>
</div>