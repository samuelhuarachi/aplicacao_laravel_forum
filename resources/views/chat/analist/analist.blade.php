@extends('chat.base')

@section('content')

<!-- <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js"></script>

<script src="https://www.gstatic.com/firebasejs/7.9.3/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.9.3/firebase-database.js"></script>
<script src="{{ asset('js/peerAnalist.js') }}"></script>

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

<br>
<br>
<br>
<br>
<hr>

<video id="yourVideo" autoplay muted></video>
<video id="friendsVideo" autoplay></video>
<br />
<button onClick="showFriendsFace()" type="button" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span> Call</button>




<style>
canvas {
    display:none;
}
</style>

@endsection

@section('analist')



<script type="text/javascript">

// Your web app's Firebase configuration
var firebaseConfig = {
    apiKey: "AIzaSyDwK0hFJ_RaYCf71CX_j9pDDTZP-_HG71U",
    authDomain: "webrtc-4cc79.firebaseapp.com",
    databaseURL: "https://webrtc-4cc79.firebaseio.com",
    projectId: "webrtc-4cc79",
    storageBucket: "webrtc-4cc79.appspot.com",
    messagingSenderId: "399992591474",
    appId: "1:399992591474:web:79861834969d86a4af5eeb"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
var database = firebase.database().ref();

    var yourVideo = document.getElementById("yourVideo");
    var friendsVideo = document.getElementById("friendsVideo");
    var yourId = Math.floor(Math.random()*1000000000);
    console.log("your id")
    console.log(yourId)
    var servers = {'iceServers': [
        {'urls': 'stun:stun.services.mozilla.com'}, 
        {'urls': 'stun:stun.l.google.com:19302'}, 
        {'urls': 'turn:numb.viagenie.ca','credential': 'sempre123','username': 'samuel.huarachi@gmail.com'}]};
    var pc = new RTCPeerConnection(servers);
    pc.onicecandidate = (
        event => event.candidate?sendMessage(yourId, JSON.stringify({'ice': event.candidate})):console.log("Sent All Ice") );
    pc.onaddstream = (event => friendsVideo.srcObject = event.stream);

    function sendMessage(senderId, data) {
        var msg = database.push({ sender: senderId, message: data });
        msg.remove();
    }

    function readMessage(data) {
        var msg = JSON.parse(data.val().message);
        var sender = data.val().sender;
        if (sender != yourId) {
            if (msg.ice != undefined)
                pc.addIceCandidate(new RTCIceCandidate(msg.ice));
            else if (msg.sdp.type == "offer")
                pc.setRemoteDescription(new RTCSessionDescription(msg.sdp))
                .then(() => pc.createAnswer())
                .then(answer => pc.setLocalDescription(answer))
                .then(() => sendMessage(yourId, JSON.stringify({'sdp': pc.localDescription})));
            else if (msg.sdp.type == "answer")
                pc.setRemoteDescription(new RTCSessionDescription(msg.sdp));
        }
    };

    database.on('child_added', readMessage);

    function showMyFace() {
        console.log("show my face");
        navigator.mediaDevices.getUserMedia({audio:true, video:true})
        .then(stream => yourVideo.srcObject = stream)
        .then(stream => pc.addStream(stream));
        
    }

    function showFriendsFace() {
        console.log("friend my face");
        pc.createOffer()
        .then(offer => pc.setLocalDescription(offer) )
        .then(() => sendMessage(yourId, JSON.stringify({'sdp': pc.localDescription})) );
    }

    showMyFace();


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

    // $('#send-message').click(function() {
    //    // socket.emit('analist-said', 'Tranny says: ' + $('#message-text').val());
    // });

    canvas.width = 800;
    canvas.height = 600;

    context.width = canvas.width;
    context.height = canvas.height;

    function logger(msg)
    {
        // $("#logger").text(msg);
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

    // $(function (){
        
    //     navigator.getUserMedia = (navigator.getUserMedia 
    //                     || navigator.webkitGetUserMedia 
    //                     || navigator.mozGetUserMedia 
    //                     || navigator.msgGetUserMedia);

    //     if(navigator.getUserMedia)
    //     {
    //         navigator.getUserMedia({video: true}, loadCam, loadFail);
    //     }

    //     setInterval(function() {
    //         viewVideo(video, context);
    //     }, 70)
    // });
</script>

@endsection