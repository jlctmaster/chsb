<script type="text/javascript" src="js/chsb_seccion.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('seccion');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM educacion.tseccion ";
	$consulta = $pgsql->Ejecutar($sql);
?>
<H3 align="center">SECCIÓN</H3>
<div id="paginador">
	<div class="container">
		<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
			<thead>
				<tr>
					<th>Código</th>
					<th>Sección</th>
					<th>Turno</th>
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
					echo '<td>'.$filas['seccion'].'</td>';
					echo '<td>'.$filas['nombre_seccion'].'</td>';
					echo '<td>'.$filas['turno'].'</td>';
					for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
							echo '<td><a href="?seccion&Opt=3&seccion='.$filas['seccion'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
							echo '<td><a href="?seccion&Opt=4&seccion='.$filas['seccion'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
					echo '<a href="?seccion&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
			?>
		</center>
	</div>
</div>
<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
?>
<form class="form-horizontal" action="../controllers/control_seccion.php" method="post" id="form1">  
	<fieldset>  
	<H3 align="center">SECCIÓN</H3> 
	<div class="control-group">  
		<label class="control-label" for="seccion">Código</label>  
		<div class="controls">  
			<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
			<input class="input-xlarge" title="Ingrese el Código de la Sección" onKeyUp="this.value=this.value.toUpperCase()" name="seccion" id="seccion" type="text" required/> 
		</div>  
	</div>   
	<div class="control-group">  
		<label class="control-label" for="nombre_seccion">Sección</label>  
		<div class="controls">  
			<input class="input-xlarge" title="Ingrese el nombre de la Sección" onKeyUp="this.value=this.value.toUpperCase()" name="nombre_seccion" id="nombre_seccion" type="text" required />
		</div>  
	</div>   
	<div class="control-group">  
		<label class="control-label" for="turno">Turno</label>  
		<div class="controls">  
			<select class="selectpicker" data-live-search="true" name="turno" id="turno" title="Seleccione un turno" placeholder="Seleccione un turno"  required >
        <option value='0'>Seleccione un Turno</option>
              <option value="M" >Mañana</option>
              <option value="T" >Tarde</option>

      </select>		</div>  
	</div>
	<div class="control-group">  
		<label class="control-label" for="capacidad_min">Capacidad Mínima</label>  
		<div class="controls">  
			<input class="input-xlarge" title="Ingrese la capacidad máxima" onKeyPress="return isNumberKey(event)" maxlength=2 name="capacidad_min" id="capacidad_min" type="text" required />
		</div>  
	</div>
	<div class="control-group">  
		<label class="control-label" for="capacidad_max">Capacidad Máxima</label>  
		<div class="controls">  
			<input class="input-xlarge" title="Ingrese la Capacidad Máxima" onKeyPress="return isNumberKey(event)" maxlength=2 name="capacidad_max" id="capacidad_max" type="text" required />
		</div>  
	</div>
	<div class="control-group">  
		<label class="control-label" for="codigo_periodo">Trayecto</label>  
		<div class="controls">  
			<select class="selectpicker" data-live-search="true" title="Seleccione un Trayecto" name='codigo_periodo' id='codigo_periodo' required >
				<option value=0>Seleccione un Trayecto</option>
				<?php
					require_once('../class/class_bd.php');
					$pgsql = new Conexion();
					$sql = "SELECT * FROM educacion.tperiodo ORDER BY descripcion ASC";
					$query = $pgsql->Ejecutar($sql);
					while($row=$pgsql->Respuesta($query)){
						echo "<option value=".$row['codigo_periodo'].">".$row['descripcion']."</option>";
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
		<a href="?seccion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
	</div>  
	</fieldset>  
</form>
<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM educacion.tseccion WHERE seccion ='".$_GET['seccion']."'";
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
?>
<form class="form-horizontal" action="../controllers/control_seccion.php" method="post" id="form1">  
	<fieldset>  
	<H3 align="center">SECCIÓN</H3>  
	<div class="control-group">  
		<label class="control-label" for="seccion">Código</label>  
		<div class="controls">
			<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
			<input class="input-xlarge" title="Ingrese el Código de la Sección" name="seccion" id="seccion" type="text" value="<?=$row['seccion']?>" /> 
		</div>  
	</div>  
	<div class="control-group">  
		<label class="control-label" for="nombre_seccion">Nombre Sección</label>  
		<div class="controls">  
			<input class="input-xlarge" title="Ingrese el nombre de la Sección" onKeyUp="this.value=this.value.toUpperCase()" name="nombre_seccion" id="nombre_seccion" type="text" value="<?=$row['nombre_seccion']?>" required />
		</div>  
	</div>   
	<div class="control-group">  
		<label class="control-label" for="turno">Turno</label>  
		<div class="controls">  
	<select class="selectpicker" data-live-search="true" name="turno" id="turno" title="Seleccione un turno" placeholder="Seleccione un turno"  required >
        <option value='0'>Seleccione un Turno</option>
         		<option value="M" <? if($row['turno']=="M") {echo "selected";} ?> >Mañana</option>
              	<option value="T" <? if($row['turno']=="T") {echo "selected";} ?> >Tarde</option>	
             </select>
      </select>		</div>  
	</div>
	<div class="control-group">  
		<label class="control-label" for="capacidad_min">Capacidad Máxima
		</label>  
		<div class="controls">  
			<input class="input-xlarge" title="Ingrese la longitud máxima para la clave" onKeyPress="return isNumberKey(event)" maxlength=2 name="capacidad_min" id="capacidad_min" type="text" value="<?=$row['capacidad_min']?>" required />
		</div>  
	</div>
	<div class="control-group">  
		<label class="control-label" for="capacidad_max">Capacidad Máxima</label>  
		<div class="controls">  
			<input class="input-xlarge" title="Ingrese la Capacidad Máxima" onKeyPress="return isNumberKey(event)" maxlength=2 name="capacidad_max" id="capacidad_max" type="text" value="<?=$row['capacidad_max']?>" required />
		</div>  
	</div>
<div class="control-group">  
		<label class="control-label" for="codigo_periodo">Trayecto</label>  
		<div class="controls">  
			<select class="selectpicker" data-live-search="true" title="Seleccione un Trayecto" name='codigo_periodo' id='codigo_periodo' required >
				<option value=0>Seleccione un Trayecto</option>
				<?php
					require_once('../class/class_bd.php');
					$pgsql = new Conexion();
					$sql = "SELECT * FROM educacion.tperiodo ORDER BY descripcion ASC";
					$query = $pgsql->Ejecutar($sql);
					while($rows=$pgsql->Respuesta($query)){
						if($rows['codigo_periodo']==$row['codigo_periodo'])
							echo "<option value=".$rows['codigo_periodo']." selected >".$rows['descripcion']."</option>";
						else
							echo "<option value=".$row['codigo_periodo'].">".$row['descripcion']."</option>";
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
		<a href="?seccion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
	</div>  
	</fieldset>  
</form>
<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT s.seccion,s.nombre_seccion,s.turno,s.capacidad_min,s.capacidad_max, p.descripcion  
	FROM educacion.tseccion s
	INNER JOIN educacion.tperiodo p on s.codigo_periodo=p.codigo_periodo WHERE seccion ='".$_GET['seccion']."'";
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
?>
<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
<H3 align="center">SECCIÓN</H3>
<div class="printer">
	<table class="bordered-table zebra-striped" >
		<tr>
			<td>
				<label>Código:</label>
			</td>
			<td>
				<label><?=$row['seccion']?></label>
			</td>
		</tr>
		<tr>
			<td>
				<label>Sección:</label>
			</td>
			<td>
				<label><?=$row['nombre_seccion']?></label>
			</td>
		</tr>
		<tr>
			<td>
				<label>Turno:</label>
			</td>
			<td>
				<label><?=$row['turno']?></label>
			</td>
		</tr>
		<tr>
			<td>
				<label>Capacidad Mínima:</label>
			</td>
			<td>
				<label><?=$row['capacidad_min']?></label>
			</td>
		</tr>
		<tr>
			<td>
				<label>Capacidad Máxima:</label>
			</td>
			<td>
				<label><?=$row['capacidad_max']?></label>
			</td>
		</tr>
		<tr>
			<td>
				<label>Trayecto:</label>
			</td>
			<td>
				<label><?=$row['descripcion']?></label>
			</td>
		</tr>
		
	</table>
	<center>
		<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
		<a href="?seccion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
	</center>
</div>
<?php
} // Fin Ventana de Impresiones
?>