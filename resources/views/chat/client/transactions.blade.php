@extends('chat.base')

@section('content')

@include('chat.client._menu')

<h1>Transactions</h1>

@foreach($transactionsJson as $transaction)

<div class="card">
  <div class="card-header">
    Status {{ json_decode($transaction->trasaction)->status }}
  </div>
  <div class="card-body">
    Creditos {{ json_decode($transaction->trasaction)->amount->value }} <br>
    {{ json_decode($transaction->trasaction)->payment_method->card->holder->name }} <br>
    Cartao {{ json_decode($transaction->trasaction)->payment_method->card->brand }} <br>
    .... .... {{ json_decode($transaction->trasaction)->payment_method->card->last_digits }} <br>
  </div>
</div>

<br><br>
@endforeach

@include('chat.client._setupjavascript')

@endsection