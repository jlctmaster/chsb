$(document).ready(init);
function init(){
	// Init JQueryTe
	$('.jqte-test').jqte();
	
	// settings of status
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
	});

	$('#btnGuardar').click(ValidarCampos);

	//Búsquedas de las parroquias por autocompletar.
	$('#codigo_parroquia').autocomplete({
		source:'../autocomplete/parroquia.php', 
		minLength:1
	});

	function ValidarCampos(){
		var send = true;
		if($('#rif_negocio').val()==""){
			alert("¡Debe ingresar el RIF del negocio!");
			send = false;
		}
		else if($('#nombre').val()==""){
			alert("¡Debe ingresar el nombre del negocio!");
			send = false;
		}
		else if($('#telefono').val()==""){
			alert("¡Debe ingresar un número de teléfono del negocio!");
			send = false;
		}
		else if($('#email').val()==""){
			alert("¡Debe ingresar un correo electrónico del negocio!");
			send = false;
		}
		else if($('#codigo_parroquia').val()==0){
			alert("¡Debe seleccionar una parroquia!");
			send = false;
		}
		else if($('#direccion').val()==""){
			alert("¡Debe ingresar la dirección del negocio!");
			send = false;
		}
		else if($('#mision').val()==""){
			alert("¡Debe ingresar la misión del negocio!");
			send = false;
		}
		else if($('#vision').val()==""){
			alert("¡Debe ingresar la visión del negocio!");
			send = false;
		}
		else if($('#objetivo').val()==""){
			alert("¡Debe ingresar el objetivo general y especificos del negocio!");
			send = false;
		}
		else if($('#historia').val()==""){
			alert("¡Debe ingresar la reseña histórica del negocio!");
			send = false;
		}

		if(send==true)
			$('#form1').submit();
	}
}