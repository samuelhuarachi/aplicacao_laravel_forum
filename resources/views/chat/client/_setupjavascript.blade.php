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
<script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<script>



$('[data-fancybox="gallery"]').fancybox({
    thumbs : {
        autoStart : true
    }
})

const BASEURL = '{{ env("NODEAPI") }}'

@if(isset($tokenClient) && $tokenClient)
const token = '{{ $tokenClient }}'
@else
const token = null
@endif

@if(isset($reponseAuthClient) && $reponseAuthClient->email_verified)
const email_verified = true
@else
const email_verified = false
@endif

let analistPricePerHourGlobal = null
@if (isset($analistExists) && $analistExists->pricePerHour)
    analistPricePerHourGlobal = {{ $analistExists->pricePerHour }}
@endif

let socket = null


@if(isset($analistExists))
    const clientRoom = '{{ $analistExists->slug }}'
@endif



</script>

<script src="{{ asset('js/peerClient.js') }}"></script>