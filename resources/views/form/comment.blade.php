
<input type="hidden" name="topicID" value="{{ $topicFind->id }}">
<div class="form-group row">

    <label for="td" 
            class="col-md-4 col-form-label text-md-right">
                {{ __('Seu relato é um TD?') }}</label>
    <div class="col-md-6">
        <div class="row">
            <div class="col-sm-6">
                <!-- <input id="tdyes" type="radio" name="td" value="1" checked> Sim -->

                {!! Form::radio('td', '1', null, ['id' => 'tdyes']) !!} Sim
            </div>
            <div class="col-sm-6">
                <!-- <input id="tdno" type="radio" name="td" value="0"> Não  -->
                {!! Form::radio('td', '0', null, ['id' => 'tdno']) !!} Não
            </div>
        </div>
    </div>
</div>
<div id="positiveComment" class="form-group row">
    <label for="positive" 
            class="col-md-4 col-form-label text-md-right">
                {{ __('Positivo ou Negativo?') }}</label>
    <div class="col-md-6">
        <div class="row">
            <div class="col-sm-6">
                {!! Form::radio('positive', '1', null) !!} Positivo
            </div>
            <div class="col-sm-6">
                {!! Form::radio('positive', '0', null) !!} Negativo 
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label for="comment" 
            class="col-md-4 col-form-label text-md-right">
                {{ __('Relato/Comentário (obrigatório)') }}</label>

    <div class="col-md-6">

        @error('comment')
            {!! Form::textarea('comment', null, ['id' => 'textareaComment', 'style' => 'height:200px;', 'class' => 'form-control is-invalid', 'maxlength' => '2999', 'autocomplete' => 'new-comment']) !!}
        @else
        {!! Form::textarea('comment', null, ['id' => 'textareaComment', 'style' => 'height:200px;', 'class' => 'form-control', 'maxlength' => '2999', 'autocomplete' => 'new-comment']) !!}
        @enderror
        
        <div class = "alert alert-error">                      
            @foreach ($errors->all('<p>:message</p>') as $input_error)
                {{ $input_error }}
            @endforeach 
        </div> 

        <div id="commentCount"></div>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-4"></div>
    <div class="col-md-6">
        <div class="g-recaptcha" data-sitekey="6LdCjtIUAAAAACvMQa2ejy8_nxFcWXun9PmZtx7B"></div>
    </div>
</div>