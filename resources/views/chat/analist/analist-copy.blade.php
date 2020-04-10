@extends('chat.analist.base')

@section('content')

<div class="container">
        <div class="row">
            <div  class="col-md-12 mb-3">
                <h2>{{ $myData->name }} {{ $myData->lastname }}</h2>

                <img width="10" src="{{ asset('images/green.png') }}" alt=""> <small>Ao vivo</small>

                <button class="btn btn-danger btn-sm">Sair</button>

                <div class="workspace">

                <video id="analistVideo" autoplay muted></video>

                <div class="chat">
                    <div class="history"></div>
                    <div class="message">
                        <small>Digite sua mensagem</small> <br>
                        <input type="text" id="message" name="message">
                        <br>
                        <br>
                        <button id="btnSend" class="btn btn-sm btn-primary btn-block" type="button">Enviar</button> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('analist')
<script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js"></script>

<script src="{{ asset('js/peerAnalist.js') }}"></script>

<script type="text/javascript">

let token = '{{ $token }}';
let slug = '{{ $myData->slug }}';

// var firebaseConfig = {
//     apiKey: "AIzaSyDwK0hFJ_RaYCf71CX_j9pDDTZP-_HG71U",
//     authDomain: "webrtc-4cc79.firebaseapp.com",
//     databaseURL: "https://webrtc-4cc79.firebaseio.com",
//     projectId: "webrtc-4cc79",
//     storageBucket: "webrtc-4cc79.appspot.com",
//     messagingSenderId: "399992591474",
//     appId: "1:399992591474:web:79861834969d86a4af5eeb"
// };
// firebase.initializeApp(firebaseConfig);
// var database = firebase.database().ref();
//     var yourVideo = document.getElementById("yourVideo");
//     var friendsVideo = document.getElementById("friendsVideo");
//     var yourId = Math.floor(Math.random()*1000000000);
//     console.log("your id")
//     console.log(yourId)
//     var servers = {'iceServers': [
//         {'urls': 'stun:stun.services.mozilla.com'}, 
//         {'urls': 'stun:stun.l.google.com:19302'}, 
//         {'urls': 'turn:numb.viagenie.ca','credential': 'sempre123','username': 'samuel.huarachi@gmail.com'}]};
//     var pc = new RTCPeerConnection(servers);
//     pc.onicecandidate = (
//         event => event.candidate ? sendMessage
//         (yourId, JSON.stringify({'ice': event.candidate}))
//         :
//         console.log("Sent All Ice") 
        
//         );
//     pc.onaddstream = (event => friendsVideo.srcObject = event.stream);
//     function sendMessage(senderId, data) {
//         console.log("executing function: sendMessage");
//         var msg = database.push({ sender: senderId, message: data });
//         msg.remove();
//     }
//     function readMessage(data) {
//         console.log("function readMessage")
//         console.log(data.val().message);
//         console.log("Other ID " + data.val().sender);
//         console.log("My ID " + yourId)

//         var msg = JSON.parse(data.val().message);
//         var sender = data.val().sender;
//         if (sender != yourId) {
//             if (msg.ice != undefined)
//                 pc.addIceCandidate(new RTCIceCandidate(msg.ice));
//             else if (msg.sdp.type == "offer")
//                 pc.setRemoteDescription(new RTCSessionDescription(msg.sdp))
//                 .then(() => pc.createAnswer())
//                 .then(answer => pc.setLocalDescription(answer))
//                 .then(() => sendMessage(yourId, JSON.stringify({'sdp': pc.localDescription})));
//             else if (msg.sdp.type == "answer")
//                 pc.setRemoteDescription(new RTCSessionDescription(msg.sdp));
//         }
//     };
//     database.on('child_added', readMessage);
//     function showMyFace() {
//         console.log("show my face");
//         navigator.getUserMedia = (navigator.getUserMedia 
//     || navigator.webkitGetUserMedia 
//     || navigator.mozGetUserMedia 
//     || navigator.msgGetUserMedia);

//         navigator.mediaDevices.getUserMedia({audio:false, video:true})
//         .then(stream => yourVideo.srcObject = stream)
//         .then(stream => pc.addStream(stream));
        
//     }
//     function showFriendsFace() {
//         console.log("friend my facesdafsee");
//         pc.createOffer()
//         .then(offer => pc.setLocalDescription(offer) )
//         .then(() => sendMessage(
//                         yourId, 
//                         JSON.stringify({'sdp': pc.localDescription})
//                     )
//                 );
//     }
//     showMyFace();


// *************************************************************************

    //const socket = io('http://localhost:3001')
    // var canvas = document.getElementById("preview");
    // var context = canvas.getContext("2d");
    // var video = document.getElementById("video");

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

    // canvas.width = 800;
    // canvas.height = 600;

    // context.width = canvas.width;
    // context.height = canvas.height;

    // function logger(msg)
    // {
    //     // $("#logger").text(msg);
    // }

    // function loadCam(stream)
    // {
    //     video.srcObject = stream;
    // }

    // function loadFail()
    // {
    //     logger("Camera nao conectada :(");
    // }

    // function viewVideo(video, context){

    //     context.drawImage(video, 0, 0, context.width, context.height);
    //     // socket.emit('stream', canvas.toDataURL('image/webp'))
    // }

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