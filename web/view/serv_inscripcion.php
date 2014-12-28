<script type="text/javascript" src="js/chsb_inscripcion.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('inscripcion');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT i.codigo_inscripcion,p.descripcion,TO_CHAR(p.fecha_inicio,'DD/MM/YYYY') as fecha_inicio,TO_CHAR(p.fecha_fin,'DD/MM/YYYY') as fecha_fin,
	TO_CHAR(i.fecha_cierre,'DD/MM/YYYY') as fecha_cierre 
	FROM educacion.tinscripcion i 
	INNER JOIN educacion.tperiodo p ON i.codigo_periodo = p.codigo_periodo 
	WHERE p.esinscripcion='Y'";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: PERÍODO INSCRIPCIÓN</center></legend>
		<div id="paginador" class="enjoy-css">
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código:</th>
							<th>Descripción:</th>
							<th>Fecha Inicio:</th>
							<th>Fecha Cierre:</th>
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
							echo '<td>'.$filas['codigo_inscripcion'].'</td>';
							echo '<td>'.$filas['descripcion'].'</td>';
							echo '<td>'.$filas['fecha_inicio'].'</td>';
							echo '<td>'.$filas['fecha_cierre'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?inscripcion&Opt=3&codigo_inscripcion='.$filas['codigo_inscripcion'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?inscripcion&Opt=4&codigo_inscripcion='.$filas['codigo_inscripcion'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?inscripcion&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
						?>
						<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>
					</center>		
				<div id="Imprimir" style="display:none;">
					<span>Descargar Como:</span>
					<br/><br/>
					<a href="<?php echo  '../pdf/pdf_inscripcion.php';?>" target="_blank"> <img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"> </a>
					&nbsp;&nbsp;
					<a href="../excel/excel_inscripcion.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
			    </div>
				</div>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
	?>
	<form class="form-horizontal" action="../controllers/control_inscripcion.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: PERÍODO INSCRIPCIÓN</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_inscripcion">Código:</label>  
					<div class="controls">  
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
						<input class="input-xlarge" title="el Código del período de inscripción es generado por el sistema" name="codigo_inscripcion" id="codigo_inscripcion" type="text" readonly /> 
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="descripcion">Descripción:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el nombre o descripción para el período de inscripción" onKeyUp="this.value=this.value.toUpperCase()" name="descripcion" id="descripcion" type="text" size="50" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="fecha_inicio">Fecha de Inicio:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha inicial del período de inscripción"  name="fecha_inicio" id="fecha_inicio" type="text" size="50" readonly required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="fecha_fin">Fecha de Culminación:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha final del período de inscripción" name="fecha_fin" id="fecha_fin" type="text" size="50" readonly required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="fecha_fin">Fecha de Cierre:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de cierre del período de inscripción" name="fecha_cierre" id="fecha_cierre" type="text" size="50" readonly required />
					</div>  
				</div>
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
					<a href="?inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div>
			</div>  
		</fieldset>  
	</form>
	<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT i.codigo_inscripcion,p.descripcion,TO_CHAR(p.fecha_inicio,'DD/MM/YYYY') as fecha_inicio,TO_CHAR(p.fecha_fin,'DD/MM/YYYY') as fecha_fin,
	TO_CHAR(i.fecha_cierre,'DD/MM/YYYY') as fecha_cierre,i.estatus  
	FROM educacion.tinscripcion i 
	INNER JOIN educacion.tperiodo p ON i.codigo_periodo = p.codigo_periodo 
	WHERE p.esinscripcion='Y' AND codigo_inscripcion = '".$_GET['codigo_inscripcion']."'";
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_inscripcion.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: PERÍODO INSCRIPCIÓN</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_inscripcion">Código:</label>  
					<div class="controls">  
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
						<input class="input-xlarge" title="el Código del período de inscripción es generado por el sistema" name="codigo_inscripcion" id="codigo_inscripcion" type="text" value="<?=$row['codigo_inscripcion']?>" readonly /> 
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="descripcion">Descripción:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el nombre o descripción para el período de inscripción" onKeyUp="this.value=this.value.toUpperCase()" name="descripcion" id="descripcion" type="text" size="50" value="<?=$row['descripcion']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="fecha_inicio">Fecha de Inicio:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha inicial del período de inscripción"  name="fecha_inicio" id="fecha_inicio" type="text" size="50" value="<?=$row['fecha_inicio']?>" readonly required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="fecha_fin">Fecha de Culminación:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha final del período de inscripción" name="fecha_fin" id="fecha_fin" type="text" size="50" value="<?=$row['fecha_fin']?>" readonly required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="fecha_fin">Fecha de Cierre:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de cierre del período de inscripción" name="fecha_cierre" id="fecha_cierre" type="text" size="50" value="<?=$row['fecha_cierre']?>" readonly required />
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
					for($x=0;$x<count($a);$x++)
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
						?>
						<a href="?inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
					</div>
				</div>  
			</fieldset>  
		</form>
		<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT i.codigo_inscripcion,p.descripcion,TO_CHAR(p.fecha_inicio,'DD/MM/YYYY') as fecha_inicio,TO_CHAR(p.fecha_fin,'DD/MM/YYYY') as fecha_fin,
	TO_CHAR(i.fecha_cierre,'DD/MM/YYYY') as fecha_cierre,i.estatus  
	FROM educacion.tinscripcion i 
	INNER JOIN educacion.tperiodo p ON i.codigo_periodo = p.codigo_periodo 
	WHERE p.esinscripcion='Y' AND codigo_inscripcion = '".$_GET['codigo_inscripcion']."'";
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: PERÍODO INSCRIPCIÓN</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Código:</label>
						</td>
						<td>
							<label><?=$row['codigo_inscripcion']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Descripción:</label>
						</td>
						<td>
							<label><?=$row['descripcion']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Fecha de Inicio:</label>
						</td>
						<td>
							<label><?=$row['fecha_inicio']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Fecha de Culminación:</label>
						</td>
						<td>
							<label><?=$row['fecha_fin']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Fecha de Cierre:</label>
						</td>
						<td>
							<label><?=$row['fecha_cierre']?></label>
						</td>
					</tr>
				</table>
				<center>
					<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
					<a href="?inscripcion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana de Impresiones
?>