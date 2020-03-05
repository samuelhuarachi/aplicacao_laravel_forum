<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <meta name="robots" content="index, follow"> 
    <style>
    .image-in-gallery {
        width: 50px;
        height: 50px;
        margin-bottom:3px;
        margin-right: 3px;
    }

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
                @yield('content')
            </div>
        </div>

    
    @yield('analist')
    @yield('client')

    <style>
    video {
        border:1px solid #333;
        height: 300px;
    
    }
    canvas {
        border: 1px solid red;
        height: 300px;
    }
    </style>
</body>
</html>