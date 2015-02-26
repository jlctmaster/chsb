$(document).ready(init);
function init(){

	$('#btnImprimirTodos').click(function(){
		imprimirRegistros();
	})

	function imprimirRegistros(){
		alertDGC(document.getElementById('Imprimir'),'./menu_principal.php?proceso_inscripcion');
			//Función que procede a cambiar el estatus del Documento a Anular.
			$('#BtnAnular').click(function(){
				$('.dgcAlert').animate({opacity:0},50);
			    $('.dgcAlert').css('display','none');
				document.getElementById('Anular').innerHTML="";
			})
	}
	//$('#rootwizard').bootstrap({'tabClass': 'nav nav-tabs'});

	$('#tab2').click(function(){
		if($('#codigo_proceso_inscripcion').val()==""){
			alert('¡Debe completar los datos del estudiante antes de continuar!');
			return false;
		}
		else{
			return true;
		}
	});
	$('#tab3').click(function(){
		if($('#codigo_proceso_inscripcion').val()==""){
			alert('¡Debe completar los datos del estudiante antes de continuar!');
			return false;
		}
		else{
			return true;
		}
	});
	$('#tab4').click(function(){
		if($('#codigo_proceso_inscripcion').val()==""){
			alert('¡Debe completar los datos del estudiante antes de continuar!');
			return false;
		}
		else{
			return true;
		}
	});
	$('#tab5').click(function(){
		if($('#codigo_proceso_inscripcion').val()==""){
			alert('¡Debe completar los datos del estudiante antes de continuar!');
			return false;
		}
		else{
			return true;
		}
	});
	$('#tab6').click(function(){
		if($('#codigo_proceso_inscripcion').val()==""){
			alert('¡Debe completar los datos del estudiante antes de continuar!');
			return false;
		}
		else{
			return true;
		}
	});

	var hash = window.location.hash.substr(1);
	var href = $('ul.nav-tabs li a').each(function(){ 
		var href = $(this).attr('href'); 
		href=href.substr(1); 
		if(hash==href){ 
			$(".tab-pane").hide(); 
			$("ul.nav-tabs li").removeClass("active"); 
			$(this).parent('li').addClass("active"); 
			$('#'+hash).fadeIn(); 
		}	 
	});

	$("ul.nav-tabs li").click(function(){ 
		$("ul.nav-tabs li").removeClass("active"); 
		$(this).addClass("active"); 
		$(".tab-pane").hide();   
		var content = $(this).find("a").attr("href"); 
		$(content).fadeIn(); return false; 
	});
	//	Muestra la Ficha de Inscripción en una pestaña nueva.
	$('#btnPrintReport').click(function(){
        url = "../pdf/pdf_ficha_inscripcion.php?p1="+$('#codigo_proceso_inscripcion').val();
		window.open(url, '_blank');
	})

	$('#btnPrint').click(function(){
		window.print();
	});

	$('#btnGuardar1').click(function(){
		ValidarCampos($('#form1'));
	});
	$('#btnGuardar2').click(function(){
		ValidarCampos($('#form2'));
	});
	$('#btnGuardar3').click(function(){
		ValidarCampos($('#form3'));
	});
	$('#btnGuardar4').click(function(){
		ValidarCampos($('#form4'));
	});
	$('#btnGuardar5').click(function(){
		ValidarCampos($('#form5'));
	});
	$('#btnGuardar6').click(function(){
		ValidarCampos($('#form6'));
	});

	//Búsquedas del representante por autocompletar.
	$('#cedula_responsable').autocomplete({
		source:'../autocomplete/profesor.php', 
		minLength:1,
		select: function (event, ui){
			Datos={"lOpt":"BuscarDatosPersona","filtro":ui.item.value};
			BuscarDatosResponsable(Datos);
		}
	});

	//Búsquedas del representante por autocompletar.
	$('#cedula_representante').autocomplete({
		source:'../autocomplete/representante.php', 
		minLength:1,
		select: function (event, ui){
			Datos={"lOpt":"BuscarDatosRepresentante","filtro":ui.item.value};
			BuscarDatosRepresentante(Datos);
		}
	});

    //Busca los Datos del Responsable seleccionado.
    function BuscarDatosResponsable(value){
        $.ajax({
        url: '../controllers/control_persona.php',
        type: 'POST',
        async: true,
        data: value,
        dataType: "json",
        success: function(resp){
        	$('#profesor').val(resp[0].primer_nombre+" "+resp[0].primer_apellido);
        },
        error: function(jqXHR, textStatus, errorThrown){
        	alert('¡Error al procesar la petición! '+textStatus+" "+errorThrown)
        }
        });
    }

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
        	$('#sexo_representante[value='+resp[0].sexo+']').attr("checked","checked");
        	$('#fecha_nacimiento_representante').val(resp[0].fecha_nacimiento);
        	$('#primer_nombre_representante').val(resp[0].primer_nombre);
        	$('#segundo_nombre_representante').val(resp[0].segundo_nombre);
        	$('#primer_apellido_representante').val(resp[0].primer_apellido);
        	$('#segundo_apellido_representante').val(resp[0].segundo_apellido);
        	$('#lugar_nacimiento_representante').val(resp[0].lugar_nacimiento);
        	$('#direccion_representante').val(resp[0].direccion);
        	$('#telefono_local_representante').val(resp[0].telefono_local);
        	$('#telefono_movil_representante').val(resp[0].telefono_movil);
        	$('#profesion_representante').val(resp[0].profesion);
        	$('#grado_instruccion_representante').val(resp[0].grado_instruccion);
        },
        error: function(jqXHR, textStatus, errorThrown){
        	alert('¡Error al procesar la petición! '+textStatus+" "+errorThrown)
        }
        });
    }

	function ValidarCampos(form){
		if(form.attr("id")=="form1"){
			var send = true;
			if($('#fecha_inscripcion').val()==""){
				alert("¡Debe seleccionar la fecha de inscripción!");
				send = false;
			}
			else if($('#cedula_persona').val()==""){
				alert("¡Debe ingresar la cédula del estudiante!");
				send = false;
			}
			else if($('#cedula_responsable').val()==0){
				alert("¡Debe seleccionar al profesor responsable!");
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
			else if($('#fecha_nacimiento_estudiante').val()==""){
				alert("¡Debe seleccionar la fecha de nacimiento del estudiante!");
				send = false;
			}
			else if($('#lugar_nacimiento').val()==0){
				alert("¡Debe seleccionar el lugar de nacimiento del estudiante!");
				send = false;
			}
			else if($('#direccion').val()==""){
				alert("¡Debe ingresar la dirección del estudiante!");
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
				form.submit();
		}

		if(form.attr("id")=="form2"){
			var send = true;
			if($('#impedimento_deporte:checked').val()=="Y" && $('#especifique_deporte').val()==""){
				alert("¡Debe especificar el impedimento deportivo del estudiante!");
				send = false;
			}
			else if($('#practica_deporte:checked').val()=="Y" && $('#cual_deporte').val()==""){
				alert("¡Debe especificar cual deporte practica el estudiante!");
				send = false;
			}
			else if($('#tiene_beca:checked').val()=="Y" && $('#organismo').val()==""){
				alert("¡Debe indicar de que organismo tiene la beca el estudiante!");
				send = false;
			}
			else if(($('#tiene_hermanos:checked').val()=="Y" && $('#cuantas_hembras').val()=="0") && $('#tiene_hermanos:checked').val()=="Y" && $('#cuantos_varones').val()=="0"){
				alert("¡Debe indicar al menos un hermano o una hermana del estudiante!");
				send = false;
			}
			else if($('#estudian_aca:checked').val()=="Y" && $('#que_anio').val()==""){
				alert("¡Debe indicar en que año estudia(n) el(los) hermano(s) o la(s) hermana(s) del estudiante!");
				send = false;
			}
			else if($('#peso').val()==""){
				alert("¡Debe ingresar el peso del estudiante!");
				send = false;
			}
			else if($('#talla').val()==""){
				alert("¡Debe ingresar la estatura del estudiante!");
				send = false;
			}
			else if($('#tiene_talento:checked').val()=="Y" && $('#cual_talento').val()==""){
				alert("¡Debe indicar que talento posee el estudiante!");
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
				form.submit();
		}

		if(form.attr("id")=="form3"){
			var send = true;
			if($('#cedula_padre').val()!=""){
				if($('#cedula_padre').val()==""){
					alert("¡Debe ingresar la cédula del padre del estudiante!");
					send = false;
				}
				else if($('#fecha_nacimiento_padre').val()==""){
					alert("¡Debe seleccionar la fecha de nacimiento del padre del estudiante!");
					send = false;
				}
				else if($('#primer_nombre_padre').val()==""){
					alert("¡Debe ingresar el primer nombre del padre del estudiante!");
					send = false;
				}
				else if($('#primer_apellido_padre').val()==""){
					alert("¡Debe ingresar el primer apellido del padre del estudiante!");
					send = false;
				}
				
				else if($('#direccion_padre').val()==""){
					alert("¡Debe ingresar la dirección del padre del estudiante!");
					send = false;
				}
			
				/*else if($('#profesion_padre').val()==""){
					alert("¡Debe ingresar la profesión del padre!");
					send = false;
				}
				else if($('#grado_instruccion_padre').val()==""){
					alert("¡Debe ingresar el grado de instrucción del padre!");
					send = false;
				}*/
			}
			else if($('#cedula_madre').val()!=""){
				if($('#cedula_madre').val()==""){
					alert("¡Debe ingresar la cédula de la madre del estudiante!");
					send = false;
				}
				else if($('#fecha_nacimiento_madre').val()==""){
					alert("¡Debe seleccionar la fecha de nacimiento de la madre del estudiante!");
					send = false;
				}
				else if($('#primer_nombre_madre').val()==""){
					alert("¡Debe ingresar el primer nombre de la madre del estudiante!");
					send = false;
				}
				else if($('#primer_apellido_madre').val()==""){
					alert("¡Debe ingresar el primer apellido de la madre del estudiante!");
					send = false;
				}
			
				else if($('#direccion_madre').val()==""){
					alert("¡Debe ingresar la dirección de la madre del estudiante!");
					send = false;
				}
			/*
				else if($('#profesion_madre').val()==""){
					alert("¡Debe ingresar la profesión de la madre!");
					send = false;
				}
				else if($('#grado_instruccion_madre').val()==""){
					alert("¡Debe ingresar el grado de instrucción de la madre!");
					send = false;
				}*/
			}
			else{
				send = true;
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
				form.submit();
		}

		if(form.attr("id")=="form4"){
			var send = true;
			if($('#codigo_parentesco').val()==""){
				alert("¡Debe seleccionar el parentesco del representante con el estudiante!");
				send = false;
			}
			else if($('#cedula_representante').val()==""){
				alert("¡Debe ingresar la cédula del representante del estudiante!");
				send = false;
			}
	
			else if($('#primer_nombre_representante').val()==""){
				alert("¡Debe ingresar el primer nombre del representante del estudiante!");
				send = false;
			}
			else if($('#primer_apellido_representante').val()==""){
				alert("¡Debe ingresar el primer apellido del representante del estudiante!");
				send = false;
			}
			
			else if($('#direccion_representante').val()==""){
				alert("¡Debe ingresar la dirección del representante del estudiante!");
				send = false;
			}
		/*
			else if($('#profesion_representante').val()==""){
				alert("¡Debe ingresar la profesión del representante!");
				send = false;
			}
			else if($('#grado_instruccion_representante').val()==""){
				alert("¡Debe ingresar el grado de instrucción del representante!");
				send = false;
			}*/

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
				form.submit();
		}

		if(form.attr("id")=="form5"){
			var send = true;
			if($('#integracion_escuela_comunidad').val()=="5" && $('#especifique_integracion').val()==""){
				alert("¡Debe especificar en que integración escuela-comunidad puede aportar!");
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
				form.submit();
		}

		if(form.attr("id")=="form6"){
			var send = true;
			
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
				form.submit();
		}
	}

	function CambiarEstatus(valor){
		if(valor==0)
			$('#lOpt').val("Desactivar");
		else
			$('#lOpt').val("Activar");
		$('#form1').submit();
	}
}
