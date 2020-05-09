<script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/fontawesome.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="{{ asset('js/jquery.creditCardValidator.js') }}"></script>

<script>

const BASEURL = '{{ env("NODEAPI") }}'

@if($tokenClient)
const token = '{{ $tokenClient }}'
@else
const token = null
@endif

@if(isset($reponseAuthClient) && $reponseAuthClient->email_verified)
const email_verified = true
@else
const email_verified = false
@endif

let socket = null


@if(isset($analistExists))
    const clientRoom = '{{ $analistExists->slug }}'
@endif



</script>

<script src="{{ asset('js/peerClient.js') }}"></script>