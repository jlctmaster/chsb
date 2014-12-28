<script type="text/javascript" src="js/chsb_configuracion_bien.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('configuracion_bien');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM bienes_nacionales.tconfiguracion_bien";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: CONFIGURACIÓN DEL BIEN</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código:</th>
							<th>Código Bien:</th>
							<th>Item Base:</th>
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
							echo '<td>'.$filas['codigo_configuracion_bien'].'</td>';
							echo '<td>'.$filas['codigo_bien'].'</td>';
							echo '<td>'.$filas['item_base'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?configuracion_bien&Opt=3&codigo_configuracion_bien='.$filas['codigo_configuracion_bien'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?configuracion_bien&Opt=4&codigo_configuracion_bien='.$filas['codigo_configuracion_bien'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?configuracion_bien&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
						?>
					</center>
				</div>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
	?>
	<form class="form-horizontal" action="../controllers/control_configuracion_bien.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: CONFIGURACIÓN DEL BIEN</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_configuracion_bien">Código:</label>  
					<div class="controls">  
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
						<input class="input-xlarge" title="el Código de la configuración del bien es generado por el sistema" name="codigo_configuracion_bien" id="codigo_configuracion_bien" type="text" readonly /> 
					</div>  
				</div> 

				<div class="control-group">  
					<label class="control-label" for="codigo_bien">Bien:</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione un Bien" name='codigo_bien' id='codigo_bien' required >
							<option value=0>Seleccione un Bien</option>
							<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT * FROM bienes_nacionales.tbien ORDER BY nombre ASC";
							$query = $pgsql->Ejecutar($sql);
							while($row=$pgsql->Respuesta($query)){
								echo "<option value=".$row['codigo_bien'].">".$row['nombre']."</option>";
							}
							?>
						</select>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="codigo_item">Código Item:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el código del iten" name="codigo_item" id="codigo_item" type="text" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cantidad">Cantidad:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad" onKeyPress="return isNumberKey(event)" name="cantidad" id="cantidad" type="text" />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="item_base">Item Base:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el item base" onKeyUp="this.value=this.value.toUpperCase()" name="item_base" id="item_base" type="text" />
					</div>  
				</div>  

				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
					<a href="?configuracion_bien"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div> 
			</div> 
		</fieldset>  
	</form>
	<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * bienes_nacionales.tconfiguracion_bien";
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_configuracion_bien.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: CONFIGURACIÓN DEL BIEN</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_configuracion_bien">Código:</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
						<input class="input-xlarge" title="el Código de la configuración del bien es generado por el sistema" name="codigo_configuracion_bien" id="codigo_configuracion_bien" type="text" value="<?=$row['codigo_configuracion_bien']?>" readonly /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="codigo_bien">Bien</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione una Bien" name='codigo_bien' id='codigo_bien' required >
							<option value=0>Seleccione un Bien</option>
							<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT * FROM bienes_nacionales.tbien ORDER BY nombre ASC";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								if($rows['codigo_bien']==$row['codigo_bien'])
									echo "<option value=".$rows['codigo_bien']." selected >".$rows['nombre']."</option>";
								else
									echo "<option value=".$row['codigo_bien'].">".$row['nombre']."</option>";
							}
							?>
						</select>
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="codigo_item">Código Item:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese código del item" name="codigo_item" id="codigo_item" type="text" value="<?=$row['codigo_item']?>" readonly required />
					</div>  
				</div>

				<div class="control-group">  
					<label class="control-label" for="cantidad">Cantidad:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad" onKeyPress="return isNumberKey(event)" name="cantidad" id="cantidad" type="text" value="<?=$row['cantidad']?>" />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="item_base">Item Base:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el item base" onKeyUp="this.value=this.value.toUpperCase()" name="item_base" id="item_base" type="text" value="<?=$row['item_base']?>" />
					</div>  
				</div>  

				<div class="control-group">  
					<?php if($row['estatus']=='1'){echo "<p id='estatus' class='Activo'>Activo </p>";}else{echo "<p id='estatus' class='Desactivado'>Desactivado</p>";} ?>
				</div>  
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<div class="form-action">
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
						<a href="?configuracion_bien"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
					</div> 
				</div> 
			</fieldset>  
		</form>
		<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * 
	FROM bienes_nacionales.tconfiguracion_bien cb 
	INNER JOIN bienes_nacionales.tbien b ON cb.codigo_bien = b.codigo_bien
	WHERE cb.codigo_configuracion_bien =".$_GET['codigo_configuracion_bien'];
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: CONFIGURACIÓN DEL BIEN</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Código:</label>
						</td>
						<td>
							<label><?=$row['codigo_configuracion_bien']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Bien:</label>
						</td>
						<td>
							<label><?=$row['codigo_bien']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Código Item:</label>
						</td>
						<td>
							<label><?=$row['codigo_item']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Cantidad:</label>
						</td>
						<td>
							<label><?=$row['cantidad']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Item Base:</label>
						</td>
						<td>
							<label><?=$row['item_base']?></label>
						</td>
					</tr>

				</table>
				<center>
					<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
					<a href="?configuracion_bien"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana de Impresiones
?>