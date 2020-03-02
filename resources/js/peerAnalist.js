
import io from 'socket.io-client';
var Peer = require('simple-peer')
const socket = io('http://localhost:3001');

console.log(location);
location.hash === '#init'

var peer = new Peer({
    initiator: true,
    trickle: false
})

peer.on('signal', function (data) {
    console.log("foi");
    document.getElementById('analistID').value = JSON.stringify(data)
    socket.emit('analist-id', JSON.stringify(data))
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

socket.on('connect', function() {
    // $("#msg").append("connectd: " + socket.id + "<br>");
    socket.emit('msg', 'I am connected ' + socket.id);
})