<script type="text/javascript" src="js/chsb_estudiante.js"></script>
<?php
require_once("../class/class_perfil.php");
require_once('../class/class_bd.php');
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('estudiante');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT p.cedula_persona, p.primer_nombre,p.primer_apellido,
	CASE pins.anio_a_cursar WHEN '1' THEN '1ER AÑO' WHEN '2' THEN '2DO AÑO' WHEN '3' THEN '3ER AÑO' WHEN '4' THEN '4TO AÑO' ELSE '5TO AÑO' END AS anio_a_cursar  
 	FROM general.tpersona p 
	INNER JOIN educacion.tproceso_inscripcion pins ON p.cedula_persona = pins.cedula_persona 
	INNER JOIN general.ttipo_persona tp ON p.codigo_tipopersona=tp.codigo_tipopersona 
	WHERE tp.descripcion LIKE '%ESTUDIANTE%'";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: ESTUDIANTE</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Cédula</th>
							<th>Primer Nombre</th>
							<th>Primer Apellido</th>
							<th>Año en Curso</th>
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
							echo '<td>'.$filas['cedula_persona'].'</td>';
							echo '<td>'.$filas['primer_nombre'].'</td>';
							echo '<td>'.$filas['primer_apellido'].'</td>';
							echo '<td>'.$filas['anio_a_cursar'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?estudiante&Opt=3&cedula_persona='.$filas['cedula_persona'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?estudiante&Opt=4&cedula_persona='.$filas['cedula_persona'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?estudiante&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
						?>
						<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>
					</center>		
				<div id="Imprimir" style="display:none;">
					<span>Descargar Como:</span>
					<br/><br/>
					<a href="<?php echo  '../pdf/pdf_estudiante.php';?>" target="_blank"> <img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"> </a>
					&nbsp;&nbsp;
					<a href="../excel/excel_estudiante.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
			    </div>
				</div>
			</div>
		</div>
	</fieldset>
	<?php
} 
// Fin Ventana Principal
// Ventana de Registro
else if($_GET['Opt']=="2"){ 
	?>
	<form class="form-horizontal" action="../controllers/control_estudiante.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: ESTUDIANTE</center></legend>		
			<div id="paginador" class="enjoy-css">
				<?php
					$pgsql=new Conexion();
					$sql="SELECT i.codigo_inscripcion,INITCAP(p.descripcion) descripcion,TO_CHAR(p.fecha_inicio,'DD/MM/YYYY') fecha_inicio,
					TO_CHAR(p.fecha_fin,'DD/MM/YYYY') fecha_fin,TO_CHAR(i.fecha_cierre,'DD/MM/YYYY') fecha_cierre 
					FROM educacion.tinscripcion i
					INNER JOIN educacion.tperiodo p ON i.codigo_periodo = p.codigo_periodo AND p.esinscripcion =  'Y'
					WHERE i.estatus = '1'";
					$query = $pgsql->Ejecutar($sql);
					while ($row = $pgsql->Respuesta($query)){
						echo "<span style='font-weight: bold;'>".$row['descripcion']." (Fecha de Inicio: </span>".$row['fecha_inicio']."<span style='font-weight: bold;'> Fecha de Culminación: </span>".$row['fecha_fin']."<span style='font-weight: bold;'> Fecha Máxima: </span>".$row['fecha_cierre']."<span style='font-weight: bold;'> )</span>";
						echo "<input type='hidden' name='codigo_inscripcion' id='codigo_inscripcion' value='".$row['codigo_inscripcion']."' />";
						echo "<input type='hidden' name='fecha_inicio' id='fecha_inicio_ins' value='".$row['fecha_inicio']."' />";
						echo "<input type='hidden' name='fecha_cierre' id='fecha_fin_ins' value='".$row['fecha_cierre']."' /> <br><br>";
					}
				?>
				<div class="control-group">  
					<label class="control-label" for="fecha_inscripcion">Fecha Inscripción</label>  
					<div class="controls">
						<input class="input-xlarge" title="Ingrese la fecha de inscripcion del estudiante" name="fecha_inscripcion" id="fecha_inscripcion" type="text" readonly required /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="primer_nombre">Año Académico</label>  
					<div class="controls">  
						<?php
							$pgsql=new Conexion();
							$sql="SELECT * FROM educacion.tano_academico WHERE estatus = '1'";
							$query = $pgsql->Ejecutar($sql);
							while($row=$pgsql->Respuesta($query)){
								echo "<input type='hidden' name='codigo_ano_academico' id='codigo_ano_academico' value='".$row['codigo_ano_academico']."' />";
								echo "<input class='input-xlarge' type='text' name='ano_academico' id='ano_academico' value='".$row['ano']."' readonly required />";
							}
						?>
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cedula_responsable">Docente Responsable</label>  
					<div class="controls">  
		            	<select class="selectpicker" data-live-search="true" title="Seleccione un Docente" name='cedula_responsable' id='cedula_responsable' required >
							<option value=0>Seleccione un Docente</option>
							<?php
								$pgsql = new Conexion();
								$sql = "SELECT p.cedula_persona,INITCAP(p.primer_nombre||' '||p.primer_apellido) nombre 
								FROM general.tpersona p 
								INNER JOIN general.ttipo_persona tp ON p.codigo_tipopersona = tp.codigo_tipopersona 
								WHERE LOWER(descripcion) LIKE '%docente%'";
								$query = $pgsql->Ejecutar($sql);
								while($row=$pgsql->Respuesta($query)){
									echo "<option value=".$row['cedula_persona'].">".$row['cedula_persona']." ".$row['nombre']."</option>";
								}
							?>
						</select>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="cedula_persona">Cédula</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar"> 
						<input class="input-xlarge" title="Ingrese el número de cédula" onKeyPress="return isRif(event,this.value)" onKeyUp="this.value=this.value.toUpperCase()" maxlength=10 name="cedula_persona" id="cedula_persona" type="text" required /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="primer_nombre">Primer Nombre</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el primer nombre del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="primer_nombre" id="primer_nombre" type="text" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="segundo_nombre">Segundo Nombre</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el segundo  nombre del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_nombre" id="segundo_nombre" type="text" />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="primer_apellido">Primer Apellido</label>  
					<div class="controls">   
						<input class="input-xlarge" title="Ingrese elprimer apellido del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="primer_apellido" id="se" type="text" required />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="segundo_apellido">Segundo Apellido</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el segundo apellido del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_apellido" id="segundo_apellido" type="text" />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="sexo">Sexo</label>  
					<div class="controls">  
						<div class="radios">
							<input type="radio" name="sexo" id="sexo" value="F" checked="checked" required /> Femenino
							<input type="radio" name="sexo" id="sexo" value="M" required /> Masculino
						</div>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="fecha_nacimiento">Fecha de Nacimiento</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de nacimiento del estudiante" name="fecha_nacimiento" id="fecha_nacimiento" type="text" readonly required />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="lugar_nacimiento">Lugar de Nacimiento</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione el lugar" name='lugar_nacimiento' id='lugar_nacimiento' required >
							<option value=0>Seleccione el Lugar</option>
							<?php
							$pgsql = new Conexion();
							$sql = "SELECT * FROM general.tparroquia ORDER BY descripcion ASC";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								echo "<option value=".$rows['codigo_parroquia'].">".$rows['descripcion']."</option>";
							}
							?>
						</select>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="direccion">Dirección</label>  
					<div class="controls">  
						<textarea class="input-xlarge" title="Ingrese la direccion del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="direccion" id="direccion" type="text" required /></textarea>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="telefono_local">Teléfono Local</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el número de teléfono local" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_local" id="telefono_local" type="text" required />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="telefono_movil">Teléfono Móvil</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el número de teléfono movil" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_movil" id="telefono_movil" type="text" />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="anio_a_cursar">Año a Cursar</label>  
					<div class="controls">  
		                <div class="radios">
							<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="1" checked="checked" required /> 1ero
							<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="2" required /> 2do
							<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="3" required /> 3ero
							<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="4" required /> 4to
							<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="5" required /> 5to
						</div>
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="peso">Peso en KG</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el número de kilogramos que pesa el estudiante" maxlength=4 onKeyPress="return isNumberKey(event)" name="peso" id="peso" type="text" required />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="talla">Talla</label>  
					<div class="controls">
						<select class="selectpicker" data-live-search="true" name="talla" id="talla" title="Seleccione una Talla" required > 
							<option value=0>Seleccione</option>
							<option value="1" >Talla S</option>
							<option value="2" >Talla M</option>
							<option value="3" >Talla L</option>
							<option value="4" >Talla X</option>
							<option value="5" >Talla XL</option>	
			            </select>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="indice">Índice</label>  
					<div class="controls">  
		                <input class="input-xlarge" type="text" title="Ingrese su indice acádemico" maxlength=4 onKeyPress="return isNumberKey(event)" name="indice" id="indice" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cedula_representante">Cédula del Representante</label>  
					<div class="controls">  
		                <input class="input-xlarge" type="text" name="cedula_representante" id="cedula_representante" onKeyUp="this.value=this.value.toUpperCase()" maxlength=10 /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="representante">Representante</label>  
					<div class="controls">  
		                <input class="input-xlarge" type="text" name="representante" id="representante" readonly /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="codigo_parentesco">Parentesco</label>  
					<div class="controls">
						<select class="selectpicker" data-live-search="true" title="Seleccione un Parentesco" name='codigo_parentesco' id='codigo_parentesco' >
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
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
					<a href="?estudiante"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div>
			</div>
		</fieldset>  
	</form>
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
}
// Fin Ventana de Registro
// Ventana de Modificaciones
else if($_GET['Opt']=="3"){ 
	$pgsql=new Conexion();
	$sql = "SELECT pins.codigo_proceso_inscripcion,TO_CHAR(pins.fecha_inscripcion,'DD/MM/YYYY') as fecha_inscripcion,pins.cedula_responsable,p.cedula_persona,
	p.primer_nombre,p.segundo_nombre,p.primer_apellido,p.segundo_apellido,p.sexo,TO_CHAR(p.fecha_nacimiento,'DD/MM/YYYY') as fecha_nacimiento,
	p.lugar_nacimiento,p.direccion,p.telefono_local,p.telefono_movil,pins.anio_a_cursar,pins.peso,pins.talla,pins.indice,pins.cedula_representante,
	r.primer_nombre||' '||r.primer_apellido AS representante,pins.codigo_parentesco,pins.seccion,pins.observacion,pins.procesado,p.estatus
	FROM general.tpersona p 
	INNER JOIN educacion.tproceso_inscripcion pins ON p.cedula_persona = pins.cedula_persona 
	INNER JOIN general.tpersona r ON pins.cedula_representante = r.cedula_persona 
	WHERE p.cedula_persona =".$pgsql->comillas_inteligentes($_GET['cedula_persona']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_estudiante.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: ESTUDIANTE</center></legend>		
			<div id="paginador" class="enjoy-css">  
				<?php
					$pgsql=new Conexion();
					$sql="SELECT i.codigo_inscripcion,INITCAP(p.descripcion) descripcion,TO_CHAR(p.fecha_inicio,'DD/MM/YYYY') fecha_inicio,
					TO_CHAR(p.fecha_fin,'DD/MM/YYYY') fecha_fin,TO_CHAR(i.fecha_cierre,'DD/MM/YYYY') fecha_cierre 
					FROM educacion.tinscripcion i
					INNER JOIN educacion.tperiodo p ON i.codigo_periodo = p.codigo_periodo AND p.esinscripcion =  'Y'
					WHERE i.estatus = '1'";
					$query = $pgsql->Ejecutar($sql);
					while ($rows = $pgsql->Respuesta($query)){
						echo "<span style='font-weight: bold;'>".$rows['descripcion']." (Fecha de Inicio: </span>".$rows['fecha_inicio']."<span style='font-weight: bold;'> Fecha de Culminación: </span>".$rows['fecha_fin']."<span style='font-weight: bold;'> Fecha Máxima: </span>".$rows['fecha_cierre']."<span style='font-weight: bold;'> )</span>";
						echo "<input type='hidden' name='codigo_inscripcion' id='codigo_inscripcion' value='".$rows['codigo_inscripcion']."' />";
						echo "<input type='hidden' name='fecha_inicio' id='fecha_inicio_ins' value='".$rows['fecha_inicio']."' />";
						echo "<input type='hidden' name='fecha_cierre' id='fecha_fin_ins' value='".$rows['fecha_cierre']."' /> <br><br>";
					}
				?>
				<div class="control-group">  
					<label class="control-label" for="fecha_inscripcion">Fecha Inscripción</label>  
					<div class="controls">
						<input class="input-xlarge" title="Ingrese la fecha de inscripcion del estudiante" name="fecha_inscripcion" id="fecha_inscripcion" value="<?=$row['fecha_inscripcion']?>" type="text" readonly required /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="primer_nombre">Año Académico</label>  
					<div class="controls">  
						<?php
							$pgsql=new Conexion();
							$sql="SELECT * FROM educacion.tano_academico WHERE estatus = '1'";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								echo "<input type='hidden' name='codigo_ano_academico' id='codigo_ano_academico' value='".$rows['codigo_ano_academico']."' />";
								echo "<input class='input-xlarge' type='text' name='ano_academico' id='ano_academico' value='".$rows['ano']."' readonly required />";
							}
						?>
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cedula_responsable">Docente Responsable</label>  
					<div class="controls">  
		            	<select class="selectpicker" data-live-search="true" title="Seleccione un Docente" name='cedula_responsable' id='cedula_responsable' required >
							<option value=0>Seleccione un Docente</option>
							<?php
								$pgsql = new Conexion();
								$sql = "SELECT p.cedula_persona,INITCAP(p.primer_nombre||' '||p.primer_apellido) nombre 
								FROM general.tpersona p 
								INNER JOIN general.ttipo_persona tp ON p.codigo_tipopersona = tp.codigo_tipopersona 
								WHERE LOWER(descripcion) LIKE '%docente%'";
								$query = $pgsql->Ejecutar($sql);
								while($rows=$pgsql->Respuesta($query)){
									if($row['cedula_responsable']==$rows['cedula_persona'])
										echo "<option value=".$rows['cedula_persona']." selected >".$rows['cedula_persona']." ".$rows['nombre']."</option>";
									else
										echo "<option value=".$rows['cedula_persona'].">".$rows['cedula_persona']." ".$rows['nombre']."</option>";
								}
							?>
						</select>
					</div>  
				</div>  			
				<div class="control-group">  
					<label class="control-label" for="cedula_persona">Cédula</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar"> 
						<input type="hidden" id="codigo_proceso_inscripcion" name="codigo_proceso_inscripcion" value="<?=$row['codigo_proceso_inscripcion']?>">
						<input type="hidden" id="oldci" name="oldci" value="<?=$row['cedula_persona']?>">
						<input class="input-xlarge" title="Ingrese el número de cédula" onKeyPress="return isRif(event,this.value)" onKeyUp="this.value=this.value.toUpperCase()" maxlength=10 name="cedula_persona" id="cedula_persona" type="text" value="<?=$row['cedula_persona']?>" required /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="primer_nombre">Primer Nombre</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el primer nombre del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="primer_nombre" id="primer_nombre" type="text" value="<?=$row['primer_nombre']?>" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="segundo_nombre">Segundo Nombre</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el segundo  nombre del persona" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_nombre" id="segundo_nombre" type="text" value="<?=$row['segundo_nombre']?>" />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="primer_apellido">Primer Apellido</label>  
					<div class="controls">   
						<input class="input-xlarge" title="Ingrese elprimer apellido del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="primer_apellido" id="se" type="text" value="<?=$row['primer_apellido']?>" required />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="segundo_apellido">Segundo Apellido</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el segundo apellido del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_apellido" id="segundo_apellido" type="text" value="<?=$row['segundo_apellido']?>" />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="sexo">Sexo</label>  
					<div class="controls">  
						<div class="radios">
							<input type="radio" name="sexo" id="sexo" <?php if($row['sexo']=="F"){echo "value='F' checked='checked'";}?> required /> Femenino
							<input type="radio" name="sexo" id="sexo" <?php if($row['sexo']=="M"){echo "value='M' checked='checked'";}?> required /> Masculino
						</div>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="fecha_nacimiento">Fecha de Nacimiento</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de nacimiento del estudiante" name="fecha_nacimiento" id="fecha_nacimiento" type="text" value="<?=$row['fecha_nacimiento']?>" readonly required />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="lugar_nacimiento">Lugar de Nacimiento</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione el lugar" name='lugar_nacimiento' id='lugar_nacimiento' required >
							<option value=0>Seleccione el Lugar</option>
							<?php
							$pgsql = new Conexion();
							$sql = "SELECT * FROM general.tparroquia ORDER BY descripcion ASC";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								if($rows['codigo_parroquia']==$row['lugar_nacimiento'])
									echo "<option value=".$rows['codigo_parroquia']." selected >".$rows['descripcion']."</option>";
								else
									echo "<option value=".$rows['codigo_parroquia'].">".$rows['descripcion']."</option>";
							}
							?>
						</select>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="direccion">Dirección</label>  
					<div class="controls">  
						<textarea class="input-xlarge" title="Ingrese la direccion del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="direccion" id="direccion" type="text" required /><?php echo $row['direccion']; ?></textarea>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="telefono_local">Teléfono Local</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el número de teléfono local" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_local" id="telefono_local" type="text" value="<?=$row['telefono_local']?>" required />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="telefono_movil">Teléfono Móvil</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el número de teléfono movil" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_movil" id="telefono_movil" type="text" value="<?=$row['telefono_movil']?>" />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="anio_a_cursar">Año a Cursar</label>  
					<div class="controls">  
		                <div class="radios">
							<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="1" <?php if($row['anio_a_cursar']=="1"){echo "checked='checked'"; } ?> required /> 1ero
							<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="2" <?php if($row['anio_a_cursar']=="2"){echo "checked='checked'"; } ?> required /> 2do
							<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="3" <?php if($row['anio_a_cursar']=="3"){echo "checked='checked'"; } ?> required /> 3ero
							<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="4" <?php if($row['anio_a_cursar']=="4"){echo "checked='checked'"; } ?> required /> 4to
							<input type="radio" name="anio_a_cursar" id="anio_a_cursar" value="5" <?php if($row['anio_a_cursar']=="5"){echo "checked='checked'"; } ?> required /> 5to
						</div>
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="peso">Peso en KG</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el número de kilogramos que pesa el estudiante" maxlength=4 onKeyPress="return isNumberKey(event)" name="peso" id="peso" type="text" value="<?=$row['peso']?>" required />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="talla">Talla</label>  
					<div class="controls">
						<select class="selectpicker" data-live-search="true" name="talla" id="talla" title="Seleccione una Talla" required > 
							<option value=0>Seleccione</option>
							<option value="1" >Talla S</option>
							<option value="2" >Talla M</option>
							<option value="3" >Talla L</option>
							<option value="4" >Talla X</option>
							<option value="5" >Talla XL</option>	
			            </select>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="indice">Índice</label>  
					<div class="controls">  
		                <input class="input-xlarge" type="text" title="Ingrese su indice acádemico" maxlength=4 onKeyPress="return isNumberKey(event)" name="indice" id="indice" value="<?=$row['indice']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cedula_representante">Cédula del Representante</label>  
					<div class="controls">  
		                <input class="input-xlarge" type="text" name="cedula_representante" id="cedula_representante" onKeyUp="this.value=this.value.toUpperCase()" maxlength=10 value="<?=$row['cedula_representante']?>" required /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="representante">Representante</label>  
					<div class="controls">  
		                <input class="input-xlarge" type="text" name="representante" id="representante" value="<?=$row['representante']?>" readonly /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="codigo_parentesco">Parentesco</label>  
					<div class="controls">
						<select class="selectpicker" data-live-search="true" title="Seleccione un Parentesco" name='codigo_parentesco' id='codigo_parentesco' required >
							<option value=0>Seleccione un Parentesco</option>
							<?php
								$pgsql = new Conexion();
								$sql = "SELECT * FROM general.tparentesco ORDER BY descripcion ASC";
								$query = $pgsql->Ejecutar($sql);
								while($rows=$pgsql->Respuesta($query)){
									if($row['codigo_parentesco']==$rows['codigo_parentesco'])
										echo "<option value=".$rows['codigo_parentesco']." selected >".$rows['descripcion']."</option>";
									else
										echo "<option value=".$rows['codigo_parentesco'].">".$rows['descripcion']."</option>";
								}
							?>
						</select>
					</div>  
				</div> 
				<div class="control-group">  
					<label class="control-label" for="seccion">Sección</label>  
					<div class="controls">
						<input type="hidden" name="oldseccion" id="oldseccion" value="<?=$row['seccion']?>">
		                <select class="selectpicker" data-live-search="true" title="Seleccione una Sección" name='seccion' id='seccion' required >
							<option value=0>Seleccione una Sección</option>
							<?php
								$pgsql = new Conexion();
								$sql = "SELECT s.seccion,s.nombre_seccion||' ('||MAX(s.capacidad_max)-COUNT(isec.seccion)||')' AS nombre_seccion 
								FROM educacion.tseccion s 
								LEFT JOIN educacion.tinscrito_seccion isec ON s.seccion = isec.seccion 
								GROUP BY s.seccion,s.nombre_seccion 
								ORDER BY MAX(s.capacidad_max)-COUNT(isec.seccion) DESC,s.seccion ASC";
								$query = $pgsql->Ejecutar($sql);
								while($rows=$pgsql->Respuesta($query)){
									if($rows['seccion']==$row['seccion'])
										echo "<option value=".$rows['seccion']." selected >".$rows['nombre_seccion']."</option>";
									else
										echo "<option value=".$rows['seccion'].">".$rows['nombre_seccion']."</option>";
								}
							?>
						</select>
					</div>  
				</div> 
				<div class="control-group">  
					<label class="control-label" for="observacion">Observación</label>  
					<div class="controls">  
						<textarea class="input-xlarge" title="Ingrese alguna observación sobre la inscripción del estudiante" onKeyUp="this.value=this.value.toUpperCase()" name="observacion" id="observacion" type="text" /><?php echo $row['observacion']; ?></textarea>
					</div>  
				</div> 
				<div class="control-group">  
					<?php if($row['estatus']=='1'){echo "<p id='estatus' class='Activo'>Activo </p>";}else{echo "<p id='estatus' class='Desactivado'>Desactivado</p>";} ?>
				</div>  
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
					<?php
						for($x=0;$x<count($a);$x++){
							if($a[$x]['orden']=='3'){
								if($row['estatus']=='1')
									echo '<button type="button" id="btnDesactivar" class="btn btn-large btn-primary"><i class="'.$a[$x]['icono'].'"></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button>&nbsp;';
								else
									echo '<button disabled type="button" id="btnDesactivar" class="btn btn-large btn-primary"><i class="'.$a[$x]['icono'].'"></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button>&nbsp;';

							}else if($a[$x]['orden']=='4'){
								if($row['estatus']=='1')
									echo '<button disabled type="button" id="btnActivar" class="btn btn-large btn-primary"><i class="'.$a[$x]['icono'].'"></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button>';
								else
									echo '<button type="button" id="btnActivar" class="btn btn-large btn-primary"><i class="'.$a[$x]['icono'].'"></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button>';
							}
						}
						if($row['procesado']=="Y")
							echo '&nbsp;<button type="button" id="btnPrintReport" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir Ficha</button>';
					?>
					<a href="?estudiante"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div>  
			</div>
		</fieldset>  
	</form>
<?php
}  // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	$pgsql=new Conexion();
	$sql = "SELECT e.cedula_persona,INITCAP(e.primer_nombre) primer_nombre,INITCAP(e.segundo_nombre) segundo_nombre
	,INITCAP(e.primer_apellido) primer_apellido,INITCAP(e.segundo_apellido) segundo_apellido,CASE e.sexo WHEN 'F' THEN 'FEMENINO' ELSE 'MASCULINO' END sexo
	,TO_CHAR(fecha_nacimiento,'DD/MM/YYYY') fecha_nacimiento,p.descripcion As lugar_nacimiento,e.direccion,e.telefono_local,e.telefono_movil
	,t.descripcion AS tipo_persona 
	FROM general.tpersona e
	INNER JOIN general.tparroquia p ON e.lugar_nacimiento= p.codigo_parroquia
	INNER JOIN general.ttipo_persona t ON e.codigo_tipopersona=t.codigo_tipopersona
	WHERE e.cedula_persona =".$pgsql->comillas_inteligentes($_GET['cedula_persona']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: ESTUDIANTE</center></legend>		
		<div id="paginador" class="enjoy-css">	
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Cédula:</label>
						</td>
						<td>
							<label><?=$row['cedula_persona']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Primer Nombre:</label>
						</td>
						<td>
							<label><?=$row['primer_nombre']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Segundo Nombre:</label>
						</td>
						<td>
							<label><?=$row['segundo_nombre']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Primer Apellido:</label>
						</td>
						<td>
							<label><?=$row['primer_apellido']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Segundo Apellido:</label>
						</td>
						<td>
							<label><?=$row['segundo_apellido']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Sexo:</label>
						</td>
						<td>
							<label><?=$row['sexo']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Fecha Nacimiento:</label>
						</td>
						<td>
							<label><?=$row['fecha_nacimiento']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Lugar Nacimiento:</label>
						</td>
						<td>
							<label><?=$row['lugar_nacimiento']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Direción:</label>
						</td>
						<td>
							<label><?=$row['direccion']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Teléfono local:</label>
						</td>
						<td>
							<label><?=$row['telefono_local']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Teléfono Móvil:</label>
						</td>
						<td>
							<label><?=$row['telefono_movil']?></label>
						</td>
					</tr>
				</table>
				<center>
					<button id="btnPrint" type="button"class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
					<a href="?estudiante"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
		<?php
} // Fin Ventana de Impresiones
?>