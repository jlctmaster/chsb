var HoraAsignado=0;
var HoraTotal=0;
var HoraLibre=0;
var indice=0;
var indice_asignado=0;

$(document).on("ready",Principal);

function cargar_hora_maxima(elegido){
	elegido1=$("#codigo_ano_academico").val();
	var parametros={"profesor":elegido,"codigo_ano_academico": elegido1,"combo":"horas"};
	$.ajax({
		data: 	parametros,
		url: 	'../controllers/control_ajax2.php',
		type: 	'post',
		success: 	function(response){
			sacar_valor=$.parseJSON(response);
			//	Campos Visibles
			$('#celdaasignado').html(sacar_valor[0].asignado);
			$('#celdalibre').html(sacar_valor[0].libre);
			$('#celdatotal').html(sacar_valor[0].total);
			//	Campos Ocultos
			$('#A').val(sacar_valor[0].asignado);
			$('#L').val(sacar_valor[0].libre);
			$('#T').val(sacar_valor[0].total);
			//	Agregar valor a las variables
			HoraAsignado=parseInt(document.getElementById("A").value);
			HoraTotal=parseInt(document.getElementById("T").value);
			HoraLibre=parseInt(document.getElementById("L").value);
		}
	});
}

function cargar_datos(){
	$("#seccion").on('change',function () {
		elegido=$(this).val();
		elegido1=$("#codigo_ano_academico").val();
		elegido2=$("#codigo_ambiente").val();
		var parametros={ "seccion": elegido,"codigo_ano_academico": elegido1,combo: "seccion", "codigo_ambiente": elegido2  } ;
		$.ajax({
			data:  parametros,
			url:   '../controllers/control_ajax2.php',
			type:  'post',
			success:  function (response) {
				sacar_valor=$.parseJSON(response);				  
				for(i=0;i<sacar_valor.length;i++){
					datos=sacar_valor[i].celda+"*"+sacar_valor[i].seccion+"*"+sacar_valor[i].codigo_ambiente+"*"+sacar_valor[i].materia+"*"+sacar_valor[i].profesor;				   
					campo="<input type='hidden' name='contenidos[]' id='"+sacar_valor[i].celda+"_vo'  value='"+datos+"'/>";
					dia=Array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
					datos_img="Dia: "+dia[sacar_valor[i].dia]+"<br>Hora: "+sacar_valor[i].hora+"<br>Materia: "+sacar_valor[i].nombre_materia+"<br>Prof: "+sacar_valor[i].nombre+" "+sacar_valor[i].apellido+"<br>Aula: "+sacar_valor[i].nombre_ambiente;
					var img="<img src='../images/marca.png' alt='"+datos_img+"'/>";
					$("#"+sacar_valor[i].celda).removeAttr('class').html('').html('Asignado').addClass("asignado").append(campo).append(img);
				}
				//var campo="<input type='hidden' name='contenidos[]' id='"+celda.prop('id')+"_vo'  value='"+valor+"'/>";
				//celda.append(campo);
			}
		});

		if($(this).val()=="null" || $(this).val()==""){
			$("#codigo_materia").html("<option value='null'>Elige una opcion...</option>").attr("disabled","disabled");
			$("#cedula_persona > option[value='']").attr("selected",true);       				
			$("#cedula_persona").prop("disabled","disabled");
		}else{
			$("#codigo_materia > option[value='']").attr("selected",true);       
			$("#codigo_materia").attr("disabled",false);
		}
		$("#seccion option:selected").each(function () {
			elegido=$(this).val();
			$.post("../controllers/control_ajax.php", { elegido: elegido,combo: "seccion" }, function(data){
			$("#codigo_materia").html(data);
			});
		});
	});    	

}

function cargar_datos_celda(){
	$("#codigo_ambiente").on('change',function () {
		$("#tb_horario tr td[id]").each(function(i){
			if($(this).attr("class")!="weekend_noche")
				$(this).html('').removeAttr('class'); 
		});
		if(!($(this).val()=="null" || $(this).val()=="")){
			$("#seccion").prop("disabled","");
			$("#codigo_ambiente option:selected").each(function () {
				elegido=$(this).val();
				elegido1=$("#codigo_ano_academico").val();
				var parametros={ "codigo_ambiente": elegido,"codigo_ano_academico": elegido1,combo: "codigo_ambiente" } ;
				$.ajax({
					data:  parametros,
					url:   '../controllers/control_ajax2.php',
					type:  'POST',
					success:  function (response) {
						sacar_valor=$.parseJSON(response);
						for(i=0;i<sacar_valor.length;i++)
							$("#"+sacar_valor[i].celda).removeAttr('class').addClass("h_academica");
					}
				});
				//$('#resultados').text(JSON.stringify(datos, null, 4));
				//$('#respuesta').text(datos.respuesta).fadeIn('slow');   
				//$.post("../controllers/control_ajax2.php", { "codigo_ambiente": elegido,"codigo_ano_academico": elegido1,combo: "codigo_ambiente" },
				// function(data){
				//  });			
			});
		}else{
			$("#seccion").prop("disabled","disabled");
			$("#cedula_persona").prop("disabled","disabled");
			$("#codigo_materia").prop("disabled","disabled");
			$("#cedula_persona").val("");
			$("#codigo_materia > option[value='']").attr("selected",true); 
			$("#seccion > option[value='']").attr("selected",true);                    
			alert('debe seleccionar un Ambiente');
		}
	});    	

}

function Principal(){
	cargar_datos();
	cargar_datos_celda();
	$("td[id]").live("click",Seleccionar);
	$("td[class=asignado]").live("dblclick",ExtraerDatos);
	$("td[class=seleccionado]").live("click",desactivar);
	$("td[class=asignado] img").live("click",mostrar_alt);
	$("#btaceptar").live("click",Enviar);
	$("#ok").on("click",celdaID);
	$("#tb_horario").live("click",function(){
		indice_asignado=$("td.seleccionado").size();
	});
	$("#btaceptar").on("mouseover",function(){
		$(this).prop("src","../images/add_hover.png")
	});
	$("#btaceptar").on("mouseout",function(){
		$(this).prop("src","../images/add.png")
	});

	$("#codigo_materia").on('change',function (){
		if(!($(this).val()=="null" ||$(this).val()=="")){
			$("#cedula_persona").prop("disabled","");
		}else{
			$("#cedula_persona > option[value='']").attr("selected",true);       
			$("#cedula_persona").prop("disabled","disabled");
		}
	});			  	

	$('#btnGuardar').on("click",function(){
		var send = true;
		var contenido = document.getElementsByName('contenidos[]');
		if(contenido.length==0){
			alert('Debe seleccionar al menos un bloque de hora');
			send=false;
		}

		if(send==true){
			$('#form1').submit();
		}
	});

	//Búsquedas del docente por autocompletar.
	$('#cedula_persona').autocomplete({
		source:'../autocomplete/docente_horario.php', 
		minLength:1,
		select: function (event, ui){
			docente=ui.item.value;
			docente=docente.split('_');
			cargar_hora_maxima(docente[0]);
		}
	});
}

function mostrar_alt(){
	valor=$(this).prop('alt');
	alert(valor);
}

function desactivar(){
	if($(this).attr('class')=='seleccionado'){
		HoraAsignado--;
		HoraLibre++;
		$("#celdalibre").html(HoraLibre);
		$("#celdaasignado").html(HoraAsignado);
		$($(this)).removeAttr('class');		  
	}
}

function celdaID(){
	var dataforms=document.getElementById("ventana");
	div=document.createElement('div');
	div.innerHTML=dataforms.innerHTML;
}

function Seleccionar(){
	if($(this).attr('class')==undefined){
		if(HoraTotal>HoraAsignado){
			HoraAsignado++;
			HoraLibre--;
			$(this).removeClass($(this).attr('class')).addClass("seleccionado");
			$("#celdalibre").html(HoraLibre);
			$("#celdaasignado").html(HoraAsignado);
		}else{
			alert("<font style='color:red'>No puede selecciona m&#225;s "+indice_asignado+"/"+document.getElementById("L").value+"</font>");
		}
	}
}

function ExtraerDatos(){ 
	$(this).removeClass('asignado');
	$(this).removeAttr('title');
	$(this).removeAttr('class');
	id=$(this).prop('id')+'_vo';
	$("#"+id).remove();
	this.innerHTML='';
	HoraAsignado--;
	HoraLibre++;
	$("#celdalibre").html(HoraLibre);
	$("#celdaasignado").html(HoraAsignado);
}

function Enviar(){
	amb=$("#codigo_ambiente").val();
	sec=$("#seccion").val();
	pro=$("#cedula_persona").val();
	mat=$("#codigo_materia").val();
	error=false;
	mensaje="Falta por completar los siguiente campo: ";          
	if(amb==""){
		mensaje=mensaje+"Ambiente   ";
		error=true;
	}
	if(sec==""){
		mensaje=mensaje+"Seccion    ";
		$error=true;
	}	
	if(pro==""){
		mensaje=mensaje+"Profesor   ";
		error=true;
	}		  
	if(mat==""){
		mensaje=mensaje+"Materia    ";
		error=true;
	}
	if(error==true){
		alert(mensaje) 	
	}else{       	
		var datos;
		$("td[class=seleccionado]").each(function(i){ 
			$(this).text("Asignado");
			$(this).addClass("asignado");
			$(this).removeClass("seleccionado");
			datos_profesor=$("#cedula_persona").val().split('_');
			profesor=datos_profesor[0];
			datos=$(this).prop("id")+"*"+$("#seccion option:selected").val()+"*"+$("#codigo_ambiente option:selected").val()+"*"+$("#codigo_materia").val()+"*"+profesor;				   
			dia=Array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
			x=$(this).prop("id").split('-');
			eldia=dia[x[1]];
			var iii = $("#codigo_ambiente option:selected").text();
			datos_img="Dia: "+eldia+"<br>Hora: "+$(this).prop('title')+"<br>Materia: "+ 
			$("#codigo_materia option:selected").text()+"<br>Prof: "+$("#cedula_persona").val()+"<br>Aula: "+iii;
			if(validar_profesor_horario($(this).prop("id"),profesor))				   
				anadir_contenido($(this),datos,datos_img);
		});
	}
}

function validar_profesor_horario(celda,profesor){
	var is_ok=true;
	elegido1=$("#codigo_ano_academico").val();
	var parametros={ "codigo_ano_academico": elegido1,"profesor": profesor,"celda": celda, "combo": "profesor"  } ;       
	$.ajax({
		data:  parametros,
		url:   '../controllers/control_ajax2.php',
		type:  'post',
		success:  function (response){
			sacar_valor=$.parseJSON(response);
			if(!sacar_valor)
				sacar_valor=0;		  
			if(sacar_valor.length > 0){
				is_ok=false;
				for(i=0;i<sacar_valor.length;i++){
					alert(sacar_valor[0].nombre+' '+ sacar_valor[0].apellido );
				}
			}
		}
	});
	return is_ok;
}               

function anadir_contenido(celda,valor,datos_img){
	var campo="<input type='hidden' name='contenidos[]' id='"+celda.prop('id')+"_vo'  value='"+valor+"'/>";
	var img="<img src='../images/marca.png' alt='"+datos_img+"'/>";
	celda.append(campo);
	celda.append(img);
	indice++;
}

function validar(){
	if(HoraLibre==0 && HoraTotal==HoraAsignado && indice_asignado==0){
		return true;
	}else if(HoraLibre==0 && indice_asignado>0){
		if(indice_asignado>1){ pl='as';nv=indice_asignado; }else{ pl='a';nv="";}
		alert("<font style='color:red'>Debe agregar contenido a l"+pl+" "+nv+" celd"+pl+" seleccionad"+pl+"!</font>");
		return false;			
	}else{
		alert("<font style='color:red'>Completar todas las horas! "+HoraAsignado+"/"+HoraTotal+"</font>");
		return false;
	}
	//return false;
}

