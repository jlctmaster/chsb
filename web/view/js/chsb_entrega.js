$(document).ready(init);
function init(){
	
	$('#btnPrintReport').click(function(){
        url = "../pdf/pdf_formato_entrega.php?p1="+$('#codigo_entrega').val();
		window.open(url, '_blank');
	})
	$('#btnPrint').click(function(){
		window.print();
	});
	$('#btnGuardar').click(ValidarCampos);

	$('#btnImprimirTodos').click(function(){
		imprimirRegistros();
	})

	$('#codigo_prestamo').change(function(){
		var Datos = {'lOpt':'buscarDatosPrestamo','codigo_prestamo':$('#codigo_prestamo').val()};
		buscarPrestamo(Datos);
	})
	
	function buscarPrestamo(value){
		$.ajax({
	        url: '../controllers/control_entrega.php',
	        type: 'POST',
	        async: true,
	        data: value,
	        dataType: "json",
	        success: function(resp){
	        	$('#cedula_responsable option[value='+resp[0].cedula_responsable+']').attr('selected', 'selected');
	        	$('#cedula_persona').val(resp[0].cedula_persona);
	        	$('#estudiante').val(resp[0].estudiante);
	        	$('#fecha_entrada').val(resp[0].fecha_entrada);
	        	//	Eliminamos el detalle del elemento tablaDetEntrega para reescribir los valores.
	        	$('#tablaDetEntrega tr[id]').remove();
	        	for(var contador=0;contador<resp.length;contador++){
	        		$("#tablaDetEntrega").append("<tr id='"+contador+"'>"+
	    			"<td>"+
					"<input type='hidden' name='ejemplar[]' id='ejemplar_"+contador+"' value='"+resp[contador].codigo_ejemplar+"' >"+
					"<input type='hidden' name='ubicacion[]' id='ubicacion_"+contador+"' value='"+resp[contador].codigo_ubicacion+"' >"+
					"<input class='input-xlarge' type='text' name='name_ejemplar[]' id='name_ejemplar_"+contador+"' title='Ejemplar a entregar' value='"+resp[contador].name_ejemplar+"' readonly >"+
					"</td>"+
					"<td>"+
					"<input type='hidden' name='cantidad_max[]' id='cantidad_max_"+contador+"' value='"+resp[contador].cantidad+"'>"+
					"<input type='text' name='cantidad[]' id='cantidad_"+contador+"' title='Cantidad a recuperar' value='"+resp[contador].cantidad+"'>"+
					"</td>"+
	                "</tr>");
	                //	Modificamos el width de la cantidad para este elemento
	                $('#cantidad_'+contador).css("width","80px");
	        	}
	        },
	        error: function(jqXHR, textStatus, errorThrown){
	        	alert('¡Error al procesar la petición! '+textStatus+" "+errorThrown)
	        }
        });
	}

	function imprimirRegistros(){
		alertDGC(document.getElementById('Imprimir'),'./menu_principal.php?entrega');
			//Función que procede a cambiar el estatus del Documento a Anular.
			$('#BtnAnular').click(function(){
				$('.dgcAlert').animate({opacity:0},50);
			    $('.dgcAlert').css('display','none');
				document.getElementById('Anular').innerHTML="";
			})
	}
	//	Muestra la Ficha de Inscripción en una pestaña nueva.
	$('#btnPrintReport').click(function(){
        url = "../pdf/pdf_formato_entrega.php?p1="+$('#codigo_entrega').val();
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
		var cantidad = document.getElementsByName('cantidad[]');
		var cantidad_max = document.getElementsByName('cantidad_max[]');
		var ubicacion = document.getElementsByName('ubicacion[]');
		
		if($('#codigo_prestamo').val()==0){
			alert("¡Debe seleccionar un Préstamo!");
			send = false;
		}
		else if($('#cedula_responsable').val()==0){
			alert("¡Debe seleccionar una persona responsable!");
			send = false;
		}
		else if($('#cedula_persona').val()==0){
			alert("¡Debe seleccionar una persona!");
			send = false;
		}
		else if($('#fecha_entrada').val()==""){
			alert("¡Debe seleccionar la Fecha de Entrada!");
			send = false;
		}
		else if(ejemplar && cantidad && cantidad_max && ubicacion){
			for(i=0;i<ejemplar.length;i++){
				var Cant=$('#cantidad_'+i).val();
				var CantMax=$('#cantidad_max_'+i).val();
				if(parseInt(Cant)>parseInt(CantMax)){
					alert('¡La cantidad del Ejemplar '+$('#name_ejemplar_'+i+'').val()+' debe ser menor o igual a '+CantMax+'!');
					send = false;
				}
			}
		}
		else if(!ejemplar && !cantidad && !ubicacion){
			alert("¡Debe Haber almenos un libro a entregar!");
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
}