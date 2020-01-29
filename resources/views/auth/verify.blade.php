@extends('base')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Antes de prosseguir verifique seu e-mail. Eu sei que é chato, mas é rapidinho.') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('O link de verificação foi enviado no seu e-mail') }}
                        </div>
                    @endif

                    {{ __('Antes de prosseguir, verifique seu e-mail. Caso não tenha recebido o link, clique no link abaixo.') }}
                    
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('requisitar meu link de verificação novamente') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
