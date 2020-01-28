@extends('base')


@section('content')

<header>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
            
                <h1>Seja bem-vindo 
                @if (env('REMOVE_PORN') == false)
                
                    ao forum travesti acompanhantes
                @endif</h1>
            </div>
        </div>
    </div>
</header>
<main>
    <div>
        <div>
            <div class="col-md-12">

                @if (env('REMOVE_PORN') == false)
                    <figure class="text-center">
                        <img width="400" src="{{ asset('images/travesti-capa.jpg') }}" alt="foto de capa de uma travesti">
                    </figure>

                    <p class="text-center">O maior forum de travesti do Brasil. Relatos de usuários,
                onde você poderá tirar suas dúvidas, e compartilhar suas
                experiencias.</p>
                
                @endif

               

                <div class="text-center">
                    <a class="btn btn-primary btn-danger" 
                    href="{{ route('forum.index') }}">Entrar o melhor forum de travesti</a>
                </div>
                <br><br><br><br>
            </div>
        </div>
    </div>
</main>

@endsection