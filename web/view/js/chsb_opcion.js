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
		if($('#nombre_opcion').val()==""){
			alert("¡Debe ingresar el nombre del botón!");
			send = false;
		}
		else if($('#accion').val()==""){
			alert("¡Debe seleccionar una acción!");
			send = false;
		}
		else if($('#orden').val()==""){
			alert("¡Debe ingresar el número por el cual se ordenará el botón en el formulario!");
			send = false;
		}
		else if($('#icono').val()==""){
			alert("¡Debe seleccionar un icono!");
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