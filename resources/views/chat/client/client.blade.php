@extends('chat.base')

@section('content')

<div id="isOnline"></div>

<br>
<br>
<br>
<br>
<br>

<hr>
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


<img id="play">
<div id="message-received"></div>

@endsection

@section('client')
<script src="{{ asset('js/peerClient.js') }}"></script>
<script type="text/javascript">

    // var socket = io('http://localhost:3001');
    // socket.on('stream', function(image){
    //     var img = document.getElementById("play");
    //     img.src = image;
    // })

    // socket.on('analist-said', function(message) {
    //     var messageBox = $("#message-received");
    //     messageBox.html(messageBox.html() + "<br>" + message);
    // })

    // socket.on('connect', function() {
    //     // $("#msg").append("connectd: " + socket.id + "<br>");
    //     socket.emit('msg', 'I am connected ' + socket.id);
    // })

</script>

@endsection