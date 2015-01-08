$(document).ready(init);
function init(){
	//	variable global para determinar si ha ocurrido un error o no
	var ocurrioerror=false;
	//	Busca la cantidad disponible del item seleccionado en la ubicación seleccionada.
	$('#codigo_bien').change(function(){
		var Datos = {"lOpt":"BuscarDisponibilidad","codigo_bien":$('#codigo_bien').val()};
		obtenerCantidadDisponible(Datos);
	})
	//	Busca la cantidad disponible del item seleccionado en la ubicación seleccionada.
	$('#cantidad').change(function(){
		if(parseInt($('#cantidad').val()) > parseInt($('#cantidad_max').val()) && $('#codigo_bien').val()!="0"){
			alert("¡La cantidad a recuperar debe ser menor o igual a "+$('#cantidad_max').val()+"!");
		}else if($('#codigo_bien').val()!="0"){
			var Datos = {"lOpt":"BuscarDisponibilidadPorCant","codigo_bien":$('#codigo_bien').val(),"cantidad":$('#cantidad').val()};
			obtenerCantidadDisponible(Datos);
		}
	})
	//	Esta función busca la cantidad disponible del item seleccionado.
	function obtenerCantidadDisponible(value){
		$.ajax({
	        url: '../controllers/control_reconstruccion.php',
	        type: 'POST',
	        async: true,
	        data: value,
	        dataType: "json",
	        success: function(resp){
	        	try{
			        if(resp[0].msj==undefined){
			        	$('#cantidad').val(resp[0].cant_disponible_a_recuperar);
			        	$('#cantidad_max').val(resp[0].cant_disponible);
			        	//	Guardamos resultado en arreglo para luego buscar las ubicaciones fuentes.
			        	var arrayRegistros = new Array();
			        	for(var pos=0;pos<resp.length;pos++){
			        		arrayRegistros.push(resp[pos]);
			        	}
			        	//	Eliminamos el detalle del elemento tablaDetReconstruccion para reescribir los valores.
			        	$('#tablaDetReconstruccion tr[id]').remove();
				        var objRecord =	BuscarUbicacionFuente(arrayRegistros);
				        if(ocurrioerror==false){
					        //	Recorremos el objeto para dibujar las tuplas en la tabla tablaDetReconstruccion.
					        for(var contador=0;contador<objRecord.length;contador++){
				        		$("#tablaDetReconstruccion").append("<tr id='"+contador+"'>"+
								"<td>"+
								"<input type='hidden' name='ubicacion[]' id='ubicacion_"+contador+"' value='"+objRecord[contador].codigo_ubicacion+"' >"+
								"<input class='input-xlarge' type='text' name='name_ubicacion[]' id='name_ubicacion_"+contador+"' title='Ubicación donde se va a almacenar' value='"+objRecord[contador].ubicacion+"' readonly >"+
								"</td>"+
				    			"<td>"+
								"<input type='hidden' name='items[]' id='items_"+contador+"' value='"+objRecord[contador].codigo_item+"' >"+
								"<input class='input-xlarge' type='text' name='name_items[]' id='name_items_"+contador+"' title='Componente a recuperar' value='"+objRecord[contador].item_a_usar+"' readonly >"+
								"</td>"+
								"<td>"+
								"<input type='hidden' name='cantidad_max[]' id='cantidad_max_"+contador+"' value='"+objRecord[contador].total_a_usar+"'>"+
								"<input type='text' name='cantidad[]' id='cantidad_"+contador+"' title='Cantidad a recuperar' value='"+objRecord[contador].total_a_usar+"'>"+
								"</td>"+
				                "</tr>");
				                //	Modificamos el width de la cantidad para este elemento
				                $('#cantidad_'+contador).css("width","80px");
				        	}
				        }
			        }
			        else
			        	alert(resp[0].msj);
	        	}catch(e){
	        		alert(e.message);
	        	}
	        },
	        error: function(jqXHR, textStatus, errorThrown){
	        	alert('¡Error al procesar la petición! '+textStatus+" "+errorThrown)
	        }
        });
	}
	//	Esta función busca la ubicación fuente de donde extraer los componentes a usar.
	function BuscarUbicacionFuente(records){
		var arreglo = new Array();
		for(var i=0;i<records.length;i++){
			var total_a_usar=records[i].total_a_usar;
			var codigo_item=records[i].codigo_item;
			var item_a_usar=records[i].item_a_usar;
			var value={"lOpt":"BuscarUbicacionFuente","codigo_item":records[i].codigo_item,"cantidad":records[i].total_a_usar};
			$.ajax({
		        url: '../controllers/control_reconstruccion.php',
		        type: 'POST',
		        async: false,
		        data: value,
		        dataType: "json",
		        success: function(resp){
		        	try{
		        		if(resp[0].msj==undefined){
		        			total_a_usar=parseInt(resp[0].existencia)-parseInt(total_a_usar);
			        		while(parseInt(total_a_usar)<parseInt(0)){
			        			var Datos={"lOpt":"BuscarUbicacionFuente","codigo_item":records[i].codigo_item,"cantidad":total_a_usar}
			        			var newubicacion = ubicacionFuente(Datos);
			        			total_a_usar=parseInt(newubicacion[0].existencia)-parseInt(total_a_usar);
			        			if(parseInt(total_a_usar)==parseInt(0))
			        				arreglo.push({"codigo_item":codigo_item,"item_a_usar":item_a_usar,"total_a_usar":newubicacion[0].existencia,"codigo_ubicacion":newubicacion[0].codigo_ubicacion,"ubicacion":newubicacion[0].ubicacion});
			        			else
			        				arreglo.push({"codigo_item":codigo_item,"item_a_usar":item_a_usar,"total_a_usar":total_a_usar,"codigo_ubicacion":newubicacion[0].codigo_ubicacion,"ubicacion":newubicacion[0].ubicacion});
			        		}
			        		if(parseInt(total_a_usar)==parseInt(0))
			        			arreglo.push({"codigo_item":codigo_item,"item_a_usar":item_a_usar,"total_a_usar":resp[0].existencia,"codigo_ubicacion":resp[0].codigo_ubicacion,"ubicacion":resp[0].ubicacion});
			        		else if(parseInt(total_a_usar)>parseInt(0))
			        			arreglo.push({"codigo_item":codigo_item,"item_a_usar":item_a_usar,"total_a_usar":records[i].total_a_usar,"codigo_ubicacion":resp[0].codigo_ubicacion,"ubicacion":resp[0].ubicacion});
							//	Si todo ok reseteamos el valor de la variable global por si se ejecuto una transaccion que haya fallado..
							ocurrioerror=false;
		        		}
		        		else{
				        	throw new Error(resp[0].msj+" "+item_a_usar+"!");
		        		}
		        	}catch(e){
		        		alert(e.message);
				        ocurrioerror=true;
		        	}
		        },
		        error: function(jqXHR, textStatus, errorThrown){
		        	alert('¡Error al procesar la petición! '+textStatus+" "+errorThrown)
		        }
	        });
		}
		return arreglo;
	}

	function ubicacionFuente(value){
		var ubicacion = new Array();
		$.ajax({
	        url: '../controllers/control_reconstruccion.php',
	        type: 'POST',
	        async: false,
	        data: value,
	        dataType: "json",
	        success: function(resp){
        		ubicacion.push(resp[0]);
	        },
	        error: function(jqXHR, textStatus, errorThrown){
	        	alert('¡Error al procesar la petición! '+textStatus+" "+errorThrown)
	        }
        });
        return ubicacion;
	}

	$('#btnPrint').click(function(){
		window.print();
	});

	$('#btnImprimirTodos').click(function(){
		imprimirRegistros();
	})

	function imprimirRegistros(){
		alertDGC(document.getElementById('Imprimir'),'./menu_principal.php?reconstruccion');
			//Función que procede a cambiar el estatus del Documento a Anular.
			$('#BtnAnular').click(function(){
				$('.dgcAlert').animate({opacity:0},50);
			    $('.dgcAlert').css('display','none');
				document.getElementById('Anular').innerHTML="";
			})
	}
	//	Muestra la Ficha de Inscripción en una pestaña nueva.
	$('#btnPrintReport').click(function(){
        url = "../pdf/pdf_formato_reconstruccion.php?p1="+$('#codigo_reconstruccion').val();
		window.open(url, '_blank');
	})

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
		var items = document.getElementsByName('items[]');
		var cantidad = document.getElementsByName('cantidad[]');
		var cantidad_max = document.getElementsByName('cantidad_max[]');
		var ubicacion = document.getElementsByName('ubicacion[]');

		//Comprobamos si el elemento estatus existe para luego verificar su valor.
		if(document.getElementById("estatus")){
			if($.trim($('#estatus').text())=="Activo"){
				send = true;
			}else{
				alert("¡El registro no se puede modificar ya que está desactivado!");
				send = false;
			}
		}

		if($('#fecha').val()==""){
			alert("¡Debe Seleccionar la fecha de recuperación!");
			send = false;
		}
		else if($('#cedula_persona').val()==0){
			alert("¡Debe Seleccionar la persona responsable de la recuperación!");
			send = false;
		}
		else if($('#codigo_ubicacion').val()==0){
			alert("¡Debe seleccionar la ubicación origen!");
			send = false;
		}
		else if($('#codigo_bien').val()==0){
			alert("¡Debe seleccionar un bien nacional a recuperar!");
			send = false;
		}
		else if($('#cantidad').val()==0){
			alert("¡Debe ingresar una cantidad a recuperar mayor a 0!");
			send = false;
		}
		else if(parseInt($('#cantidad').val()) > parseInt($('#cantidad_max').val())){
			alert("¡La cantidad a recuperar debe ser menor o igual a "+$('#cantidad_max').val()+"!");
			send = false;
		}
		else if(items && cantidad && cantidad_max && ubicacion){
			for(i=0;i<items.length;i++){
				var Cant=$('#cantidad_'+i).val();
				var CantMax=$('#cantidad_max_'+i).val();
				if(parseInt(Cant)>parseInt(CantMax)){
					alert('¡La cantidad del item '+$('#name_items_'+i+'').val()+' debe ser menor o igual a '+CantMax+'!');
					send = false;
				}
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

/*

function IllegalArgumentException(sMessage) {
    this.name = "IllegalArgumentException";
    this.message = sMessage;
    this.stack = (new Error()).stack;
}
IllegalArgumentException.prototype = Object.create(Error.prototype);
IllegalArgumentException.prototype.constructor = IllegalArgumentException; */