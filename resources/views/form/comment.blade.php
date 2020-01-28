
<input type="hidden" name="topicID" value="{{ $topicFind->id }}">
<div class="form-group row">

    <label for="td" 
            class="col-md-4 col-form-label text-md-right">
                {{ __('Seu relato é um TD?') }}</label>
    <div class="col-md-6">
        <div class="row">
            <div class="col-sm-6">
                <input id="tdyes" type="radio" name="td" value="1" checked> Sim
            </div>
            <div class="col-sm-6">
                <input id="tdno" type="radio" name="td" value="0"> Não 
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
                <input type="radio" name="positive" value="1" checked> Positivo
            </div>
            <div class="col-sm-6">
                <input type="radio" name="positive" value="0"> Negativo 
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label for="comment" 
            class="col-md-4 col-form-label text-md-right">
                {{ __('Relato/Comentário (obrigatório)') }}</label>

    <div class="col-md-6">

        <textarea
                id="textareaComment"
                style="height:200px;"
                class="form-control @error('comment') is-invalid @enderror" 
                name="comment"
                maxlength="2999"
                autocomplete="new-comment"></textarea>
        <div id="commentCount"></div>
        @error('comment')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <div class="col-md-4"></div>
    <div class="col-md-6">
        <div class="g-recaptcha" data-sitekey="6LdCjtIUAAAAACvMQa2ejy8_nxFcWXun9PmZtx7B"></div>
    </div>
</div>