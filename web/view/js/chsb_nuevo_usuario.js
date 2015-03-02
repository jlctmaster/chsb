$(document).ready(init);
function init(){

	//Búsquedas de las personas por autocompletar.
	$('#cedula_persona').autocomplete({
		source:'../autocomplete/usuario.php', 
		minLength:1
	});

	$('#btnGuardar').click(ValidarCampos);

	function ValidarCampos(){
		var send = true;
		if($('#cedula_persona').val()==""){
			alert("¡Debe ingresar la cédula de la persona!");
			send = false;
		}
		else if($('#codigo_perfil').val()=="" || $('#codigo_perfil').val()=="null"){
			alert("¡Debe seleccionar un perfil!");
			send = false;
		}

		if(send==true)
			$('#form1').submit();
	}
}