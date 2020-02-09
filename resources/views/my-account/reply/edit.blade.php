@extends('base')


@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Atualizar
                </div>
                <div class="card-body">
                    {!! Form::model($replyFind, [
                        'route' => 'forum.reply.update',
                        'class' => 'form', 
                        'method' => 'put']) !!}
                        
                        {!! Form::hidden('comment_id', $replyFind->comment->id) !!}
                        {!! Form::hidden('reply_id', $replyFind->id) !!}

                        @include('form.reply')
                        
                        <div class="form-group row mb-0 mt-3">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Atualizar Resposta') }}
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

    $("#textareaReply").keyup(function() {
        $("#commentCountReply").text("Caracteres " + $(this).val().length + ". Máximo 2999.");
    });
    $("#commentCountReply").text("Caracteres 0. Máximo 2999.");
});

</script>

@endsection