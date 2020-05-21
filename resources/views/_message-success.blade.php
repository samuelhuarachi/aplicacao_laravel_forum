@if(Session::has('flash_message'))
    <div class="alert alert-success" role="alert">
        {!! Session::get('flash_message') !!}
        <button style="margin-top:3px;" type="button" class="close"><span aria-hidden="true">×</span></button>
    </div>
@endif