<div aria-live="polite" aria-atomic="true" style="position: absolute; mn-height: 200px; width: 100%;">
    <!-- Position it -->
    <div id="toast-list" style="position: absolute; top: 0; right: 0; z-index: 999;">


        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div data-autohide="false" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <img src="..." class="rounded mr-2" alt="...">
                        <strong class="mr-auto">Bootstrap</strong>
                        <small class="text-muted">just now</small>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        {{ $error }}
                    </div>
                </div>
            @endforeach
        @endif

       
    </div>
</div>
