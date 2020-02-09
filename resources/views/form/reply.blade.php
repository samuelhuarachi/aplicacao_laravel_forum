<div class="form-group row">
    <label for="reply" 
            class="col-md-4 col-form-label text-md-right">
                {{ __('Resposta (obrigatório)') }}</label>

    <div class="col-md-6">
        @error('comment')
            {!! Form::textarea('reply', null, ['id' => 'textareaReply', 'style' => 'height:200px;', 'class' => 'form-control is-invalid', 'maxlength' => '2999', 'autocomplete' => 'new-reply']) !!}
        @else
            {!! Form::textarea('reply', null, ['id' => 'textareaReply', 'style' => 'height:200px;', 'class' => 'form-control', 'maxlength' => '2999', 'autocomplete' => 'new-reply']) !!}
        @enderror

        @error('reply')
            <span class="invalid-reply" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <div id="commentCountReply"></div>
    </div>
</div>
<div class="form-group row">
    <div class="col-md-4"></div>
    <div class="col-md-6">
        <div class="g-recaptcha" data-sitekey="6LdCjtIUAAAAACvMQa2ejy8_nxFcWXun9PmZtx7B"></div>
    </div>
</div>