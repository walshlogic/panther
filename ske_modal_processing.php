<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>Sketch Processing Modal</title>
    <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="./css/sb-admin-2.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"
        defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        defer></script>
    <script src="./js/ske_scripts.js"
        defer></script>
</head>

<body>
    <!-- Modal HTML -->
    <div class="modal fade"
        id="SketchProcessingModal"
        tabindex="-1"
        aria-labelledby="ModalLabel"
        aria-hidden="true"
        data-backdrop="static"
        data-keyboard="false"
        role="dialog">
        <div class="modal-dialog modal-md modal-dialog-centered"
            role="document">
            <div class="modal-content"
                style="border-radius: 25px">
                <div class="modal-header">
                    <h5 class="modal-title text-primary font-weight-bolder"
                        id="ModalLabel"> SKETCH MANAGER | PROCESSOR </h5>
                </div>
                <div class="modal-body bg-primary text-light text-uppercase font-weight-bolder text-center"
                    id="modalBody"> Select 'PROCESS' To Initiate Sketch Import <br>
                    <br>
                    <div class="modal-body bg-danger text-uppercase font-weight-bolder text-center"> The Process Will
                        Take Several Minutes <br>
                        <br> Do Not Make Another Selection <br> While The Process Is Running <br>
                    </div>
                    <br>
                    <div class="modal-footer"
                        style="background-color: white;">
                        <button type="button"
                            class="btn btn-success btn-sm"
                            data-dismiss="modal"> CANCEL </button>
                        <button type="button"
                            class="btn btn-primary btn-sm btn-process"
                            onclick="processAndShowLoading()"> PROCESS </button>
                    </div>
                </div>
                <div id="loadingGif"
                    style="display: none; text-align: center;">
                    <img src="img/pantherLoading1.gif"
                        alt="Loading..."
                        style="display: block; margin: 0 auto;">
                </div>
            </div>
        </div>
    </div>
</body>

</html>