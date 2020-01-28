@extends('base')


@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Atualizar comentario</h1>

            <div class="card">
                <div class="card-header">
                    Atualizar
                </div>
                <div class="card-body">

                {!! Form::model($commentFind, [
                        'class' => 'form', 
                        'method' => 'put']) !!}
                        
                        @include('form.comment')
                        <div class="form-group row mb-0 mt-3">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Atualizar minhas informações') }}
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection