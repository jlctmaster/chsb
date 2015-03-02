<script type="text/javascript" src="js/chsb_opcion.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('botones');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM seguridad.topcion";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: BOTONES</center></legend>		
		<div id="paginador" class="enjoy-css"> 
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código</th>
							<th>Botón</th>
							<th>Orden</th>
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
							echo '<td>'.$filas['codigo_opcion'].'</td>';
							echo '<td>'.$filas['nombre_opcion'].'</td>';
							echo '<td>'.$filas['orden'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?botones&Opt=3&codigo_opcion='.$filas['codigo_opcion'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?botones&Opt=4&codigo_opcion='.$filas['codigo_opcion'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?botones&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
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
	<form class="form-horizontal" action="../controllers/control_opcion.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: BOTONES</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_opcion">Código:</label>  
					<div class="controls">  
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
						<input class="input-xlarge" title="el Código del botón es generado por el sistema" name="codigo_opcion" id="codigo_opcion" type="text" readonly /> 
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="nombre_opcion">Botón:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el nombre del botón" onKeyUp="this.value=this.value.toUpperCase()" name="nombre_opcion" id="nombre_opcion" type="text" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="accion">Acción:</label>  
					<div class="controls">  
						<select class="bootstrap-select form-control" name="accion" id="accion" title="Seleccione una acción" required >
							<option value="0">Sin acción</option>
							<option value="1">Insertar,Incluir,Registrar,Guardar</option>
							<option value="2">Modificar,Actualizar,Guardar</option>
							<option value="3">Desactivar,Deshabilitar,Guardar</option>
							<option value="4">Activar,Habilitar,Guardar</option>
							<option value="5">Buscar,Consultar,Imprimir</option>
							<option value="6">Otros</option>
						</select>
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="orden">Orden:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese número por el cual se ordenará el botón en el menú" onKeyPress="return isNumberKey(event)" maxlength=2 name="orden" id="orden" type="text" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="icono">Icono:</label>  
					<div class="controls">  
						<div class="radios">
							<input name="icono" id="icono" type="radio" value="ninguno" title="Ningún Icono" checked="checked" required/>
							<span>Ninguno</span> <br>
							<input name="icono" id="icono" type="radio" value="icon-pencil" title="Seleccionar icono de registro" required/>
							<span class="icon-pencil" title="Icono de registro"></span> 
							<input name="icono" id="icono" type="radio" value="icon-edit" title="Seleccionar icono de editar" required/>
							<span class="icon-edit" title="Icono de editar"></span> 
							<input name="icono" id="icono" type="radio" value="icon-eye-close" title="Seleccionar icono de no visible" required/>
							<span class="icon-eye-close" title="Icono de no visible"></span> 
							<input name="icono" id="icono" type="radio" value="icon-eye-open" title="Seleccionar icono de visible" required/>
							<span class="icon-eye-open" title="Icono de visible"></span> 
							<input name="icono" id="icono" type="radio" value="icon-search" title="Seleccionar icono de buscar" required/>
							<span class="icon-search" title="Icono de buscar"></span> <br>
							<input name="icono" id="icono" type="radio" value="icon-plus" title="Seleccionar icono de agregar" required/>
							<span class="icon-plus" title="Icono de agregar"></span> 
							<input name="icono" id="icono" type="radio" value="icon-refresh" title="Seleccionar icono de actualizar" required/>
							<span class="icon-refresh" title="Icono de actualizar"></span> 
							<input name="icono" id="icono" type="radio" value="icon-remove" title="Seleccionar icono de remover" required/>
							<span class="icon-remove" title="Icono de remover"></span> 
							<input name="icono" id="icono" type="radio" value="icon-ok" title="Seleccionar icono habilitar" required/>
							<span class="icon-ok" title="Icono de habilitar"></span> 
							<input name="icono" id="icono" type="radio" value="icon-zoom-in" title="Seleccionar icono de acercar" required/>
							<span class="icon-zoom-in" title="Icono de acercar"></span> <br>
							<input name="icono" id="icono" type="radio" value="icon-ok-circle" title="Seleccionar icono de añadir" required/>
							<span class="icon-ok-circle" title="Icono de añadir"></span> 
							<input name="icono" id="icono" type="radio" value="icon-check" title="Seleccionar icono de comprobar" required/>
							<span class="icon-check" title="Icono de comprobar"></span> 
							<input name="icono" id="icono" type="radio" value="icon-trash" title="Seleccionar icono de eliminar" required/>
							<span class="icon-trash" title="Icono de eliminar"></span> 
							<input name="icono" id="icono" type="radio" value="icon-heart" title="Seleccionar icono salvar" required/>
							<span class="icon-heart" title="Icono de salvar"></span> 
							<input name="icono" id="icono" type="radio" value="icon-download" title="Seleccionar icono de descargar" required/>
							<span class="icon-download" title="Icono de descargar"></span> 
						</div>
					</div>  
				</div>
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
					<a href="?botones"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div>  
			</div>
		</fieldset>  
	</form>
	<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM seguridad.topcion WHERE codigo_opcion =".$_GET['codigo_opcion'];
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_opcion.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: BOTONES</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_opcion">Código:</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
						<input class="input-xlarge" title="el Código del Botón es generado por el sistema" name="codigo_opcion" id="codigo_opcion" type="text" value="<?=$row['codigo_opcion']?>" readonly /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="nombre_opcion">Botón:</label>  
					<div class="controls">  
						<input type="hidden" id="oldopcion" name="oldopcion" value="<?=$row['nombre_opcion']?>"> 
						<input class="input-xlarge" title="Ingrese el nombre del opcion" onKeyUp="this.value=this.value.toUpperCase()" name="nombre_opcion" id="nombre_opcion" type="text" value="<?=$row['nombre_opcion']?>" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="accion">Acción:</label>  
					<div class="controls">  
						<select class="bootstrap-select form-control" name="accion" id="accion" title="Seleccione una acción" required >
							<option <?php  if($row['accion']==0) echo "selected"; ?> value="0">Sin acción</option>
							<option <?php  if($row['accion']==1) echo "selected"; ?> value="1">Insertar,Incluir,Registrar,Guardar</option>
							<option <?php  if($row['accion']==2) echo "selected"; ?> value="2">Modificar,Actualizar,Guardar</option>
							<option <?php  if($row['accion']==3) echo "selected"; ?> value="3">Desactivar,Deshabilitar,Guardar</option>
							<option <?php  if($row['accion']==4) echo "selected"; ?> value="4">Activar,Habilitar,Guardar</option>
							<option <?php  if($row['accion']==5) echo "selected"; ?> value="5">Buscar,Consultar,Imprimir</option>
							<option <?php  if($row['accion']==6) echo "selected"; ?> value="6">Otros</option>
						</select>
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="orden">Orden:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese número por el cual se ordenará el botón en el menú" onKeyPress="return isNumberKey(event)" maxlength=2 name="orden" id="orden" type="text" value="<?=$row['orden']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="icono">Icono:</label>  
					<div class="controls">  
						<div class="radios">
							<input name="icono" id="icono" type="radio" value="ninguno" title="Ningún Icono" <?php if($row['icono']=="ninguno"){ echo "checked='checked'"; } ?> required/>
							<span>Ninguno</span> <br>
							<input name="icono" id="icono" type="radio" value="icon-pencil" title="Seleccionar icono de registro" <?php if($row['icono']=="icon-pencil"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-pencil" title="Icono de registro"></span> 
							<input name="icono" id="icono" type="radio" value="icon-edit" title="Seleccionar icono de editar" <?php if($row['icono']=="icon-edit"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-edit" title="Icono de editar"></span> 
							<input name="icono" id="icono" type="radio" value="icon-eye-close" title="Seleccionar icono de no visible" <?php if($row['icono']=="icon-eye-close"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-eye-close" title="Icono de no visible"></span> 
							<input name="icono" id="icono" type="radio" value="icon-eye-open" title="Seleccionar icono de visible" <?php if($row['icono']=="icon-eye-open"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-eye-open" title="Icono de visible"></span> 
							<input name="icono" id="icono" type="radio" value="icon-search" title="Seleccionar icono de buscar" <?php if($row['icono']=="icon-search"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-search" title="Icono de buscar"></span> <br>
							<input name="icono" id="icono" type="radio" value="icon-plus" title="Seleccionar icono de agregar" <?php if($row['icono']=="icon-plus"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-plus" title="Icono de agregar"></span> 
							<input name="icono" id="icono" type="radio" value="icon-refresh" title="Seleccionar icono de actualizar" <?php if($row['icono']=="icon-refresh"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-refresh" title="Icono de actualizar"></span> 
							<input name="icono" id="icono" type="radio" value="icon-remove" title="Seleccionar icono de remover" <?php if($row['icono']=="icon-remove"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-remove" title="Icono de remover"></span> 
							<input name="icono" id="icono" type="radio" value="icon-ok" title="Seleccionar icono habilitar" <?php if($row['icono']=="icon-ok"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-ok" title="Icono de habilitar"></span> 
							<input name="icono" id="icono" type="radio" value="icon-zoom-in" title="Seleccionar icono de acercar" <?php if($row['icono']=="icon-zoom-in"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-zoom-in" title="Icono de acercar"></span> <br>
							<input name="icono" id="icono" type="radio" value="icon-ok-circle" title="Seleccionar icono de añadir" <?php if($row['icono']=="icon-ok-circle"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-ok-circle" title="Icono de añadir"></span> 
							<input name="icono" id="icono" type="radio" value="icon-check" title="Seleccionar icono de comprobar" <?php if($row['icono']=="icon-check"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-check" title="Icono de comprobar"></span> 
							<input name="icono" id="icono" type="radio" value="icon-trash" title="Seleccionar icono de eliminar" <?php if($row['icono']=="icon-trash"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-trash" title="Icono de eliminar"></span> 
							<input name="icono" id="icono" type="radio" value="icon-heart" title="Seleccionar icono salvar" <?php if($row['icono']=="icon-heart"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-heart" title="Icono de salvar"></span> 
							<input name="icono" id="icono" type="radio" value="icon-download" title="Seleccionar icono de descargar" <?php if($row['icono']=="icon-download"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-download" title="Icono de descargar"></span> 
						</div>
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
						<a href="?botones"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
					</div>  
				</div>
			</fieldset>  
		</form>
		<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT codigo_opcion,nombre_opcion,orden,icono,
	CASE accion WHEN 1 THEN 'Insertar,Incluir,Registrar,Guardar' WHEN 2 THEN 'Modificar,Actualizar,Guardar' 
	WHEN 3 THEN 'Desactivar,Deshabilitar,Guardar' WHEN 4 THEN 'Activar,Habilitar,Guardar' WHEN 5 THEN 'Buscar,Consultar,Imprimir' 
	WHEN 6 THEN 'Otros' ELSE 'Sin acción' END AS accion 
	FROM seguridad.topcion WHERE codigo_opcion =".$_GET['codigo_opcion'];
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: BOTONES</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Código:</label>
						</td>
						<td>
							<label><?=$row['codigo_opcion']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Botón:</label>
						</td>
						<td>
							<label><?=$row['nombre_opcion']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Acción:</label>
						</td>
						<td>
							<label><?=$row['accion']?></label>
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
							<label>Icono:</label>
						</td>
						<td>
							<?php
							if($row['icono']=='ninguno')
								echo "<span>Ninguno</span>";
							else
								echo "<i class='".$row['icono']."'></i>";
							?>
						</td>
					</tr>
				</table>
				<center>
					<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
					<a href="?botones"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana de Impresiones
?>