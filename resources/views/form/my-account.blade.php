
<div class="form-group row">
    <label for="email" 
            class="col-md-4 col-form-label text-md-right">
                {{ __('Usuário') }}</label>

    <div class="col-md-6">
        {{ Auth::user()->name }}
    </div>
</div>

<div class="form-group row">
    <label for="email" 
            class="col-md-4 col-form-label text-md-right">
                {{ __('E-mail') }}</label>

    <div class="col-md-6">
        {{ Auth::user()->email }}
    </div>
</div>

<div class="form-group row">
    <label for="password" 
            class="col-md-4 col-form-label text-md-right">
                {{ __('Nova senha') }}</label>

    <div class="col-md-6">
        <input  id="password" 
                type="password" 
                class="form-control @error('password') is-invalid @enderror" 
                name="password"
                autocomplete="new-password">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-4"></div>
    <div class="col-md-6">
        <div class="g-recaptcha" data-sitekey=""></div>
    </div>
</div>