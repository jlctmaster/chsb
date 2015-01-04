$(document).ready(init);
function init(){
	//	Busca la cantidad disponible del item seleccionado en la ubicación seleccionada.
	$('#codigo_bien').change(function(){
		var Datos = {"lOpt":"BuscarCantidadDisponible","codigo_bien":$('#codigo_bien').val(),"codigo_ubicacion":$('#codigo_ubicacion').val()};
		obtenerCantidadDisponible(Datos);
	})
	//	Busca la cantidad disponible del item seleccionado en la ubicación seleccionada.
	$('#cantidad').change(function(){
		if(parseInt($('#cantidad').val()) > parseInt($('#cantidad_max').val())){
			alert("¡Debe ingresar una cantidad a recuperar debe ser menor o igual a "+$('#cantidad_max').val()+"!");
		}else{
	    	var arrayRegistros = new Array();
	    	//	Eliminamos el detalle del elemento tablaDetRecuperacion para reescribir los valores.
	    	$('#tablaDetRecuperacion tr[id]').remove();
	        var objRecord =	BuscarConfiguracion($('#codigo_bien').val(),$('#cantidad').val(),arrayRegistros);
	        //	Recorremos el objeto para dibujar las tuplas en la tabla tablaDetRecuperacion.
	        for(var contador=0;contador<objRecord.length;contador++){
	        	var go = true;
	        	//	Solo mostramos los items del ultimo nivel de configuración.
	        	if(objRecord[contador].esconfigurable=="N"){
	        		var item = document.getElementsByName('items[]');
	        		//	Sumamos las cantidades de los items repetidos
	        		for(var i=0; i<item.length;i++){
	        			if($('#items_'+i).val()==objRecord[contador].codigo_item_recuperado){
	        				$('#cantidad_max_'+i).val(parseInt($('#cantidad_max_'+i).val())+parseInt(objRecord[contador].cantidad_recuperada));
	        				$('#cantidad_'+i).val(parseInt($('#cantidad_'+i).val())+parseInt(objRecord[contador].cantidad_recuperada));
	        				go=false;
	        			}
	        		}
	        		if(go==true){
		        		$("#tablaDetRecuperacion").append("<tr id='"+contador+"'>"+
						"<td>"+
						"<input type='hidden' name='ubicacion[]' id='ubicacion_"+contador+"' value='"+objRecord[contador].codigo_ubicacion+"' >"+
						"<input class='input-xlarge' type='text' name='name_ubicacion[]' id='name_ubicacion_"+contador+"' title='Ubicación donde se va a almacenar' value='"+objRecord[contador].ubicacion+"' readonly >"+
						"</td>"+
		    			"<td>"+
						"<input type='hidden' name='items[]' id='items_"+contador+"' value='"+objRecord[contador].codigo_item_recuperado+"' >"+
						"<input class='input-xlarge' type='text' name='name_items[]' id='name_items_"+contador+"' title='Componente a recuperar' value='"+objRecord[contador].item_recuperado+"' readonly >"+
						"</td>"+
						"<td>"+
						"<input type='hidden' name='cantidad_max[]' id='cantidad_max_"+contador+"' value='"+objRecord[contador].cantidad_recuperada+"'>"+
						"<input type='text' name='cantidad[]' id='cantidad_"+contador+"' title='Cantidad a recuperar' value='"+objRecord[contador].cantidad_recuperada+"'>"+
						"</td>"+
		                "</tr>");
		                //	Modificamos el width de la cantidad para este elemento
		                $('#cantidad_'+contador).css("width","80px");
	        		}
	        	}
	    	}
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
	        	$('#cantidad').val(resp[0].existencia);
	        	$('#cantidad_max').val(resp[0].existencia);
	        	var arrayRegistros = new Array();
	        	//	Eliminamos el detalle del elemento tablaDetRecuperacion para reescribir los valores.
	        	$('#tablaDetRecuperacion tr[id]').remove();
		        var objRecord =	BuscarConfiguracion(resp[0].codigo_item,resp[0].existencia,arrayRegistros);
		        //	Recorremos el objeto para dibujar las tuplas en la tabla tablaDetRecuperacion.
		        for(var contador=0;contador<objRecord.length;contador++){
		        	var go = true;
		        	//	Solo mostramos los items del ultimo nivel de configuración.
		        	if(objRecord[contador].esconfigurable=="N"){
		        		var item = document.getElementsByName('items[]');
		        		//	Sumamos las cantidades de los items repetidos
		        		for(var i=0; i<item.length;i++){
		        			if($('#items_'+i).val()==objRecord[contador].codigo_item_recuperado){
		        				$('#cantidad_max_'+i).val(parseInt($('#cantidad_max_'+i).val())+parseInt(objRecord[contador].cantidad_recuperada));
		        				$('#cantidad_'+i).val(parseInt($('#cantidad_'+i).val())+parseInt(objRecord[contador].cantidad_recuperada));
		        				go=false;
		        			}
		        		}
		        		if(go==true){
			        		$("#tablaDetRecuperacion").append("<tr id='"+contador+"'>"+
							"<td>"+
							"<input type='hidden' name='ubicacion[]' id='ubicacion_"+contador+"' value='"+objRecord[contador].codigo_ubicacion+"' >"+
							"<input class='input-xlarge' type='text' name='name_ubicacion[]' id='name_ubicacion_"+contador+"' title='Ubicación donde se va a almacenar' value='"+objRecord[contador].ubicacion+"' readonly >"+
							"</td>"+
			    			"<td>"+
							"<input type='hidden' name='items[]' id='items_"+contador+"' value='"+objRecord[contador].codigo_item_recuperado+"' >"+
							"<input class='input-xlarge' type='text' name='name_items[]' id='name_items_"+contador+"' title='Componente a recuperar' value='"+objRecord[contador].item_recuperado+"' readonly >"+
							"</td>"+
							"<td>"+
							"<input type='hidden' name='cantidad_max[]' id='cantidad_max_"+contador+"' value='"+objRecord[contador].cantidad_recuperada+"'>"+
							"<input type='text' name='cantidad[]' id='cantidad_"+contador+"' title='Cantidad a recuperar' value='"+objRecord[contador].cantidad_recuperada+"'>"+
							"</td>"+
			                "</tr>");
			                //	Modificamos el width de la cantidad para este elemento
			                $('#cantidad_'+contador).css("width","80px");
		        		}
		        	}
	        	}
	        },
	        error: function(jqXHR, textStatus, errorThrown){
	        	alert('¡Error al procesar la petición! '+textStatus+" "+errorThrown)
	        }
        });
	}
	//	Esta función busca la configuración del item y lo carga en la tabla de detalle.
	function BuscarConfiguracion(item,cantidad,records){
		var value={"lOpt":"BuscarConfiguracion","codigo_bien":item,"cantidad":cantidad};
		$.ajax({
	        url: '../controllers/control_reconstruccion.php',
	        type: 'POST',
	        async: false,
	        data: value,
	        dataType: "json",
	        success: function(resp){
	        	for(var pos=0;pos<resp.length;pos++){
	        		records.push(resp[pos]);
	        		if(resp[pos].esconfigurable=='Y')
	        			BuscarConfiguracion(resp[pos].codigo_item_recuperado,resp[pos].cantidad_recuperada,records);
	        	}
	        },
	        error: function(jqXHR, textStatus, errorThrown){
	        	alert('¡Error al procesar la petición! '+textStatus+" "+errorThrown)
	        }
        });
		return records;
	}

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
			alert("¡Debe ingresar una cantidad a recuperar debe ser menor o igual a "+$('#cantidad_max').val()+"!");
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