@extends('chat.base')

@section('content')

<video id="friendsVideo" autoplay></video>

@endsection

@section('client')
<script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
<script src="{{ asset('js/peerClient.js') }}"></script>
<script type="text/javascript">

    // var friendsVideo = document.getElementById("friendsVideo");
    // var yourId = Math.floor(Math.random()*1000000000);

    // var servers = {'iceServers': [
    //     {'urls': 'stun:stun.services.mozilla.com'}, 
    //     {'urls': 'stun:stun.l.google.com:19302'}, 
    //     {'urls': 'turn:numb.viagenie.ca','credential': 'sempre123','username': 'samuel.huarachi@gmail.com'}]};
    // var pc = new RTCPeerConnection(servers);
    // pc.onaddstream = (event => friendsVideo.srcObject = event.stream);

    // pc.onicecandidate = function(event) {
    //     if (event.candidate) {
    //         console.log("enviando msg ficticia")
    //     } else {
    //         console.log("Sent All Ice") 
    //     }
    // }
    // function showFriendsFace() {
    //     console.log("function showFriendsFace")
    //     pc.createOffer()
    //     .then(offer => pc.setLocalDescription(offer));
    // }

    // function showMyFace() {
    //     console.log("show my face");
    //     navigator.getUserMedia = (navigator.getUserMedia 
    // || navigator.webkitGetUserMedia 
    // || navigator.mozGetUserMedia 
    // || navigator.msgGetUserMedia);

    //     navigator.mediaDevices.getUserMedia({audio:false, video:true})
    //     .then(stream => yourVideo.srcObject = stream)
    //     .then(stream => pc.addStream(stream));
        
    // }

    // showMyFace()
    


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