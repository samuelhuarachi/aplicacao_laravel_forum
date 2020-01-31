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
    <div class="row">
        
        <div class="col-md-12">
            <a href="{{ route('forum.index') }}">
                    <i class="icon-chevron-left"></i>  Voltar a página inicial do forum</a>
            <br><br>
            <h1>{{ $topicFind->title }}</h1>

            @if ($topicFind->cellphone !== null)
                <p>Celular {{ $topicFind->cellphone }}</p>
            @endif

            <a  class="btn btn-danger" href="#"
                data-toggle="modal" 
                data-target="#exampleModal"
            >
                                
                        <i class="icon-plus"></i> Novo relato ou comentário</a>
            <br><br>
            <h2>Relatos</h2>

            @if ($topicFind->comments->count() == 0)
                <div class="card">
                    <div class="card-body">
                        Nenhum relato no momento. Seja o primeiro a comentar.
                    </div>
                </div>
            @else
                @foreach($topicFind->comments as $comment)
                    <div class="card mt-2">
                        <div class="card-header">
                            <span class="float-right">
                                    {{ date('d/m/Y H:i:s', strtotime($comment->created_at)) }}</span>
                                Postado por <a href="#">{{ $comment->user->name }}</a>
                        </div>
                        <div class="card-body">
                            
                            <p>
                            @if ($comment->td && $comment->positive)
                                <img style="width:10px;" src="{{ asset('images/ball-green.jpg') }}" alt="Imagem indicando que é um relato positivo"> 
                            @endif

                            @if ($comment->td && !$comment->positive)
                                <img style="width:20px;" src="{{ asset('images/hand_thumb_down.png') }}" alt="Imagem indicando que é um relato negativo"> 
                            @endif
                        
                            @if ($comment->td)
                                É um TD? Sim.

                                @if ($comment->positive)
                                    Positivo? Sim</p>
                                @else
                                    Positivo? Não</p>
                                @endif
                            @else
                            <img style="width:20px;" src="{{ asset('images/list.png') }}" alt="Imagem indicando que é um comentário"> Comentário:</p>
                            @endif

                            <div class="card">
                                <div class="card-body">
                                    <figure>
                                        <img style="width:80px;" class="float-right border border-danger" src="{{ asset('images/vader.png') }}" alt="Imagem do avatar do forum">
                                    </figure>

                                    @if($comment->user->id == Auth::user()->id)
                                        <a class="btn btn-outline-primary btn-sm" 
                                            href="{{ route('forum.myaccount.comment.update', $comment->id) }}">
                                            Editar</a>
                                        <br><br>
                                    @endif
                                    {{ $comment->comment }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    {!! Form::open([
                'route' => 'forum.topic.comment.insert',
                'class' => 'form', 
                'method' => 'post']) !!}
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Novo relato ou comentário</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        @include('form.comment')
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-danger">
                        {{ __('Postar novo relato/comentário') }}
                    </button>
      </div>
      {!! Form::close() !!}
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