const BASEURL = 'http://localhost:3001';

import io from 'socket.io-client';
var Peer = require('simple-peer')
const { ConfigureIsOnline } = require('./common')
const axios = require('axios');
const socket = io(BASEURL);



socket.on('send-status', function(message) {
    var messageBox = $("#isOnline");
    messageBox.html(message);
})

navigator.getUserMedia = (navigator.getUserMedia 
    || navigator.webkitGetUserMedia 
    || navigator.mozGetUserMedia 
    || navigator.msgGetUserMedia);

navigator.getUserMedia({video: true, audio: false}, function(stream) {
    var peer = new Peer({
        initiator: false,
        trickle: false,
        stream: stream
    })

    peer.on('signal', function (data) {
        console.log("foi");
        document.getElementById('analistID').value = JSON.stringify(data)
    })

    document.getElementById('connect').addEventListener('click', function() {
        var otherID = JSON.parse(document.getElementById('clientID').value)
        peer.signal(otherID)
    })

    document.getElementById('send').addEventListener('click', function() {
        var yourMessage = document.getElementById('yourMessage').value
        peer.send(yourMessage)
    })

    peer.on('data', function(data) {
        document.getElementById('messages').textContent += data + '\n'
    })

    peer.on('stream', function(stream) {
        var video = document.createElement('video')
        document.body.appendChild(video)

        // video.src = window.URL.createObjectURL(stream)
        video.srcObject = stream
        video.play()
    })

}, function(err) {
    console.error(err)
})


function verifyStatus()
{
    var url = BASEURL + '/analist/(19)%2092323-1300';
    axios.get(url)
        .then(response => {
            ConfigureIsOnline(response.data.isOnline)
            console.log(response.data.isOnline)
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
}

verifyStatus()