<fieldset>
	<legend><center>Reporte: FICHA DE INSCRIPCIÓN</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<form class="form-horizontal" action="../excel/excel_historico_inscripcion.php" method="post" id="form1">
				<div class="row">
					<label class="control-label"> Valores a Mostrar:</label>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span4">
								<select name="origen[]" id="origen" multiple="multiple" size="8">
									<option value="fecha_inscripcion">Fecha de Inscripción</option>
									<option value="ano_academico">Año Académico</option>
									<option value="responsable">Docente Resp.</option>
									<option value="estudiante">Estudiante</option>
									<option value="cedula_estudiante">Cédula Estudiante</option>
									<option value="sexo">Género</option>
									<option value="fecha_nacimiento">Fecha de Nacimiento</option>
									<option value="edad">Edad</option>
									<option value="lugar_nacimiento">Lugar de Nacimiento</option>
									<option value="entidad_federal">Entidad Federal</option>
									<option value="direccion">Dirección</option>
									<option value="anio_a_cursar">Año a Cursar</option>
									<option value="coordinacion_pedagogica">Coordinación Pedagógica</option>
									<option value="telefono_local">Teléfono Local</option>
									<option value="estado_salud">Estado de Salud</option>
									<option value="alergico">Alérgico</option>
									<option value="estudiante_regular">Estudiante Regular</option>
									<option value="procedencia">Procedencia</option>
									<option value="cual_materia">Materia</option>
									<option value="practica_deporte">Practica Deporte</option>
									<option value="impedimento_deporte">Impedimento Deportivo</option>
									<option value="especifique_deporte">Impedimento</option>
									<option value="materia_pendiente">Materia Pendiente</option>
									<option value="cual_deporte">Deporte</option>
									<option value="tiene_beca">Posee Beca</option>
									<option value="organismo">Organismo Becario</option>
									<option value="tiene_hermanos">Hermanos</option>
									<option value="cuantas_hembras">Cuantas Hembras</option>
									<option value="cuantos_varones">Cuantos Varones</option>
									<option value="estudian_aca">Estudian Acá</option>
									<option value="que_anio">Años que Cursan</option>
									<option value="peso">Peso</option>
									<option value="talla">Estatura</option>
									<option value="indice">Indice Corporal</option>
									<option value="tiene_talento">Con Talento</option>
									<option value="cual_talento">Talento</option>
									<option value="padre">Padre</option>
									<option value="fecha_nacimiento_padre">F.Nac. Padre</option>
									<option value="cedula_padre">Cédula Padre</option>
									<option value="profesion_padre">Profesión del Padre</option>
									<option value="grado_instruccion_padre">Grado de Inst. Padre</option>
									<option value="direccion_padre">Dirección del Padre</option>
									<option value="telefono_local_padre">Tlf. Local del Padre</option>
									<option value="madre">Madre</option>
									<option value="fecha_nacimiento_madre">F.Nac. Madre</option>
									<option value="cedula_madre">Cédula Madre</option>
									<option value="profesion_madre">Profesión Madre</option>
									<option value="grado_instruccion_madre">Grado Inst. Madre</option>
									<option value="direccion_madre">Dirección de la Madre</option>
									<option value="telefono_local_madre">Tlf. Local de la Madre</option>
									<option value="representante">Representante</option>
									<option value="fecha_nacimiento_madre">F.Nac. Representante</option>
									<option value="cedula_representante">Cédula Representante</option>
									<option value="profesion_representante">Profesión Representante</option>
									<option value="grado_instruccion_representante">Grado Inst. Representante</option>
									<option value="direccion_representante">Dirección Representante</option>
									<option value="telefono_local_representante">Tlf. Local del Representante</option>
									<option value="Parentesco">Parentesco</option>
									<option value="nombre_seccion">Sección</option>
									<option value="observacion">Observación</option>
									<option value="estatus">Estatus</option>
								</select>
				            </div>
				            <div class="span4">
				                <input type="button" class="pasar izq" value="Pasar »"><input type="button" class="quitar der" value="« Quitar"><br />
								<input type="button" class="pasartodos izq" value="Todos »"><input type="button" class="quitartodos der" value="« Todos">
				            </div>
				            <div class="span4">
				            	<input type="hidden" name="campos[]" id="campos">
				            	<input type="hidden" name="etiquetas[]" id="etiquetas">
								<select name="destino[]" id="destino" multiple="multiple" size="8">
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="row">
					<label class="control-label"> Valores a Filtrar:</label>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span6">
				            	<span class="control-label"> Fecha de Inscripción Desde:</span>
				                <input class="span12" type="text" name="fid" id="fid" readonly /> 
				            </div>
				            <div class="span6">
				            	<span class="control-label"> Fecha de Inscripción Hasta:</span>
								<input class="span12" type="text" name="fih" id="fih" readonly /> 
				            </div>
				        </div>
				    </div>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span6">
				            	<span class="control-label"> Año Académico:</span>
				                <select class="bootstrap-select span12" title="Seleccione un Año" name='codigo_ano_academico' id='codigo_ano_academico' >
									<option value=0>Seleccione un Año</option>
									<?php
									$pgsql = new Conexion();
									$sql = "SELECT * FROM educacion.tano_academico ORDER BY ano ASC";
									$query = $pgsql->Ejecutar($sql);
									while($row=$pgsql->Respuesta($query)){
										echo "<option value=".$row['codigo_ano_academico'].">".$row['ano']."</option>";
									}
									?>
								</select>
				            </div>
				            <div class="span6">
						        <span class="control-label">Docente Responsable:</span>
					            <input class="span12" type="text" name="cedula_responsable" id="cedula_responsable" onKeyUp="this.value=this.value.toUpperCase()" /> 
				            </div>
				        </div>
				    </div>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span6">
				            	<span class="control-label"> Fecha de Nacimiento del Est. Desde:</span>
				                <input class="span12" type="text" name="fnd" id="fnd" readonly /> 
				            </div>
				            <div class="span6">
				            	<span class="control-label"> Fecha de Nacimiento del Est. Hasta:</span>
								<input class="span12" type="text" name="fnh" id="fnh" readonly /> 
				            </div>
				        </div>
				    </div>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span6">
						        <span class="control-label">Género:</span>
				                <select class="bootstrap-select span12" name="sexo" id="sexo" title="Seleccione un Género">
				                	<option value="0">Ambos</option>
				                	<option value="F">Femenino</option>
				                	<option value="M">Masculino</option>
				                </select>
				            </div>
				            <div class="span6">
				            	<span class="control-label">Lugar de Nacimiento:</span>
								<input class="span12" title="Seleccione el Lugar de Nacimiento" onKeyUp="this.value=this.value.toUpperCase()" name="lugar_nacimiento" id="lugar_nacimiento" type="text" />
				            </div>
				        </div>
				    </div>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span6">
						        <span class="control-label">Año a Cursar:</span>
				                <div class="radios">
									<input type="checkbox" name="anio_a_cursar[]" id="anio_a_cursar" value="1" /> 1ero
									<input type="checkbox" name="anio_a_cursar[]" id="anio_a_cursar" value="2" /> 2do
									<input type="checkbox" name="anio_a_cursar[]" id="anio_a_cursar" value="3" /> 3ero
									<input type="checkbox" name="anio_a_cursar[]" id="anio_a_cursar" value="4" /> 4to
									<input type="checkbox" name="anio_a_cursar[]" id="anio_a_cursar" value="5" /> 5to
								</div>
				            </div>
				            <div class="span6">
				            	<span class="control-label">Coordinación Pedagógica N°:</span>
				                <div class="radios">
									<input type="checkbox" name="coordinacion_pedagogica[]" id="coordinacion_pedagogica" value="1" /> 1
									<input type="checkbox" name="coordinacion_pedagogica[]" id="coordinacion_pedagogica" value="2" /> 2
									<input type="checkbox" name="coordinacion_pedagogica[]" id="coordinacion_pedagogica" value="3" /> 3
									<input type="checkbox" name="coordinacion_pedagogica[]" id="coordinacion_pedagogica" value="4" /> 4
									<input type="checkbox" name="coordinacion_pedagogica[]" id="coordinacion_pedagogica" value="5" /> 5
								</div>
				            </div>
				        </div>
				    </div>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span6">
						        <span class="control-label">Estado de Salud:</span>
				                <div class="radios">
									<input type="checkbox" name="estado_salud[]" id="estado_salud" value="1" /> Excelente
									<input type="checkbox" name="estado_salud[]" id="estado_salud" value="2" /> Bueno
									<input type="checkbox" name="estado_salud[]" id="estado_salud" value="3" /> Regular
								</div>
				            </div>
				            <div class="span6">
				            	<span class="control-label">Alérgico(a):</span>
				                <div class="radios">
									<input type="checkbox" name="alergico[]" id="alergico" value="Y" /> Sí
									<input type="checkbox" name="alergico[]" id="alergico" value="N" /> No
								</div>
				            </div>
				        </div>
				    </div>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span6">
						        <span class="control-label">Estudiante Regular:</span>
				                <div class="radios">
									<input type="checkbox" name="estudiante_regular[]" id="estudiante_regular" value="Y" /> Sí
									<input type="checkbox" name="estudiante_regular[]" id="estudiante_regular" value="N" /> No
								</div>
				            </div>
				            <div class="span6">
				            	<span class="control-label">Procedencia:</span>
				            	<input class="span12" title="Ingrese el nombre de la escuela de la cual proviene el estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="procedencia" id="procedencia" type="text" />
				            </div>
				        </div>
				    </div>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span6">
						        <span class="control-label">Materia Pendientes:</span>
				                <div class="radios">
									<input type="checkbox" name="materia_pendiente[]" id="materia_pendiente" value="Y" /> Sí
									<input type="checkbox" name="materia_pendiente[]" id="materia_pendiente" value="N" /> No
								</div>
				            </div>
				            <div class="span6">
				            	<span class="control-label">Materia:</span>
				            	<input class="span12" title="Ingrese el nombre de las materias que tiene pendiente" onKeyUp="this.value=this.value.toUpperCase()" name="cual_materia" id="cual_materia" type="text" />
				            </div>
				        </div>
				    </div>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span6">
						        <span class="control-label">Impedimento Deportivo:</span>
				                <div class="radios">
									<input type="checkbox" name="impedimento_deporte[]" id="impedimento_deporte" value="Y" /> Sí
									<input type="checkbox" name="impedimento_deporte[]" id="impedimento_deporte" value="N" /> No
								</div>
				            </div>
				            <div class="span6">
				            	<span class="control-label">Impedimento:</span>
				            	<input class="span12" title="Ingrese su impedimento deportivo" onKeyUp="this.value=this.value.toUpperCase()" name="especifique_deporte" id="especifique_deporte" type="text" />
				            </div>
				        </div>
				    </div>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span6">
						        <span class="control-label">Practica Deporte:</span>
				                <div class="radios">
									<input type="checkbox" name="practica_deporte[]" id="practica_deporte" value="Y" /> Sí
									<input type="checkbox" name="practica_deporte[]" id="practica_deporte" value="N" /> No
								</div>
				            </div>
				            <div class="span6">
				            	<span class="control-label">Deporte:</span>
				            	<input class="span12" title="Ingrese el nombre del deporte que practica" onKeyUp="this.value=this.value.toUpperCase()" name="cual_deporte" id="cual_deporte" type="text" />
				            </div>
				        </div>
				    </div>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span6">
						        <span class="control-label">Becado:</span>
				                <div class="radios">
									<input type="checkbox" name="tiene_beca[]" id="tiene_beca" value="Y" /> Sí
									<input type="checkbox" name="tiene_beca[]" id="tiene_beca" value="N" /> No
								</div>
				            </div>
				            <div class="span6">
				            	<span class="control-label">Organismo:</span>
				            	<input class="span12" title="Ingrese el nombre del organismo" onKeyUp="this.value=this.value.toUpperCase()" name="organismo" id="organismo" type="text" />
				            </div>
				        </div>
				    </div>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span6">
						        <span class="control-label">Sus hermanos estudian acá:</span>
				                <div class="radios">
									<input type="checkbox" name="estudian_aca[]" id="estudian_aca" value="Y" /> Sí
									<input type="checkbox" name="estudian_aca[]" id="estudian_aca" value="N" /> No
								</div>
				            </div>
				            <div class="span6">
				            	<span class="control-label">Año Escolar donde estudian:</span>
				            	<input class="span12" title="Ingrese los años que estudian sus hermanos(as)" onKeyUp="this.value=this.value.toUpperCase()" name="que_anio" id="que_anio" type="text" />
				            </div>
				        </div>
				    </div>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span6">
						        <span class="control-label">Peso del Estudiante Desde:</span>
				                <input class="span12" title="Ingrese el número de kilogramos que pesa" maxlength=4 onKeyPress="return isNumberKey(event)" name="pesod" id="pesod" type="text" />
				            </div>
				            <div class="span6">
				            	<span class="control-label">Peso del Estudiante Hasta:</span>
				            	<input class="span12" title="Ingrese el número de kilogramos que pesa" maxlength=4 onKeyPress="return isNumberKey(event)" name="pesoh" id="pesoh" type="text" />
				            </div>
				        </div>
				    </div>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span6">
						        <span class="control-label">Estatura del Estudiante Desde:</span>
				                <input class="span12" title="Ingrese el número de estatura en centimétros que mide" maxlength=6 onKeyPress="return isNumberKey(event)" name="tallad" id="tallad" type="text" />
				            </div>
				            <div class="span6">
				            	<span class="control-label">Estatura del Estudiante Hasta:</span>
				            	<input class="span12" title="Ingrese el número de estatura en centimétros que mide" maxlength=6 onKeyPress="return isNumberKey(event)" name="tallah" id="tallah" type="text" />
				            </div>
				        </div>
				    </div>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span6">
						        <span class="control-label">Indice Corporal del Est. Desde:</span>
				                <input class="span12" title="Ingrese el número del indice corporal del estudiante" maxlength=6 onKeyPress="return isNumberKey(event)" name="indiced" id="indiced" type="text" />
				            </div>
				            <div class="span6">
				            	<span class="control-label">Indice Corporal del Est. Hasta:</span>
				            	<input class="span12" title="Ingrese el número del indice corporal del estudiante" maxlength=6 onKeyPress="return isNumberKey(event)" name="indiceh" id="indiceh" type="text" />
				            </div>
				        </div>
				    </div>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span6">
						        <span class="control-label">Posee Habilidades/Talento:</span>
				                <div class="radios">
									<input type="checkbox" name="tiene_talento[]" id="tiene_talento" value="Y" /> Sí
									<input type="checkbox" name="tiene_talento[]" id="tiene_talento" value="N" /> No
								</div>
				            </div>
				            <div class="span6">
				            	<span class="control-label">Habilidad/Talento:</span>
				            	<input class="span12" title="Ingrese el nombre de la habilidad o talento que posee" onKeyUp="this.value=this.value.toUpperCase()" name="cual_talento" id="cual_talento" type="text" />
				            </div>
				        </div>
				    </div>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span6">
						        <span class="control-label">Sección Desde:</span>
				                <select class="bootstrap-select span12" title="Seleccione una Sección" name='seccion_desde' id='seccion_desde' >
									<option value=0> Seleccione una Sección</option>
									<?php
										$pgsql = new Conexion();
										$sql = "SELECT seccion,nombre_seccion 
										FROM educacion.tseccion 
										ORDER BY seccion ASC";
										$query = $pgsql->Ejecutar($sql);
										while($row=$pgsql->Respuesta($query)){
											echo "<option value=".$row['seccion'].">".$row['nombre_seccion']."</option>";
										}
									?>
								</select>
				            </div>
				            <div class="span6">
				            	<span class="control-label">Sección Hasta:</span>
				            	 <select class="bootstrap-select span12" title="Seleccione una Sección" name='seccion_hasta' id='seccion_hasta' >
									<option value=0>Seleccione una Sección</option>
									<?php
										$pgsql = new Conexion();
										$sql = "SELECT seccion,nombre_seccion 
										FROM educacion.tseccion 
										ORDER BY seccion ASC";
										$query = $pgsql->Ejecutar($sql);
										while($row=$pgsql->Respuesta($query)){
											echo "<option value=".$row['seccion'].">".$row['nombre_seccion']."</option>";
										}
									?>
								</select>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Generar Reporte</button>
				</div>
			</form>
		</div>
	</div>
</fieldset>
<style type="text/css">
	.row > [class*="span"] {
		display: inline;
		margin-left: 10%;
	}
</style>
<script type="text/javascript">
$(document).ready(init);
function init(){
    //Agregar Objeto Calendario al input fecha_inscripcion_desde.
    $('#fid').datepicker({
        showOn: 'both',
        numberOfMonths: 1,
        buttonImage: '../images/calendario.png',
        buttonImageOnly: true
    });
    //Agregar Objeto Calendario al input fecha_inscripcion_hasta.
    $('#fih').datepicker({
        showOn: 'both',
        numberOfMonths: 1,
        buttonImage: '../images/calendario.png',
        buttonImageOnly: true
    });
    //Agregar Objeto Calendario al input fecha_nacimiento_desde.
    $('#fnd').datepicker({
        showOn: 'both',
        numberOfMonths: 1,
        buttonImage: '../images/calendario.png',
        buttonImageOnly: true
    });
    //Agregar Objeto Calendario al input fecha_nacimiento_hasta.
    $('#fnh').datepicker({
        showOn: 'both',
        numberOfMonths: 1,
        buttonImage: '../images/calendario.png',
        buttonImageOnly: true
    });
	//Búsquedas del representante por autocompletar.
	$('#cedula_responsable').autocomplete({
		source:'../autocomplete/docente_horario.php', 
		minLength:1
	});
	//Búsquedas de las parroquias por autocompletar.
	$('#lugar_nacimiento').autocomplete({
		source:'../autocomplete/parroquia.php', 
		minLength:1
	});
	//	Mover Objetos
	$('.pasar').click(function() { return !$('#origen option:selected').remove().appendTo('#destino'); });  
	$('.quitar').click(function() { return !$('#destino option:selected').remove().appendTo('#origen'); });
	$('.pasartodos').click(function() { $('#origen option').each(function() { $(this).remove().appendTo('#destino'); }); });
	$('.quitartodos').click(function() { $('#destino option').each(function() { $(this).remove().appendTo('#origen'); }); });
	$('.submit').click(function() { $('#destino option').prop('selected', 'selected'); });
	//	Validaciones
	$('#btnGuardar').click(function(){
		var send = true;
		var realvalues = [];
		var textvalues = [];
		$('#destino option').each(function(i, selected) {
		    realvalues[i] = $(selected).val();
		    textvalues[i] = $(selected).text();
		});
		
		$('#campos').val(realvalues);
		$('#etiquetas').val(textvalues);

		if(realvalues.length==0){
			alert("¡Debe seleccionar al menos un valor a mostrar!");
			send=false;
		}

		if(send==true)
			$("#form1").submit();
	})
}
</script>