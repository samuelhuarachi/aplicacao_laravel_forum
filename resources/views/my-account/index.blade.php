@extends('base')


@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Minha Conta
                </div>
                <div class="card-body">
                {!! Form::open([
                        'route' => 'forum.myaccount.update',
                        'method' => 'PUT',
                        'class' => 'form']) !!}
                    @include('form.my-account')
                    
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
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card mt-3">
                        <div class="card-header">
                            Meus Relatos
                        </div>
                        <div class="card-body">
                            @foreach(Auth::user()->comments->reverse() as $comment)
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <span class="float-right">{{ date('d/m/Y H:i:s', strtotime($comment->created_at)) }}</span>
                                        <p><b>{{ $comment->topic->title }} &bull; {{ $comment->topic->city->state->title }} - {{ $comment->topic->city->title }}</b></p>
                                        @if(strlen($comment->comment) > 100)
                                            {{ substr($comment->comment, 0, 100) }} ...
                                        @else
                                            {{ $comment->comment }}
                                        @endif
                                        
                                        <br><br>
                                        <a  href="{{ route('forum.myaccount.comment.update', $comment->id) }}"><i class="icon-edit"></i> Editar</a>
                                        <a 
                                        onclick="return confirm('Deseja realmente excluir? Não será possível mais recuperar.')"
                                        class="float-right" 
                                        href="{{ route('forum.comment.remove', $comment->id) }}">Excluir definitivamente</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mt-3">
                        <div class="card-header">
                            Minas Repostas
                        </div>
                        <div class="card-body">
                            @foreach(Auth::user()->replies->reverse() as $reply)
                                <div class="card mt-3">
                                    <div class="card-body">
                                        @if(strlen($reply->reply) > 100)
                                            {{ substr($reply->reply, 0, 100) }} ...
                                        @else
                                            {{ $reply->reply }}
                                        @endif
                                        <br><br>
                                        <a  href="{{ route('forum.reply.edit', $reply->id) }}"><i class="icon-edit"></i> Editar</a>
                                        <a 
                                            onclick="return confirm('Deseja realmente excluir? Não será possível mais recuperar.')"
                                            class="float-right" 
                                            href="{{ route('forum.reply.remove', $reply->id) }}">Excluir definitivamente</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection