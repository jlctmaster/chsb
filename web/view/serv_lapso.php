<script type="text/javascript" src="js/chsb_lapso.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('lapso');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT l.codigo_lapso,l.lapso, a.ano FROM educacion.tlapso l
	INNER JOIN educacion.tano_academico a ON l.codigo_ano_academico = a.codigo_ano_academico";
	$consulta = $pgsql->Ejecutar($sql);
	?>

	<fieldset>
		<legend><center>Vista: LAPSO</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código:</th>
							<th>Lapso:</th>
							<th>Año Académico:</th>
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
							echo '<td>'.$filas['codigo_lapso'].'</td>';
							echo '<td>'.$filas['lapso'].'</td>';
							echo '<td>'.$filas['ano'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?lapso&Opt=3&codigo_lapso='.$filas['codigo_lapso'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?lapso&Opt=4&codigo_lapso='.$filas['codigo_lapso'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?lapso&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
						?>
						<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>
					</center>		
					<div id="Imprimir" style="display:none;">
						<span>Descargar Como:</span>
						<br/><br/>
						<a href="<?php echo  '../pdf/pdf_lapso.php';?>" target="_blank"><img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"></a>
						&nbsp;&nbsp;						
						<a href="../excel/excel_lapso.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
					</div>
				</div>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
	?>
	<form class="form-horizontal" action="../controllers/control_lapso.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: LAPSO</center></legend>		
			<div id="paginador" class="enjoy-css">	
				<div class="control-group">  
					<label class="control-label" for="codigo_lapso">Código:</label>  
					<div class="controls">  
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
						<input class="input-xlarge" title="el Código del lapso es generado por el sistema" name="codigo_lapso" id="codigo_lapso" type="text" readonly /> 
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="lapso">Lapso:</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" name="lapso" id="lapso" title="Seleccione un Lapso" required > 
							<option value=0>Seleccione un Lapso</option>
							<option value="1er" >I Lapso</option>
							<option value="2do" >II Lapso</option>
							<option value="3er" >III Lapso</option>		
						</select>
					</div>
				</div>   
				<div class="control-group">  
					<label class="control-label" for="codigo_ano_academico">Año Académico:</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione un Año" name='codigo_ano_academico' id='codigo_ano_academico' required >
							<option value=0>Seleccione un Año</option>
							<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT * FROM educacion.tano_academico ORDER BY ano ASC";
							$query = $pgsql->Ejecutar($sql);
							while($row=$pgsql->Respuesta($query)){
								echo "<option value=".$row['codigo_ano_academico'].">".$row['ano']."</option>";
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
					<a href="?lapso"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div>  
			</div>
		</fieldset>  
	</form>
	<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT codigo_lapso,trim(lapso) as lapso,codigo_ano_academico,estatus FROM educacion.tlapso WHERE codigo_lapso =".$pgsql->comillas_inteligentes($_GET['codigo_lapso']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_lapso.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: LAPSO</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_lapso">Código:</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
						<input class="input-xlarge" title="el Código del lapso es generado por el sistema" name="codigo_lapso" id="codigo_lapso" type="text" value="<?=$row['codigo_lapso']?>" readonly /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="lapso">Lapso:</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" name="lapso" id="lapso" title="Seleccione un Lapso" required > 
							<option value=0>Seleccione un Lapso </option>
							<option value="1er" <? if($row['lapso']=="1er") {echo "selected";} ?> >I Lapso</option>
							<option value="2do" <? if($row['lapso']=="2do") {echo "selected";} ?> >II Lapso</option>
							<option value="3er" <? if($row['lapso']=="3er") {echo "selected";} ?> >III Lapso</option>		
						</select>
					</div>
				</div>   
				<div class="control-group">  
					<label class="control-label" for="codigo_ano_academico">Año Académico:</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione un Año" name='codigo_ano_academico' id='codigo_ano_academico' required >
							<option value=0>Seleccione un Año</option>
							<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT * FROM educacion.tano_academico ORDER BY ano ASC";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								if($rows['codigo_ano_academico']==$row['codigo_ano_academico'])
									echo "<option value=".$rows['codigo_ano_academico']." selected >".$rows['ano']."</option>";
								else
									echo "<option value=".$rows['codigo_ano_academico'].">".$rows['ano']."</option>";
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
						<a href="?lapso"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
					</div>  
				</div>
			</fieldset>  
		</form>
		<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT l.codigo_lapso,l.lapso, a.ano FROM educacion.tlapso l
	INNER JOIN educacion.tano_academico a ON l.codigo_ano_academico = a.codigo_ano_academico 
	WHERE l.codigo_lapso =".$pgsql->comillas_inteligentes($_GET['codigo_lapso']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />	
	<fieldset>
		<legend><center>Vista: LAPSO</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Código:</label>
						</td>
						<td>
							<label><?=$row['codigo_lapso']?></label>
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
							<label>Año:</label>
						</td>
						<td>
							<label><?=$row['ano']?></label>
						</td>
					</tr>
				</table>
				<center>
					<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
					<a href="?lapso"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana de Impresiones
?>