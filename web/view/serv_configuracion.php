<script type="text/javascript" src="js/chsb_configuracion.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('configuracion');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM seguridad.tconfiguracion";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: CONFIGURACIÓN DEL SISTEMA</center></legend>		
		<div id="paginador" class="enjoy-css"> 
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código:</th>
							<th>Nombre:</th>
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
							echo '<td>'.$filas['codigo_configuracion'].'</td>';
							echo '<td>'.$filas['descripcion'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?configuracion&Opt=3&codigo_configuracion='.$filas['codigo_configuracion'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?configuracion&Opt=4&codigo_configuracion='.$filas['codigo_configuracion'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?configuracion&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
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
	<form class="form-horizontal" action="../controllers/control_configuracion.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: CONFIGURACIÓN DEL SISTEMA</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_configuracion">Código:</label>  
					<div class="controls">  
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
						<input class="input-xlarge" title="El código de la configuración es generado por el sistema" name="codigo_configuracion" id="codigo_configuracion" type="text" readonly /> 
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="descripcion">Nombre:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el nombre de la configuración" onKeyUp="this.value=this.value.toUpperCase()" name="descripcion" id="descripcion" type="text" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="longitud_minclave">Longitud Mínima de la Clave:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la longitud mínima para la clave" onKeyPress="return isNumberKey(event)" maxlength=2 name="longitud_minclave" id="longitud_minclave" type="text" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="longitud_maxclave">Longitud Máxima de la Clave:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la longitud máxima para la clave" onKeyPress="return isNumberKey(event)" maxlength=2 name="longitud_maxclave" id="longitud_maxclave" type="text" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cantidad_letrasmayusculas">Cantidad de Letras Mayúsculas:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de letras mayúsculas" onKeyPress="return isNumberKey(event)" maxlength=2 name="cantidad_letrasmayusculas" id="cantidad_letrasmayusculas" type="text" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cantidad_letrasminusculas">Cantidad de Letras Minúsculas:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de letras minúsculas" onKeyPress="return isNumberKey(event)" maxlength=2 name="cantidad_letrasminusculas" id="cantidad_letrasminusculas" type="text" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cantidad_numeros">Cantidad de Carácteres Númericos:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de carácteres númericos" onKeyPress="return isNumberKey(event)" maxlength=2 name="cantidad_numeros" id="cantidad_numeros" type="text" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cantidad_caracteresespeciales">Cantidad de Carácteres Especiales:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de carácteres especiales" onKeyPress="return isNumberKey(event)" maxlength=2 name="cantidad_caracteresespeciales" id="cantidad_caracteresespeciales" type="text" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="dias_vigenciaclave">Cantidad de Días de Vigencia de la Clave:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de días para la vigencia de la clave" onKeyPress="return isNumberKey(event)" maxlength=3 name="dias_vigenciaclave" id="dias_vigenciaclave" type="text" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="dias_aviso">Cantidad de Días de Aviso de la Clave:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de días para avisar el vencimiento de la clave" onKeyPress="return isNumberKey(event)" maxlength=3 name="dias_aviso" id="dias_aviso" type="text" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="numero_ultimasclaves">Cantidad de Últimas Claves Usadas:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad a validar de las últimas claves usadas" onKeyPress="return isNumberKey(event)" maxlength=2 name="numero_ultimasclaves" id="numero_ultimasclaves" type="text" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="intentos_fallidos">Cantidad de Intentos Fallidos:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de intentos fallidos a validar para acceder al sistema" onKeyPress="return isNumberKey(event)" maxlength=2 name="intentos_fallidos" id="intentos_fallidos" type="text" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="numero_preguntas">Cantidad de Preguntas Secretas:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de preguntas secretas" onKeyPress="return isNumberKey(event)" maxlength=2 name="numero_preguntas" id="numero_preguntas" type="text" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="numero_preguntasaresponder">Cantidad de Preguntas a Responder:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de preguntas secretas a responder" onKeyPress="return isNumberKey(event)" maxlength=2 name="numero_preguntasaresponder" id="numero_preguntasaresponder" type="text" required />
					</div>  
				</div>
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
					<a href="?configuracion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div>  
			</div>
		</fieldset>  
	</form>
	<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM seguridad.tconfiguracion 
	WHERE codigo_configuracion =".$_GET['codigo_configuracion'];
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_configuracion.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: CONFIGURACIÓN DEL SISTEMA</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_configuracion">Código:</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
						<input class="input-xlarge" title="el Código del Estado es generado por el sistema" name="codigo_configuracion" id="codigo_configuracion" type="text" value="<?=$row['codigo_configuracion']?>" readonly /> 
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="descripcion">Nombre:</label>  
					<div class="controls">  
						<input type="hidden" id="olddescripcion" name="olddescripcion" value="<?=$row['descripcion']?>">  
						<input class="input-xlarge" title="Ingrese el nombre de la configuración" onKeyUp="this.value=this.value.toUpperCase()" name="descripcion" id="descripcion" type="text" value="<?=$row['descripcion']?>" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="longitud_minclave">Longitud Mínima de la Clave:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la longitud mínima para la clave" onKeyPress="return isNumberKey(event)" maxlength=2 name="longitud_minclave" id="longitud_minclave" type="text" value="<?=$row['longitud_minclave']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="longitud_maxclave">Longitud Máxima de la Clave:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la longitud máxima para la clave" onKeyPress="return isNumberKey(event)" maxlength=2 name="longitud_maxclave" id="longitud_maxclave" type="text" value="<?=$row['longitud_maxclave']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cantidad_letrasmayusculas">Cantidad de Letras Mayúsculas:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de letras mayúsculas" onKeyPress="return isNumberKey(event)" maxlength=2 name="cantidad_letrasmayusculas" id="cantidad_letrasmayusculas" type="text" value="<?=$row['cantidad_letrasmayusculas']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cantidad_letrasminusculas">Cantidad de Letras Minúsculas:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de letras minúsculas" onKeyPress="return isNumberKey(event)" maxlength=2 name="cantidad_letrasminusculas" id="cantidad_letrasminusculas" type="text" value="<?=$row['cantidad_letrasminusculas']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cantidad_numeros">Cantidad de Carácteres Númericos:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de carácteres númericos" onKeyPress="return isNumberKey(event)" maxlength=2 name="cantidad_numeros" id="cantidad_numeros" type="text" value="<?=$row['cantidad_numeros']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="cantidad_caracteresespeciales">Cantidad de Carácteres Especiales:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de carácteres especiales" onKeyPress="return isNumberKey(event)" maxlength=2 name="cantidad_caracteresespeciales" id="cantidad_caracteresespeciales" type="text" value="<?=$row['cantidad_caracteresespeciales']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="dias_vigenciaclave">Cantidad de Días de Vigencia de la Clave:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de días para la vigencia de la clave" onKeyPress="return isNumberKey(event)" maxlength=3 name="dias_vigenciaclave" id="dias_vigenciaclave" type="text" value="<?=$row['dias_vigenciaclave']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="dias_aviso">Cantidad de Días de Aviso de la Clave:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de días para avisar el vencimiento de la clave" onKeyPress="return isNumberKey(event)" maxlength=3 name="dias_aviso" id="dias_aviso" type="text" value="<?=$row['dias_aviso']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="numero_ultimasclaves">Cantidad de Últimas Claves Usadas:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de las últimas claves usadas a validar" onKeyPress="return isNumberKey(event)" maxlength=2 name="numero_ultimasclaves" id="numero_ultimasclaves" type="text" value="<?=$row['numero_ultimasclaves']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="intentos_fallidos">Cantidad de Intentos Fallidos:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de intentos fallidos a validar para acceder al sistema" onKeyPress="return isNumberKey(event)" maxlength=2 name="intentos_fallidos" id="intentos_fallidos" type="text" value="<?=$row['intentos_fallidos']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="numero_preguntas">Cantidad de Preguntas Secretas:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de preguntas secretas" onKeyPress="return isNumberKey(event)" maxlength=2 name="numero_preguntas" id="numero_preguntas" type="text" value="<?=$row['numero_preguntas']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="numero_preguntasaresponder">Cantidad de Preguntas a Responder:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la cantidad de preguntas secretas a responder" onKeyPress="return isNumberKey(event)" maxlength=2 name="numero_preguntasaresponder" id="numero_preguntasaresponder" type="text" value="<?=$row['numero_preguntasaresponder']?>" required />
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
						<a href="?configuracion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
					</div>  
				</div>
			</fieldset>  
		</form>
		<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM seguridad.tconfiguracion WHERE codigo_configuracion =".$_GET['codigo_configuracion'];
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: CONFIGURACIÓN DEL SISTEMA</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Código:</label>
						</td>
						<td>
							<label><?=$row['codigo_configuracion']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Nombre:</label>
						</td>
						<td>
							<label><?=$row['descripcion']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Longitud Mínima de la Clave:</label>
						</td>
						<td>
							<label><?=$row['longitud_minclave']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Longitud Maxima de la Clave:</label>
						</td>
						<td>
							<label><?=$row['longitud_maxclave']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Cantidad de Letras Mayúsculas:</label>
						</td>
						<td>
							<label><?=$row['cantidad_letrasmayusculas']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Cantidad de Letras Minúsculas:</label>
						</td>
						<td>
							<label><?=$row['cantidad_letrasminusculas']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Cantidad de Carácteres Númericos:</label>
						</td>
						<td>
							<label><?=$row['cantidad_numeros']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Cantidad de Carácteres Especiales:</label>
						</td>
						<td>
							<label><?=$row['cantidad_caracteresespeciales']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Cantidad de Días de Vigencia de la Clave:</label>
						</td>
						<td>
							<label><?=$row['dias_vigenciaclave']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Cantidad de Días de Aviso de la Clave:</label>
						</td>
						<td>
							<label><?=$row['dias_aviso']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Cantidad de Últimas Claves Usadas:</label>
						</td>
						<td>
							<label><?=$row['numero_ultimasclaves']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Cantidad de Intentos Fallidos:</label>
						</td>
						<td>
							<label><?=$row['intentos_fallidos']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Cantidad de Preguntas Secretas:</label>
						</td>
						<td>
							<label><?=$row['numero_preguntas']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Cantidad de Preguntas a Responder:</label>
						</td>
						<td>
							<label><?=$row['numero_preguntasaresponder']?></label>
						</td>
					</tr>
				</table>
				<center>
					<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
					<a href="?configuracion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana de Impresiones
?>