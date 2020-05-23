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

     <script id="navegg" type="text/javascript">
    (function(n,v,g){o="Navegg";if(!n[o]){
        a=v.createElement('script');a.src=g;b=document.getElementsByTagName('script')[0];
        b.parentNode.insertBefore(a,b);n[o]=n[o]||function(parms){
        n[o].q=n[o].q||[];n[o].q.push([this, parms])};}})
    (window, document, 'https://tag.navdmp.com/universal.min.js');
    window.naveggReady = window.naveggReady||[];
    window.nvg66267 = new Navegg({
        acc: 66267
    });
    </script> 

    <!-- start Mixpanel --><script type="text/javascript">(function(c,a){if(!a.__SV){var b=window;try{var d,m,j,k=b.location,f=k.hash;d=function(a,b){return(m=a.match(RegExp(b+"=([^&]*)")))?m[1]:null};f&&d(f,"state")&&(j=JSON.parse(decodeURIComponent(d(f,"state"))),"mpeditor"===j.action&&(b.sessionStorage.setItem("_mpcehash",f),history.replaceState(j.desiredHash||"",c.title,k.pathname+k.search)))}catch(n){}var l,h;window.mixpanel=a;a._i=[];a.init=function(b,d,g){function c(b,i){var a=i.split(".");2==a.length&&(b=b[a[0]],i=a[1]);b[i]=function(){b.push([i].concat(Array.prototype.slice.call(arguments,
    0)))}}var e=a;"undefined"!==typeof g?e=a[g]=[]:g="mixpanel";e.people=e.people||[];e.toString=function(b){var a="mixpanel";"mixpanel"!==g&&(a+="."+g);b||(a+=" (stub)");return a};e.people.toString=function(){return e.toString(1)+".people (stub)"};l="disable time_event track track_pageview track_links track_forms track_with_groups add_group set_group remove_group register register_once alias unregister identify name_tag set_config reset opt_in_tracking opt_out_tracking has_opted_in_tracking has_opted_out_tracking clear_opt_in_out_tracking people.set people.set_once people.unset people.increment people.append people.union people.track_charge people.clear_charges people.delete_user people.remove".split(" ");
    for(h=0;h<l.length;h++)c(e,l[h]);var f="set set_once union unset remove delete".split(" ");e.get_group=function(){function a(c){b[c]=function(){call2_args=arguments;call2=[c].concat(Array.prototype.slice.call(call2_args,0));e.push([d,call2])}}for(var b={},d=["get_group"].concat(Array.prototype.slice.call(arguments,0)),c=0;c<f.length;c++)a(f[c]);return b};a._i.push([b,d,g])};a.__SV=1.2;b=c.createElement("script");b.type="text/javascript";b.async=!0;b.src="undefined"!==typeof MIXPANEL_CUSTOM_LIB_URL?
    MIXPANEL_CUSTOM_LIB_URL:"file:"===c.location.protocol&&"//cdn4.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//)?"https://cdn4.mxpnl.com/libs/mixpanel-2-latest.min.js":"//cdn4.mxpnl.com/libs/mixpanel-2-latest.min.js";d=c.getElementsByTagName("script")[0];d.parentNode.insertBefore(b,d)}})(document,window.mixpanel||[]);
    mixpanel.init("bb4285779bceec91f2e4b2ad4dad1312");</script><!-- end Mixpanel -->

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