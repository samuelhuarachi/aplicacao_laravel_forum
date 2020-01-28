@if ($errors->any())
	
	<script type="text/javascript">

	var erro;
	erro = '';

	// Rederiza mensagem de erro
	@foreach ($errors->all() as $error)
		erro = erro + '{{ $error }} <br>';
	@endforeach

    Swal.fire({
        title: 'Erros encontrados',
        html: erro,
        icon: 'error',
        confirmButtonText: 'Ok'
    })

	</script>

@endif