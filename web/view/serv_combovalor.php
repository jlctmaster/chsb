<script type="text/javascript" src="js/chsb_combovalor.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->nid_perfil($_SESSION['user_codigo_perfil']);
$perfil->curl('combovalor');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM general.tcombo_valor";
	$consulta = $pgsql->Ejecutar($sql);
?>
<H3 align="center">VALORES DE COMBOS DINÁMICOS</H3>
<div id="paginador">
	<div class="container">
		<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
			<thead>
				<tr>
					<th>N&deg;</th>
					<th>Tabla</th>
					<th>Valor</th>
					<?php
					for($x=0;$x<count($a);$x++){
						if($a[$x]['norden']=='2' || $a[$x]['norden']=='5')
							echo '<th>'.$a[$x]['cnombreopcion'].'</th>';
					}
					?>
				</tr>
			</thead>
			<tbody>
			<?php
				while ($filas = $pgsql->Respuesta($consulta))
				{
					echo '<tr>';
					echo '<td>'.$filas['nid_combovalor'].'</td>';
					echo '<td>'.$filas['ctabla'].'</td>';
					echo '<td>'.$filas['cdescripcion'].'</td>';
					for($x=0;$x<count($a);$x++){
						if($a[$x]['norden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
							echo '<td><a href="?combovalor&Opt=3&nid_combovalor='.$filas['nid_combovalor'].'" style="border:0px;"><i class="'.$a[$x]['cicono'].'"></i></a></td>';
						else if($a[$x]['norden']=='5') //Imprimir o Ver el Registro
							echo '<td><a href="?combovalor&Opt=4&nid_combovalor='.$filas['nid_combovalor'].'" style="border:0px;"><i class="'.$a[$x]['cicono'].'"></i></a></td>';
					}
					echo "</tr>";
				}
				?>
			<tbody>
		</table>
		<center>
			<?php
			for($x=0;$x<count($a);$x++)
				if($a[$x]['norden']=='1')
					echo '<a href="?combovalor&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['cicono'].'></i>&nbsp;'.$a[$x]['cnombreopcion'].'</button></a>';
			?>
		</center>
	</div>
</div>
<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
?>
<form class="form-horizontal" action="../controllers/control_combovalor.php" method="post" id="form1">  
	<fieldset>  
	<legend>Valor de Combo Dinámico</legend>  
	<div class="control-group">  
		<label class="control-label" for="nid_combovalor">Código</label>  
		<div class="controls">  
			<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
			<input class="input-xlarge" title="el código para el valor del combo es generado por el sistema" name="nid_combovalor" id="nid_combovalor" type="text" readonly /> 
		</div>  
	</div>  
	<div class="control-group">  
		<label class="control-label" for="ctabla">Tabla Destino</label>  
		<div class="controls">  
			<select class="selectpicker" data-live-search="true" name="ctabla" id="ctabla" title="Seleccione una tabla" required >
				<?php
				require_once('../class/class_bd.php');
				$conexion = new Conexion();
				$sql="SELECT DISTINCT schemaname FROM pg_catalog.pg_tables 
				WHERE schemaname IN ('general','facturacion','inventario','seguridad') 
				ORDER BY schemaname ASC";
				$query=$conexion->Ejecutar($sql);
				while ($schema=$conexion->Respuesta($query)){
					echo "<optgroup label='".$schema['schemaname']."'>";
					$sqlx="SELECT DISTINCT tablename FROM pg_catalog.pg_tables 
					WHERE schemaname = '".$schema['schemaname']."'
					ORDER BY tablename ASC";
					$querys=$conexion->Ejecutar($sqlx);
					while ($tables=$conexion->Respuesta($querys)){
						echo "<option value='".$tables['tablename']."'>".$tables['tablename']."</option>";
					}
				}
				?>
			</select> 
		</div>  
	</div>  
	<div class="control-group">  
		<label class="control-label" for="input01">Texto a Mostrar</label>  
		<div class="controls">  
			<input class="input-xlarge" title="Ingrese el texto a mostrar en el combo" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" size="50" required />
		</div>  
	</div>  
	<div class="control-group">  
		<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
	</div>  
	<div class="form-actions">
		<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
		<a href="?combovalor"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
	</div>  
	</fieldset>  
</form>
<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT *,CASE WHEN dfecha_desactivacion IS NULL THEN 'Activo' ELSE 'Desactivado' END estatus FROM general.tcombo_valor WHERE nid_combovalor =".$_GET['nid_combovalor'];
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
?>
<form class="form-horizontal" action="../controllers/control_combovalor.php" method="post" id="form1">  
	<fieldset>  
	<legend>Valor de Combo Dinámico</legend>  
	<div class="control-group">  
		<label class="control-label" for="nid_combovalor">Código</label>  
		<div class="controls">
			<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
			<input class="input-xlarge" title="el código para el valor del combo es generado por el sistema" name="nid_combovalor" id="nid_combovalor" type="text" value="<?=$row['nid_combovalor']?>" readonly /> 
		</div>  
	</div>  
	<div class="control-group">  
		<label class="control-label" for="ctabla">Tabla Destino</label>  
		<div class="controls">  
			<select class="selectpicker" data-live-search="true" name="ctabla" id="ctabla" title="Seleccione una tabla" required >
				<?php
				require_once('../class/class_bd.php');
				$conexion = new Conexion();
				$sql="SELECT DISTINCT schemaname FROM pg_catalog.pg_tables 
				WHERE schemaname IN ('general','facturacion','inventario','seguridad') 
				ORDER BY schemaname ASC";
				$query=$conexion->Ejecutar($sql);
				while ($schema=$conexion->Respuesta($query)){
					echo "<optgroup label='".$schema['schemaname']."'>";
					$sqlx="SELECT DISTINCT tablename FROM pg_catalog.pg_tables 
					WHERE schemaname = '".$schema['schemaname']."'
					ORDER BY tablename ASC";
					$querys=$conexion->Ejecutar($sqlx);
					while ($tables=$conexion->Respuesta($querys)){
						if($tables['tablename']==$row['ctabla'])
							echo "<option value='".$tables['tablename']."' selected >".$tables['tablename']."</option>";
						else
							echo "<option value='".$tables['tablename']."'>".$tables['tablename']."</option>";
					}
				}
				?>
			</select> 
		</div>  
	</div>  
	<div class="control-group">  
		<label class="control-label" for="input01">Texto a Mostrar</label>  
		<div class="controls">  
			<input class="input-xlarge" title="Ingrese el texto a mostrar en el combo" onKeyUp="this.value=this.value.toUpperCase()" name="cdescripcion" id="cdescripcion" type="text" value="<?=$row['cdescripcion']?>" required />
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
				if($a[$x]['norden']=='3'){
					if($row['estatus']=='Activo')
						echo '<button type="button" id="btnDesactivar" class="btn btn-large btn-primary"><i class="'.$a[$x]['cicono'].'"></i>&nbsp;'.$a[$x]['cnombreopcion'].'</button>&nbsp;';
					else
						echo '<button disabled type="button" id="btnDesactivar" class="btn btn-large btn-primary"><i class="'.$a[$x]['cicono'].'"></i>&nbsp;'.$a[$x]['cnombreopcion'].'</button>&nbsp;';

				}else if($a[$x]['norden']=='4'){
					if($row['estatus']=='Activo')
						echo '<button disabled type="button" id="btnActivar" class="btn btn-large btn-primary"><i class="'.$a[$x]['cicono'].'"></i>&nbsp;'.$a[$x]['cnombreopcion'].'</button>';
					else
						echo '<button type="button" id="btnActivar" class="btn btn-large btn-primary"><i class="'.$a[$x]['cicono'].'"></i>&nbsp;'.$a[$x]['cnombreopcion'].'</button>';
				}
		?>
		<a href="?combovalor"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
	</div>  
	</fieldset>  
</form>
<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM general.tcombo_valor WHERE nid_combovalor =".$_GET['nid_combovalor'];
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
?>
<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
<H3 align="center">VALORES DE COMBOS DINÁMICOS</H3>
<div class="printer">
	<table class="bordered-table zebra-striped" >
		<tr>
			<td>
				<label>Código:</label>
			</td>
			<td>
				<label><?=$row['nid_combovalor']?></label>
			</td>
		</tr>
		<tr>
			<td>
				<label>Tabla Destino:</label>
			</td>
			<td>
				<label><?=$row['ctabla']?></label>
			</td>
		</tr>
		<tr>
			<td>
				<label>Texto a Mostrar:</label>
			</td>
			<td>
				<label><?=$row['cdescripcion']?></label>
			</td>
		</tr>
	</table>
	<center>
		<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
		<a href="?combovalor"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
	</center>
</div>
<?php
} // Fin Ventana de Impresiones
?>