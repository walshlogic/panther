<!DOCTYPE html>
<!-- page title header -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 font-weight-bolder text-uppercase"
        style="color: #696969"> <?php echo $screenTitle ?> </h1>
    <h class="h6 mb-0"> <?php echo $screenTitleMidText ?> </h>
    <a href="<?php echo $screenTitleRightButtonLink; ?>"
        class="d-none d-sm-inline-block btn btn-sm btn-dark shadow-sm">
        <i class="fas <?php echo $screenTitleRightButtonIcon; ?>"></i> <?php echo $screenTitleRightButtonText ?> </a>
</div>