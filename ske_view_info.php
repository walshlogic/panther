<div class="modal fade"
    id="<?php echo $modalID; ?>"
    tabindex="-1"
    role="dialog"
    aria-labelledby="fileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog"
        role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"
                    id="fileModalLabel">PENDING SKETCH FILE INFORMATION</h5>
                <button type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Display File Information -->
                <img src="data:image/jpeg;base64,<?php echo $thumbnail; ?>"
                    class="img-fluid mb-2">
                <p>Filename:
                    <?php echo $filename; ?>
                </p>
                <p>File Size:
                    <?php echo formatSizeUnits($filesize); ?>
                </p>
                <p>Last Modified:
                    <?php echo $filemtime; ?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal">CLOSE</button>
                <button type="button"
                    class="btn btn-primary"
                    onclick="window.open('ske_view_print.php?file=<?php echo urlencode($file); ?>')">PRINT</button>
            </div>
        </div>
    </div>
</div>