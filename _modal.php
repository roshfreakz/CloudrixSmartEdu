<!-- Modal -->
<div class="modal fade" id="alertModel" tabindex="-1" role="dialog" aria-labelledby="LoadingModel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title">Alert!</h5>
            </div>
            <div class="modal-body">
                <p id="alertModalMessage"></p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-gradient-primary" id="alertButton">Ok</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="LoadingModel" tabindex="-1" role="dialog" aria-labelledby="LoadingModel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Processing...</h5>
            </div>
        </div>
    </div>
</div>

<script>

   

    function ShowLoadingFn(){
        $('#LoadingModel').modal('show');
    }

    function HideLoadingFn(){
        $('#LoadingModel').modal('hide');
    }

    function ShowAlert(Message, redirect) {
        $('#alertModalMessage').html(Message);
        $('#alertButton').attr('onclick', 'HideAlert(' + redirect + ')');
        $('#alertModel').modal('show');
    }

    function HideAlert(redirect) {
        $('#alertModel').modal('hide');
        window.location.href = redirect;
    }
</script>