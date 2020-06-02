@extends('base')


@section('content')



<div id="top-info">
    <b>Seja bem-vindo!</b>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center mb-3">
            <a href="https://v3.machoman.life/?mcr=ANZ9025582">
                <img id="machoman_top" src="https://forumttt.s3-sa-east-1.amazonaws.com/machoman-banner.jpg" alt="Macho Man adulto, tudo o que precisa para deixar as mulheres loucas na cama">
            </a>
        </div>
    </div>
</div>


<div id="user-info">
    <i class="icon-circle"></i>
    <b>{{ $stateFounded->title }}</b> / <b>{{ $cityFounded->title }}</b>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">

        {{-- <a href="{{ route('forum.index') }}">
                    <i class="icon-chevron-left"></i>  Voltar a página inicial do forum</a>
            <br><br> --}}
                <a href="{{ route('login') }}">
                <button type="button" class="btn btn-light">
                <i class="icon-user"></i> Entrar</button>
            </a>

            <a href="{{ route('register') }}">
                <button type="button" class="btn btn-primary float-right">
                        Cadastre para deixar seu relato</button>
            </a>
            <br><br>
        </div>
        
        <div class="col-md-12">
            
            <h1>Travesti {{ ucwords($topicFind->title) }}</h1>


            <div class="card">
                <div class="card-body">
                    @if ($topicFind->cellphone !== null)
                        <b>Celular {{ $topicFind->cellphone }}</b><br>
                    @endif

                    @if ($statistic['current-city-title']) 
                        Ela, provavelmente, está em {{ $statistic['current-city-title'] }}<br>
                    @endif

                    @if (count($statistic['track-city']) > 0)
                        @foreach($statistic['track-city'] as $cityHistory)
                            &rarr; Passou por {{ $cityHistory['city_title'] }}, que fica no estado de {{ $cityHistory['state_title'] }}, 
                                    em {{ date('d/m/Y',strtotime($cityHistory['firstsee'])) }} até {{ date('d/m/Y', strtotime($cityHistory['lastsee'])) }}.<br>
                        @endforeach
                    @endif
                </div>
            </div>
            

            @if($photos)
                <h2 class="mt-3">Fotos</h2>
                <div class="card">
                    <div class="card-body">
                        <small>Clique para ampliar</small><br>
                        @foreach($photos as $photo)
                            <a 
                            data-caption="Fotos da travesti {{ ucwords($topicFind->title) }}"
                            data-fancybox="gallery" href="{{ $photo->photo }}">
                                <img class="image-in-gallery" src="{{ $photo->photo }}" alt="Fotos da travesti {{ ucwords($topicFind->title) }}">
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($findedCellphone && trim($findedCellphone->about) !== "")
                <h2 class="mt-3">Descrição</h2>
                <div class="card">
                    <div style="column-count: 2; column-gap: 40px; column-rule-style: solid;" class="card-body">
                        {{ $findedCellphone->about }}
                    </div>
                </div>
            @endif

            
            
            <h2 class="mt-3">Relatos</h2>
            <a  class="btn btn-danger" href="#"
                data-toggle="modal" 
                data-target="#exampleModal"
            >
                                
                <i class="icon-plus"></i> Novo relato ou comentário</a>
                        <br><br>
            @if ($topicFind->comments->count() == 0)
                <div class="card">
                    <div class="card-body">
                        Nenhum relato no momento. Seja o primeiro a comentar.
                    </div>
                </div>
            @else
                @foreach($topicFind->comments as $comment)
                    <div class="card mt-3">
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
                                        <img style="width:80px;" class="float-right" src="{{ asset('images/avatar.jpg') }}" alt="Avatar">
                                    </figure>

                                    @if (Auth::check())
                                        @if($comment->user->id == Auth::user()->id)
                                            <a class="btn btn-outline-primary btn-sm" 
                                                href="{{ route('forum.myaccount.comment.update', $comment->id) }}">
                                                <i class="icon-edit"></i> Editar</a>
                                            <br><br>
                                        @endif
                                    @endif

                                    <div>
                                        {{ $comment->comment }}
                                    </div>
                                    <br>
                                    <a class="btn btn-primary replyButton" href="#"
                                                        data-commentID="{{ $comment->id }}"
                                                        data-toggle="modal" 
                                                        data-target="#replyModal"
                                    ><i class="icon-reply"></i>  Responder</a>
                                    
                                    @if($comment->replies)
                                        @foreach($comment->replies as $reply)
                                            <div style="margin-top:10px;" class="card">
                                                <div class="card-body">
                                                    <i class="float-right">{{ date("d/m/Y", strtotime($reply->created_at)) }}</i>
                                                    <i>{{ $reply->user->name }} respondeu esse relato/comentário</i>
                                                    <br><br>
                                                    <div class="reply-style p-2">
                                                        {{ $reply->reply }}
                                                    </div>
                                                    
                                                    @if(Auth::check())
                                                        @if($reply->user->id == Auth::user()->id)
                                                            <br>
                                                            <a class="btn btn-outline-primary btn-sm" 
                                                                    href="{{ route('forum.reply.edit', $reply->id) }}">Editar Resposta</a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            

        </div>
    </div>
</div>

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

<!-- Reply modal -->
<div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    {!! Form::open([
                'route' => 'forum.reply.new',
                'class' => 'form', 
                'method' => 'post']) !!}
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Responder</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <input type="hidden" id="commentID" name="comment_id" value="0"> 
        @include('form.reply')
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-danger">
                        {{ __('Responder') }}
                    </button>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>

@include('forum.banner.online_girls')
<style>
    body {
        position: relative;
    }
</style>

@endsection

@section('footer')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>


<script>

$( document ).ready(function() {

    $('.replyButton').click(function ($this) {
        $('#commentID').val($this.currentTarget.dataset.commentid);
    });

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

    $('[data-fancybox="gallery"]').fancybox({
        thumbs : {
            autoStart : true
        }
    });

    $("#textareaReply").keyup(function() {
        $("#commentCountReply").text("Caracteres " + $(this).val().length + ". Máximo 2999.");
    });
    $("#commentCountReply").text("Caracteres 0. Máximo 2999.");
    
});

const BASEURL = '{{ env("NODEAPI") }}'

</script>

<script src="{{ asset('js/forum.js') }}"></script>

@endsection