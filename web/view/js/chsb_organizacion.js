$(document).ready(init);
function init(){
	$('#btnPrint').click(function(){
		window.print();
	});

	$('#btnGuardar').click(ValidarCampos);
	$('#btnImprimirTodos').click(function(){
		imprimirRegistros();
	})

	function imprimirRegistros(){
		alertDGC(document.getElementById('Imprimir'),'./menu_principal.php?organizacion');
			//Función que procede a cambiar el estatus del Documento a Anular.
			$('#BtnAnular').click(function(){
				$('.dgcAlert').animate({opacity:0},50);
			    $('.dgcAlert').css('display','none');
				document.getElementById('Anular').innerHTML="";
			})
	}

	//Búsquedas de las parroquias por autocompletar.
	$('#codigo_parroquia').autocomplete({
		source:'../autocomplete/parroquia.php', 
		minLength:1
	});
	
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
		if($('#rif_organización').val()==""){
			alert("¡Debe ingresar el RIF de la Organización!");
			send = false;
		}

		else if($('#nombre').val()==""){
			alert("¡Debe ingresar el nombre de la Organización!");
			send = false;
		}
		else if($('#direccion').val()==""){
			alert("¡Debe ingresar la dirección de la Organización!");
			send = false;
		}
		else if($('#telefono').val()==""){
			alert("¡Debe ingresar el numero de la Organización!");
			send = false;
		}

		else if($('#tipo_organizacion').val()==""){
			alert("¡Debe ingresar el Tipo de la Organización!");
			send = false;
		}

		else if($('#codigo_parroquia').val()==0){
			alert("¡Debe Seleccionar una Parroquia!");
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