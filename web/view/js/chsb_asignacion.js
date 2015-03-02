$(document).ready(init);
function init(){
		$('#btnPrintReport').click(function(){
        url = "../pdf/pdf_formato_asignacion.php?p1="+$('#codigo_asignacion').val();
		window.open(url, '_blank');
	})

	$('#btnPrint').click(function(){
		window.print();
	});

	$('#btnGuardar').click(ValidarCampos);

	$('#btnImprimirTodos').click(function(){
		imprimirRegistros();
	})
	
	function imprimirRegistros(){
		alertDGC(document.getElementById('Imprimir'),'./menu_principal.php?asignacion');
			//Función que procede a cambiar el estatus del Documento a Anular.
			$('#BtnAnular').click(function(){
				$('.dgcAlert').animate({opacity:0},50);
			    $('.dgcAlert').css('display','none');
				document.getElementById('Anular').innerHTML="";
			})
	}
	//	Muestra la Ficha de Inscripción en una pestaña nueva.
	$('#btnPrintReport').click(function(){
        url = "../pdf/pdf_formato_asignacion.php?p1="+$('#codigo_asignacion').val();
		window.open(url, '_blank');
	})

	//Búsquedas del representante por autocompletar.
	$('#cedula_persona').autocomplete({
		source:'../autocomplete/persona.php', 
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
		var items = document.getElementsByName('items[]');
		var cantidad = document.getElementsByName('cantidad[]');
		var ubicacion = document.getElementsByName('ubicacion[]');
		var ubicacion_hasta = document.getElementsByName('ubicacion_hasta[]');
		if($('#fecha_asignacion').val()==""){
			alert("¡Debe Seleccionar la fecha de adquisición!");
			send = false;
		}
		else if($('#cedula_persona').val()==0){
			alert("¡Debe seleccionar una persona responsable!");
			send = false;
		}
		else if(items && cantidad && ubicacion && ubicacion_hasta){
			arregloI = new Array();
			arregloU = new Array();
			arregloUH = new Array();
			console.log(items.length);
			for(i=0;i<items.length;i++){
				var I = $('#items_'+i).val().split('_');
				var U = $('#ubicacion_'+i).val().split('_');
				var UH = $('#ubicacion_hasta_'+i).val().split('_');
				arregloI.push(I[0]);
				arregloU.push(U[0]);
				arregloUH.push(UH[0]);
				var Cant=$('#cantidad_'+i).val();
				var CantDisponible=obtenerCantidadDisponible(I[0],U[0]);
				if(Cant<=0){
					alert('¡La cantidad del item '+I[0]+' debe ser mayor a 0!');
					send = false;	
				}
				if(parseInt(CantDisponible) < parseInt(Cant)){
					alert('¡La cantidad del item '+I[0]+' en la Ubicación '+U[0]+' debe ser menor o igual a la disponible ('+CantDisponible+')!');
					send = false;
				}
			}
			if(combinacionRepetida(arregloI,arregloU,arregloUH)>0){
				alert('¡La combinación Item + Ubicación Origen + Ubicación Destino no se puede repetir!')
				send = false
			}
		}
		else if(!items && !cantidad && !ubicacion && !ubicacion_hasta){
			alert("¡Debe seleccionar almenos un item!");
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

	function contarRepetidos(arreglo){
	    var arreglo2 = arreglo;
	    var con=0;
	    for (var m=0; m<arreglo2.length; m++)
	    {
	        for (var n=0; n<arreglo2.length; n++)
	        {
	            if(n!=m)
	            {
	                if(arreglo2[m]==arreglo2[n])
	                {
	                	con++;
	                }
	            }
	        }
	    }
	    return con;
	}

	function obtenerCantidadDisponible(item,ubicacion){
		var existencia=0;
		value ={"lOpt":"BuscarCantidadDisponible","codigo_item":item,"codigo_ubicacion":ubicacion};
		$.ajax({
	        url: '../controllers/control_asignacion.php',
	        type: 'POST',
	        async: false,
	        data: value,
	        dataType: "json",
	        success: function(resp){
	        	existencia = resp[0].existencia;
	        },
	        error: function(jqXHR, textStatus, errorThrown){
	        	alert('¡Error al procesar la petición! '+textStatus+" "+errorThrown)
	        }
        });
        return existencia;
	}

	function combinacionRepetida(arregloA,arregloB,arregloC){
	    var arreglo1 = arregloA;
	    var arreglo2 = arregloB;
	    var arreglo3 = arregloC;
	    var con=0;
	    for (var m=0; m<arreglo1.length; m++)
	    {
	        for (var n=0; n<arreglo1.length; n++)
	        {
	            if(n!=m)
	            {
	                if(arreglo1[m]==arreglo1[n] && arreglo2[m]==arreglo2[n] && arreglo3[m]==arreglo3[n])
	                {
	                	con++;
	                }
	            }
	        }
	    }
	    return con;
	}
}