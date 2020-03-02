
var Peer = require('simple-peer')

console.log(location);
location.hash === '#init'

var peer = new Peer({
    initiator: false,
    trickle: false
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