$(document).ready(init);
function init(){

	$('#esconfigurable').click(function(){
		if($('#esconfigurable').is(':checked'))
			$('#tablaBienes').show();
		else
			$('#tablaBienes').hide();
	});

	$('#btnPrint').click(function(){
		window.print();
	});

	$('#btnGuardar').click(ValidarCampos);

	$('#btnImprimirTodos').click(function(){
		imprimirRegistros();
	})

	function imprimirRegistros(){
		alertDGC(document.getElementById('Imprimir'),'./menu_principal.php?bien');
			//Función que procede a cambiar el estatus del Documento a Anular.
			$('#BtnAnular').click(function(){
				$('.dgcAlert').animate({opacity:0},50);
			    $('.dgcAlert').css('display','none');
				document.getElementById('Anular').innerHTML="";
			})
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
		var items = document.getElementsByName('items[]');
		var cantidades = document.getElementsByName('cantidades[]');
		var item_base = document.getElementsByName('item_base[]');
		if($('#nombre').val()==""){
			alert("¡Debe ingresar el nombre del Bien!");
			send = false;
		}
		else if($('#nro_serial').val()==""){
			alert("¡Debe ingresar el serial del Bien!");
			send = false;
		}
		else if($('#codigo_tipo_bien').val()==0){
			alert("¡Debe Seleccionar un Tipo de Bien!");
			send = false;
		}
		else if(items && cantidades && item_base){
			arregloI = new Array();
			arregloIB = new Array();
			for(i=0;i<items.length;i++){
				arregloI.push($('#items_'+i).val());
				if($('#item_base_'+i).is(':checked'))
					arregloIB.push($('#item_base_'+i).val());
				var Cant=$('#cantidades_'+i).val();
				if(Cant<=0){
					alert('¡La cantidad del componente '+$('#items_'+i+' option:selected').text()+' debe ser mayor a 0!');
					send = false;	
				}
			}
			if(contarRepetidos(arregloI)>0){
				alert('¡No puede haber bienes repetidos!')
				send = false;
			}
			else if(contarRepetidos(arregloIB)>0){
				alert('¡Solo puede haber un componente base!')
				send = false;
			}
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
