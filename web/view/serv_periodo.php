<script type="text/javascript" src="js/chsb_periodo.js"></script>
<?php
require_once("../class/class_perfil.php");
require_once('../class/class_bd.php');
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('periodo');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	$pgsql=new Conexion();
	$sql = "SELECT *, TO_CHAR(p.fecha_inicio,'DD/MM/YYYY') as fecha_inicio,TO_CHAR(p.fecha_fin,'DD/MM/YYYY') as fecha_fin,
	CASE a.cerrado WHEN 'Y' THEN 'SÍ' ELSE 'NO' END AS cerrado 
	FROM educacion.tperiodo p 
	INNER JOIN educacion.tlapso l ON p.codigo_lapso = l.codigo_lapso 
	INNER JOIN educacion.tano_academico a ON l.codigo_ano_academico = a.codigo_ano_academico 
	WHERE esinscripcion='N'";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: PERÍODO</center></legend>		
		<div id="paginador" class="enjoy-css"> 
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código</th>
							<th>Período</th>
							<th>Lapso</th>
							<th>¿Cerrado?</th>
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
							echo '<td>'.$filas['codigo_periodo'].'</td>';
							echo '<td>'.$filas['descripcion'].'</td>';
							echo '<td>'.$filas['lapso'].'</td>';
							echo '<td>'.$filas['cerrado'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?periodo&Opt=3&codigo_periodo='.$filas['codigo_periodo'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?periodo&Opt=4&codigo_periodo='.$filas['codigo_periodo'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?periodo&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
						?>
						<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>
					</center>		
					<div id="Imprimir" style="display:none;">
						<span>Descargar Como:</span>
						<br/><br/>
						<a href="<?php echo  '../pdf/pdf_periodo.php';?>" target="_blank"><img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"></a>
						&nbsp;&nbsp;						
						<a href="../excel/excel_periodo.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
					</div>
				</div>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
	?>
	<form class="form-horizontal" action="../controllers/control_periodo.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: PERÍODO</center></legend>		
			<div id="paginador" class="enjoy-css"> 
				<div class="control-group">  
					<label class="control-label" for="codigo_periodo">Código:</label>  
					<div class="controls">  
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
						<input class="input-xlarge" title="el Código del período es generado por el sistema" name="codigo_periodo" id="codigo_periodo" type="text" readonly /> 
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="descripcion">Período:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el nombre del período" onKeyUp="this.value=this.value.toUpperCase()" name="descripcion" id="descripcion" type="text" size="50" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="fecha_inicio">Fecha de Inicio:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha inicial del período"  name="fecha_inicio" id="fecha_inicio" type="text" size="50" readonly required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="fecha_fin">Fecha de Culminación:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha final nombre del período" name="fecha_fin" id="fecha_fin" type="text" size="50" readonly required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="codigo_lapso">Lapso:</label>  
					<div class="controls">  
						<select class="bootstrap-select form-control" title="Seleccione un Lapso" name='codigo_lapso' id='codigo_lapso' required >
							<option value=0>Seleccione un Lapso</option>
							<?php
							$pgsql = new Conexion();
							$sql = "SELECT l.codigo_lapso,l.lapso||' ('||a.ano||')' AS lapso 
							FROM educacion.tlapso l 
							INNER JOIN educacion.tano_academico a ON l.codigo_ano_academico = a.codigo_ano_academico 
							WHERE a.cerrado='N' 
							ORDER BY l.lapso ASC";
							$query = $pgsql->Ejecutar($sql);
							while($row=$pgsql->Respuesta($query)){
								echo "<option value=".$row['codigo_lapso'].">".$row['lapso']."</option>";
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
					<a href="?periodo"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div> 
			</div> 
		</fieldset>  
	</form>
	<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT codigo_periodo,descripcion,TO_CHAR(fecha_inicio,'DD/MM/YYYY') as fecha_inicio,
	TO_CHAR(fecha_fin,'DD/MM/YYYY') as fecha_fin,codigo_lapso,estatus 
	FROM educacion.tperiodo 
	WHERE codigo_periodo =".$pgsql->comillas_inteligentes($_GET['codigo_periodo'])." 
	AND esinscripcion='N'";
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_periodo.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: PERÍODO</center></legend>		
			<div id="paginador" class="enjoy-css"> 
				<div class="control-group">  
					<label class="control-label" for="codigo_periodo">Código</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
						<input class="input-xlarge" title="el Código del período es generado por el sistema" name="codigo_periodo" id="codigo_periodo" type="text" value="<?=$row['codigo_periodo']?>" readonly /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="descripcion">Período:</label>  
					<div class="controls">  
						<input type="hidden" id="olddescripcion" name="olddescripcion" value="<?=$row['descripcion']?>">
						<input class="input-xlarge" title="Ingrese el nombre del período" onKeyUp="this.value=this.value.toUpperCase()" name="descripcion" id="descripcion" type="text" value="<?=$row['descripcion']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="fecha_inicio">Fecha de Inicio:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha inicial del período" name="fecha_inicio" id="fecha_inicio" type="text" size="50" value="<?=$row['fecha_inicio']?>" readonly required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="fecha_fin">Fecha de Culminación:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de culminación del período" name="fecha_fin" id="fecha_fin" type="text" size="50" value="<?=$row['fecha_fin']?>" readonly required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="codigo_lapso">Lapso</label>  
					<div class="controls">  
						<select class="bootstrap-select form-control" title="Seleccione un Lapso" name='codigo_lapso' id='codigo_lapso' required >
							<option value=0>Seleccione un Lapso</option>
							<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT DISTINCT * FROM 
							(SELECT l.codigo_lapso,l.lapso||' ('||a.ano||')' AS lapso 
							FROM educacion.tlapso l 
							INNER JOIN educacion.tano_academico a ON l.codigo_ano_academico = a.codigo_ano_academico 
							WHERE a.cerrado='N' 
							UNION ALL 
							SELECT l.codigo_lapso,l.lapso||' ('||a.ano||')' AS lapso 
							FROM educacion.tperiodo p 
							INNER JOIN educacion.tlapso l ON l.codigo_lapso = p.codigo_lapso 
							INNER JOIN educacion.tano_academico a ON l.codigo_ano_academico = a.codigo_ano_academico 
							WHERE p.codigo_periodo = ".$pgsql->comillas_inteligentes($_GET['codigo_periodo'])." AND p.esinscripcion = 'N') lapso";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								if($rows['codigo_lapso']==$row['codigo_lapso'])
									echo "<option value=".$rows['codigo_lapso']." selected >".$rows['lapso']."</option>";
								else
									echo "<option value=".$rows['codigo_lapso'].">".$rows['lapso']."</option>";
							}
							?>
						</select>
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
						<a href="?periodo"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
					</div> 
				</div> 
			</fieldset>  
		</form>
		<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT *, TO_CHAR(fecha_inicio,'DD/MM/YYYY') as fecha_inicio,TO_CHAR(fecha_fin,'DD/MM/YYYY') as fecha_fin,
	CASE a.cerrado WHEN 'Y' THEN 'SÍ' ELSE 'NO' END AS cerrado 
	FROM educacion.tperiodo p 
	INNER JOIN educacion.tlapso l ON p.codigo_lapso = l.codigo_lapso 
	INNER JOIN educacion.tano_academico a ON l.codigo_ano_academico = a.codigo_ano_academico 
	WHERE p.codigo_periodo =".$pgsql->comillas_inteligentes($_GET['codigo_periodo'])." AND esinscripcion='N'";
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: PERÍODO</center></legend>		
		<div id="paginador" class="enjoy-css"> 
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Código:</label>
						</td>
						<td>
							<label><?=$row['codigo_periodo']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Período:</label>
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
							<label>Lapso:</label>
						</td>
						<td>
							<label><?=$row['lapso']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Cerrado:</label>
						</td>
						<td>
							<label><?=$row['cerrado']?></label>
						</td>
					</tr>
				</table>
				<center>
					<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
					<a href="?periodo"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana de Impresiones
?>