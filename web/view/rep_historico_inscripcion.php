<fieldset>
	<legend><center>Reporte: FICHA DE INSCRIPCIÓN</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<form class="form-horizontal" action="../excel/excel_historico_inscripcion.php" method="post" id="form1">
				<div class="row">
					<span class="control-label"> Valores a Mostrar:</span>
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
									<option value="especifique_deporte">Deporte Impedido</option>
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
					<span class="control-label"> Valores a Filtrar:</span>
				    <div class="span6">
				        <div class="row-fluid">
				            <div class="span4">
								
				            </div>
				            <div class="span4">
				                
				            </div>
				            <div class="span4">
								
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
	//	Mover Objetos
	$('.pasar').click(function() { return !$('#origen option:selected').remove().appendTo('#destino'); });  
	$('.quitar').click(function() { return !$('#destino option:selected').remove().appendTo('#origen'); });
	$('.pasartodos').click(function() { $('#origen option').each(function() { $(this).remove().appendTo('#destino'); }); });
	$('.quitartodos').click(function() { $('#destino option').each(function() { $(this).remove().appendTo('#origen'); }); });
	$('.submit').click(function() { $('#destino option').prop('selected', 'selected'); });
	//	Ordenamiento
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

		if(send==true)
			$("#form1").submit();
	})
}
</script>
<?php if(isset($_SESSION['datos'])) unset($_SESSION['datos']);?>