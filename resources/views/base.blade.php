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

<style>

.logo {
    line-height: 1;
    margin-bottom: 0;
}

.logo a{
    font-size: 69px;
    font-family: 'Baloo', cursive;
    color: #dc3545;
}

.logo-description {
    font-weight: bold;
    color: #333;
}

figure {
    margin: 0px !important;
}

.tranny-cover-thumb {
    max-height: 110px;
    margin-right: 20px;
}

.traveti-title {
    background: #333;
    padding-top: 30px;
    padding-bottom: 0px;
    margin-bottom: 30px;
}

.traveti-title h1 {
    color: #fff;
}

.traveti-title p {
    color: #fff;
}

footer {
    background: #000;
    padding-top: 3rem;
    padding-bottom: 4rem;
    margin-top:100px;
    margin-bottom:0px;
    color: #fff;
}

footer p {
  margin-bottom: .25rem;
}

#top-menu {
    /* background: #fff;
    padding:10px;
    border: 1px solid rgb(227, 43, 43); */
}

body {
    padding-top: 50px;
    background: #f2f2f2;
    font-family: 'Arsenal', sans-serif;
}

a  {
    color: #333;
    // background: #f2f2f2;
    /* padding-right:5px;
    padding-left:5px; */
}

.dropdown-item.active, .dropdown-item:active {
    background-color: #dc3545;
}

a:hover {
    color: red;
    text-decoration: none;
}

h1, h2, h3, h4, h5, h6 {
    font-family: 'Great Vibes', cursive;
}

.card {
    border: 1px solid rgb(227, 43, 43);
    border-radius: 0px;
}

.card-header:first-child {
    border-radius: 0px;
}

.card-header {
    border-bottom: 1px solid rgb(227, 43, 43);
    background-color: #dc3545;
    color: #fff;
}

#user-info {
    position: fixed;
    background: #000;
    bottom: 0px;
    color: #fff;
    z-index: 999;
    padding-right: 10px;
    padding-left: 10px;
    width: 100%;
    text-align: right;
}

#top-info {
    position: fixed;
    background: #000;
    top: 0px;
    color: #fff;
    z-index: 999;
    padding-right: 10px;
    padding-left: 10px;
    width: 100%;
}

#travesti-dancando {
    position: fixed;
    bottom:20px;
    right:0px;
}

#travesti-loira-dancando {
    position: fixed;
    bottom:20px;
    left:0px;
}

.card {
    /* -webkit-box-shadow: 8px 8px 8px -6px rgba(171,171,171,1);
    -moz-box-shadow: 8px 8px 8px -6px rgba(171,171,171,1);
    box-shadow: 8px 8px 8px -6px rgba(171,171,171,1); */
}

#menu ul {
    list-style:none;
    padding: 0px;
}
#menu ul li { display: inline;
margin-right:5px; }

.reply-style {
    background: #f4f4f4;
    border-radius: 4px;
}
</style>

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
                        <a class="btn btn-danger" href="{{ route('forum.index') }}">Forum</a>
                    </li>
                    
                    <li>
                        <a class="btn btn-danger" href="#">Blog</a>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://canvas-gauges.com/download/latest/all/gauge.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    
    @include('_message-error')

    @yield('footer')
</body>
</html>