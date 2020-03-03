@extends('chat.base')

@section('content')


<div id="isOnline"></div>
<button class="btn btn-success" id="onlineButton">Ficar Online</button>

<br>
<br>
<br>
<br>

<p>Analista ID</p>
<textarea id="analistID" cols="60" rows="10"></textarea>
<br>
<textarea id="clientID" cols="30" rows="10"></textarea>
<br>
<button id="connect">connect</button>
<br>
<input type="text" name="yourMessage" id="yourMessage">
<br>
<button id="send">send</button>
<div id="messages"></div>
<br>
<br>

<video src="" id="video" autoplay="true"></video>
<canvas id="preview"></canvas>
<div id="logger"></div>

<section id="messge">
    <input type="text" id="message-text" name="messge-text">
    <button id="send-message">Enviar</button>
</section>

<style>
canvas {
    display:none;
}
</style>

@endsection

@section('analist')
<script src="{{ asset('js/peerAnalist.js') }}"></script>
<script type="text/javascript">

    //const socket = io('http://localhost:3001')
    var canvas = document.getElementById("preview");
    var context = canvas.getContext("2d");
    var video = document.getElementById("video");

    // socket.on('connect', function() {
    //     $("#msg").append("connectd: " + socket.id + "<br>");
    //     socket.emit('msg', 'I am connected ' + socket.id);
    // })

    // socket.on('msg', function(msg) {
    //     $("#msg").append(msg + "<br>");
    // })

    $('#send-message').click(function() {
       // socket.emit('analist-said', 'Tranny says: ' + $('#message-text').val());
    });

    canvas.width = 800;
    canvas.height = 600;

    context.width = canvas.width;
    context.height = canvas.height;

    function logger(msg)
    {
        $("#logger").text(msg);
    }

    function loadCam(stream)
    {
        video.srcObject = stream;
    }

    function loadFail()
    {
        logger("Camera nao conectada :(");
    }

    function viewVideo(video, context){

        context.drawImage(video, 0, 0, context.width, context.height);
        // socket.emit('stream', canvas.toDataURL('image/webp'))
    }

    $(function (){
        
        navigator.getUserMedia = (navigator.getUserMedia 
                        || navigator.webkitGetUserMedia 
                        || navigator.mozGetUserMedia 
                        || navigator.msgGetUserMedia);

        if(navigator.getUserMedia)
        {
            navigator.getUserMedia({video: true}, loadCam, loadFail);
        }

        setInterval(function() {
            viewVideo(video, context);
        }, 70)
    });
</script>

@endsection