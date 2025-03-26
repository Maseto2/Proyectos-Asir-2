var inicio=0;
	var timeout=0;
 
	function empezarDetener(elemento)
	{
		if(timeout==0)
		{
			// empezar el cronometro
 
			elemento.value="Detener";
 
			// Obtenemos el valor actual
			inicio=vuelta=new Date().getTime();
 
			// iniciamos el proceso
			funcionando();

			/*$.ajax({
				type: 'POST',
				url: '../usuarios/homeusu.php',
				data: result,
				success: function(data) {
					console.log(data);
				}
			});*/

			/*$('body').on('click' , '.empezar' , function() {
				let IDbutton = $(this).val();
				console.log(IDbutton);
				$.post('../usuarios/homeusu.php', { IDbutton: IDbutton }).done(data => {
				  console.log(data);
				});
			  })*/

		}else{
			// detemer el cronometro
 
			elemento.value="Empezar";
			clearTimeout(timeout);
			timeout=0;
		}
	}
 
	function funcionando() {
		// obteneos la fecha actual
		var actual = new Date().getTime();
 
		// obtenemos la diferencia entre la fecha actual y la de inicio
		var diff=new Date(actual-inicio);
 
		// mostramos la diferencia entre la fecha actual y la inicial
		var result=LeadingZero(diff.getUTCHours())+":"+LeadingZero(diff.getUTCMinutes())+":"+LeadingZero(diff.getUTCSeconds());
		document.getElementById('crono').innerHTML = result;


		
		// Indicamos que se ejecute esta función nuevamente dentro de 1 segundo
		timeout=setTimeout("funcionando()",1000);

	}
 
	/* Funcion que pone un 0 delante de un valor si es necesario */
	function LeadingZero(Time) {
		return (Time < 10) ? "0" + Time : + Time;
	}


	/*$(document).ready(function() {
		$('#insert').on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				type: 'POST',
				data: { crono: $('#crono').val() },
				url: '../usuarios/homeusu.php',
				success: function(res) {
					console.log(res);
				}
			})
		})
	})*/

	
