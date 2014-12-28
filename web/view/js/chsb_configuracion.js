$(document).ready(init);
function init(){
	$('#btnPrint').click(function(){
		window.print();
	});

	$('#btnGuardar').click(ValidarCampos);
	$('#btnDesactivar').click(function(){
		noty({
	        text: stringUnicode("¿Está seguro que quiere desactivar este registro?"),
	        layout: "center",
	        type: "confirm",
	        dismissQueue: true,
	        animateOpen: {"height": "toggle"},
	        animateClose: {"height": "toggle"},
	        theme: "defaultTheme",
	        closeButton: false,
	        closeOnSelfClick: true,
	        closeOnSelfOver: false,
	        buttons: [
	        {
	            addClass: 'btn btn-primary', text: 'Aceptar', onClick: function($noty){
	                noty({dismissQueue: true, force: true, layout: "center", theme: 'defaultTheme', text: stringUnicode('¡El registro será desactivado!'), type: 'error'});
	                $noty.close();
	                setInterval(function(){
	                    CambiarEstatus(0);
	                },1000)
	            }
	        },
	        {
	            addClass: 'btn btn-danger', text: 'Cancelar', onClick: function($noty){
	                $noty.close();
	            }
	        }
	        ]
	    });
	});
	$('#btnActivar').click(function(){
		noty({
	        text: stringUnicode("¿Está seguro que quiere activar este registro?"),
	        layout: "center",
	        type: "confirm",
	        dismissQueue: true,
	        animateOpen: {"height": "toggle"},
	        animateClose: {"height": "toggle"},
	        theme: "defaultTheme",
	        closeButton: false,
	        closeOnSelfClick: true,
	        closeOnSelfOver: false,
	        buttons: [
	        {
	            addClass: 'btn btn-primary', text: 'Aceptar', onClick: function($noty){
	                noty({dismissQueue: true, force: true, layout: "center", theme: 'defaultTheme', text: stringUnicode('¡El registro será activado!'), type: 'error'});
	                $noty.close();
	                setInterval(function(){
	                    CambiarEstatus(1);
	                },1000)
	            }
	        },
	        {
	            addClass: 'btn btn-danger', text: 'Cancelar', onClick: function($noty){
	                $noty.close();
	            }
	        }
	        ]
	    });
	});

	function ValidarCampos(){
		var send = true;
		if($('#descripcion').val()==""){
			alert("¡Debe ingresar el nombre de la Configuración del Sistema!");
			send = false;
		}
		else if($('#longitud_minclave').val()==""){
			alert("¡Debe ingresar la longitud mínima para la clave!");
			send = false;
		}
		else if($('#longitud_maxclave').val()==""){
			alert("¡Debe ingresar la longitud máxima para la clave!");
			send = false;
		}
		else if($('#cantidad_letrasmayusculas').val()==""){
			alert("¡Debe ingresar la cantidad de letras mayúsculas!");
			send = false;
		}
		else if($('#cantidad_letrasminusculas').val()==""){
			alert("¡Debe ingresar la cantidad de letras minúsculas!");
			send = false;
		}
		else if($('#cantidad_caracteresespeciales').val()==""){
			alert("¡Debe ingresar la cantidad de carácteres especiales!");
			send = false;
		}
		else if($('#cantidad_numeros').val()==""){
			alert("¡Debe ingresar la cantidad de carácteres númericos!");
			send = false;
		}
		else if($('#dias_vigenciaclave').val()==""){
			alert("¡Debe ingresar la cantidad de días para la vigencia de la clave!");
			send = false;
		}
		else if($('#numero_ultimasclaves').val()==""){
			alert("¡Debe ingresar la cantidad a validar de las últimas claves usadas!");
			send = false;
		}
		else if($('#dias_aviso').val()==""){
			alert("¡Debe ingresar la cantidad de días para avisar el vencimiento de la clave!");
			send = false;
		}
		else if($('#intentos_fallidos').val()==""){
			alert("¡Debe ingresar la cantidad de intentos fallidos a validar para acceder al sistema!");
			send = false;
		}
		else if($('#numero_preguntas').val()==""){
			alert("¡Debe ingresar la cantidad de preguntas secretas!");
			send = false;
		}
		else if($('#numero_preguntasaresponder').val()==""){
			alert("¡Debe ingresar la cantidad de preguntas secretas a responder!");
			send = false;
		}

		//Comprobamos si el elemento estatus existe para luego verificar su valor.
		if(document.getElementById("estatus")){
			if($.trim($('#estatus').text())=="Activo"){
				send = true;
			}else{
				alert("¡El registro no se puede modificar ya que esta desactivado!");
				send = false;
			}
		}

		if(send==true)
			$('#form1').submit();
	}

	function CambiarEstatus(valor){
		if(valor==0)
			$('#lOpt').val("Desactivar");
		else
			$('#lOpt').val("Activar");
		$('#form1').submit();
	}
}