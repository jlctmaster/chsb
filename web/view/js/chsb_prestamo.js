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

	//Búsquedas de las parroquias por autocompletar.
	$('#cedula_responsable').autocomplete({
		source:'../autocomplete/bibliotecario.php', 
		minLength:1
	});

	//Búsquedas de las parroquias por autocompletar.
	$('#cedula_persona').autocomplete({
		source:'../autocomplete/persona_academica.php', 
		minLength:1
	});
	
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

		else if($('#lugar_prestamo').val()==""){
			alert("¡Debe seleccionar un Lugar!");
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
			var E,U,Cant,CantDisponible;
			for(i=0;i<ejemplar.length;i++){
				E = $('#ejemplar_'+i).val().split('_');
				U = $('#ubicacion_'+i).val().split('_');
				arregloI.push(E[0]);
				arregloU.push(U[0]);
				Cant=$('#cantidad_'+i).val();
				CantDisponible=obtenerCantidadDisponible(E[0],U[0]);
				if(Cant<=0){
					alert('¡La cantidad del ejemplar '+$('#ejemplar_'+i).val()+' debe ser mayor a 0!');
					send = false;	
				}
				if(parseInt(Cant) > parseInt(CantDisponible)){
					alert('¡La cantidad del ejemplar '+$('#ejemplar_'+i).val()+' en la Ubicación '+$('#ubicacion_'+i).val()+' debe ser menor o igual a la disponible ('+CantDisponible+')!');
					send = false;
				}
			}
			if(combinacionRepetida(arregloI,arregloU)>0){
				alert('¡La combinación Ejemplar + Ubicación no se puede repetir!')
				send = false
			}
		}
		else if(!ejemplar && !ubicacion && !cantidad){
			alert("¡Debe seleccionar almenos un ejemplar!");
			send = false;
		}

		//Comprobamos si el elemento estatus existe para luego verificar su valor.
		if(document.getElementById("estatus") && send!=false){
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
	        data: value,
	        dataType: "json",
	        async: false,
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

	function combinacionRepetida(arregloA,arregloB){
	    var arreglo1 = arregloA;
	    var arreglo2 = arregloB;
	    var con=0;
	    for (var m=0; m<arreglo1.length; m++)
	    {
	        for (var n=0; n<arreglo1.length; n++)
	        {
	            if(n!=m)
	            {
	                if(arreglo1[m]==arreglo1[n] && arreglo2[m]==arreglo2[n])
	                {
	                	con++;
	                }
	            }
	        }
	    }
	    return con;
	}
}