

<div class="form-group row">
    <label for="title" 
            class="col-md-4 col-form-label text-md-right">
                {{ __('Título (obrigatório)') }}</label>

    <div class="col-md-6">
        <input  id="title" 
                type="text" 
                class="form-control @error('title') is-invalid @enderror" 
                name="title" 
                autocomplete="new-title">

        @error('title')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="cellphone" 
            class="col-md-4 col-form-label text-md-right">
                {{ __('Celular') }}</label>

    <div class="col-md-6">
        <input  id="cellphone" 
                type="text" 
                class="form-control @error('cellphone') is-invalid @enderror" 
                name="cellphone" 
                autocomplete="new-cellphone"
                placeholder="(XX) XXXXX-XXXX">

        @error('cellphone')
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