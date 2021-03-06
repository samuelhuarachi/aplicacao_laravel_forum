<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <meta name="robots" content="index, follow">
    <link href="https://fonts.googleapis.com/css?family=Arsenal|Great+Vibes&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Baloo&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/chat/client.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" />
    <title>Boneca Forum - Garotas ao vivo na webcam</title>

    @yield('head')

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

    @yield('content')

    @yield('client')


    <div class="container">
        <div class="row">
            <footer>
                GarotaForum.com / BonecaForum.com © 2020. Todos os direitos reservados

                <a class="float-right" href="{{ route('chat.termos_de_uso') }}">Termos de Uso</a>
                <a class="float-right mr-2" href="{{ route('chat.politica_de_privacidade') }}">Política de Privacidade</a>
                <a class="float-right mr-2" href="{{ route('chat.politica_de_cookies') }}">Política de Cookies</a>
            </footer>
        </div>
    </div>
</body>
</html>