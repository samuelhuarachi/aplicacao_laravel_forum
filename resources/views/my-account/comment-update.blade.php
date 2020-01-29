@extends('base')


@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Atualizar comentario</h1>

            <div class="card">
                <div class="card-header">
                    Atualizar
                </div>
                <div class="card-body">

                {!! Form::model($commentFind, [
                        'class' => 'form', 
                        'route' => 'forum.myaccount.comment.update.request',
                        'method' => 'put']) !!}
                        
                        {!! Form::hidden('commendID', $commentFind->id) !!}

                        @include('form.comment')
                        <div class="form-group row mb-0 mt-3">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Atualizar minhas informações') }}
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer')

<script>

$( document ).ready(function() {

    if ($('#tdno').is(':checked')) {
        $('#positiveComment').hide();
    }

    $('#tdyes').change(function(obj) {
        if ($('#tdyes').is(':checked')) {
            $('#positiveComment').fadeIn(2000);
        }
    });

    $('#tdno').change(function(obj) {
        if ($('#tdno').is(':checked')) {
            $('#positiveComment').hide();
        }
    });

    $("#textareaComment").keyup(function() {
        $("#commentCount").text("Caracteres " + $(this).val().length + ". Máximo 2999.");
    });

    $("#commentCount").text("Caracteres 0. Máximo 2999.");
    
});

</script>

@endsection