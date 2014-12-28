<script type="text/javascript" src="js/chsb_modulo.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('modulo');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM seguridad.tmodulo";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: MÓDULO</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código:</th>
							<th>Módulo:</th>
							<th>Orden:</th>
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
							echo '<td>'.$filas['codigo_modulo'].'</td>';
							echo '<td>'.$filas['nombre_modulo'].'</td>';
							echo '<td>'.$filas['orden'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?modulo&Opt=3&codigo_modulo='.$filas['codigo_modulo'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?modulo&Opt=4&codigo_modulo='.$filas['codigo_modulo'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?modulo&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
						?>
					</center>
				</div>
			</div>
			<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
	?>
	<form class="form-horizontal" action="../controllers/control_modulo.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: MÓDULO</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_modulo">Código:</label>  
					<div class="controls">  
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
						<input class="input-xlarge" title="el Código del Módulo es generado por el sistema" name="codigo_modulo" id="codigo_modulo" type="text" readonly /> 
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="nombre_modulo">Módulo:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el nombre del módulo" onKeyUp="this.value=this.value.toUpperCase()" name="nombre_modulo" id="nombre_modulo" type="text" size="50" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="orden">Orden:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese número por el cual se ordenará el módulo en el menú" onKeyPress="return isNumberKey(event)" maxlength=2 name="orden" id="orden" type="text" size="50" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="icono">Icono:</label>  
					<div class="controls">  
						<div class="radios">
							<input name="icono" id="icono" type="radio" value="icon-home" title="Seleccionar icono de casa" checked="checked" required/>
							<span class="icon-home" title="Icono de casa"></span> 
							<input name="icono" id="icono" type="radio" value="icon-list" title="Seleccionar icono de lista" required/>
							<span class="icon-list" title="Icono de lista"></span> 
							<input name="icono" id="icono" type="radio" value="icon-list-alt" title="Seleccionar icono de lista alternativa" required/>
							<span class="icon-list-alt" title="Icono de lista alternativa"></span> 
							<input name="icono" id="icono" type="radio" value="icon-cog" title="Seleccionar icono de configuraci&oacute;n" required/>
							<span class="icon-cog" title="Icono de configuraci&oacute;n"></span> 
							<input name="icono" id="icono" type="radio" value="icon-lock" title="Seleccionar icono de seguridad" required/>
							<span class="icon-lock" title="Icono de seguridad"></span> 
						</div>
					</div>  
				</div>
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
					<a href="?modulo"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div> 
			</div> 
		</fieldset>  
	</form>
	<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM seguridad.tmodulo WHERE codigo_modulo =".$_GET['codigo_modulo'];
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_modulo.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: MÓDULO</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_modulo">Código:</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
						<input class="input-xlarge" title="el Código del Módulo es generado por el sistema" name="codigo_modulo" id="codigo_modulo" type="text" value="<?=$row['codigo_modulo']?>" readonly /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="nombre_modulo">Módulo:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el nombre del modulo" onKeyUp="this.value=this.value.toUpperCase()" name="nombre_modulo" id="nombre_modulo" type="text" value="<?=$row['nombre_modulo']?>" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="orden">Orden:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese número por el cual se ordenará el módulo en el menú" onKeyPress="return isNumberKey(event)" maxlength=2 name="orden" id="orden" type="text" value="<?=$row['orden']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="icono">Icono:</label>  
					<div class="controls">  
						<div class="radios">
							<input name="icono" id="icono" type="radio" value="icon-home" title="Seleccionar icono de casa" <? if($row['icono']=="icon-home"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-home" title="Icono de casa"></span> 
							<input name="icono" id="icono" type="radio" value="icon-list" title="Seleccionar icono de lista" <? if($row['icono']=="icon-list"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-list" title="Icono de lista"></span> 
							<input name="icono" id="icono" type="radio" value="icon-list-alt" title="Seleccionar icono de lista alternativa" <? if($row['icono']=="icon-list-alt"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-list-alt" title="Icono de lista alternativa"></span> 
							<input name="icono" id="icono" type="radio" value="icon-cog" title="Seleccionar icono de configuraci&oacute;n" <? if($row['icono']=="icon-cog"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-cog" title="Icono de configuraci&oacute;n"></span> 
							<input name="icono" id="icono" type="radio" value="icon-lock" title="Seleccionar icono de seguridad" <? if($row['icono']=="icon-lock"){ echo "checked='checked'"; } ?> required/>
							<span class="icon-lock" title="Icono de seguridad"></span> 
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
						<a href="?modulo"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
					</div>  
				</fieldset>  
			</form>
			<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM seguridad.tmodulo WHERE codigo_modulo =".$_GET['codigo_modulo'];
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: MÓDULO</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Código:</label>
						</td>
						<td>
							<label><?=$row['codigo_modulo']?></label>
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
							<i class="<?=$row['icono']?>"></i>
						</td>
					</tr>
				</table>
				<center>
					<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
					<a href="?modulo"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana de Impresiones
?>