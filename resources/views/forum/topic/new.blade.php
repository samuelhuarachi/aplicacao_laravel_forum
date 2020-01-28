@extends('base')


@section('content')

<div id="top-info">
    <b>Seja bem-vindo!</b>
</div>

<div id="user-info">
    <i class="icon-circle"></i>
    <b>{{ $stateFounded->title }}</b> / <b>{{ $cityFounded->title }}</b>
</div>

<div class="container">
    <a href="{{ route('forum.index') }}">
        <i class="icon-chevron-left"></i>  Voltar a página inicial do forum</a>
    
    <br><br>
    <h1>Novo tópico para a cidade 
            {{ $cityFind->title }} no estado {{ $stateFind->title }}</h1>


    <div class="card">
        <div class="card-header">
            <b>Novo tópico</b>
        </div>
        <div class="card-body">
        {!! Form::open(['route' => 'forum.topic.insert', 'class' => 'form', 'method' => 'post']) !!}
            @include('form.topic')
            
            <div class="form-group row mb-0 mt-3">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Postar novo tópico') }}
                    </button>
                </div>
            </div>
        {!! Form::close() !!}
        </div>
    </div>
   
</div>


@endsection

@section ('footer')

<script>

$( document ).ready(function() {
    $('#cellphone').mask('(00) 00000-0000');
});

</script>

@endsection