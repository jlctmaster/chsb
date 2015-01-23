$(document).ready(init);
function init(){
		$('#btnPrintReport').click(function(){
        url = "../pdf/pdf_formato_prestamo.php?p1="+$('#codigo_prestamo').val();
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
		alertDGC(document.getElementById('Imprimir'),'./menu_principal.php?prestamo');
			//Función que procede a cambiar el estatus del Documento a Anular.
			$('#BtnAnular').click(function(){
				$('.dgcAlert').animate({opacity:0},50);
			    $('.dgcAlert').css('display','none');
				document.getElementById('Anular').innerHTML="";
			})
	}
	//	Muestra la Ficha de Inscripción en una pestaña nueva.
	$('#btnPrintReport').click(function(){
        url = "../pdf/pdf_formato_prestamo.php?p1="+$('#codigo_prestamo').val();
		window.open(url, '_blank');
	})
	
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
		var ejemplar = document.getElementsByName('ejemplar[]');
		var ubicacion = document.getElementsByName('ubicacion[]');
		var cantidad = document.getElementsByName('cantidad[]');
		
		if($('#cedula_responsable').val()==0){
			alert("¡Debe seleccionar una persona responsable!");
			send = false;
		}
		else if($('#cedula_persona').val()==0){
			alert("¡Debe seleccionar una persona!");
			send = false;
		}
		else if($('#codigo_area').val()==0){
			alert("¡Debe seleccionar un Área!");
			send = false;
		}
		else if($('#cota').val()==""){
			alert("¡Debe Ingresar una Cota!");
			send = false;
		}
		else if($('#fecha_salida').val()==""){
			alert("¡Debe Seleccionar la fecha de salida!");
			send = false;
		}
		else if($('#fecha_entrada').val()==""){
			alert("¡Debe seleccionar la Fecha de Entrada!");
			send = false;
		}
		else if(ejemplar && ubicacion){
			arregloI = new Array();
			arregloU = new Array();
			for(i=0;i<ejemplar.length;i++){
				arregloI.push($('#ejemplar_'+i).val());
				arregloU.push($('#ubicacion_'+i).val());
				var Cant=$('#cantidad_'+i).val();
				var CantDisponible=obtenerCantidadDisponible($('#ejemplar_'+i).val(),$('#ubicacion_'+i).val());
				if(Cant<=0){
					alert('¡La cantidad del ejemplar '+$('#ejemplar_'+i+' option:selected').text()+' debe ser mayor a 0!');
					send = false;	
				}
				if(parseInt(Cant) > parseInt(CantDisponible)){
					alert('¡La cantidad del ejemplar '+$('#ejemplar_'+i+' option:selected').text()+' en la Ubicación '+$('#ubicacion_'+i+' option:selected').text()+' debe ser menor o igual a la disponible ('+CantDisponible+')!');
					send = false;
				}
			}
			if(contarRepetidos(arregloI)>0 && contarRepetidos(arregloU)>0){
				alert('¡La combinación Ejemplar + Ubicación no se puede repetir!')
				send = false
			}
		}
		else if(!ejemplar && !ubicacion && !cantidad){
			alert("¡Debe seleccionar almenos un ejemplar!");
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

	function obtenerCantidadDisponible(ejemplar,ubicacion){
		var existencia=0;
		value ={"lOpt":"BuscarCantidadDisponible","codigo_ejemplar":ejemplar,"codigo_ubicacion":ubicacion};
		$.ajax({
	        url: '../controllers/control_prestamo.php',
	        type: 'POST',
	        async: false,
	        data: value,
	        dataType: "json",
	        success: function(resp){
	        	if(resp[0].existencia!=undefined)
	        		existencia = resp[0].existencia;
	        	else
	        		existencia = 0;
	        },
	        error: function(jqXHR, textStatus, errorThrown){
	        	alert('¡Error al procesar la petición! '+textStatus+" "+errorThrown)
	        }
        });
        return existencia;
	}
}