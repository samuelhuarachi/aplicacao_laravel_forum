@extends('base')


@section('content') 



<div class="container">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center mb-3">
            <a href="http://mon.net.br/s02k9">
                <img id="banner1_top" src="https://forumttt.s3-sa-east-1.amazonaws.com/Banner_TVaca.jpg" alt="Deixe ela facinho facinho com tesão de vaca">
            </a>
        </div>
    </div>
</div>


<div id="top-info">
    <a style="color: #fff" href="/camstream">
    Clique aqui, e conheca Boneca Forum 
                    <img src="/images/logo_lado.png" width="128">
                    </a>
</div>

<div id="user-info">
    <i class="icon-pushpin"></i>
    <b>{{ $stateFounded->title }}</b> / <b>{{ $cityFounded->title }}</b>
</div>

<div class="container">
    
    <div class="row mb-3">
        <div class="col-md-12">

            <h1>Acompanhantes garotass em {{ $cityFounded->title }}</h1>
               
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
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
            <div class="card mt-3">
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

            <form class="mt-3" action="{{ route('forum.index') }}">
                <label for="cellphone">Pesquisar pelo celular:</label><br>
                <input 
                        type="text" 
                        id="cellphone_search"
                        name="cellphone" 
                        placeholder="(XX) XXXXX-XXXX" 
                        value=""><br>
                <input class="btn btn-primary" type="submit" value="Pesquisar">
            </form> 

            <div id="girl-list" class="card mt-2">
                <div class="card-header">
                    <b>Relatos, sobre experiencias dos nossos usuários, com garotass, 
                    encontrados:</b>
                </div>
                <div class="card-body">
                    <a class="btn btn-danger" href="{{ route('forum.topic.new', 
                                [$stateFounded->slug, $cityFounded->slug]) }}">
                                
                        <i class="icon-plus"></i> Novo Tópico</a>
                    <br><br>

                    @if (!$cellphoneSearch)
                        {{ $cityFoundedPaginate->links() }}
                    @endif

                    @if (count($cityFounded->topics) == 0)
                        <p class="mb-0">Não foi encontrado nenhum tópico para a cidade {{ $cityFounded->title }}</p>
                    @else

                        
                        <p>Total encontradas: {{ $totaTopics }}</p>
                        @foreach($cityFoundedPaginate->items() as $topic)


                            

                            <div class="card mt-3">
                                <div class="card-header">
                                    @if (isset($lastSeeList[$topic->cellphone]))

                                        @php

                                        $datetime1 = new DateTime($lastSeeList[$topic->cellphone]['data']['lastsee']);
                                        $datetime2 = new DateTime(date('Y-m-d'));
                                        $interval = $datetime1->diff($datetime2)->days;

                                        @endphp

                                        @if($interval > 0)
                                            Passou por aqui há {{ $interval }} dias ({{ date('d/m/Y', strtotime($lastSeeList[$topic->cellphone]['data']['lastsee'])) }})
                                        @else
                                            Vista última vez em {{ date('d/m/Y', strtotime($lastSeeList[$topic->cellphone]['data']['lastsee'])) }}
                                        @endif
                                        

                                        @if ($lastSeeList[$topic->cellphone]['data']['current'] == 0)

                                            @if (isset($listt[$topic->cellphone]))
                                                <span class="float-right">Mudou de cidade, está em {{ $listt[$topic->cellphone]['current-city-title'] }}</span>
                                            @else
                                                <span class="float-right">Mudou de cidade</span>
                                            @endif
                                        @else
                                            
                                            @if($interval == 0)
                                                <span class="float-right"><img width="10" src="{{ asset('images/green.png') }}" /> Disponível nessa cidade</span>
                                            @else
                                                <span class="float-right"><img width="10" src="{{ asset('images/gray.png') }}" /> Não localizada hoje</span>
                                            @endif
                                        @endif
                                        
                                    @else
                                        Não temos dados de frequencia no momento
                                    @endif
                                   
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm">
                                            
                                                {{-- <a href="{{ route('forum.topic.details', [$stateFounded->slug, $cityFounded->slug, $topic->slug]) }}">
                                                    <img class="float-left girl-cover-thumb" src="{{ $coversList[$topic->slug] }}" alt="Foto de capa da garotas {{ $topic->title }}">
                                                </a> --}}

                                            <a href="{{ route('forum.topic.details', [$stateFounded->slug, $cityFounded->slug, $topic->slug]) }}">{{ $topic->title }}</a>

                                            @if (isset($cellPhoneNewGirl[$topic->cellphone]) && $cellPhoneNewGirl[$topic->cellphone] == 0)
                                                <span class="badge badge-secondary">novata</span>
                                            @endif
                                            <br>
                                            @php

                                            $reportCount = $topic->where('cellphone', $topic->cellphone)
                                                    ->join('comments', 'topics.id', '=', 'comments.topic_id')
                                                    ->select('comments.id')
                                                    ->count();
                                            @endphp

                                            <small>{{ $reportCount }} relatos</small>
                                            
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
                        <br>
                        @if (!$cellphoneSearch)
                            {{ $cityFoundedPaginate->links() }}
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <!-- <div class="col-md-2">
        </div> -->
    </div>
</div>

@include('forum.banner.online_girls')

@endsection

@section('footer')

<script>
const BASEURL = '{{ env("NODEAPI") }}'
</script>
<script src="{{ asset('js/forum.js') }}"></script>
<script>

$('#cellphone_search').mask('(00) 00000-0000');

</script>

@endsection
