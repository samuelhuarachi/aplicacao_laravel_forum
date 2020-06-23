<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <meta name="robots" content="noindex" />
    <title>Login</title>
</head>
<body>
    
    <h3>Login</h3>

    {!! Form::open([
                'route' => 'chat.analist.authenticate',
                'method' => 'post']) !!}
        <input type="text" id="login3" name="login3">
        <br>
        <input type="password" id="password3" name="password3">
        <br>
        <button class="btn btn-sm btn-primary" type="submit">Acessar</button>
    {!! Form::close() !!}
    <style>

    body {
        text-align: center;
        background: #282828;
        text-align: center;
        color: #fff;
        margin-top: 20%;
        font-size: small;
    }

    input {
        border: 0px;
        padding: 3px;
        margin: 0px;
        margin-bottom: 5px;

    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    @include('_message-error')

</body>
</html>