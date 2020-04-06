// const BASEURL = 'https://quiet-beach-73356.herokuapp.com';
const BASEURL = 'http://localhost:3001'

import io from 'socket.io-client';
//const { ConfigureIsOnline } = require('./common')
const axios = require('axios');
const socket = io(BASEURL);
var friendsVideo = document.getElementById("friendsVideo");

const clientId = uuidv4();

var servers = {'iceServers': [
        {'urls': 'turn:numb.viagenie.ca','credential': 'sempre123','username': 'samuel.huarachi@gmail.com'},
        {'urls': 'stun:stun.services.mozilla.com'}, 
        {'urls': 'stun:stun.l.google.com:19302'}
    ]};
var pc = new RTCPeerConnection(servers);


pc.onicecandidate = (
    event => event.candidate ? 
        socket.emit('sendClientICE', 
                JSON.stringify({'clientId': clientId,'ice': event.candidate}))
        :
        console.log("Sent All Ice"));


var url = BASEURL + '/analist/(19)%2092323-1300';
axios.get(url)
    .then(response => {
        var msg = response.data;
        msg = JSON.parse((msg.sdpOffer))
        let sdpClient = msg.sdp

        // pc.setRemoteDescription(new RTCSessionDescription(msg))
        //         .then(() => pc.createAnswer())
        //         .then(answer => pc.setLocalDescription(answer))
        //         .then(() => socket.emit('sendClientSDP',JSON.stringify({'sdp': pc.localDescription})))
    })
    .catch(function (error) {
        // handle error
        console.log(error);
    })

pc.onaddstream = (event => friendsVideo.srcObject = event.stream);

setTimeout(function() {
    console.log("request analist offer")
    socket.emit('INeedAnalistOffer', clientId);
}, 3000);

socket.on('sendAnalistOfferToClient', data => {
    var msg = data;
    msg = JSON.parse(msg)

    console.log(clientId)
    console.log(msg.clientId)
    if (msg.clientId == clientId) {
        console.log(msg.sdp)
        pc.setRemoteDescription(new RTCSessionDescription(msg.sdp))
                    .then(() => pc.createAnswer())
                    .then(answer => pc.setLocalDescription(answer))
                    .then(() => socket.emit('sendClientSDP',
                            JSON.stringify({'clientId': clientId,'sdp': pc.localDescription})))
    }
})


function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}


// *******************************************************************



// socket.on('send-status', function(message) {
//     var messageBox = $("#isOnline");
//     messageBox.html(message);
// })

// navigator.getUserMedia = (navigator.getUserMedia 
//     || navigator.webkitGetUserMedia 
//     || navigator.mozGetUserMedia 
//     || navigator.msgGetUserMedia);

// navigator.getUserMedia({video: true, audio: false}, function(stream) {
//     var peer = new Peer({
//         initiator: false,
//         trickle: false,
//         config: {
//             iceServers: [{ 'url': 'stun:stun.l.google.com:19302' }]
//         }
//     })

//     peer.on('signal', function (data) {
//         console.log("foi");
//         document.getElementById('analistID').value = JSON.stringify(data)
//     })

//     document.getElementById('connect').addEventListener('click', function() {
//         var otherID = JSON.parse(document.getElementById('clientID').value)
//         peer.signal(otherID)
//     })

//     document.getElementById('send').addEventListener('click', function() {
//         var yourMessage = document.getElementById('yourMessage').value
//         peer.send(yourMessage)
//     })

//     peer.on('data', function(data) {
//         document.getElementById('messages').textContent += data + '\n'
//     })
//     peer.on('stream', function(stream) {
//         var video = document.createElement('video')
//         document.body.appendChild(video)

        
//         video.srcObject = stream
//         video.play()
//     })
// }, function(err) {
//     console.error(err)
// })


// function verifyStatus()
// {
//     var url = BASEURL + '/analist/(19)%2092323-1300';
//     axios.get(url)
//         .then(response => {
//             ConfigureIsOnline(response.data.isOnline)
//             console.log(response.data.isOnline)
//         })
//         .catch(function (error) {
//             // handle error
//             console.log(error);
//         })
// }

// verifyStatus()