<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @if(\Request::route()->getName() == 'forum.topic.details')

        @if ($topicFind->cellphone && trim($topicFind->cellphone) !== '')
            <title>Boneca Forum | Travesti {{ ucwords($topicFind->title) }} {{ $topicFind->cellphone }}</title>
        @else
            <title>Boneca Forum | Tópico {{ ucwords($topicFind->title) }}</title>
        @endif
            
    @else 
        <title>Boneca Forum | Forum de relato das experiência dos usuários, com travestis</title>
    @endif
    
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <meta name="description" content="Forum travesti tras relatos de usuários sobre experiencias com as travestis no Brasil."> 
    <meta name="og:title" property="og:title" content="Forum bonecas tem relatos de experiencias de pessoas com travetis no Brasil"> 
    <meta name="robots" content="index, follow"> 
    <link href="https://www.bonecaforum.com{{ $_SERVER['REQUEST_URI'] }}" rel="canonical"> 
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <link href="https://fonts.googleapis.com/css?family=Arsenal|Great+Vibes&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Baloo&display=swap" rel="stylesheet">


    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-137662022-2"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-137662022-2');
    </script>

    <!-- Hotjar Tracking Code for http://www.bonecaforum.com -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:1695660,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>

</head>
<body>

<div class="container">
    <div class="row">
        <div  class="col-md-12 mb-3">
            <p class="logo"><a href="/">Boneca Fórum</a></p>
            <p class="logo-description">Encontre as mais belas travestis da sua cidade</p>
        </div>
        <div class="col-md-12 mb-3">
            <nav id="menu">

                @auth
                    <div class="row mb-3">
                        <div class="col-md-12">
                        
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                {{ csrf_field() }}
                                <button class="float-right" type="submit">Sair do forum</button>
                            </form>
                        
                        </div>
                    </div>
                @endauth
                <ul id="top-menu">
                    <li>
                        <a class="btn btn-danger" href="{{ route('forum.index') }}/#tranny-list">Veja mais travestis na sua cidade</a>
                    </li>
                    
                    @auth
                        <li>
                            <a href="{{ route('forum.myaccount') }}">
                                <i class="icon-user"></i> Minha Conta</a>
                        </li>
                    @endauth
                </ul>
            </nav>
        </div>
    </div>
</div>

@yield('content')


<footer>
    <div class="container">
        <p class="float-right">
            <a href="#">Ir para o topo</a>
        </p>
        @if (env('REMOVE_PORN')!='true')
            <p>Boneca Fórum - Relatos, acompanhantes travestis no Brasil</p>
        @endif
    </div>
</footer>

    <script
			  src="https://code.jquery.com/jquery-3.4.1.min.js"
			  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
			  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://canvas-gauges.com/download/latest/all/gauge.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    @include('_message-error')

    @yield('footer')
</body>
</html>