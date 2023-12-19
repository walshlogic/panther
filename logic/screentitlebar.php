<!DOCTYPE html>
<!-- page title header -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 font-weight-bolder text-uppercase"
        style="color: #696969">
        <?php echo $screenTitle; ?>
    </h1>
    <h class="h6 mb-0">
        <?php echo $screenTitleMidText; ?>
    </h>
    <?php if (!empty($screenTitleRightButtonIcon) || !empty($screenTitleRightButtonText)): ?>
        <button id="<?php echo $screenTitleRightButtonId; ?>"
            class="d-none d-sm-inline-block btn btn-sm btn-dark shadow-sm">
            <?php if (!empty($screenTitleRightButtonIcon)): ?> <i
                    class="fas <?php echo $screenTitleRightButtonIcon; ?>"></i> <?php endif; ?>
            <?php echo $screenTitleRightButtonText; ?> </button> <?php endif; ?>
</div>