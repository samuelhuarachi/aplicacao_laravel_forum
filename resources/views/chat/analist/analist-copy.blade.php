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

</script>

@endsection