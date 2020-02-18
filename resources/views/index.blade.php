@extends('base')


@section('content')

<div id="top-info">
    <b>Seja bem-vindo!</b>
</div>

<div id="user-info">
    <i class="icon-circle"></i>
    <b>{{ $stateFounded->title }}</b> / <b>{{ $cityFounded->title }}</b>
</div>

<div class="container-fluid traveti-title">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>
                @if (env('REMOVE_PORN')!='true') 
                Boneca
                @endif
                Forum
                </h1>

                @if (env('REMOVE_PORN')!='true') 
                    <p>Forum com relatos das mais belas travestis brasileiras</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="container">
    
    <div class="row mb-3">
        <div class="col-md-12">
                <a href="{{ route('login') }}">
                <button type="button" class="btn btn-light">
                <i class="icon-user"></i> Login</button>
            </a>
            
            <a href="{{ route('register') }}">
                <button type="button" class="btn btn-primary float-right">
                        Cadastrar no forum</button>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <h2>{{ $stateFounded->title }} / {{ $cityFounded->title }}</h2>
            <div class="card">
                <div class="card-header">
                    <b>Selecione seu estado</b>
                </div>
                <div class="card-body">
                    @foreach($states as $state)
                        <a href="{{ route('set-new-state', $state->id) }}">{{ $state->title }}</a> &bull;
                    @endforeach
                </div>
            </div>
            <div class="card mt-5">
                <div class="card-header">
                    <b>Selecione sua cidade</b>
                </div>
                <div class="card-body">

                    {!! Form::open(['route' => 'forum.set-new-city', 'method' => 'put', 'class' => 'form']) !!}

                        <div class="form-group">
                            <select name="cityID" class="selectpicker" data-live-search="true">
                                
                                @foreach($allCities as $city)
                                    <option value="{{ $city->id }}" data-tokens="{{ $city->id }}">{{ $city->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        {!! Form::submit('Buscar Tópicos', ['class' => 'btn btn-danger mb-2']) !!}
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-header">
                    <b>Relatos, sobre experiencias dos nossos usuários, com travestis, encontrados:</b>
                </div>
                <div class="card-body">
                    <a class="btn btn-danger" href="{{ route('forum.topic.new', 
                                [$stateFounded->slug, $cityFounded->slug]) }}">
                                
                        <i class="icon-plus"></i> Novo Tópico</a>
                    <br><br>
                    @if (count($cityFounded->topics) == 0)
                        <p class="mb-0">Não foi encontrado nenhum tópico para a cidade {{ $cityFounded->title }}</p>
                    @else
                        @foreach($cityFounded->topics->reverse() as $topic)

                            <div class="card mt-3">
                                <div class="card-header">
                                    @if (isset($lastSeeList[$topic->cellphone]))
                                        Vista a última vez: {{ date('d/m/Y', strtotime($lastSeeList[$topic->cellphone]['data']['lastsee'])) }}

                                        @if ($lastSeeList[$topic->cellphone]['data']['current'] == 0)

                                            @if (isset($lastSeeList[$topic->cellphone]['location']))
                                                <span class="float-right">Mudou de cidade, está em {{ $lastSeeList[$topic->cellphone]['location'] }}</span>
                                            @else
                                                <span class="float-right">Mudou de cidade</span>
                                            @endif
                                        @else
                                            <span class="float-right"><img width="10" src="{{ asset('images/green.png') }}" /> Disponível nessa cidade</span>
                                        @endif
                                        
                                    @else

                                    @endif
                                   
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm">
                                            @if (isset($coversList[$topic->slug]))
                                                <a href="{{ route('forum.topic.details', [$stateFounded->slug, $cityFounded->slug, $topic->slug]) }}">
                                                    <img class="float-left tranny-cover-thumb" src="{{ $coversList[$topic->slug] }}" alt="Foto de capa da travesti {{ $topic->title }}">
                                                </a>
                                            @endif
                                            <a href="{{ route('forum.topic.details', [$stateFounded->slug, $cityFounded->slug, $topic->slug]) }}">{{ $topic->title }}</a>
                                            <br>
                                            <small>{{ $topic->comments->count() }} relatos</small>
                                            
                                        </div>
                                        <div class="col-sm">

                                            @if ($topic->cellphone !== null && trim($topic->cellphone) !== "")
                                                <svg class="bi bi-phone" width="1em" height="1em" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M13 3H7a1 1 0 00-1 1v11a1 1 0 001 1h6a1 1 0 001-1V4a1 1 0 00-1-1zM7 2a2 2 0 00-2 2v11a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7z" clip-rule="evenodd"></path>
                                                    <path fill-rule="evenodd" d="M10 15a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                </svg> <small>Celular {{ $topic->cellphone }}</small>
                                            @else

                                            @endif
                                        </div>
                                        <!-- <div class="col-sm d-flex justify-content-center">
                                            <small>Nota: 91</small>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-2">
            
            @if (env('REMOVE_PORN')!='true')
                
                <figure>
                    <img 
                        class="mb-1"
                        style="width:100%"
                        src="{{ asset('images/travesti-titulo.jpeg') }}" alt="travesti mostrando o pênis">
                </figure>

                <figure>
                    <img 
                        class="mb-1"
                        style="width:100%"
                        src="{{ asset('images/travesti-ativa.jpeg') }}" alt="travesti ativa comendo homem">
                </figure>
                
                <figure>
                    <img 
                        class="mb-1"
                        style="width:100%"
                        src="{{ asset('images/travesti-2.jpg') }}" alt="travesti com a mão no pau">
                </figure>
                
                <figure>
                    <img 
                        class="mb-1"
                        style="width:100%"
                        src="{{ asset('images/travesti-ativa-2.jpeg') }}" alt="travesti ativa comendo homem">
                </figure>
            @endif
            
            <!-- <img class="mb-1" style="width:100%" src="{{ asset('images/iwant.jpg') }}" alt="">
            <img class="mb-1" style="width:100%" src="{{ asset('images/war2.jpg') }}" alt="">
            <img class="mb-1" style="width:100%" src="{{ asset('images/freddie.jpg') }}" alt="">
             -->
        </div>
    </div>
</div>


@endsection
