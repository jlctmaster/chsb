<script type="text/javascript" src="js/chsb_perfil.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('perfiles');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT p.codigo_perfil,p.nombre_perfil,c.descripcion AS configuracion 
	FROM seguridad.tperfil p INNER JOIN seguridad.tconfiguracion c ON p.codigo_configuracion = c.codigo_configuracion";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: PERFIL DE USUARIO</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código:</th>
							<th>Perfil:</th>
							<th>Conf. de Sistema:</th>
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
							echo '<td>'.$filas['codigo_perfil'].'</td>';
							echo '<td>'.$filas['nombre_perfil'].'</td>';
							echo '<td>'.$filas['configuracion'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?perfiles&Opt=3&codigo_perfil='.$filas['codigo_perfil'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?perfiles&Opt=4&codigo_perfil='.$filas['codigo_perfil'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?perfiles&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
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
	<form class="form-horizontal" action="../controllers/control_perfil.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: PERFIL DE USUARIO</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_perfil">Código:</label>  
					<div class="controls">  
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
						<input class="input-xlarge" title="el Código del perfil es generado por el sistema" name="codigo_perfil" id="codigo_perfil" type="text" readonly /> 
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="nombre_perfil">Perfil:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el nombre del perfil" onKeyUp="this.value=this.value.toUpperCase()" name="nombre_perfil" id="nombre_perfil" type="text" size="50" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="codigo_configuracion">Configuración del Sistema:</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione una Configuración del Sistema" name='codigo_configuracion' id='codigo_configuracion' required >
							<option value=0>Seleccione una Configuración del Sistema</option>
							<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT * FROM seguridad.tconfiguracion ORDER BY descripcion ASC";
							$query = $pgsql->Ejecutar($sql);
							while($row=$pgsql->Respuesta($query)){
								echo "<option value=".$row['codigo_configuracion'].">".$row['descripcion']."</option>";
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
					<a href="?perfiles"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div>  
				<?php 
				include_once('../class/class_html.php');
				$html=new Html();
				$html->tabla_accesos(null);   
				?>  
			</div>
		</fieldset>  
	</form>
	<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM seguridad.tperfil WHERE codigo_perfil =".$_GET['codigo_perfil'];
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_perfil.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: PERFIL DE USUARIO</center></legend>		
			<div id="paginador" class="enjoy-css">
				<div class="control-group">  
					<label class="control-label" for="codigo_perfil">Código</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
						<input class="input-xlarge" title="el Código del Perfil es generado por el sistema" name="codigo_perfil" id="codigo_perfil" type="text" value="<?=$row['codigo_perfil']?>" readonly /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="nombre_perfil">Perfil</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el nombre del perfil" onKeyUp="this.value=this.value.toUpperCase()" name="nombre_perfil" id="nombre_perfil" type="text" value="<?=$row['nombre_perfil']?>" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="codigo_configuracion">Configuración del Sistema</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione una Configuración del Sistema" name='codigo_configuracion' id='codigo_configuracion' required >
							<option value=0>Seleccione una Configuración del Sistema</option>
							<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT * FROM seguridad.tconfiguracion ORDER BY descripcion ASC";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								if($row['codigo_configuracion']==$rows['codigo_configuracion'])
									echo "<option value=".$rows['codigo_configuracion']." selected >".$rows['descripcion']."</option>";
								else
									echo "<option value=".$rows['codigo_configuracion'].">".$rows['descripcion']."</option>";
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
							if($row['estatus']=='Activo')
								echo '<button type="button" id="btnDesactivar" class="btn btn-large btn-primary"><i class="'.$a[$x]['icono'].'"></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button>&nbsp;';
							else
								echo '<button disabled type="button" id="btnDesactivar" class="btn btn-large btn-primary"><i class="'.$a[$x]['icono'].'"></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button>&nbsp;';

						}else if($a[$x]['orden']=='4'){
							if($row['estatus']=='Activo')
								echo '<button disabled type="button" id="btnActivar" class="btn btn-large btn-primary"><i class="'.$a[$x]['icono'].'"></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button>';
							else
								echo '<button type="button" id="btnActivar" class="btn btn-large btn-primary"><i class="'.$a[$x]['icono'].'"></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button>';
						}
						?>
						<a href="?perfiles"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
					</div>  
					<?php 
					include_once('../class/class_html.php');
					$html=new Html();
					$html->tabla_accesos($row['codigo_perfil']);   
					?>  
				</div>
			</fieldset>  
		</form>
		<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT p.codigo_perfil,p.nombre_perfil,c.descripcion AS configuracion 
	FROM seguridad.tperfil p INNER JOIN seguridad.tconfiguracion c ON p.codigo_configuracion = c.codigo_configuracion 
	WHERE p.codigo_perfil =".$_GET['codigo_perfil'];
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: PERFIL DE USUARIO</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Código:</label>
						</td>
						<td>
							<label><?=$row['codigo_perfil']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Perfil:</label>
						</td>
						<td>
							<label><?=$row['nombre_perfil']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Conf. del Sistema:</label>
						</td>
						<td>
							<label><?=$row['configuracion']?></label>
						</td>
					</tr>
				</table>
				<center>
					<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
					<a href="?perfiles"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana de Impresiones
?>