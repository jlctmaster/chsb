<script type="text/javascript" src="js/chsb_proceso_inscripcion.js"></script>
<?php
	require_once("../class/class_perfil.php");
	require_once('../class/class_bd.php');
	$perfil=new Perfil();
	$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
	$perfil->url('proceso_inscripcion');
	$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
	if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
		require_once('../class/class_bd.php'); 
		$pgsql=new Conexion();
		$sql = "SELECT pi.codigo_proceso_inscripcion,pi.cedula_persona,INITCAP(est.primer_nombre)||' '||INITCAP(est.primer_apellido) nombre,
		TO_CHAR(pi.fecha_inscripcion,'DD/MM/YYYY') fecha_inscripcion,CASE pi.anio_a_cursar WHEN '1' THEN '1ER AÑO' WHEN '2' THEN '2DO AÑO' 
		WHEN '3' THEN '3ER AÑO' WHEN '4' THEN '4TO AÑO' ELSE '5TO AÑO' END AS anio_a_cursar
		FROM educacion.tproceso_inscripcion pi 
		INNER JOIN general.tpersona est ON pi.cedula_persona = est.cedula_persona";
		$consulta = $pgsql->Ejecutar($sql);
?>
	<fieldset>
		<legend><center>Vista: PROCESO DE INSCRIPCIÓN</center></legend>		
		<div id="paginador" class="enjoy-css"> 
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código</th>
							<th>Cédula Estudiante</th>
							<th>Nombre y Apellido</th>
							<th>Fecha Inscripción</th>
							<th>Grado Académico</th>
							<?php
							for($x=0;$x<count($a);$x++){
								if($a[$x]['orden']=='2' || $a[$x]['orden']=='5')
									echo '<th>'.$a[$x]['nombre_opcion'].'</th>';
							}
							?>
						</tr>
					</thead>
					<tbody>
						<?php
							while ($filas = $pgsql->Respuesta($consulta))
							{
								echo '<tr>';
								echo '<td>'.$filas['codigo_proceso_inscripcion'].'</td>';
								echo '<td>'.$filas['cedula_persona'].'</td>';
								echo '<td>'.$filas['nombre'].'</td>';
								echo '<td>'.$filas['fecha_inscripcion'].'</td>';
								echo '<td>'.$filas['anio_a_cursar'].'</td>';
								for($x=0;$x<count($a);$x++){
									if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
										echo '<td><a href="?proceso_inscripcion&Opt=3&codigo_proceso_inscripcion='.$filas['codigo_proceso_inscripcion'].'#tab-datosestudiantes" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
									else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
										echo '<td><a href="?proceso_inscripcion&Opt=4&codigo_proceso_inscripcion='.$filas['codigo_proceso_inscripcion'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
								}
								echo "</tr>";
							}
						?>
					<tbody>
				</table>
				<center>
					<?php
						for($x=0;$x<count($a);$x++)
							if($a[$x]['orden']=='1')
								echo '<a href="?proceso_inscripcion&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
					?>
					<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>

				</center>

				<div id="Imprimir" style="display:none;">
					<span>Descargar Como:</span>
					<br/><br/>
					<a href="<?php echo  '../pdf/pdf_proceso_inscripcion.php';?>" target="_blank"> <img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"> </a>
					&nbsp;&nbsp;
					<a href="../excel/excel_proceso_inscripcion.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
			    </div>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
	} // Fin Ventana Principal
	else if($_GET['Opt']=="2"){ // Ventana de Registro
		$pgsql=new Conexion();
		$sql="SELECT i.codigo_inscripcion,INITCAP(p.descripcion) descripcion,TO_CHAR(p.fecha_inicio,'DD/MM/YYYY') fecha_inicio,
		TO_CHAR(p.fecha_fin,'DD/MM/YYYY') fecha_fin,TO_CHAR(i.fecha_cierre,'DD/MM/YYYY') fecha_cierre, 
		EXTRACT(day from NOW()-i.fecha_cierre) AS dias_restantes 
		FROM educacion.tinscripcion i
		INNER JOIN educacion.tperiodo p ON i.codigo_periodo = p.codigo_periodo AND p.esinscripcion =  'Y'
		WHERE i.estatus = '1' AND i.cerrado='N'";
		$query = $pgsql->Ejecutar($sql);
		$fila=$pgsql->Respuesta($query);
	?>
	<fieldset id="PInscripcion">
		<legend><center>PROCESO DE INSCRIPCIÓN</center></legend>
		<!-- Remover aqui para activar validación para limitar el formulario cuando haya finalizado el periodo de inscripción
		<?php
			if($fila['dias_restantes']>0){
		?>	
		<div id="paginador" class="enjoy-css">
			<span style='font-weight: bold;'>¡Lo sentimos, el Proceso de Inscripción ya ha Culminado!</span>
			<div class="form-actions">
				<a href="?proceso_inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
			</div>
		</div>
		<?php
			}else{
		?>
		Remover aqui	-->
		<div id="rootwizard" class="tabbable tabs-left">
			<ul class="nav nav-tabs">
			  	<li class="active"><a href="#tab-datosestudiantes" data-toggle="tab" id="tab1">Datos del <br>Estudiante</a></li>
				<li><a href="#tab-condicionestudiante" data-toggle="tab" id="tab2">Condición del <br>Estudiante</a></li>
				<li><a href="#tab-antecedentesfamiliares" data-toggle="tab" id="tab3">Antecedentes <br>Familiares</a></li>
				<li><a href="#tab-datosrepresentante" data-toggle="tab" id="tab4">Datos Rep. Legal</a></li>
				<li><a href="#tab-integracionec" data-toggle="tab" id="tab5">Integración <br>Escuela-Comunidad</a></li>
				<li><a href="#tab-documentos" data-toggle="tab" id="tab5">Documentos Consignados</a></li>
			</ul>
			<div class="tab-content">
			    <div class="tab-pane active in" id="tab-datosestudiantes">
			    	<form class="form-horizontal" action="../controllers/control_proceso_inscripcion.php" method="post" id="form1">  
						<fieldset>
							<div id="paginador" class="enjoy-css"> 
								<input type="hidden" name="lOpt" id="lOpt" value="Registrar_Paso1">
								<span style='font-weight: bold;'><?=$fila['descripcion']?> (Fecha de Inicio: </span><?=$fila['fecha_inicio']?><span style='font-weight: bold;'> Fecha de Culminación: </span><?=$fila['fecha_fin']?><span style='font-weight: bold;'> Fecha Máxima: </span><?=$fila['fecha_cierre']?><span style='font-weight: bold;'> )</span>
								<input type='hidden' name='codigo_inscripcion' id='codigo_inscripcion' value='<?=$fila['codigo_inscripcion']?>' />
								<input type='hidden' name='fecha_inicio' id='fecha_inicio_ins' value='<?=$fila['fecha_inicio']?>' />
								<input type='hidden' name='fecha_cierre' id='fecha_fin_ins' value='<?=$fila['fecha_cierre']?>' /><br><br>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Fecha Inscripción:</label>
								                <input class="span12" type="text" name="fecha_inscripcion" id="fecha_inscripcion" readonly required /> 
								            </div>
								            <div class="span6">
								                <label class="control-label">Año Académico:</label>
								                <?php
												$pgsql=new Conexion();
												$sql="SELECT * FROM educacion.tano_academico WHERE estatus = '1' AND cerrado = 'N'";
												$query = $pgsql->Ejecutar($sql);
												while($row=$pgsql->Respuesta($query)){
													echo "<input type='hidden' name='codigo_ano_academico' id='codigo_ano_academico' value='".$row['codigo_ano_academico']."' />";
													echo "<input class='span12' type='text' name='ano_academico' id='ano_academico' value='".$row['ano']."' readonly required />";
												}
								                ?>
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Cédula Estudiante:</label>
								                <input class="span12" type="text" name="cedula_persona" id="cedula_persona" onKeyPress="return isRif(event,this.value)" onKeyUp="this.value=this.value.toUpperCase()" maxlength=12 required /> 
								            </div>
								            <div class="span6">
								            	<label class="control-label">Docente Responsable</label>
							            		<input class="span12" type="text" name="cedula_responsable" id="cedula_responsable" onKeyUp="this.value=this.value.toUpperCase()" /> 
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Primer Nombre:</label>
								                <input class="span12" title="Ingrese el primer nombre del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="primer_nombre" id="primer_nombre" type="text" required />
								            </div>
								            <div class="span6">
								                <label class="control-label">Segundo Nombre:</label>
								                <input class="span12" title="Ingrese el segundo nombre del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_nombre" id="segundo_nombre" type="text" />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Primer Apellido:</label>
								                <input class="span12" title="Ingrese el primer apellido del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="primer_apellido" id="primer_apellido" type="text" required />
								            </div>
								            <div class="span6">
								                <label class="control-label">Segundo Apellido:</label>
								                <input class="span12" title="Ingrese el segundo apellido del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_apellido" id="segundo_apellido" type="text" />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Género:</label>
								                <div class="radios">
													<input type="radio" name="sexo" id="sexo" value="F" checked="checked" required /> Femenino
													<input type="radio" name="sexo" id="sexo" value="M" required /> Masculino
												</div>
								            </div>
								            <div class="span6">
								                <label class="control-label">Fecha de Nacimiento:</label>
								                <input class="span12" title="Ingrese la fecha de nacimiento del estudiante" name="fecha_nacimiento_estudiante" id="fecha_nacimiento_estudiante" type="text" readonly required />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Lugar de Nacimiento:</label>
								                <input class="span12" title="Seleccione el Lugar de Nacimiento" onKeyUp="this.value=this.value.toUpperCase()" name="lugar_nacimiento" id="lugar_nacimiento" type="text" required />
								            </div>
								            <div class="span6">
								            	<label class="control-label">Dirección:</label>
								            	<textarea class="span12" title="Ingrese la direccion de la persona" onKeyUp="this.value=this.value.toUpperCase()" name="direccion" id="direccion" required ></textarea>
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Teléfono Local:</label>
								                <input class="span12" title="Ingrese el número de teléfono local" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_local" id="telefono_local" type="text"  />
								            </div>
								            <div class="span6">
								                <label class="control-label">Teléfono Móvil:</label>
								                <input class="span12" title="Ingrese el número de teléfono movil" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_movil" id="telefono_movil" type="text" />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Año a Cursar:</label>
								                <div class="radios">
													<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="1" checked="checked" required /> 1ero
													<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="2" required /> 2do
													<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="3" required /> 3ero
													<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="4" required /> 4to
													<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="5" required /> 5to
												</div>
								            </div>
								            <div class="span6">
								                <label class="control-label">Coordinación Pedagógica N°:</label>
								                <div class="radios">
													<input type="radio" name="coordinacion_pedagogica" id="coordinacion_pedagogica" value="1" checked="checked" required /> 1
													<input type="radio" name="coordinacion_pedagogica" id="coordinacion_pedagogica" value="2" required /> 2
													<input type="radio" name="coordinacion_pedagogica" id="coordinacion_pedagogica" value="3" required /> 3
													<input type="radio" name="coordinacion_pedagogica" id="coordinacion_pedagogica" value="4" required /> 4
													<input type="radio" name="coordinacion_pedagogica" id="coordinacion_pedagogica" value="5" required /> 5
												</div>
								            </div>
								        </div>
								    </div>
								</div>
								<div class="control-group">  
									<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
								</div>  
								<div class="form-actions">
									<button type="button" id="btnGuardar1" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
									<a href="?proceso_inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
								</div>
							</div>  
						</fieldset>  
					</form>
			    </div>
			    <div class="tab-pane" id="tab-condicionestudiante">
			      <form class="form-horizontal" action="../controllers/control_proceso_inscripcion.php" method="post" id="form2"> 
			      	<fieldset>
						<div id="paginador" class="enjoy-css"> 
				      		<input type="hidden" name="lOpt" id="lOpt" value="Registrar_Paso2">
				      		<?php
								$pgsql = new Conexion();
								$sql="SELECT pi.codigo_proceso_inscripcion,pi.cedula_persona,p.primer_nombre||' '||p.primer_apellido AS nombre
								FROM educacion.tproceso_inscripcion pi 
								INNER JOIN general.tpersona p ON pi.cedula_persona = p.cedula_persona 
								WHERE pi.codigo_proceso_inscripcion = ".$_GET['codigo_proceso_inscripcion'];
								$query = $pgsql->Ejecutar($sql);
								$rows=$pgsql->Respuesta($query);
				      		?>
				      		<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Cédula Estudiante:</label>
							                <input type="hidden" name="codigo_proceso_inscripcion" id="codigo_proceso_inscripcion" value="<?=$rows['codigo_proceso_inscripcion']?>" />
							                <input class="span12" type="text" name="cedula_persona" id="cedula_persona" value="<?=$rows['cedula_persona']?>" readonly /> 
							            </div>
							            <div class="span6">
							                <label class="control-label">Nombre y Apellido:</label>
							                <input class="span12" name="nombre_apellido" id="nombre_apellido" type="text" value="<?=$rows['nombre']?>" readonly />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">¿Estudiante Regular?</label>
							                <div class="radios">
												<input type="radio" name="estudiante_regular" id="estudiante_regular" value="Y" checked="checked" required /> Sí
												<input type="radio" name="estudiante_regular" id="estudiante_regular" value="N" required /> No
											</div>
							            </div>
							            <div class="span6">
							                <label class="control-label">¿Procedencia?</label>
											<input class="span12" type="text" title="Ingrese el nombre de la escuela de la cual proviene el estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="procedencia" id="procedencia" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">¿Tiene Materia Pendiente?</label>
							                <div class="radios">
												<input type="radio" name="materia_pendiente" id="materia_pendiente" value="Y" required /> Sí
												<input type="radio" name="materia_pendiente" id="materia_pendiente" value="N" checked="checked" required /> No
											</div>
							            </div>
							            <div class="span6">
							                <label class="control-label">¿Cuál?</label>
											<input class="span12" type="text" title="Ingrese el nombre de las materias que tiene pendiente" onKeyUp="this.value=this.value.toUpperCase()" name="cual_materia" id="cual_materia" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Estado de Salud:</label>
							                <div class="radios">
												<input type="radio" name="estado_salud" id="estado_salud" value="1" checked="checked" required /> Excelente
												<input type="radio" name="estado_salud" id="estado_salud" value="2" required /> Bueno
												<input type="radio" name="estado_salud" id="estado_salud" value="3" required /> Regular
											</div>
							            </div>
							            <div class="span6">
							                <label class="control-label">¿Es Alérgico(a)?</label>
							                <div class="radios">
												<input type="radio" name="alergico" id="alergico" value="Y" required /> Sí
												<input type="radio" name="alergico" id="alergico" value="N" checked="checked" required /> No
											</div>
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">¿Presenta algún Impedimento <br>Deportivo?</label>
							                <div class="radios">
												<input type="radio" name="impedimento_deporte" id="impedimento_deporte" value="Y" required /> Sí
												<input type="radio" name="impedimento_deporte" id="impedimento_deporte" value="N" checked="checked" required /> No
											</div>
							            </div>
							            <div class="span6">
							                <label class="control-label">Especifique:</label>
											<textarea class="span12" title="Ingrese su impedimento deportivo" onKeyUp="this.value=this.value.toUpperCase()" name="especifique_deporte" id="especifique_deporte"></textarea>
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">¿Practica algún Deporte?</label>
							                <div class="radios">
												<input type="radio" name="practica_deporte" id="practica_deporte" value="Y" required /> Sí
												<input type="radio" name="practica_deporte" id="practica_deporte" value="N" checked="checked" required /> No
											</div>
							            </div>
							            <div class="span6">
							                <label class="control-label">¿Cuál?</label>
											<input class="span12" type="text" title="Ingrese el nombre del deporte que practica" onKeyUp="this.value=this.value.toUpperCase()" name="cual_deporte" id="cual_deporte" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">¿Tiene Beca?</label>
							                <div class="radios">
												<input type="radio" name="tiene_beca" id="tiene_beca" value="Y" required /> Sí
												<input type="radio" name="tiene_beca" id="tiene_beca" value="N" checked="checked" required /> No
											</div>
							            </div>
							            <div class="span6">
							                <label class="control-label">¿De que Organismo?</label>
											<input class="span12" type="text" title="Ingrese el nombre del organismo" onKeyUp="this.value=this.value.toUpperCase()" name="organismo" id="organismo" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">¿Tiene Hermanos?</label>
							                <div class="radios">
												<input type="radio" name="tiene_hermanos" id="tiene_hermanos" value="Y" required /> Sí
												<input type="radio" name="tiene_hermanos" id="tiene_hermanos" value="N" checked="checked" required /> No
											</div>
							            </div>
							            <div class="span3">
							                <label class="control-label">¿Cant. Hembras?</label>
											<input class="span4" type="text" title="Ingrese el número de hermanas que tiene" maxlength=1 onKeyPress="return isNumberKey(event)" name="cuantas_hembras" id="cuantas_hembras" value="0" />
							            </div>
							            <div class="span3">
							                <label class="control-label">¿Cant. Varones?</label>
											<input class="span4" type="text" title="Ingrese el número de hermanos que tiene" maxlength=1 onKeyPress="return isNumberKey(event)" name="cuantos_varones" id="cuantos_varones" value="0" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">¿Estudian Acá?</label>
							                <div class="radios">
												<input type="radio" name="estudian_aca" id="estudian_aca" value="Y" required /> Sí
												<input type="radio" name="estudian_aca" id="estudian_aca" value="N" checked="checked" required /> No
											</div>
							            </div>
							            <div class="span6">
							                <label class="control-label">¿En que Año?</label>
											<input class="span12" type="text" title="Ingrese los años que estudian sus hermanos(as) separado por coma (,)" onKeyUp="this.value=this.value.toUpperCase()" name="que_anio" id="que_anio" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Peso en KG:</label>
											<input class="span12" type="text" title="Ingrese el número de kilogramos que pesa" maxlength=4 onKeyPress="return isNumberKey(event)" name="peso" id="peso">
							            </div>
							            <div class="span6">
							                <label class="control-label">Estatura en CM:</label>
											<input class="span12" type="text" title="Ingrese el número de estatura en centimétros que mide" maxlength=6 onKeyPress="return isNumberKey(event)" name="talla" id="talla">
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">¿Tiene Habilidades/Talento?</label>
							                <div class="radios">
												<input type="radio" name="tiene_talento" id="tiene_talento" value="Y" required /> Sí
												<input type="radio" name="tiene_talento" id="tiene_talento" value="N" checked="checked" required /> No
											</div>
							            </div>
							            <div class="span6">
							                <label class="control-label">¿Cuál?</label>
											<input class="span12" type="text" title="Ingrese el nombre de la habilidad o talento que posee" onKeyUp="this.value=this.value.toUpperCase()" name="cual_talento" id="cual_talento" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="control-group">  
								<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
							</div>  
							<div class="form-actions">
								<button type="button" id="btnGuardar2" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
								<a href="?proceso_inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
							</div>
						</div> 
			      	</fieldset>
			      </form>
			    </div>
				<div class="tab-pane" id="tab-antecedentesfamiliares">
					<form class="form-horizontal" action="../controllers/control_proceso_inscripcion.php" method="post" id="form3"> 
						<fieldset>
							<div id="paginador" class="enjoy-css"> 
								<input type="hidden" name="lOpt" id="lOpt" value="Registrar_Paso3">
								<?php
									$pgsql = new Conexion();
									$sql="SELECT pi.codigo_proceso_inscripcion,pi.cedula_persona,p.primer_nombre||' '||p.primer_apellido AS nombre
									FROM educacion.tproceso_inscripcion pi 
									INNER JOIN general.tpersona p ON pi.cedula_persona = p.cedula_persona 
									WHERE pi.codigo_proceso_inscripcion = ".$_GET['codigo_proceso_inscripcion'];
									$query = $pgsql->Ejecutar($sql);
									$rows=$pgsql->Respuesta($query);
					      		?>
					      		<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Cédula Estudiante:</label>
								                <input type="hidden" name="codigo_proceso_inscripcion" id="codigo_proceso_inscripcion" value="<?=$rows['codigo_proceso_inscripcion']?>" />
								                <input class="span12" type="text" name="cedula_persona" id="cedula_persona" value="<?=$rows['cedula_persona']?>" readonly /> 
								            </div>
								            <div class="span6">
								                <label class="control-label">Nombre y Apellido:</label>
								                <input class="span12" name="nombre_apellido" id="nombre_apellido" type="text" value="<?=$rows['nombre']?>" readonly />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Cédula del Padre:</label>
								                <input class="span12" type="text" name="cedula_padre" id="cedula_padre" onKeyUp="this.value=this.value.toUpperCase()" maxlength=10 /> 
								            </div>
								            <div class="span6">
								                <label class="control-label">Fecha de Nacimiento del Padre:</label>
								                <input class="span12" title="Ingrese la fecha de nacimiento del padre" name="fecha_nacimiento_padre" id="fecha_nacimiento_padre" type="text" readonly />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Primer Nombre del Padre:</label>
								                <input class="span12" title="Ingrese el primer nombre del padre" onKeyUp="this.value=this.value.toUpperCase()" name="primer_nombre_padre" id="primer_nombre_padre" type="text" />
								            </div>
								            <div class="span6">
								                <label class="control-label">Segundo Nombre del Padre:</label>
								                <input class="span12" title="Ingrese el segundo nombre del padre" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_nombre_padre" id="segundo_nombre_padre" type="text" />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Primer Apellido del Padre:</label>
								                <input class="span12" title="Ingrese el primer apellido del padre" onKeyUp="this.value=this.value.toUpperCase()" name="primer_apellido_padre" id="primer_apellido_padre" type="text" />
								            </div>
								            <div class="span6">
								                <label class="control-label">Segundo Apellido del Padre:</label>
								                <input class="span12" title="Ingrese el segundo apellido del padre" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_apellido_padre" id="segundo_apellido_padre" type="text" />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Lugar de Nacimiento del Padre:</label>
								                <input class="span12" title="Seleccione el Lugar de Nacimiento" onKeyUp="this.value=this.value.toUpperCase()" name="lugar_nacimiento_padre" id="lugar_nacimiento_padre" type="text" required />
								            </div>
								            <div class="span6">
								            	<label class="control-label">Dirección:</label>
								            	<textarea class="span12" title="Ingrese la dirección del Padre" onKeyUp="this.value=this.value.toUpperCase()" name="direccion_padre" id="direccion_padre" ></textarea>
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Teléfono Local del Padre:</label>
								                <input class="span12" title="Ingrese el número de teléfono local del padre" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_local_padre" id="telefono_local_padre" type="text" />
								            </div>
								            <div class="span6">
								                <label class="control-label">Teléfono Móvil del Padre:</label>
								                <input class="span12" title="Ingrese el número de teléfono movil del padre" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_movil_padre" id="telefono_movil_padre" type="text" />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Profesión del Padre:</label>
								                <input class="span12" title="Ingrese la profesión del padre" onKeyUp="this.value=this.value.toUpperCase()" name="profesion_padre" id="profesion_padre" type="text" />
								            </div>
								            <div class="span6">
								                <label class="control-label">Grado de Instrucción del Padre:</label>
								                <input class="span12" title="Ingrese el grado de instrucción del padre" onKeyUp="this.value=this.value.toUpperCase()" name="grado_instruccion_padre" id="grado_instruccion_padre" type="text" />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Cédula de la Madre:</label>
								                <input class="span12" type="text" name="cedula_madre" id="cedula_madre" onKeyUp="this.value=this.value.toUpperCase()" maxlength=10 /> 
								            </div>
								            <div class="span6">
								                <label class="control-label">Fecha de Nacimiento de la Madre:</label>
								                <input class="span12" title="Ingrese la fecha de nacimiento de la madre" name="fecha_nacimiento_madre" id="fecha_nacimiento_madre" type="text" readonly />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Primer Nombre de la Madre:</label>
								                <input class="span12" title="Ingrese el primer nombre de la madre" onKeyUp="this.value=this.value.toUpperCase()" name="primer_nombre_madre" id="primer_nombre_madre" type="text" />
								            </div>
								            <div class="span6">
								                <label class="control-label">Segundo Nombre de la Madre:</label>
								                <input class="span12" title="Ingrese el segundo nombre de la madre" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_nombre_madre" id="segundo_nombre_madre" type="text" />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Primer Apellido de la Madre:</label>
								                <input class="span12" title="Ingrese el primer apellido de la madre" onKeyUp="this.value=this.value.toUpperCase()" name="primer_apellido_madre" id="primer_apellido_madre" type="text" />
								            </div>
								            <div class="span6">
								                <label class="control-label">Segundo Apellido de la Madre:</label>
								                <input class="span12" title="Ingrese el segundo apellido de la madre" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_apellido_madre" id="segundo_apellido_madre" type="text" />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Lugar de Nacimiento de la Madre:</label>
								                <input class="span12" title="Seleccione el Lugar de Nacimiento" onKeyUp="this.value=this.value.toUpperCase()" name="lugar_nacimiento_madre" id="lugar_nacimiento_madre" type="text" required />
								            </div>
								            <div class="span6">
								            	<label class="control-label">Dirección:</label>
								            	<textarea class="span12" title="Ingrese la dirección de la madre" onKeyUp="this.value=this.value.toUpperCase()" name="direccion_madre" id="direccion_madre" ></textarea>
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Teléfono Local de la Madre:</label>
								                <input class="span12" title="Ingrese el número de teléfono local de la madre" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_local_madre" id="telefono_local_madre" type="text" />
								            </div>
								            <div class="span6">
								                <label class="control-label">Teléfono Móvil de la Madre:</label>
								                <input class="span12" title="Ingrese el número de teléfono movil de la madre" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_movil_madre" id="telefono_movil_madre" type="text" />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Profesión de la Madre:</label>
								                <input class="span12" title="Ingrese la profesión de la madre" onKeyUp="this.value=this.value.toUpperCase()" name="profesion_madre" id="profesion_madre" type="text" />
								            </div>
								            <div class="span6">
								                <label class="control-label">Grado de Instrucción de la Madre:</label>
								                <input class="span12" title="Ingrese el grado de instrucción de la madre" onKeyUp="this.value=this.value.toUpperCase()" name="grado_instruccion_madre" id="grado_instruccion_madre" type="text" />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="control-group">  
									<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
								</div>  
								<div class="form-actions">
									<button type="button" id="btnGuardar3" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
									<a href="?proceso_inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
								</div>
							</div> 
						</fieldset>
					</form>
			    </div>
				<div class="tab-pane" id="tab-datosrepresentante">
					<form class="form-horizontal" action="../controllers/control_proceso_inscripcion.php" method="post" id="form4"> 
						<fieldset>
							<div id="paginador" class="enjoy-css">
								<input type="hidden" name="lOpt" id="lOpt" value="Registrar_Paso4">
								<?php
									$pgsql = new Conexion();
									$sql="SELECT pi.codigo_proceso_inscripcion,pi.cedula_persona,p.primer_nombre||' '||p.primer_apellido AS nombre,pi.cedula_padre,pi.cedula_madre 
									FROM educacion.tproceso_inscripcion pi 
									INNER JOIN general.tpersona p ON pi.cedula_persona = p.cedula_persona 
									WHERE pi.codigo_proceso_inscripcion = ".$_GET['codigo_proceso_inscripcion'];
									$query = $pgsql->Ejecutar($sql);
									$rows=$pgsql->Respuesta($query);
					      		?>
					      		<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Cédula Estudiante:</label>
								                <input type="hidden" name="codigo_proceso_inscripcion" id="codigo_proceso_inscripcion" value="<?=$rows['codigo_proceso_inscripcion']?>" />
								                <input type="hidden" name="cedula_padre" id="cedula_padre" value="<?=$rows['cedula_padre']?>" />
								                <input type="hidden" name="cedula_madre" id="cedula_madre" value="<?=$rows['cedula_madre']?>" />
								                <input class="span12" type="text" name="cedula_persona" id="cedula_persona" value="<?=$rows['cedula_persona']?>" readonly /> 
								            </div>
								            <div class="span6">
								                <label class="control-label">Nombre y Apellido:</label>
								                <input class="span12" name="nombre_apellido" id="nombre_apellido" type="text" value="<?=$rows['nombre']?>" readonly />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Cédula del Representante:</label>
								                <input class="span12" type="text" name="cedula_representante" id="cedula_representante" onKeyUp="this.value=this.value.toUpperCase()" maxlength=10 /> 
								            </div>
								            <div class="span6">
								                <label class="control-label">Parentesco:</label>
								                <select class="bootstrap-select form-control" title="Seleccione un Parentesco" name='codigo_parentesco' id='codigo_parentesco' >
													<option value=0>Seleccione un Parentesco</option>
													<?php
														$pgsql = new Conexion();
														$sql = "SELECT * FROM general.tparentesco ORDER BY descripcion ASC";
														$query = $pgsql->Ejecutar($sql);
														while($rows=$pgsql->Respuesta($query)){
															echo "<option value=".$rows['codigo_parentesco'].">".$rows['descripcion']."</option>";
														}
													?>
												</select>
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Género:</label>
								                <div class="radios">
													<input type="radio" name="sexo_representante" id="sexo_representante" value="F" checked="checked" required /> Femenino
													<input type="radio" name="sexo_representante" id="sexo_representante" value="M" required /> Masculino
												</div>
								            </div>
								            <div class="span6">
								                <label class="control-label">Fecha de Nacimiento del Representante:</label>
								                <input class="span12" title="Ingrese la fecha de nacimiento del representante" name="fecha_nacimiento_representante" id="fecha_nacimiento_representante" type="text" readonly />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Primer Nombre del Representante:</label>
								                <input class="span12" title="Ingrese el primer nombre del representante" onKeyUp="this.value=this.value.toUpperCase()" name="primer_nombre_representante" id="primer_nombre_representante" type="text" />
								            </div>
								            <div class="span6">
								                <label class="control-label">Segundo Nombre del Representante:</label>
								                <input class="span12" title="Ingrese el segundo nombre del representante" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_nombre_representante" id="segundo_nombre_representante" type="text" />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Primer Apellido del Representante:</label>
								                <input class="span12" title="Ingrese el primer apellido del representante" onKeyUp="this.value=this.value.toUpperCase()" name="primer_apellido_representante" id="primer_apellido_representante" type="text" />
								            </div>
								            <div class="span6">
								                <label class="control-label">Segundo Apellido del Representante:</label>
								                <input class="span12" title="Ingrese el segundo apellido del representante" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_apellido_representante" id="segundo_apellido_representante" type="text" />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Lugar de Nacimiento del <br>Representante:</label>
								                <input class="span12" title="Seleccione el Lugar de Nacimiento" onKeyUp="this.value=this.value.toUpperCase()" name="lugar_nacimiento_representante" id="lugar_nacimiento_representante" type="text" required />
								            </div>
								            <div class="span6">
								            	<label class="control-label">Dirección:</label>
								            	<textarea class="span12" title="Ingrese la dirección del Representante" onKeyUp="this.value=this.value.toUpperCase()" name="direccion_representante" id="direccion_representante" ></textarea>
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Teléfono Local del Representante:</label>
								                <input class="span12" title="Ingrese el número de teléfono local del representante" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_local_representante" id="telefono_local_representante" type="text" />
								            </div>
								            <div class="span6">
								                <label class="control-label">Teléfono Móvil del Representante:</label>
								                <input class="span12" title="Ingrese el número de teléfono movil del representante" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_movil_representante" id="telefono_movil_representante" type="text" />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Profesión del Representante:</label>
								                <input class="span12" title="Ingrese la profesión del representante" onKeyUp="this.value=this.value.toUpperCase()" name="profesion_representante" id="profesion_representante" type="text" />
								            </div>
								            <div class="span6">
								                <label class="control-label">Grado de Instrucción del Representante:</label>
								                <input class="span12" title="Ingrese el grado de instrucción del representante" onKeyUp="this.value=this.value.toUpperCase()" name="grado_instruccion_representante" id="grado_instruccion_representante" type="text" />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="control-group">  
									<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
								</div>  
								<div class="form-actions">
									<button type="button" id="btnGuardar4" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
									<a href="?proceso_inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
								</div>
							</div> 
						</fieldset>
					</form>
			    </div>
				<div class="tab-pane" id="tab-integracionec">
					<form class="form-horizontal" action="../controllers/control_proceso_inscripcion.php" method="post" id="form5"> 
						<fieldset>
							<div id="paginador" class="enjoy-css">
								<input type="hidden" name="lOpt" id="lOpt" value="Registrar_Paso5">
								<?php
									$pgsql = new Conexion();
									$sql="SELECT pi.codigo_proceso_inscripcion,pi.cedula_persona,p.primer_nombre||' '||p.primer_apellido AS nombre
									FROM educacion.tproceso_inscripcion pi 
									INNER JOIN general.tpersona p ON pi.cedula_persona = p.cedula_persona 
									WHERE pi.codigo_proceso_inscripcion = ".$_GET['codigo_proceso_inscripcion'];
									$query = $pgsql->Ejecutar($sql);
									$rows=$pgsql->Respuesta($query);
					      		?>
					      		<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Cédula Estudiante:</label>
								                <input type="hidden" name="codigo_proceso_inscripcion" id="codigo_proceso_inscripcion" value="<?=$rows['codigo_proceso_inscripcion']?>" />
								                <input class="span12" type="text" name="cedula_persona" id="cedula_persona" value="<?=$rows['cedula_persona']?>" readonly /> 
								            </div>
								            <div class="span6">
								                <label class="control-label">Nombre y Apellido:</label>
								                <input class="span12" name="nombre_apellido" id="nombre_apellido" type="text" value="<?=$rows['nombre']?>" readonly />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								            	<label class="control-label">Integración Educativa, <br>¿Puede Aportar?</label>
								                <div class="radios">
													<input type="radio" name="integracion_educativa" id="integracion_educativa" value="Y" required /> Sí
													<input type="radio" name="integracion_educativa" id="integracion_educativa" value="N" checked="checked" required /> No
												</div>
								            </div>
								            <div class="span6">
								            	<label class="control-label">Integración Plomería, <br>¿Puede Aportar?</label>
								                <div class="radios">
													<input type="radio" name="integracion_plomeria" id="integracion_plomeria" value="Y" required /> Sí
													<input type="radio" name="integracion_plomeria" id="integracion_plomeria" value="N" checked="checked" required /> No
												</div>
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								            	<label class="control-label">Integración Electricidad, <br>¿Puede Aportar?</label>
								                <div class="radios">
													<input type="radio" name="integracion_electricidad" id="integracion_electricidad" value="Y" required /> Sí
													<input type="radio" name="integracion_electricidad" id="integracion_electricidad" value="N" checked="checked" required /> No
												</div>
								            </div>
								            <div class="span6">
								            	<label class="control-label">Integración Albañilería, <br>¿Puede Aportar?</label>
								                <div class="radios">
													<input type="radio" name="integracion_albanileria" id="integracion_albanileria" value="Y" required /> Sí
													<input type="radio" name="integracion_albanileria" id="integracion_albanileria" value="N" checked="checked" required /> No
												</div>
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								            	<label class="control-label">Integración Peluquería, <br>¿Puede Aportar?</label>
								                <div class="radios">
													<input type="radio" name="integracion_peluqueria" id="integracion_peluqueria" value="Y" required /> Sí
													<input type="radio" name="integracion_peluqueria" id="integracion_peluqueria" value="N" checked="checked" required /> No
												</div>
								            </div>
								            <div class="span6">
								            	<label class="control-label">Integración Ambientación, <br>¿Puede Aportar?</label>
								                <div class="radios">
													<input type="radio" name="integracion_ambientacion" id="integracion_ambientacion" value="Y" required /> Sí
													<input type="radio" name="integracion_ambientacion" id="integracion_ambientacion" value="N" checked="checked" required /> No
												</div>
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								            	<label class="control-label">Integración Manualidades, <br>¿Puede Aportar?</label>
								                <div class="radios">
													<input type="radio" name="integracion_manualidades" id="integracion_manualidades" value="Y" required /> Sí
													<input type="radio" name="integracion_manualidades" id="integracion_manualidades" value="N" checked="checked" required /> No
												</div>
								            </div>
								            <div class="span6">
								            	<label class="control-label">Integración Bisutería, <br>¿Puede Aportar?</label>
								                <div class="radios">
													<input type="radio" name="integracion_bisuteria" id="integracion_bisuteria" value="Y" required /> Sí
													<input type="radio" name="integracion_bisuteria" id="integracion_bisuteria" value="N" checked="checked" required /> No
												</div>
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								            	<label class="control-label">¿Otra Integración?</label>
								                <div class="radios">
													<input type="radio" name="otra_integracion" id="otra_integracion" value="Y" required /> Sí
													<input type="radio" name="otra_integracion" id="otra_integracion" value="N" checked="checked" required /> No
												</div>
								            </div>
								            <div class="span6">
								                <label class="control-label">Especifique:</label>
												<input class="span12" type="text" title="Especifique en que puede aportar" onKeyUp="this.value=this.value.toUpperCase()" name="especifique_integracion" id="especifique_integracion" />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="control-group">  
									<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
								</div>  
								<div class="form-actions">
									<button type="button" id="btnGuardar5" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
									<a href="?proceso_inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
								</div>
							</div> 
						</fieldset>
					</form>
			    </div>
				<div class="tab-pane" id="tab-documentos">
					<form class="form-horizontal" action="../controllers/control_proceso_inscripcion.php" method="post" id="form6"> 
						<fieldset>
							<div id="paginador" class="enjoy-css">
								<input type="hidden" name="lOpt" id="lOpt" value="Registrar_Paso6">
								<?php
									$pgsql = new Conexion();
									$sql="SELECT pi.codigo_proceso_inscripcion,pi.cedula_persona,p.primer_nombre||' '||p.primer_apellido AS nombre
									FROM educacion.tproceso_inscripcion pi 
									INNER JOIN general.tpersona p ON pi.cedula_persona = p.cedula_persona 
									WHERE pi.codigo_proceso_inscripcion = ".$_GET['codigo_proceso_inscripcion'];
									$query = $pgsql->Ejecutar($sql);
									$rows=$pgsql->Respuesta($query);
					      		?>
					      		<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Cédula Estudiante:</label>
								                <input type="hidden" name="codigo_proceso_inscripcion" id="codigo_proceso_inscripcion" value="<?=$rows['codigo_proceso_inscripcion']?>" />
								                <input class="span12" type="text" name="cedula_persona" id="cedula_persona" value="<?=$rows['cedula_persona']?>" readonly /> 
								            </div>
								            <div class="span6">
								                <label class="control-label">Nombre y Apellido:</label>
								                <input class="span12" name="nombre_apellido" id="nombre_apellido" type="text" value="<?=$rows['nombre']?>" readonly />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Fotocopia C.I. Estudiante <br> ¿Entregado?</label>
								                <div class="radios">
													<input type="radio" name="fotocopia_ci" id="fotocopia_ci" value="Y" required /> Sí
													<input type="radio" name="fotocopia_ci" id="fotocopia_ci" value="N" checked="checked" required /> No
												</div>
								            </div>
								            <div class="span6">
								                <label class="control-label">4 Fotos Estudiante <br> ¿Entregado?</label>
								                <div class="radios">
													<input type="radio" name="fotos_estudiante" id="fotos_estudiante" value="Y" required /> Sí
													<input type="radio" name="fotos_estudiante" id="fotos_estudiante" value="N" checked="checked" required /> No
												</div>
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Partida de Nacimiento <br> Original y Copia <br> ¿Entregado?</label>
								                <div class="radios">
													<input type="radio" name="partida_nacimiento" id="partida_nacimiento" value="Y" required /> Sí
													<input type="radio" name="partida_nacimiento" id="partida_nacimiento" value="N" checked="checked" required /> No
												</div>
								            </div>
								            <div class="span6">
								                <label class="control-label">Boleta de Zonificación <br> ¿Entregado?</label>
								                <div class="radios">
													<input type="radio" name="boleta_zonificacion" id="boleta_zonificacion" value="Y" required /> Sí
													<input type="radio" name="boleta_zonificacion" id="boleta_zonificacion" value="N" checked="checked" required /> No
												</div>
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Boleta Promoción <br> ¿Entregado?</label>
								                <div class="radios">
													<input type="radio" name="boleta_promocion" id="boleta_promocion" value="Y" required /> Sí
													<input type="radio" name="boleta_promocion" id="boleta_promocion" value="N" checked="checked" required /> No
												</div>
								            </div>
								            <div class="span6">
								                <label class="control-label">Fotocopia C.I. Representante <br> ¿Entregado?</label>
								                <div class="radios">
													<input type="radio" name="fotocopia_ci_representante" id="fotocopia_ci_representante" value="Y" required /> Sí
													<input type="radio" name="fotocopia_ci_representante" id="fotocopia_ci_representante" value="N" checked="checked" required /> No
												</div>
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Certificado Calificaciones <br> ¿Entregado?</label>
								                <div class="radios">
													<input type="radio" name="certificado_calificaciones" id="certificado_calificaciones" value="Y" required /> Sí
													<input type="radio" name="certificado_calificaciones" id="certificado_calificaciones" value="N" checked="checked" required /> No
												</div>
								            </div>
								            <div class="span6">
								                <label class="control-label">2 Fotos Representante <br> ¿Entregado?</label>
								                <div class="radios">
													<input type="radio" name="fotos_representante" id="fotos_representante" value="Y" required /> Sí
													<input type="radio" name="fotos_representante" id="fotos_representante" value="N" checked="checked" required /> No
												</div>
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								                <label class="control-label">Constancia Buena Conducta <br> ¿Entregado?</label>
								                <div class="radios">
													<input type="radio" name="constancia_buenaconducta" id="constancia_buenaconducta" value="Y" required /> Sí
													<input type="radio" name="constancia_buenaconducta" id="constancia_buenaconducta" value="N" checked="checked" required /> No
												</div>
								            </div>
								            <div class="span6">
								            	<label class="control-label">¿Otro Documento?</label>
								                <div class="radios">
													<input type="radio" name="otro_documento" id="otro_documento" value="Y" required /> Sí
													<input type="radio" name="otro_documento" id="otro_documento" value="N" checked="checked" required /> No
												</div>
								            </div>
								        </div>
								    </div>
								</div>
								<div class="row">
								    <div class="span6">
								        <div class="row-fluid">
								            <div class="span6">
								            	<label class="control-label">Observación</label>
								                <textarea class="input-xlarge" title="Ingrese alguna observación sobre la consignación de documentos del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="observacion_documentos" id="observacion_documentos" type="text" /></textarea>
								            </div>
								            <div class="span6">
								                <label class="control-label">Especifique:</label>
												<input class="span12" type="text" title="Especifique que otro documento ha consignado" onKeyUp="this.value=this.value.toUpperCase()" name="cual_documento" id="cual_documento" />
								            </div>
								        </div>
								    </div>
								</div>
								<div class="control-group">  
									<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
								</div>  
								<div class="form-actions">
									<button type="button" id="btnGuardar6" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
									<a href="?proceso_inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
								</div>
							</div> 
						</fieldset>
					</form>
			    </div>
			</div>	
		</div>
		<?php
			}
		?>
	</fieldset>
	<?php
		if(isset($_SESSION['datos']['procesado']) && $_SESSION['datos']['procesado']=="Y"){
			echo '<script language="javascript">
			setTimeout(function(){
				noty({
			        text: stringUnicode("¿Desea Imprimir la Ficha de Inscripción?"),
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
			            addClass: "btn btn-primary", text: "Sí", onClick: function($noty){
			                $noty.close();
							url = "../pdf/pdf_ficha_inscripcion.php?p1='.$_SESSION['datos']['codigo_proceso_inscripcion'].'";
							window.open(url, "_blank");
			            }
			        },
			        {
			            addClass: "btn btn-danger", text: "No", onClick: function($noty){
			                $noty.close();
			            }
			        }
			        ]
			    });
			},1000);
				</script>';
		}
		else if(isset($_SESSION['datos']['error']) && !empty($_SESSION['datos']['error'])){
			echo "<input type='hidden' id='msjError' value='".$_SESSION['datos']['error']."' />";
			echo '<script language="javascript">
				setTimeout(function(){
					noty({
						"text": stringUnicode(document.getElementById("msjError").value),
						"layout":"center",
						"type":"error",
						"animateOpen":{"height":"toggle"},
						"animateClose":{"height":"toggle"},
						"speed":500,
						"timeout":5000,
						"closeButton":false,
						"closeButton":true,
						"closeOnSelfClick":true,
						"closeOnSelfOver":false
					})
				},1500);
				</script>';
		}
	} // Ventana de Registro
	else if($_GET['Opt']=="3"){ // Ventana de Modificaciones		
		$pgsql=new Conexion();
		$sql = "SELECT pins.codigo_proceso_inscripcion,TO_CHAR(pins.fecha_inscripcion,'DD/MM/YYYY') as fecha_inscripcion,
		(SELECT codigo_ano_academico FROM educacion.tano_academico WHERE estatus = '1' AND cerrado = 'N') AS codigo_ano_academico,
		pins.cedula_persona,p.primer_nombre,p.segundo_nombre,p.primer_apellido,
		p.segundo_apellido,p.sexo,TO_CHAR(p.fecha_nacimiento,'DD/MM/YYYY') as fecha_nacimiento,p.lugar_nacimiento||'_'||par.descripcion AS lugar_nacimiento,
		p.direccion,p.telefono_local,p.telefono_movil,pins.anio_a_cursar,pins.coordinacion_pedagogica,aa.ano,
		i.codigo_inscripcion,INITCAP(per.descripcion) descripcion,pins.cedula_responsable||'_'||pro.primer_nombre||' '||pro.primer_apellido AS profesor, 
		TO_CHAR(per.fecha_inicio,'DD/MM/YYYY') fecha_inicio,TO_CHAR(per.fecha_fin,'DD/MM/YYYY') fecha_fin,
		TO_CHAR(i.fecha_cierre,'DD/MM/YYYY') fecha_cierre,EXTRACT(day from NOW()-i.fecha_cierre) AS dias_restantes  
		FROM educacion.tproceso_inscripcion pins 
		INNER JOIN general.tpersona p ON pins.cedula_persona = p.cedula_persona 
		INNER JOIN general.tparroquia par ON p.lugar_nacimiento = par.codigo_parroquia 
		INNER JOIN general.tpersona pro ON pins.cedula_responsable = pro.cedula_persona 
		INNER JOIN educacion.tano_academico aa ON pins.codigo_ano_academico = aa.codigo_ano_academico 
		INNER JOIN educacion.tinscripcion i ON pins.codigo_inscripcion = i.codigo_inscripcion 
		LEFT JOIN educacion.tperiodo per ON i.codigo_periodo = per.codigo_periodo AND per.esinscripcion =  'Y' 
		WHERE pins.codigo_proceso_inscripcion =".$pgsql->comillas_inteligentes($_GET['codigo_proceso_inscripcion']);
		$query = $pgsql->Ejecutar($sql);
		$rows=$pgsql->Respuesta($query);
		//	Obtener Periodo de Inscripcion activo 
		$pgsql=new Conexion();
		$sql="SELECT i.codigo_inscripcion,INITCAP(p.descripcion) descripcion,TO_CHAR(p.fecha_inicio,'DD/MM/YYYY') fecha_inicio,
		TO_CHAR(p.fecha_fin,'DD/MM/YYYY') fecha_fin,TO_CHAR(i.fecha_cierre,'DD/MM/YYYY') fecha_cierre, 
		EXTRACT(day from NOW()-i.fecha_cierre) AS dias_restantes 
		FROM educacion.tinscripcion i
		INNER JOIN educacion.tperiodo p ON i.codigo_periodo = p.codigo_periodo AND p.esinscripcion =  'Y'
		WHERE i.estatus = '1' AND i.cerrado='N'";
		$query = $pgsql->Ejecutar($sql);
		$fila=$pgsql->Respuesta($query);
	?>
	<fieldset id="PInscripcion">
	<legend><center>PROCESO DE INSCRIPCIÓN</center></legend>
	<!-- Remover aqui para activar validación para limitar el formulario cuando haya finalizado el periodo de inscripción
	<?php
		if($fila['dias_restantes']>0){
	?>	
	<div id="paginador" class="enjoy-css">
		<span style='font-weight: bold;'>¡Lo sentimos, el Proceso de Inscripción ya ha Culminado!</span>
		<div class="form-actions">
			<a href="?proceso_inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
		</div>
	</div>
	<?php
		}else{
	?>
	Remover aqui	-->
	<div id="rootwizard" class="tabbable tabs-left">
		<ul class="nav nav-tabs">
		  	<li class="active"><a href="#tab-datosestudiantes" data-toggle="tab" id="tab1">Datos del <br>Estudiante</a></li>
			<li><a href="#tab-condicionestudiante" data-toggle="tab" id="tab2">Condición del <br>Estudiante</a></li>
			<li><a href="#tab-antecedentesfamiliares" data-toggle="tab" id="tab3">Antecedentes <br>Familiares</a></li>
			<li><a href="#tab-datosrepresentante" data-toggle="tab" id="tab4">Datos Rep. Legal</a></li>
			<li><a href="#tab-integracionec" data-toggle="tab" id="tab5">Integración <br>Escuela-Comunidad</a></li>
			<li><a href="#tab-documentos" data-toggle="tab" id="tab5">Documentos <br>Consignados</a></li>
		</ul>
		<div class="tab-content">
		    <div class="tab-pane" id="tab-datosestudiantes">
		    	<form class="form-horizontal" action="../controllers/control_proceso_inscripcion.php" method="post" id="form1">  
					<fieldset> 
						<div id="paginador" class="enjoy-css"> 
							<input type="hidden" name="lOpt" id="lOpt" value="Modificar_Paso1">  
							<span style='font-weight: bold;'><?=$fila['descripcion']?> (Fecha de Inicio: </span><?=$fila['fecha_inicio']?><span style='font-weight: bold;'> Fecha de Culminación: </span><?=$fila['fecha_fin']?><span style='font-weight: bold;'> Fecha Máxima: </span><?=$fila['fecha_cierre']?><span style='font-weight: bold;'> )</span>
							<input type='hidden' name='codigo_inscripcion' id='codigo_inscripcion' value='<?=$fila['codigo_inscripcion']?>' />
							<input type='hidden' name='fecha_inicio' id='fecha_inicio_ins' value='<?=$fila['fecha_inicio']?>' />
							<input type='hidden' name='fecha_cierre' id='fecha_fin_ins' value='<?=$fila['fecha_cierre']?>' />
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Fecha Inscripción:</label>
							                <input type="hidden" name="codigo_proceso_inscripcion" id="codigo_proceso_inscripcion" value="<?=$rows['codigo_proceso_inscripcion']?>" /> 
							                <input class="span12" type="text" name="fecha_inscripcion" id="fecha_inscripcion" value="<?=$rows['fecha_inscripcion']?>" readonly required /> 
							            </div>
							            <div class="span6">
							                <label class="control-label">Año Académico:</label>
							                <input type='hidden' name='codigo_ano_academico' id='codigo_ano_academico' value='<?=$rows['codigo_ano_academico']?>' />
											<input class='span12' type='text' name='ano_academico' id='ano_academico' value='<?=$rows['ano']?>' readonly required />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Cédula Estudiante:</label>
							                <input type="hidden" name="old_cedula_persona" id="old_cedula_persona" value="<?=$rows['cedula_persona']?>" /> 
							                <input class="span12" type="text" name="cedula_persona" id="cedula_persona" onKeyPress="return isRif(event,this.value)" onKeyUp="this.value=this.value.toUpperCase()" maxlength=12 value="<?=$rows['cedula_persona']?>" required /> 
							            </div>
							            <div class="span6">
							            	<label class="control-label">Docente Responsable</label>
							            	<input class="span12" type="text" name="cedula_responsable" id="cedula_responsable" onKeyUp="this.value=this.value.toUpperCase()" value="<?=$rows['profesor']?>" /> 
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Primer Nombre:</label>
							                <input class="span12" title="Ingrese el primer nombre del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="primer_nombre" id="primer_nombre" type="text" value="<?=$rows['primer_nombre']?>" required />
							            </div>
							            <div class="span6">
							                <label class="control-label">Segundo Nombre:</label>
							                <input class="span12" title="Ingrese el segundo nombre del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_nombre" id="segundo_nombre" type="text" value="<?=$rows['segundo_nombre']?>" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Primer Apellido:</label>
							                <input class="span12" title="Ingrese el primer apellido del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="primer_apellido" id="primer_apellido" type="text" value="<?=$rows['primer_apellido']?>" required />
							            </div>
							            <div class="span6">
							                <label class="control-label">Segundo Apellido:</label>
							                <input class="span12" title="Ingrese el segundo apellido del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_apellido" id="segundo_apellido" type="text" value="<?=$rows['segundo_apellido']?>" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Género:</label>
							                <div class="radios">
												<input type="radio" name="sexo" id="sexo" value="F" <?php if($rows['sexo']=="F"){echo "checked='checked'"; } ?> required /> Femenino
												<input type="radio" name="sexo" id="sexo" value="M" <?php if($rows['sexo']=="M"){echo "checked='checked'"; } ?> required /> Masculino
											</div>
							            </div>
							            <div class="span6">
							                <label class="control-label">Fecha de Nacimiento:</label>
							                <input class="span12" title="Ingrese la fecha de nacimiento del estudiante" name="fecha_nacimiento_estudiante" id="fecha_nacimiento_estudiante" type="text" value="<?=$rows['fecha_nacimiento']?>" readonly required />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Lugar de Nacimiento:</label>
							                <input class="span12" type="text" name="lugar_nacimiento" id="lugar_nacimiento" onKeyUp="this.value=this.value.toUpperCase()" value="<?=$rows['lugar_nacimiento']?>" /> 
							            </div>
							            <div class="span6">
							            	<label class="control-label">Dirección:</label>
							            	<textarea class="span12" title="Ingrese la direccion de la persona" onKeyUp="this.value=this.value.toUpperCase()" name="direccion" id="direccion" required /><?php echo $rows['direccion']; ?></textarea>
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Teléfono Local:</label>
							                <input class="span12" title="Ingrese el número de teléfono local" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_local" id="telefono_local" type="text" value="<?=$rows['telefono_local']?>"  />
							            </div>
							            <div class="span6">
							                <label class="control-label">Teléfono Móvil:</label>
							                <input class="span12" title="Ingrese el número de teléfono movil" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_movil" id="telefono_movil" type="text" value="<?=$rows['telefono_movil']?>" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Año a Cursar:</label>
							                <div class="radios">
												<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="1" <?php if($rows['anio_a_cursar']=="1"){echo "checked='checked'"; } ?> required /> 1ero
												<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="2" <?php if($rows['anio_a_cursar']=="2"){echo "checked='checked'"; } ?> required /> 2do
												<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="3" <?php if($rows['anio_a_cursar']=="3"){echo "checked='checked'"; } ?> required /> 3ero
												<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="4" <?php if($rows['anio_a_cursar']=="4"){echo "checked='checked'"; } ?> required /> 4to
												<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="5" <?php if($rows['anio_a_cursar']=="5"){echo "checked='checked'"; } ?> required /> 5to
											</div>
							            </div>
							            <div class="span6">
							                <label class="control-label">Coordinación Pedagógica N°:</label>
							                <div class="radios">
												<input type="radio" name="coordinacion_pedagogica" id="coordinacion_pedagogica" value="1" <?php if($rows['coordinacion_pedagogica']=="1"){echo "checked='checked'"; } ?> required /> 1
												<input type="radio" name="coordinacion_pedagogica" id="coordinacion_pedagogica" value="2" <?php if($rows['coordinacion_pedagogica']=="2"){echo "checked='checked'"; } ?> required /> 2
												<input type="radio" name="coordinacion_pedagogica" id="coordinacion_pedagogica" value="3" <?php if($rows['coordinacion_pedagogica']=="3"){echo "checked='checked'"; } ?> required /> 3
												<input type="radio" name="coordinacion_pedagogica" id="coordinacion_pedagogica" value="4" <?php if($rows['coordinacion_pedagogica']=="4"){echo "checked='checked'"; } ?> required /> 4
												<input type="radio" name="coordinacion_pedagogica" id="coordinacion_pedagogica" value="5" <?php if($rows['coordinacion_pedagogica']=="5"){echo "checked='checked'"; } ?> required /> 5
											</div>
							            </div>
							        </div>
							    </div>
							</div>
							<div class="control-group">  
								<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
							</div>  
							<div class="form-actions">
								<button type="button" id="btnGuardar1" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
								<a href="?proceso_inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
							</div>  
						</div>
					</fieldset>  
				</form>
		    </div>
		    <div class="tab-pane" id="tab-condicionestudiante">
		      <form class="form-horizontal" action="../controllers/control_proceso_inscripcion.php" method="post" id="form2"> 
		      	<fieldset>
					<div id="paginador" class="enjoy-css"> 
			      		<input type="hidden" name="lOpt" id="lOpt" value="Modificar_Paso2">
			      		<?php
							$pgsql=new Conexion();
							$sql = "SELECT pi.codigo_proceso_inscripcion,pi.cedula_persona,p.primer_nombre||' '||p.primer_apellido AS nombre,pi.estado_salud,
							pi.alergico,pi.impedimento_deporte,pi.especifique_deporte,pi.materia_pendiente,pi.cual_materia,pi.practica_deporte,pi.cual_deporte,
							pi.tiene_beca,pi.organismo,pi.tiene_hermanos,pi.cuantas_hembras,pi.cuantos_varones,pi.estudian_aca,pi.que_anio,pi.peso,pi.talla,
							pi.indice,pi.tiene_talento,pi.cual_talento,pi.estudiante_regular,pi.procedencia  
							FROM educacion.tproceso_inscripcion pi 
							INNER JOIN general.tpersona p ON pi.cedula_persona = p.cedula_persona 
							WHERE pi.codigo_proceso_inscripcion = ".$pgsql->comillas_inteligentes($_GET['codigo_proceso_inscripcion']);
							$query = $pgsql->Ejecutar($sql);
							$rows=$pgsql->Respuesta($query);
			      		?>
			      		<div class="row">
						    <div class="span6">
						        <div class="row-fluid">
						            <div class="span6">
						                <label class="control-label">Cédula Estudiante:</label>
						                <input type="hidden" name="codigo_proceso_inscripcion" id="codigo_proceso_inscripcion" value="<?=$rows['codigo_proceso_inscripcion']?>" />
						                <input class="span12" type="text" name="cedula_persona" id="cedula_persona" value="<?=$rows['cedula_persona']?>" readonly /> 
						            </div>
						            <div class="span6">
						                <label class="control-label">Nombre y Apellido:</label>
						                <input class="span12" name="nombre_apellido" id="nombre_apellido" type="text" value="<?=$rows['nombre']?>" readonly />
						            </div>
						        </div>
						    </div>
						</div>
						<div class="row">
						    <div class="span6">
						        <div class="row-fluid">
						            <div class="span6">
						                <label class="control-label">¿Estudiante Regular?</label>
						                <div class="radios">
											<input type="radio" name="estudiante_regular" id="estudiante_regular" value="Y" <?php if($rows['estudiante_regular']=="Y"){echo "checked='checked'"; } ?> required /> Sí
											<input type="radio" name="estudiante_regular" id="estudiante_regular" value="N" <?php if($rows['estudiante_regular']=="N"){echo "checked='checked'"; } ?> required /> No
										</div>
						            </div>
						            <div class="span6">
						                <label class="control-label">¿Procedencia?</label>
										<input class="span12" type="text" title="Ingrese el nombre de la escuela de la cual proviene el estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="procedencia" id="procedencia" value="<?=$rows['procedencia']?>" />
						            </div>
						        </div>
						    </div>
						</div>
						<div class="row">
						    <div class="span6">
						        <div class="row-fluid">
						            <div class="span6">
						                <label class="control-label">¿Tiene Materia Pendiente?</label>
						                <div class="radios">
											<input type="radio" name="materia_pendiente" id="materia_pendiente" value="Y" <?php if($rows['materia_pendiente']=="Y"){echo "checked='checked'"; } ?> required /> Sí
											<input type="radio" name="materia_pendiente" id="materia_pendiente" value="N" <?php if($rows['materia_pendiente']=="N"){echo "checked='checked'"; } ?> required /> No
										</div>
						            </div>
						            <div class="span6">
						                <label class="control-label">¿Cuál?</label>
										<input class="span12" type="text" title="Ingrese el nombre de las materias que tiene pendiente" onKeyUp="this.value=this.value.toUpperCase()" name="cual_materia" id="cual_materia" value="<?=$rows['cual_materia']?>" />
						            </div>
						        </div>
						    </div>
						</div>
						<div class="row">
						    <div class="span6">
						        <div class="row-fluid">
						            <div class="span6">
						                <label class="control-label">Estado de Salud:</label>
						                <div class="radios">
						                	<input type="hidden" name="codigo_proceso_inscripcion" id="codigo_proceso_inscripcion" value="<?=$rows['codigo_proceso_inscripcion']?>" /> 
											<input type="radio" name="estado_salud" id="estado_salud" value="1" <?php if($rows['estado_salud']=="1"){echo "checked='checked'"; } ?> required /> Excelente
											<input type="radio" name="estado_salud" id="estado_salud" value="2" <?php if($rows['estado_salud']=="2"){echo "checked='checked'"; } ?> required /> Bueno
											<input type="radio" name="estado_salud" id="estado_salud" value="3" <?php if($rows['estado_salud']=="3"){echo "checked='checked'"; } ?> required /> Regular
										</div>
						            </div>
						            <div class="span6">
						                <label class="control-label">¿Es Alérgico(a)?</label>
						                <div class="radios">
											<input type="radio" name="alergico" id="alergico" value="Y" <?php if($rows['alergico']=="Y"){echo "checked='checked'"; } ?> required /> Sí
											<input type="radio" name="alergico" id="alergico" value="N" <?php if($rows['alergico']=="N"){echo "checked='checked'"; } ?> required /> No
										</div>
						            </div>
						        </div>
						    </div>
						</div>
						<div class="row">
						    <div class="span6">
						        <div class="row-fluid">
						            <div class="span6">
						                <label class="control-label">¿Presenta algún Impedimento <br>Deportivo?</label>
						                <div class="radios">
											<input type="radio" name="impedimento_deporte" id="impedimento_deporte" value="Y" <?php if($rows['impedimento_deporte']=="Y"){echo "checked='checked'"; } ?> required /> Sí
											<input type="radio" name="impedimento_deporte" id="impedimento_deporte" value="N" <?php if($rows['impedimento_deporte']=="N"){echo "checked='checked'"; } ?> required /> No
										</div>
						            </div>
						            <div class="span6">
						                <label class="control-label">Especifique:</label>
										<textarea class="span12" title="Ingrese su impedimento deportivo" onKeyUp="this.value=this.value.toUpperCase()" name="especifique_deporte" id="especifique_deporte"><?php echo $rows['especifique_deporte'];?></textarea>
						            </div>
						        </div>
						    </div>
						</div>
						<div class="row">
						    <div class="span6">
						        <div class="row-fluid">
						            <div class="span6">
						                <label class="control-label">¿Practica algún Deporte?</label>
						                <div class="radios">
											<input type="radio" name="practica_deporte" id="practica_deporte" value="Y" <?php if($rows['practica_deporte']=="Y"){echo "checked='checked'"; } ?> required /> Sí
											<input type="radio" name="practica_deporte" id="practica_deporte" value="N" <?php if($rows['practica_deporte']=="N"){echo "checked='checked'"; } ?> required /> No
										</div>
						            </div>
						            <div class="span6">
						                <label class="control-label">¿Cuál?</label>
										<input class="span12" type="text" title="Ingrese el nombre del deporte que practica" onKeyUp="this.value=this.value.toUpperCase()" name="cual_deporte" id="cual_deporte" value="<?=$rows['cual_deporte']?>" />
						            </div>
						        </div>
						    </div>
						</div>
						<div class="row">
						    <div class="span6">
						        <div class="row-fluid">
						            <div class="span6">
						                <label class="control-label">¿Tiene Beca?</label>
						                <div class="radios">
											<input type="radio" name="tiene_beca" id="tiene_beca" value="Y" <?php if($rows['tiene_beca']=="Y"){echo "checked='checked'"; } ?> required /> Sí
											<input type="radio" name="tiene_beca" id="tiene_beca" value="N" <?php if($rows['tiene_beca']=="N"){echo "checked='checked'"; } ?> required /> No
										</div>
						            </div>
						            <div class="span6">
						                <label class="control-label">¿De que Organismo?</label>
										<input class="span12" type="text" title="Ingrese el nombre del organismo" onKeyUp="this.value=this.value.toUpperCase()" name="organismo" id="organismo" value="<?=$rows['organismo']?>" />
						            </div>
						        </div>
						    </div>
						</div>
						<div class="row">
						    <div class="span6">
						        <div class="row-fluid">
						            <div class="span6">
						                <label class="control-label">¿Tiene Hermanos?</label>
						                <div class="radios">
											<input type="radio" name="tiene_hermanos" id="tiene_hermanos" value="Y" <?php if($rows['tiene_hermanos']=="Y"){echo "checked='checked'"; } ?> required /> Sí
											<input type="radio" name="tiene_hermanos" id="tiene_hermanos" value="N" <?php if($rows['tiene_hermanos']=="N"){echo "checked='checked'"; } ?> required /> No
										</div>
						            </div>
						            <div class="span3">
						                <label class="control-label">¿Cuantas Hembras?</label>
										<input class="span4" type="text" title="Ingrese el número de hermanas que tiene" maxlength=1 onKeyPress="return isNumberKey(event)" name="cuantas_hembras" id="cuantas_hembras" value="<?=$rows['cuantas_hembras']?>" />
						            </div>
						            <div class="span3">
						                <label class="control-label">&nbsp;¿Cuantos Varones?</label>
										<input class="span4" type="text" title="Ingrese el número de hermanos que tiene" maxlength=1 onKeyPress="return isNumberKey(event)" name="cuantos_varones" id="cuantos_varones" value="<?=$rows['cuantos_varones']?>" />
						            </div>
						        </div>
						    </div>
						</div>
						<div class="row">
						    <div class="span6">
						        <div class="row-fluid">
						            <div class="span6">
						                <label class="control-label">¿Estudian Acá?</label>
						                <div class="radios">
											<input type="radio" name="estudian_aca" id="estudian_aca" value="Y" <?php if($rows['estudian_aca']=="Y"){echo "checked='checked'"; } ?> required /> Sí
											<input type="radio" name="estudian_aca" id="estudian_aca" value="N" <?php if($rows['estudian_aca']=="N"){echo "checked='checked'"; } ?> required /> No
										</div>
						            </div>
						            <div class="span6">
						                <label class="control-label">¿En que Año?</label>
										<input class="span12" type="text" title="Ingrese los años que estudian sus hermanos(as) separado por coma (,)" onKeyUp="this.value=this.value.toUpperCase()" name="que_anio" id="que_anio" value="<?=$rows['que_anio']?>" />
						            </div>
						        </div>
						    </div>
						</div>
						<div class="row">
						    <div class="span6">
						        <div class="row-fluid">
						            <div class="span6">
						                <label class="control-label">Peso en KG:</label>
										<input class="span12" type="text" title="Ingrese el número de kilogramos que pesa" maxlength=4 onKeyPress="return isNumberKey(event)" name="peso" id="peso" value="<?=$rows['peso']?>" />
						            </div>
						            <div class="span6">
								                <label class="control-label">Estatura en CM:</label>
												<input class="span12" type="text" title="Ingrese el número de estatura en centimétros que mide" maxlength=6 onKeyPress="return isNumberKey(event)" name="talla" id="talla" value="<?=$rows['talla']?>" />
						            </div>
						        </div>
						    </div>
						</div>
						<div class="row">
						    <div class="span6">
						        <div class="row-fluid">
						            <div class="span6">
						                <label class="control-label">¿Tiene Habilidades/Talento?</label>
						                <div class="radios">
											<input type="radio" name="tiene_talento" id="tiene_talento" value="Y" <?php if($rows['tiene_talento']=="Y"){echo "checked='checked'"; } ?> required /> Sí
											<input type="radio" name="tiene_talento" id="tiene_talento" value="N" <?php if($rows['tiene_talento']=="N"){echo "checked='checked'"; } ?> required /> No
										</div>
						            </div>
						            <div class="span6">
						                <label class="control-label">¿Cuál?</label>
										<input class="span12" type="text" title="Ingrese el nombre de la habilidad o talento que posee" onKeyUp="this.value=this.value.toUpperCase()" name="cual_talento" id="cual_talento" value="<?=$rows['cual_talento']?>" />
						            </div>
						        </div>
						    </div>
						</div>
						<div class="control-group">  
							<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
						</div>  
						<div class="form-actions">
							<button type="button" id="btnGuardar2" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
							<a href="?proceso_inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
						</div> 
					</div> 
		      	</fieldset>
		      </form>
		    </div>
			<div class="tab-pane" id="tab-antecedentesfamiliares">
				<form class="form-horizontal" action="../controllers/control_proceso_inscripcion.php" method="post" id="form3"> 
					<fieldset>
						<div id="paginador" class="enjoy-css"> 
							<input type="hidden" name="lOpt" id="lOpt" value="Modificar_Paso3">
							<?php
								$pgsql=new Conexion();
								$sql = "SELECT pins.codigo_proceso_inscripcion,pins.cedula_persona,per.primer_nombre||' '||per.primer_apellido AS nombre,p.cedula_persona AS cedula_padre,TO_CHAR(p.fecha_nacimiento,'DD/MM/YYYY') AS fecha_nacimiento_padre,
								p.primer_nombre AS primer_nombre_padre, p.segundo_nombre AS segundo_nombre_padre, p.primer_apellido AS primer_apellido_padre, p.segundo_apellido AS segundo_apellido_padre,
								p.lugar_nacimiento||'_'||ppar.descripcion AS lugar_nacimiento_padre, p.direccion AS direccion_padre,p.telefono_local AS telefono_local_padre, p.telefono_movil AS telefono_movil_padre,
								p.profesion AS profesion_padre,p.grado_instruccion AS grado_instruccion_padre,m.cedula_persona AS cedula_madre,TO_CHAR(m.fecha_nacimiento,'DD/MM/YYYY') AS fecha_nacimiento_madre,
								m.primer_nombre AS primer_nombre_madre, m.segundo_nombre AS segundo_nombre_madre, m.primer_apellido AS primer_apellido_madre, m.segundo_apellido AS segundo_apellido_madre,
								m.lugar_nacimiento||'_'||mpar.descripcion AS lugar_nacimiento_madre, m.direccion AS direccion_madre,m.telefono_local AS telefono_local_madre, m.telefono_movil AS telefono_movil_madre,
								m.profesion AS profesion_madre,m.grado_instruccion AS grado_instruccion_madre
								FROM educacion.tproceso_inscripcion pins 
								INNER JOIN general.tpersona per ON pins.cedula_persona = per.cedula_persona 
								LEFT JOIN general.tpersona p ON pins.cedula_padre = p.cedula_persona 
								LEFT JOIN general.tparroquia ppar ON p.lugar_nacimiento = ppar.codigo_parroquia 
								LEFT JOIN general.tpersona m ON pins.cedula_madre = m.cedula_persona 
								LEFT JOIN general.tparroquia mpar ON m.lugar_nacimiento = mpar.codigo_parroquia 
								WHERE pins.codigo_proceso_inscripcion =".$pgsql->comillas_inteligentes($_GET['codigo_proceso_inscripcion']);
								$query = $pgsql->Ejecutar($sql);
								$rows=$pgsql->Respuesta($query);
				      		?>
				      		<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Cédula Estudiante:</label>
							                <input type="hidden" name="codigo_proceso_inscripcion" id="codigo_proceso_inscripcion" value="<?=$rows['codigo_proceso_inscripcion']?>" />
							                <input class="span12" type="text" name="cedula_persona" id="cedula_persona" value="<?=$rows['cedula_persona']?>" readonly /> 
							            </div>
							            <div class="span6">
							                <label class="control-label">Nombre y Apellido:</label>
							                <input class="span12" name="nombre_apellido" id="nombre_apellido" type="text" value="<?=$rows['nombre']?>" readonly />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Cédula del Padre:</label>
							                <input type="hidden" name="codigo_proceso_inscripcion" id="codigo_proceso_inscripcion" value="<?=$rows['codigo_proceso_inscripcion']?>" /> 
							                <input type="hidden" name="old_cedula_padre" id="old_cedula_padre" value="<?=$rows['cedula_padre']?>" /> 
							                <input class="span12" type="text" name="cedula_padre" id="cedula_padre" onKeyUp="this.value=this.value.toUpperCase()" maxlength=10 value="<?=$rows['cedula_padre']?>" /> 
							            </div>
							            <div class="span6">
							                <label class="control-label">Fecha de Nacimiento del Padre:</label>
							                <input class="span12" title="Ingrese la fecha de nacimiento del padre" name="fecha_nacimiento_padre" id="fecha_nacimiento_padre" type="text" value="<?=$rows['fecha_nacimiento_padre']?>" readonly />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Primer Nombre del Padre:</label>
							                <input class="span12" title="Ingrese el primer nombre del padre" onKeyUp="this.value=this.value.toUpperCase()" name="primer_nombre_padre" id="primer_nombre_padre" type="text" value="<?=$rows['primer_nombre_padre']?>" />
							            </div>
							            <div class="span6">
							                <label class="control-label">Segundo Nombre del Padre:</label>
							                <input class="span12" title="Ingrese el segundo nombre del padre" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_nombre_padre" id="segundo_nombre_padre" type="text" value="<?=$rows['segundo_nombre_padre']?>" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Primer Apellido del Padre:</label>
							                <input class="span12" title="Ingrese el primer apellido del padre" onKeyUp="this.value=this.value.toUpperCase()" name="primer_apellido_padre" id="primer_apellido_padre" type="text" value="<?=$rows['primer_apellido_padre']?>" />
							            </div>
							            <div class="span6">
							                <label class="control-label">Segundo Apellido del Padre:</label>
							                <input class="span12" title="Ingrese el segundo apellido del padre" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_apellido_padre" id="segundo_apellido_padre" type="text" value="<?=$rows['segundo_apellido_padre']?>" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Lugar de Nacimiento del Padre:</label>
							                <input class="span12" title="Seleccione el Lugar de Nacimiento" onKeyUp="this.value=this.value.toUpperCase()" name="lugar_nacimiento_padre" id="lugar_nacimiento_padre" type="text" value="<?=$rows['lugar_nacimiento_padre']?>" required />
							            </div>
							            <div class="span6">
							            	<label class="control-label">Dirección:</label>
							            	<textarea class="span12" title="Ingrese la dirección del Padre" onKeyUp="this.value=this.value.toUpperCase()" name="direccion_padre" id="direccion_padre" ><?php echo $rows['direccion_padre'];?></textarea>
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Teléfono Local del Padre:</label>
							                <input class="span12" title="Ingrese el número de teléfono local del padre" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_local_padre" id="telefono_local_padre" type="text" value="<?=$rows['telefono_local_padre']?>" />
							            </div>
							            <div class="span6">
							                <label class="control-label">Teléfono Móvil del Padre:</label>
							                <input class="span12" title="Ingrese el número de teléfono movil del padre" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_movil_padre" id="telefono_movil_padre" type="text" value="<?=$rows['telefono_movil_padre']?>" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Profesión del Padre:</label>
							                <input class="span12" title="Ingrese la profesión del padre" onKeyUp="this.value=this.value.toUpperCase()" name="profesion_padre" id="profesion_padre" type="text" value="<?=$rows['profesion_padre']?>" />
							            </div>
							            <div class="span6">
							                <label class="control-label">Grado de Instrucción del Padre:</label>
							                <input class="span12" title="Ingrese el grado de instrucción del padre" onKeyUp="this.value=this.value.toUpperCase()" name="grado_instruccion_padre" id="grado_instruccion_padre" type="text" value="<?=$rows['grado_instruccion_padre']?>" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Cédula de la Madre:</label>
							                <input type="hidden" name="old_cedula_madre" id="old_cedula_madre" value="<?=$rows['cedula_madre']?>" /> 
							                <input class="span12" type="text" name="cedula_madre" id="cedula_madre" onKeyUp="this.value=this.value.toUpperCase()" maxlength=10 value="<?=$rows['cedula_madre']?>" /> 
							            </div>
							            <div class="span6">
							                <label class="control-label">Fecha de Nacimiento de la Madre:</label>
							                <input class="span12" title="Ingrese la fecha de nacimiento de la madre" name="fecha_nacimiento_madre" id="fecha_nacimiento_madre" type="text"  value="<?=$rows['fecha_nacimiento_madre']?>" readonly />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Primer Nombre de la Madre:</label>
							                <input class="span12" title="Ingrese el primer nombre de la madre" onKeyUp="this.value=this.value.toUpperCase()" name="primer_nombre_madre" id="primer_nombre_madre" type="text" value="<?=$rows['primer_nombre_madre']?>" />
							            </div>
							            <div class="span6">
							                <label class="control-label">Segundo Nombre de la Madre:</label>
							                <input class="span12" title="Ingrese el segundo nombre de la madre" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_nombre_madre" id="segundo_nombre_madre" type="text" value="<?=$rows['segundo_nombre_madre']?>" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Primer Apellido de la Madre:</label>
							                <input class="span12" title="Ingrese el primer apellido de la madre" onKeyUp="this.value=this.value.toUpperCase()" name="primer_apellido_madre" id="primer_apellido_madre" type="text" value="<?=$rows['primer_apellido_madre']?>" />
							            </div>
							            <div class="span6">
							                <label class="control-label">Segundo Apellido de la Madre:</label>
							                <input class="span12" title="Ingrese el segundo apellido de la madre" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_apellido_madre" id="segundo_apellido_madre" type="text" value="<?=$rows['segundo_apellido_madre']?>" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Lugar de Nacimiento de la Madre:</label>
							                <input class="span12" title="Seleccione el Lugar de Nacimiento" onKeyUp="this.value=this.value.toUpperCase()" name="lugar_nacimiento_madre" id="lugar_nacimiento_madre" type="text" value="<?=$rows['lugar_nacimiento_madre']?>" required />
							            </div>
							            <div class="span6">
							            	<label class="control-label">Dirección:</label>
							            	<textarea class="span12" title="Ingrese la dirección de la madre" onKeyUp="this.value=this.value.toUpperCase()" name="direccion_madre" id="direccion_madre" ><?php echo $rows['direccion_madre'];?></textarea>
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Teléfono Local de la Madre:</label>
							                <input class="span12" title="Ingrese el número de teléfono local de la madre" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_local_madre" id="telefono_local_madre" type="text" value="<?=$rows['telefono_local_madre']?>" />
							            </div>
							            <div class="span6">
							                <label class="control-label">Teléfono Móvil de la Madre:</label>
							                <input class="span12" title="Ingrese el número de teléfono movil de la madre" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_movil_madre" id="telefono_movil_madre" type="text" value="<?=$rows['telefono_movil_madre']?>" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Profesión de la Madre:</label>
							                <input class="span12" title="Ingrese la profesión de la madre" onKeyUp="this.value=this.value.toUpperCase()" name="profesion_madre" id="profesion_madre" type="text" value="<?=$rows['profesion_madre']?>" />
							            </div>
							            <div class="span6">
							                <label class="control-label">Grado de Instrucción de la Madre:</label>
							                <input class="span12" title="Ingrese el grado de instrucción de la madre" onKeyUp="this.value=this.value.toUpperCase()" name="grado_instruccion_madre" id="grado_instruccion_madre" type="text" value="<?=$rows['grado_instruccion_madre']?>" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="control-group">  
								<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
							</div>  
							<div class="form-actions">
								<button type="button" id="btnGuardar3" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
								<a href="?proceso_inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
							</div>
						</div> 
					</fieldset>
				</form>
		    </div>
			<div class="tab-pane" id="tab-datosrepresentante">
				<form class="form-horizontal" action="../controllers/control_proceso_inscripcion.php" method="post" id="form4"> 
					<fieldset>
						<div id="paginador" class="enjoy-css"> 
							<input type="hidden" name="lOpt" id="lOpt" value="Modificar_Paso4">
							<?php
								$pgsql=new Conexion();
								$sql = "SELECT pins.codigo_proceso_inscripcion,pins.cedula_persona,per.primer_nombre||' '||per.primer_apellido AS nombre,p.cedula_persona AS cedula_representante,TO_CHAR(p.fecha_nacimiento,'DD/MM/YYYY') AS fecha_nacimiento_representante,
								p.primer_nombre AS primer_nombre_representante, p.segundo_nombre AS segundo_nombre_representante, p.primer_apellido AS primer_apellido_representante, p.segundo_apellido AS segundo_apellido_representante,
								p.lugar_nacimiento||'_'||par.descripcion AS lugar_nacimiento_representante, p.direccion AS direccion_representante,p.telefono_local AS telefono_local_representante, p.telefono_movil AS telefono_movil_representante,
								p.profesion AS profesion_representante,p.grado_instruccion AS grado_instruccion_representante,pins.codigo_parentesco,pins.cedula_padre,pins.cedula_madre,p.sexo 
								FROM educacion.tproceso_inscripcion pins 
								INNER JOIN general.tpersona per ON pins.cedula_persona = per.cedula_persona 
								LEFT JOIN general.tpersona p ON pins.cedula_representante = p.cedula_persona 
								LEFT JOIN general.tparroquia par ON p.lugar_nacimiento = par.codigo_parroquia 
								WHERE pins.codigo_proceso_inscripcion =".$pgsql->comillas_inteligentes($_GET['codigo_proceso_inscripcion']);
								$query = $pgsql->Ejecutar($sql);
								$rows=$pgsql->Respuesta($query);
				      		?>
				      		<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Cédula Estudiante:</label>
							                <input type="hidden" name="codigo_proceso_inscripcion" id="codigo_proceso_inscripcion" value="<?=$rows['codigo_proceso_inscripcion']?>" />
							                <input type="hidden" name="cedula_padre" id="cedula_padre" value="<?=$rows['cedula_padre']?>" />
							                <input type="hidden" name="cedula_madre" id="cedula_madre" value="<?=$rows['cedula_madre']?>" />
							                <input class="span12" type="text" name="cedula_persona" id="cedula_persona" value="<?=$rows['cedula_persona']?>" readonly /> 
							            </div>
							            <div class="span6">
							                <label class="control-label">Nombre y Apellido:</label>
							                <input class="span12" name="nombre_apellido" id="nombre_apellido" type="text" value="<?=$rows['nombre']?>" readonly />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Cédula del Representante:</label>
							                <input type="hidden" name="old_cedula_representante" id="old_cedula_representante" value="<?=$rows['cedula_representante']?>" /> 
							                <input class="span12" type="text" name="cedula_representante" id="cedula_representante" onKeyUp="this.value=this.value.toUpperCase()" maxlength=10 value="<?=$rows['cedula_representante']?>" /> 
							            </div>
							            <div class="span6">
							                <label class="control-label">Parentesco:</label>
							                <input type="hidden" name="codigo_proceso_inscripcion" id="codigo_proceso_inscripcion" value="<?=$rows['codigo_proceso_inscripcion']?>" /> 
							                <select class="bootstrap-select form-control" title="Seleccione un Parentesco" name='codigo_parentesco' id='codigo_parentesco' >
												<option value=0>Seleccione un Parentesco</option>
												<?php
													$pgsql = new Conexion();
													$sql = "SELECT * FROM general.tparentesco ORDER BY descripcion ASC";
													$query = $pgsql->Ejecutar($sql);
													while($row=$pgsql->Respuesta($query)){
														if($rows['codigo_parentesco']==$row['codigo_parentesco'])
															echo "<option value=".$row['codigo_parentesco']." selected>".$row['descripcion']."</option>";
														else
															echo "<option value=".$row['codigo_parentesco'].">".$row['descripcion']."</option>";
													}
												?>
											</select>
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
						            <div class="span6">
						                <label class="control-label">Género:</label>
						                <div class="radios">
											<input type="radio" name="sexo_representante" id="sexo_representante" value="F" <?php if($rows['sexo']=="F"){echo "checked='checked'"; } ?> required /> Femenino
											<input type="radio" name="sexo_representante" id="sexo_representante" value="M" <?php if($rows['sexo']=="M"){echo "checked='checked'"; } ?> required /> Masculino
										</div>
						            </div>
							            <div class="span6">
							                <label class="control-label">Fecha de Nacimiento del <br> Representante:</label>
							                <input class="span12" title="Ingrese la fecha de nacimiento del representante" name="fecha_nacimiento_representante" id="fecha_nacimiento_representante" type="text"  value="<?=$rows['fecha_nacimiento_representante']?>" readonly />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Primer Nombre del Representante:</label>
							                <input class="span12" title="Ingrese el primer nombre del representante" onKeyUp="this.value=this.value.toUpperCase()" name="primer_nombre_representante" id="primer_nombre_representante" type="text" value="<?=$rows['primer_nombre_representante']?>" />
							            </div>
							            <div class="span6">
							                <label class="control-label">Segundo Nombre del Representante:</label>
							                <input class="span12" title="Ingrese el segundo nombre del representante" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_nombre_representante" id="segundo_nombre_representante" type="text" value="<?=$rows['segundo_nombre_representante']?>" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Primer Apellido del Representante:</label>
							                <input class="span12" title="Ingrese el primer apellido del representante" onKeyUp="this.value=this.value.toUpperCase()" name="primer_apellido_representante" id="primer_apellido_representante" type="text" value="<?=$rows['primer_apellido_representante']?>" />
							            </div>
							            <div class="span6">
							                <label class="control-label">Segundo Apellido del Representante:</label>
							                <input class="span12" title="Ingrese el segundo apellido del representante" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_apellido_representante" id="segundo_apellido_representante" type="text" value="<?=$rows['segundo_apellido_representante']?>" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Lugar de Nacimiento del <br>Representante:</label>
							                <input class="span12" title="Seleccione el Lugar de Nacimiento" onKeyUp="this.value=this.value.toUpperCase()" name="lugar_nacimiento_representante" id="lugar_nacimiento_representante" type="text" value="<?=$rows['lugar_nacimiento_representante']?>" required />
							            </div>
							            <div class="span6">
							            	<label class="control-label">Dirección:</label>
							            	<textarea class="span12" title="Ingrese la dirección del Representante" onKeyUp="this.value=this.value.toUpperCase()" name="direccion_representante" id="direccion_representante" ><?php echo $rows['direccion_representante'];?></textarea>
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Teléfono Local del Representante:</label>
							                <input class="span12" title="Ingrese el número de teléfono local del representante" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_local_representante" id="telefono_local_representante" type="text" value="<?=$rows['telefono_local_representante']?>" />
							            </div>
							            <div class="span6">
							                <label class="control-label">Teléfono Móvil del Representante:</label>
							                <input class="span12" title="Ingrese el número de teléfono movil del representante" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_movil_representante" id="telefono_movil_representante" type="text" value="<?=$rows['telefono_movil_representante']?>" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Profesión del Representante:</label>
							                <input class="span12" title="Ingrese la profesión del representante" onKeyUp="this.value=this.value.toUpperCase()" name="profesion_representante" id="profesion_representante" type="text" value="<?=$rows['profesion_representante']?>" />
							            </div>
							            <div class="span6">
							                <label class="control-label">Grado de Instrucción del Representante:</label>
							                <input class="span12" title="Ingrese el grado de instrucción del representante" onKeyUp="this.value=this.value.toUpperCase()" name="grado_instruccion_representante" id="grado_instruccion_representante" type="text" value="<?=$rows['grado_instruccion_representante']?>" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="control-group">  
								<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
							</div>  
							<div class="form-actions">
								<button type="button" id="btnGuardar4" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
								<a href="?proceso_inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
							</div>
						</div> 
					</fieldset>
				</form>
		    </div>
			<div class="tab-pane" id="tab-integracionec">
				<form class="form-horizontal" action="../controllers/control_proceso_inscripcion.php" method="post" id="form5"> 
					<fieldset>
						<div id="paginador" class="enjoy-css">
							<input type="hidden" name="lOpt" id="lOpt" value="Modificar_Paso5">
							<?php
								$pgsql=new Conexion();
								$sql = "SELECT pi.codigo_proceso_inscripcion,pi.cedula_persona,p.primer_nombre||' '||p.primer_apellido AS nombre,
								pi.integracion_educativa,pi.integracion_plomeria,pi.integracion_electricidad,pi.integracion_albanileria,pi.integracion_peluqueria,
								pi.integracion_ambientacion,pi.integracion_manualidades,pi.integracion_bisuteria,pi.otra_integracion,pi.especifique_integracion  
								FROM educacion.tproceso_inscripcion pi 
								INNER JOIN general.tpersona p ON pi.cedula_persona = p.cedula_persona 
								WHERE pi.codigo_proceso_inscripcion = ".$pgsql->comillas_inteligentes($_GET['codigo_proceso_inscripcion']);
								$query = $pgsql->Ejecutar($sql);
								$rows=$pgsql->Respuesta($query);
				      		?>
				      		<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Cédula Estudiante:</label>
							                <input type="hidden" name="codigo_proceso_inscripcion" id="codigo_proceso_inscripcion" value="<?=$rows['codigo_proceso_inscripcion']?>" />
							                <input class="span12" type="text" name="cedula_persona" id="cedula_persona" value="<?=$rows['cedula_persona']?>" readonly /> 
							            </div>
							            <div class="span6">
							                <label class="control-label">Nombre y Apellido:</label>
							                <input class="span12" name="nombre_apellido" id="nombre_apellido" type="text" value="<?=$rows['nombre']?>" readonly />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							            	<label class="control-label">Integración Educativa, <br>¿Puede Aportar?</label>
							                <div class="radios">
												<input type="radio" name="integracion_educativa" id="integracion_educativa" value="Y" <?php if($rows['integracion_educativa']=="Y"){ echo "checked='checked'";}?> required /> Sí
												<input type="radio" name="integracion_educativa" id="integracion_educativa" value="N" <?php if($rows['integracion_educativa']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							            <div class="span6">
							            	<label class="control-label">Integración Plomería, <br>¿Puede Aportar?</label>
							                <div class="radios">
												<input type="radio" name="integracion_plomeria" id="integracion_plomeria" value="Y" <?php if($rows['integracion_plomeria']=="Y"){ echo "checked='checked'";}?> required /> Sí
												<input type="radio" name="integracion_plomeria" id="integracion_plomeria" value="N" <?php if($rows['integracion_plomeria']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							            	<label class="control-label">Integración Electricidad, <br>¿Puede Aportar?</label>
							                <div class="radios">
												<input type="radio" name="integracion_electricidad" id="integracion_electricidad" value="Y" <?php if($rows['integracion_electricidad']=="Y"){ echo "checked='checked'";}?> value="Y" required /> Sí
												<input type="radio" name="integracion_electricidad" id="integracion_electricidad" value="N" <?php if($rows['integracion_electricidad']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							            <div class="span6">
							            	<label class="control-label">Integración Albañilería, <br>¿Puede Aportar?</label>
							                <div class="radios">
												<input type="radio" name="integracion_albanileria" id="integracion_albanileria" value="Y" <?php if($rows['integracion_albanileria']=="Y"){ echo "checked='checked'";}?> value="Y" required /> Sí
												<input type="radio" name="integracion_albanileria" id="integracion_albanileria" value="N" <?php if($rows['integracion_albanileria']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							            	<label class="control-label">Integración Peluquería, <br>¿Puede Aportar?</label>
							                <div class="radios">
												<input type="radio" name="integracion_peluqueria" id="integracion_peluqueria" value="Y" <?php if($rows['integracion_peluqueria']=="Y"){ echo "checked='checked'";}?> value="Y" required /> Sí
												<input type="radio" name="integracion_peluqueria" id="integracion_peluqueria" value="N" <?php if($rows['integracion_peluqueria']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							            <div class="span6">
							            	<label class="control-label">Integración Ambientación, <br>¿Puede Aportar?</label>
							                <div class="radios">
												<input type="radio" name="integracion_ambientacion" id="integracion_ambientacion" value="Y" <?php if($rows['integracion_ambientacion']=="Y"){ echo "checked='checked'";}?> value="Y" required /> Sí
												<input type="radio" name="integracion_ambientacion" id="integracion_ambientacion" value="N" <?php if($rows['integracion_ambientacion']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							            	<label class="control-label">Integración Manualidades, <br>¿Puede Aportar?</label>
							                <div class="radios">
												<input type="radio" name="integracion_manualidades" id="integracion_manualidades" value="Y" <?php if($rows['integracion_manualidades']=="Y"){ echo "checked='checked'";}?> value="Y" required /> Sí
												<input type="radio" name="integracion_manualidades" id="integracion_manualidades" value="N" <?php if($rows['integracion_manualidades']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							            <div class="span6">
							            	<label class="control-label">Integración Bisutería, <br>¿Puede Aportar?</label>
							                <div class="radios">
												<input type="radio" name="integracion_bisuteria" id="integracion_bisuteria" value="Y" <?php if($rows['integracion_bisuteria']=="Y"){ echo "checked='checked'";}?> required /> Sí
												<input type="radio" name="integracion_bisuteria" id="integracion_bisuteria" value="N" <?php if($rows['integracion_bisuteria']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							            	<label class="control-label">¿Otra Integración?</label>
							                <div class="radios">
												<input type="radio" name="otra_integracion" id="otra_integracion" value="Y" <?php if($rows['otra_integracion']=="Y"){ echo "checked='checked'";}?> required /> Sí
												<input type="radio" name="otra_integracion" id="otra_integracion" value="N" <?php if($rows['otra_integracion']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							            <div class="span6">
							                <label class="control-label">Especifique:</label>
											<input class="span12" type="text" title="Especifique en que puede aportar" onKeyUp="this.value=this.value.toUpperCase()" name="especifique_integracion" id="especifique_integracion" value="<?=$rows['especifique_integracion']?>" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="control-group">  
								<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
							</div>  
							<div class="form-actions">
								<button type="button" id="btnGuardar5" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
								<a href="?proceso_inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
							</div>
						</div> 
					</fieldset>
				</form>
		    </div>
			<div class="tab-pane" id="tab-documentos">
				<form class="form-horizontal" action="../controllers/control_proceso_inscripcion.php" method="post" id="form6"> 
					<fieldset>
						<div id="paginador" class="enjoy-css">
							<input type="hidden" name="lOpt" id="lOpt" value="Modificar_Paso6">
							<?php
								$pgsql = new Conexion();
								$sql="SELECT pi.codigo_proceso_inscripcion,pi.cedula_persona,p.primer_nombre||' '||p.primer_apellido AS nombre,
								pi.fotocopia_ci,pi.partida_nacimiento,pi.boleta_promocion,pi.certificado_calificaciones,pi.constancia_buenaconducta,
								pi.fotos_estudiante,pi.boleta_zonificacion,pi.fotocopia_ci_representante,pi.fotos_representante,pi.otro_documento,
								pi.cual_documento,pi.observacion_documentos,pi.procesado 
								FROM educacion.tproceso_inscripcion pi 
								INNER JOIN general.tpersona p ON pi.cedula_persona = p.cedula_persona 
								WHERE pi.codigo_proceso_inscripcion = ".$pgsql->comillas_inteligentes($_GET['codigo_proceso_inscripcion']);
								$query = $pgsql->Ejecutar($sql);
								$rows=$pgsql->Respuesta($query);
				      		?>
				      		<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Cédula Estudiante:</label>
							                <input type="hidden" name="codigo_proceso_inscripcion" id="codigo_proceso_inscripcion" value="<?=$rows['codigo_proceso_inscripcion']?>" />
							                <input class="span12" type="text" name="cedula_persona" id="cedula_persona" value="<?=$rows['cedula_persona']?>" readonly /> 
							            </div>
							            <div class="span6">
							                <label class="control-label">Nombre y Apellido:</label>
							                <input class="span12" name="nombre_apellido" id="nombre_apellido" type="text" value="<?=$rows['nombre']?>" readonly />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Fotocopia C.I. Estudiante <br> ¿Entregado?</label>
							                <div class="radios">
												<input type="radio" name="fotocopia_ci" id="fotocopia_ci" value="Y" <?php if($rows['fotocopia_ci']=="Y"){ echo "checked='checked'";}?> required /> Sí
												<input type="radio" name="fotocopia_ci" id="fotocopia_ci" value="N" <?php if($rows['fotocopia_ci']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							            <div class="span6">
							                <label class="control-label">4 Fotos Estudiante <br> ¿Entregado?</label>
							                <div class="radios">
												<input type="radio" name="fotos_estudiante" id="fotos_estudiante" value="Y" <?php if($rows['fotos_estudiante']=="Y"){ echo "checked='checked'";}?> required /> Sí
												<input type="radio" name="fotos_estudiante" id="fotos_estudiante" value="N" <?php if($rows['fotos_estudiante']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Partida de Nacimiento <br> Original y Copia <br> ¿Entregado?</label>
							                <div class="radios">
												<input type="radio" name="partida_nacimiento" id="partida_nacimiento" value="Y" <?php if($rows['partida_nacimiento']=="Y"){ echo "checked='checked'";}?> required /> Sí
												<input type="radio" name="partida_nacimiento" id="partida_nacimiento" value="N" <?php if($rows['partida_nacimiento']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							            <div class="span6">
							                <label class="control-label">Boleta de Zonificación <br> ¿Entregado?</label>
							                <div class="radios">
												<input type="radio" name="boleta_zonificacion" id="boleta_zonificacion" value="Y" <?php if($rows['boleta_zonificacion']=="Y"){ echo "checked='checked'";}?> required /> Sí
												<input type="radio" name="boleta_zonificacion" id="boleta_zonificacion" value="N" <?php if($rows['boleta_zonificacion']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Boleta Promoción <br> ¿Entregado?</label>
							                <div class="radios">
												<input type="radio" name="boleta_promocion" id="boleta_promocion" value="Y" <?php if($rows['boleta_promocion']=="Y"){ echo "checked='checked'";}?> required /> Sí
												<input type="radio" name="boleta_promocion" id="boleta_promocion" value="N" <?php if($rows['boleta_promocion']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							            <div class="span6">
							                <label class="control-label">Fotocopia C.I. Representante <br> ¿Entregado?</label>
							                <div class="radios">
												<input type="radio" name="fotocopia_ci_representante" id="fotocopia_ci_representante" value="Y" <?php if($rows['fotocopia_ci_representante']=="Y"){ echo "checked='checked'";}?> required /> Sí
												<input type="radio" name="fotocopia_ci_representante" id="fotocopia_ci_representante" value="N" <?php if($rows['fotocopia_ci_representante']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Certificado Calificaciones <br> ¿Entregado?</label>
							                <div class="radios">
												<input type="radio" name="certificado_calificaciones" id="certificado_calificaciones" value="Y" <?php if($rows['certificado_calificaciones']=="Y"){ echo "checked='checked'";}?> required /> Sí
												<input type="radio" name="certificado_calificaciones" id="certificado_calificaciones" value="N" <?php if($rows['certificado_calificaciones']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							            <div class="span6">
							                <label class="control-label">2 Fotos Representante <br> ¿Entregado?</label>
							                <div class="radios">
												<input type="radio" name="fotos_representante" id="fotos_representante" value="Y" <?php if($rows['fotos_representante']=="Y"){ echo "checked='checked'";}?> required /> Sí
												<input type="radio" name="fotos_representante" id="fotos_representante" value="N" <?php if($rows['fotos_representante']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							                <label class="control-label">Constancia Buena Conducta <br> ¿Entregado?</label>
							                <div class="radios">
												<input type="radio" name="constancia_buenaconducta" id="constancia_buenaconducta" value="Y" <?php if($rows['constancia_buenaconducta']=="Y"){ echo "checked='checked'";}?> required /> Sí
												<input type="radio" name="constancia_buenaconducta" id="constancia_buenaconducta" value="N" <?php if($rows['constancia_buenaconducta']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							            <div class="span6">
							            	<label class="control-label">¿Otro Documento?</label>
							                <div class="radios">
												<input type="radio" name="otro_documento" id="otro_documento" value="Y" <?php if($rows['otro_documento']=="Y"){ echo "checked='checked'";}?> required /> Sí
												<input type="radio" name="otro_documento" id="otro_documento" value="N" <?php if($rows['otro_documento']=="N"){ echo "checked='checked'";}?> required /> No
											</div>
							            </div>
							        </div>
							    </div>
							</div>
							<div class="row">
							    <div class="span6">
							        <div class="row-fluid">
							            <div class="span6">
							            	<label class="control-label">Observación</label>
							                <textarea class="input-xlarge" title="Ingrese alguna observación sobre la consignación de documentos del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="observacion_documentos" id="observacion_documentos" type="text" /><?php echo $rows['observacion_documentos']; ?></textarea>
							            </div>
							            <div class="span6">
							                <label class="control-label">Especifique:</label>
											<input class="span12" type="text" title="Especifique que otro documento ha consignado" onKeyUp="this.value=this.value.toUpperCase()" name="cual_documento" id="cual_documento" value="<?=$rows['cual_documento']?>" />
							            </div>
							        </div>
							    </div>
							</div>
							<div class="control-group">  
								<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
							</div>  
							<div class="form-actions">
								<button type="button" id="btnGuardar6" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
								<?php
									if($rows['procesado']=="Y")
										echo '<button type="button" id="btnPrintReport" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir Ficha</button>';
								?>
								<a href="?proceso_inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
							</div>
						</div> 
					</fieldset>
				</form>
		    </div>
		</div>	
	</div>
	<?php
		}
	?>
	<?php
		if(isset($_SESSION['datos']['error']) && !empty($_SESSION['datos']['error'])){
			echo "<input type='hidden' id='msjError' value='".$_SESSION['datos']['error']."' />";
			echo '<script language="javascript">
				setTimeout(function(){
					noty({
						"text": stringUnicode(document.getElementById("msjError").value),
						"layout":"center",
						"type":"error",
						"animateOpen":{"height":"toggle"},
						"animateClose":{"height":"toggle"},
						"speed":500,
						"timeout":5000,
						"closeButton":false,
						"closeButton":true,
						"closeOnSelfClick":true,
						"closeOnSelfOver":false
					})
				},1500);
				</script>';
		}
	} // Fin Ventana de Modificaciones
	else if($_GET['Opt']=="4"){ // Ventana de Impresiones
		require_once('../class/class_bd.php'); 
		$pgsql=new Conexion();
		$sql = "SELECT pins.codigo_proceso_inscripcion,TO_CHAR(pins.fecha_inscripcion,'DD/MM/YYYY') as fecha_inscripcion,
		pins.cedula_responsable||' '||r.primer_nombre||' '||r.primer_apellido AS responsable,
		pins.cedula_persona||' '||p.primer_nombre||' '||p.primer_apellido AS estudiante,
		CASE pins.anio_a_cursar WHEN '1' THEN '1er Año' WHEN '2' THEN '2do Año' WHEN '3' THEN '3er Año' WHEN '4' THEN '4to Año'
		ELSE '5to Año' END AS anio_a_cursar
		FROM educacion.tproceso_inscripcion pins 
		INNER JOIN general.tpersona r ON pins.cedula_responsable = r.cedula_persona 
		INNER JOIN general.tpersona p ON pins.cedula_persona = p.cedula_persona 
		WHERE codigo_proceso_inscripcion =".$pgsql->comillas_inteligentes($_GET['codigo_proceso_inscripcion']);
		$query = $pgsql->Ejecutar($sql);
		$row=$pgsql->Respuesta($query);
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
	<legend><center>PROCESO DE INSCRIPCIÓN</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="printer">
			<table class="bordered-table zebra-striped" >
				<tr>
					<td>
						<label>Código:</label>
					</td>
					<td>
						<label><?=$row['codigo_proceso_inscripcion']?></label>
					</td>
				</tr>
				<tr>
					<td>
						<label>Fecha de Inscripcion:</label>
					</td>
					<td>
						<label><?=$row['fecha_inscripcion']?></label>
					</td>
				</tr>
				<tr>
					<td>
						<label>Responsable:</label>
					</td>
					<td>
						<label><?=$row['responsable']?></label>
					</td>
				</tr>
				<tr>
					<td>
						<label>Estudiante:</label>
					</td>
					<td>
						<label><?=$row['estudiante']?></label>
					</td>
				</tr>
				<tr>
					<td>
						<label>Año a Cursar:</label>
					</td>
					<td>
						<label><?=$row['anio_a_cursar']?></label>
					</td>
				</tr>
			</table>
			<center>
				<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
				<a href="?proceso_inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
			</center>
		</div>
	</div>
<?php
} // Fin Ventana de Impresiones
?>