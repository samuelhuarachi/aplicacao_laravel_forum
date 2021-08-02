@extends('base')


@section('content')

<header>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
            
                <h1>Seja bem-vindo 
                @if (env('REMOVE_PORN') == false)
                
                    ao forum garotas acompanhantes
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
                        <img style="max-width:400px;" width="100%" src="{{ asset('images/garotas-capa.jpg') }}" alt="foto de capa de uma garotas">
                    </figure>

                    <p class="text-center">Forum garotas Brasil. Relatos de usuários,
                onde você poderá tirar suas dúvidas, e compartilhar suas
                experiencias.</p>
                
                @endif

               

                <div class="text-center">
                    <a class="btn btn-primary btn-primary" 
                    href="{{ route('forum.index') }}">Entrar no Fórum</a>
                </div>
                <br><br><br><br>
            </div>
        </div>
    </div>
</main>

@endsection

@section('footer')



@endsection