$(document).ready(init);
function init(){

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