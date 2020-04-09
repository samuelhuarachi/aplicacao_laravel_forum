@extends('chat.base')

@section('content')

<center>
<img src="{{ asset('images/warning-2.png') }}" alt="">
<br>
{!! $message !!}
</center>


<style>
html, body { height: 100%;}

#btnSend {

}

#message {
    width: 100%;
}


.workspace {
    height: 100%;
    width: 100%;
    border: 1px solid #333;
    display: inline-flex;
}

video {
    width: 50%;
    border: 1px solid red;
    background: #000;
}

.chat {
    height: 100%;
    border: 1px solid blue;
    width: 50%;
}

.history {
    border: 2px solid #696969;
    height: 70%;
}

.message {
    height: 30%;
    border: 2px solid red;
    padding-left: 5%;
    padding-right: 5%;
    background: #dc3545;
    color: #fff;
}

input {
    border: 1px solid #dc3545;
    padding: 2px;
    font-size: small;
}

</style>

@endsection

@section('analist')
<script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

@endsection