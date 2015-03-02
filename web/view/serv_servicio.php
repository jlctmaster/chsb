<script type="text/javascript" src="js/chsb_servicio.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('servicio');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT s.codigo_servicio,s.nombre_servicio,s.orden,m.nombre_modulo 
	FROM seguridad.tservicio s INNER JOIN seguridad.tmodulo m ON s.codigo_modulo = m.codigo_modulo";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: SERVICIO</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código:</th>
							<th>Servicio:</th>
							<th>Orden:</th>
							<th>Módulo:</th>
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
							echo '<td>'.$filas['codigo_servicio'].'</td>';
							echo '<td>'.$filas['nombre_servicio'].'</td>';
							echo '<td>'.$filas['orden'].'</td>';
							echo '<td>'.$filas['nombre_modulo'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?servicio&Opt=3&codigo_servicio='.$filas['codigo_servicio'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?servicio&Opt=4&codigo_servicio='.$filas['codigo_servicio'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?servicio&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
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
	<form class="form-horizontal" action="../controllers/control_servicio.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: SERVICIO</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_servicio">Código:</label>  
					<div class="controls">  
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
						<input class="input-xlarge" title="el Código del servicio es generado por el sistema" name="codigo_servicio" id="codigo_servicio" type="text" readonly /> 
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="nombre_servicio">Servicio:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el nombre del servicio" onKeyUp="this.value=this.value.toUpperCase()" name="nombre_servicio" id="nombre_servicio" type="text" size="50" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="url">Url:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la url por la cual se podrá acceder al servicio" onKeyUp="this.value=this.value.toUpperCase()" name="url" id="url" type="text" size="50" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="orden">Orden:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese número por el cual se ordenará el servicio en el menú" onKeyPress="return isNumberKey(event)" maxlength=2 name="orden" id="orden" type="text" size="50" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="codigo_modulo">Módulo:</label>  
					<div class="controls">  
						<select class="bootstrap-select form-control" title="Seleccione un Módulo" name='codigo_modulo' id='codigo_modulo' required >
							<option value=0>Seleccione un Módulo</option>
							<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT * FROM seguridad.tmodulo 
							WHERE estatus = '1' 
							ORDER BY orden ASC";
							$query = $pgsql->Ejecutar($sql);
							while($row=$pgsql->Respuesta($query)){
								echo "<option value=".$row['codigo_modulo'].">".$row['nombre_modulo']."</option>";
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
					<a href="?servicio"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div> 
			</div> 
		</fieldset>  
	</form>
	<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM seguridad.tservicio WHERE codigo_servicio =".$_GET['codigo_servicio'];
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_servicio.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: SERVICIO</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_servicio">Código:</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
						<input class="input-xlarge" title="el Código del Servicio es generado por el sistema" name="codigo_servicio" id="codigo_servicio" type="text" value="<?=$row['codigo_servicio']?>" readonly /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="nombre_servicio">Servicio:</label>  
					<div class="controls">  
						<input type="hidden" id="oldservicio" name="oldservicio" value="<?=$row['nombre_servicio']?>">
						<input class="input-xlarge" title="Ingrese el nombre del servicio" onKeyUp="this.value=this.value.toUpperCase()" name="nombre_servicio" id="nombre_servicio" type="text" value="<?=$row['nombre_servicio']?>" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="url">Url:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la url por la cual se podrá acceder al servicio" onKeyUp="this.value=this.value.toUpperCase()" name="url" id="url" type="text"  value="<?=$row['url']?>"  required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="orden">Orden:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese número por el cual se ordenara el servicio en el menú" onKeyPress="return isNumberKey(event)" maxlength=2 name="orden" id="orden" type="text" value="<?=$row['orden']?>"  required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="codigo_modulo">Módulo:</label>  
					<div class="controls">  
						<select class="bootstrap-select form-control" title="Seleccione un Módulo" name='codigo_modulo' id='codigo_modulo' required >
							<option value=0>Seleccione un Módulo</option>
							<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT * FROM seguridad.tmodulo 
							WHERE estatus = '1' 
							ORDER BY orden ASC";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								if($row['codigo_modulo']==$rows['codigo_modulo'])
									echo "<option value=".$rows['codigo_modulo']." selected >".$rows['nombre_modulo']."</option>";
								else
									echo "<option value=".$rows['codigo_modulo'].">".$rows['nombre_modulo']."</option>";
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
						<a href="?servicio"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
					</div>
				</div>  
			</fieldset>  
		</form>
		<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT s.codigo_servicio, s.nombre_servicio, s.orden, s.url, m.nombre_modulo 
	FROM seguridad.tservicio s INNER JOIN seguridad.tmodulo m ON s.codigo_modulo = m.codigo_modulo
	WHERE s.codigo_servicio =".$_GET['codigo_servicio'];
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: SERVICIO</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Código:</label>
						</td>
						<td>
							<label><?=$row['codigo_servicio']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Servicio:</label>
						</td>
						<td>
							<label><?=$row['nombre_servicio']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Url:</label>
						</td>
						<td>
							<label><?=$row['url']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Orden:</label>
						</td>
						<td>
							<label><?=$row['orden']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Módulo:</label>
						</td>
						<td>
							<label><?=$row['nombre_modulo']?></label>
						</td>
					</tr>
				</table>
				<center>
					<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
					<a href="?servicio"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana de Impresiones
?>