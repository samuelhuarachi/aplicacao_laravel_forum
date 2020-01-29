<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forum</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    
    <meta name="description" content="Forum travesti tras relatos de usuários sobre experiencias com as travestis no Brasil."> 
    <meta name="og:title" property="og:title" content="Forum bonecas tem relatos de experiencias de pessoas com travetis no Brasil"> 
    <meta name="robots" content="index, follow"> 
    <link href="URL" rel="canonical">  <!-  Configurar isso importnate-->
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <link href="https://fonts.googleapis.com/css?family=Arsenal|Great+Vibes&display=swap" rel="stylesheet">

</head>
<body>

<div class="container mb-3">
    <div class="row">
        <nav id="menu" class="col-md-12 mb-3">
            <div class="row mb-3">
                <div class="col-md-12">
                @auth
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                        <button class="float-right" type="submit">Sair do forum</button>
                    </form>
                @endauth
                </div>
            </div>
            <div class="text-center">
                <ul id="top-menu">
                    
                    <li>
                        <a href="/">Página Inicial</a>
                    </li>
                    
                    <li>
                        <a href="{{ route('forum.index') }}">Forum</a>
                    </li>
                    
                    <li>
                        <a href="#">Blog</a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('forum.myaccount') }}">
                                <i class="icon-user"></i> Minha Conta</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>
    </div>
</div>

@yield('content')


<footer class="text-muted">
    <div class="container">
        <p class="float-right">
            <a href="#">Ir para o topo</a>
        </p>
        @if (env('REMOVE_PORN')!='true')
            <p>Maior forum de relatos de travesti do Brasil</p>
        @endif
    </div>
</footer>

<style>

figure {
    margin: 0px !important;
}

.traveti-title {
    background: #bfffea;
    padding-top: 30px;
    padding-bottom: 0px;
    margin-bottom: 30px;
}

footer {
    background: #fff;
    padding-top: 3rem;
    padding-bottom: 4rem;
    margin-top:100px;
    margin-bottom:0px;
}

footer p {
  margin-bottom: .25rem;
}

#top-menu {
    background: #fff;
    padding:10px;
    border: 1px solid rgb(227, 43, 43);
}

body {
    padding-top: 50px;
    background: #f2f2f2;
    font-family: 'Arsenal', sans-serif;
}

a  {
    color: #333;
    background: #f2f2f2;
    padding-right:5px;
    padding-left:5px;
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
    -webkit-box-shadow: 8px 8px 8px -6px rgba(171,171,171,1);
    -moz-box-shadow: 8px 8px 8px -6px rgba(171,171,171,1);
    box-shadow: 8px 8px 8px -6px rgba(171,171,171,1);
}

#menu ul {
    list-style:none;
}
#menu ul li { display: inline;
margin-right:5px; }

</style>

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