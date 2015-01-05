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
		alertDGC(document.getElementById('Imprimir'),'./menu_principal.php?estudiante');
			//Función que procede a cambiar el estatus del Documento a Anular.
			$('#BtnAnular').click(function(){
				$('.dgcAlert').animate({opacity:0},50);
			    $('.dgcAlert').css('display','none');
				document.getElementById('Anular').innerHTML="";
			})
	}
	//	Muestra la Ficha de Inscripción en una pestaña nueva.
	$('#btnPrintReport').click(function(){
        url = "../pdf/pdf_ficha_inscripcion.php?p1="+$('#codigo_proceso_inscripcion').val();
		window.open(url, '_blank');
	})

	//Búsquedas del representante por autocompletar.
	$('#cedula_representante').autocomplete({
		source:'../autocomplete/representante.php', 
		minLength:1,
		select: function (event, ui){
			Datos={"lOpt":"BuscarDatosRepresentante","filtro":ui.item.value};
			BuscarDatosRepresentante(Datos);
		}
	});

    //Busca los Datos del Representante seleccionado.
    function BuscarDatosRepresentante(value){
        $.ajax({
        url: '../controllers/control_persona.php',
        type: 'POST',
        async: true,
        data: value,
        dataType: "json",
        success: function(resp){
        	if(resp[0].codigo_parentesco!=0)
        		$('#codigo_parentesco').val(resp[0].codigo_parentesco);
        	$('#representante').val(resp[0].primer_nombre+' '+resp[0].primer_apellido);
        },
        error: function(jqXHR, textStatus, errorThrown){
        	alert('¡Error al procesar la petición! '+textStatus+" "+errorThrown)
        }
        });
    }

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

		if($('#fecha_inscripcion').val()==""){
			alert("¡Debe ingresar la fecha de inscripción del estudiante!");
			send = false;
		}
		else if($('#cedula_responsable').val()==""){
			alert("¡Debe seleccionar al docente responsable!");
			send = false;
		}
		else if($('#cedula_persona').val()==""){
			alert("¡Debe ingresar la cédula del estudiante!");
			send = false;
		}
		else if($('#primer_nombre').val()==""){
			alert("¡Debe ingresar el primer nombre del estudiante!");
			send = false;
		}
		else if($('#primer_apellido').val()==""){
			alert("¡Debe ingresar el primer apellido del estudiante!");
			send = false;
		}
		else if($('#sexo').val()==""){
			alert("¡Debe ingresar el sexo del estudiante!");
			send = false;
		}
		else if($('#fecha_nacimiento').val()==""){
			alert("¡Debe ingresar la fecha de nacimiento del estudiante!");
			send = false;
		}
		else if($('#lugar-nacimiento').val()==0){
			alert("¡Debe seleccionar el lugar de nacimiento del estudiante!");
			send = false;
		}
		else if($('#direccion').val()==""){
			alert("¡Debe ingresar la direccion del estudiante!");
			send = false;
		}
		else if($('#telefono_local').val()==""){
			alert("¡Debe ingresar el teléfono local del estudiante!");
			send = false;
		}

		//Comprobamos si el elemento estatus existe para luego verificar su valor.
		if(document.getElementById("estatus")){
			if($.trim($('#estatus').text())=="Activo"){
				send = true;
			}else{
				alert("¡El registro no se puede modificar ya que está desactivado!");
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