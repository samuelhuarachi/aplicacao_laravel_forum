const BASEURL = 'https://quiet-beach-73356.herokuapp.com';
// const BASEURL = 'http://localhost:3001'

 import io from 'socket.io-client';
const socket = io(BASEURL);


var yourVideo = document.getElementById("yourVideo");
var yourId = Math.floor(Math.random()*1000000000);
var servers = {'iceServers': [
    {'urls': 'stun:stun.l.google.com:19302'},
    {'urls': 'stun:stun1.l.google.com:19302'},
    {'urls': 'stun:stun2.l.google.com:19302'},
    {'urls': 'stun:stun3.l.google.com:19302'},
    {'urls': 'stun:stun4.l.google.com:19302'},
    {'urls': 'stun:stun.l.google.com:19302'},
    {'urls': 'turn:numb.viagenie.ca','credential': 'sempre123','username': 'samuel.huarachi@gmail.com'}
]};

// {'urls': 'stun:stun.services.mozilla.com'}, 
    // {'urls': 'stun:stun.services.mozilla.com'}, 
    // {'urls': 'stun:stun.l.google.com:19302'}, 

var pc;
var myConnections = [];
let saveActiveStream = null;


navigator.getUserMedia = (navigator.getUserMedia 
    || navigator.webkitGetUserMedia 
    || navigator.mozGetUserMedia 
    || navigator.msgGetUserMedia);



// Generate offer afeter 5 seconds
setTimeout(function(){
    // pc.createOffer()
    // .then(offer => pc.setLocalDescription(offer))
    // .then(() => {
    //     console.log(pc.localDescription) 
    //     storageMySDPInServer(
    //         JSON.stringify({'id': yourId, 'sdp': pc.localDescription})) 
    // })
    console.log("beleza passou 5 seg")
}, 5000);

navigator.mediaDevices.getUserMedia({audio:false, video:true})
    .then(stream => {
        yourVideo.srcObject = stream
        saveActiveStream = stream
    })


function storageMySDPInServer(data) {
    console.log(data)
    socket.emit('analistSDPandID', data)
}

// Answers aacho que eh aqui
socket.on('receiveClientSDP', function(data) {

    console.log("receive SDP client")
    let msg = JSON.parse(data)
    let pc = myConnections[msg.clientId];
    pc.setRemoteDescription(new RTCSessionDescription(msg.sdp));
})

socket.on('receiveClientICE', function(data) {
    let msg = JSON.parse(data)
    let pc = myConnections[msg.clientId];

    console.log(msg.ice)

    pc.addIceCandidate(new RTCIceCandidate(msg.ice));
    console.log("ICE FOI")
})

// socket.on('connect', function() {
//     const analistSessionID = socket.socket.sessionid;
//     socket.emit('sendAnalistSessionID', analistSessionID)
// });

socket.on('generateAnalistOffer', function(clientId) {
    myConnections[clientId] = new RTCPeerConnection(servers);
    let pc = myConnections[clientId];

    // navigator.mediaDevices.getUserMedia({audio:false, video:true})
    // .then(stream => {});

    //console.log(stream)
    
    pc.addStream(saveActiveStream)
    
    setTimeout(function(){
        pc.createOffer()
        .then(offer => pc.setLocalDescription(offer))
        .then(() => {
            // console.log(pc.localDescription) 
            // storageMySDPInServer(
            //     JSON.stringify({'id': yourId, 'sdp': pc.localDescription}))

            console.log(pc.localDescription)

            socket.emit('sendNewAnalistOffer', 
                JSON.stringify({'clientId': clientId, 'sdp': pc.localDescription}))
        })
        console.log("gerou a oferta")
    }, 5000)
});



// const axios = require('axios');
// const { ConfigureIsOnline } = require('./common')

// console.log(location);
// location.hash === '#init'


// // navigator.getUserMedia = (navigator.getUserMedia 
// //     || navigator.webkitGetUserMedia 
// //     || navigator.mozGetUserMedia 
// //     || navigator.msgGetUserMedia);

// // navigator.getUserMedia({video: true, audio: false}, function(stream) {

// //     var peer = new Peer({
// //         initiator: true,
// //         trickle: false,
// //         stream: stream,
// //         config: {
// //             iceServers: [{ 'url': 'stun:stun.l.google.com:19302' }]
// //         }
// //     })

//     // peer.on('signal', function (data) {
//     //     console.log("foi");
//     //     document.getElementById('analistID').value = JSON.stringify(data)
//     //     socket.emit('analist-id', JSON.stringify(data))
//     // })

//     // document.getElementById('connect').addEventListener('click', function() {
//     //     var otherID = JSON.parse(document.getElementById('clientID').value)
//     //     peer.signal(otherID)
//     // })

//     // document.getElementById('send').addEventListener('click', function() {
//     //     var yourMessage = document.getElementById('yourMessage').value
//     //     peer.send(yourMessage)
//     // })

//     // peer.on('data', function(data) {
//     //     document.getElementById('messages').textContent += data + '\n'
//     // })

//     // peer.on('stream', function(stream) {
//     //     var video = document.createElement('video')
//     //     document.body.appendChild(video)

        
//     //     video.srcObject = stream
//     //     video.play()
//     // })
// // }, function(err) {
// //     console.error(err)
// // })


// socket.on('connect', function() {
//     // $("#msg").append("connectd: " + socket.id + "<br>");
//     socket.emit('msg', 'I am connected ' + socket.id);
// })

// var url = BASEURL + '/analist/(19)%2092323-1300';
// axios.get(url)
// .then(response => {
//     // ConfigureIsOnline(response.data.isOnline)
//     console.log(response.data.isOnline)
// })
// .catch(function (error) {
//     // handle error
//     console.log(error);
// })

// // $("#onlineButton").click(function() {
// //     socket.emit('make-online', 'onlinedd v')
// // })

// /**
//  * 
//  * ddddddddddddddddddddddddddddddddddddddddddddddd
//  * 
//  */




