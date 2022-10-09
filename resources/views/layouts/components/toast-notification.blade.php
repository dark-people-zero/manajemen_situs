<div class="demo-static-toast pos-absolute t-10 r-10" id="toastContainer">

</div>
<script>
    document.addEventListener("toast:error", e => {
        var template = $(`
            <div aria-atomic="true" aria-live="assertive" class="toast fade" role="alert" data-bs-autohide="false">
                <div class="toast-header bg-danger text-white p-2">
                    <i class="fe fe-x me-2"></i>
                    <h6 class="tx-14 mg-b-0 mg-r-auto text-capitalize">Error</h6>
                    {{-- <small class="me-3">11 mins ago</small> --}}
                    <button aria-label="Close" class="ms-2 mb-1 close tx-normal" data-bs-dismiss="toast" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="toast-body p-3">
                    ${e.detail.message}
                </div>
            </div>
        `);

        template.find('[aria-label="Close"]').click(function() {
            template.removeClass('show');
        })

        $("#toastContainer").append(template);

        setTimeout(() => {
            template.addClass('show');
        }, 100);

        setTimeout(() => {
            template.removeClass('show');
        }, 5000);

        setTimeout(() => {
            template.remove();
        }, 5500);
    })
    document.addEventListener("toast:info", e => {
        var template = $(`
            <div aria-atomic="true" aria-live="assertive" class="toast fade" role="alert" data-bs-autohide="false">
                <div class="toast-header bg-info text-white p-2">
                    <i class="fe fe-info me-2"></i>
                    <h6 class="tx-14 mg-b-0 mg-r-auto text-capitalize">Info</h6>
                    {{-- <small class="me-3">11 mins ago</small> --}}
                    <button aria-label="Close" class="ms-2 mb-1 close tx-normal" data-bs-dismiss="toast" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="toast-body p-3">
                    ${e.detail.message}
                </div>
            </div>
        `)
        template.find('[aria-label="Close"]').click(function() {
            template.removeClass('show');
        })

        $("#toastContainer").append(template);

        setTimeout(() => {
            template.addClass('show');
        }, 100);

        setTimeout(() => {
            template.removeClass('show');
        }, 5000);

        setTimeout(() => {
            template.remove();
        }, 5500);
    })
    document.addEventListener("toast:warning", e => {
        var template = $(`
            <div aria-atomic="true" aria-live="assertive" class="toast fade" role="alert" data-bs-autohide="false">
                <div class="toast-header bg-secondary text-white p-2">
                    <i class="fe fe-alert-triangle me-2"></i>
                    <h6 class="tx-14 mg-b-0 mg-r-auto text-capitalize">Warning</h6>
                    {{-- <small class="me-3">11 mins ago</small> --}}
                    <button aria-label="Close" class="ms-2 mb-1 close tx-normal" data-bs-dismiss="toast" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="toast-body p-3">
                    ${e.detail.message}
                </div>
            </div>
        `)
        template.find('[aria-label="Close"]').click(function() {
            template.removeClass('show');
        })

        $("#toastContainer").append(template);
        setTimeout(() => {
            template.addClass('show');
        }, 100);

        setTimeout(() => {
            template.removeClass('show');
        }, 5000);

        setTimeout(() => {
            template.remove();
        }, 5500);
    })
    document.addEventListener("toast:success", e => {
        var template = $(`
            <div aria-atomic="true" aria-live="assertive" class="toast fade" role="alert" data-bs-autohide="false">
                <div class="toast-header bg-success text-white p-2">
                    <i class="fe fe-check-circle me-2"></i>
                    <h6 class="tx-14 mg-b-0 mg-r-auto text-capitalize">Success</h6>
                    {{-- <small class="me-3">11 mins ago</small> --}}
                    <button aria-label="Close" class="ms-2 mb-1 close tx-normal" data-bs-dismiss="toast" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="toast-body p-3">
                    ${e.detail.message}
                </div>
            </div>
        `)
        template.find('[aria-label="Close"]').click(function() {
            template.removeClass('show');
        })


        $("#toastContainer").append(template);

        setTimeout(() => {
            template.addClass('show');
        }, 100);

        setTimeout(() => {
            template.removeClass('show');
        }, 5000);

        setTimeout(() => {
            template.remove();
        }, 5500);
    })
</script>


