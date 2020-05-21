@if ($errors->any())
	
	@foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            {{ $error }}
            <button style="margin-top:3px;" type="button" class="close"><span aria-hidden="true">×</span></button>
        </div>
	@endforeach

@endif