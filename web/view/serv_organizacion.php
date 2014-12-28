<script type="text/javascript" src="js/chsb_organizacion.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('organizacion');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT o.rif_organizacion, o.nombre,o.direccion,o.telefono,o.tipo_organizacion, p.descripcion AS parroquia 
	FROM general.torganizacion o 
	INNER JOIN general.tparroquia p ON o.codigo_parroquia = p.codigo_parroquia";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: ORGANIZACIÓN</center></legend>
		<div id="paginador" class="enjoy-css">
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>RIf organización</th>
							<th>Organizacion</th>
							<th>Parroquia</th>
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
							echo '<td>'.$filas['rif_organizacion'].'</td>';
							echo '<td>'.$filas['nombre'].'</td>';
							echo '<td>'.$filas['parroquia'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?organizacion&Opt=3&rif_organizacion='.$filas['rif_organizacion'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?organizacion&Opt=4&rif_organizacion='.$filas['rif_organizacion'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?organizacion&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
						?>
						<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>
					</center>

				<div id="Imprimir" style="display:none;">
					<span>Descargar Como:</span>
					<br/><br/>
					<a href="<?php echo  '../pdf/pdf_organizacion.php';?>" target="_blank"> <img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"> </a>
					&nbsp;&nbsp;
					<a href="../excel/excel_organizacion.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
			    </div>
				</div>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ 
// Ventana de Registro
	?>
	<form class="form-horizontal" action="../controllers/control_organizacion.php" method="post" id="form1">  
		<fieldset>  
			<H3 align="center">ORGANIZACIÓN</H3> 
			<div class="control-group">  
				<label class="control-label" for="rif_organizacion">RIF Organización</label>  
				<div class="controls">
					<input type="hidden" id="lOpt" name="lOpt" value="Registrar"> 
					<input class="input-xlarge" title="Ingrese el RIF de la organización" onKeyPress="return isRif(event,this.value)" onKeyUp="this.value=this.value.toUpperCase()" maxlength="10" name="rif_organizacion" id="rif_organizacion" type="text" required /> 
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="nombre">Organizacion</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese el nombre del organizacion" onKeyUp="this.value=this.value.toUpperCase()" name="nombre" id="nombre" type="text" required />
				</div>  
			</div>  

			<div class="control-group">  
				<label class="control-label" for="telefono">Teléfono</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese el número de la organizacion" onKeyUp="this.value=this.value.toUpperCase()" name="telefono" id="telefono" type="text" required />
				</div>  
			</div>   
			<div class="control-group">  
				<label class="control-label" for="direccion">Dirección</label>  
				<div class="controls">  
					<textarea class="input-xlarge" title="Ingrese la direccion de la organización" onKeyUp="this.value=this.value.toUpperCase()" name="direccion" id="direccion" type="text" required /></textarea>
				</div>  
			</div>   
			<div class="control-group">  
				<label class="control-label" for="tipo_organizacion">Tipo de Organizacion</label>  
				<div class="controls">  
					<select class="selectpicker" data-live-search="true" name="tipo_organizacion" id="tipo_organizacion" title="Seleccione un tipo de organizacion" required /> 
					<option value=0>Seleccione un Tipo de Organizacion</option>
					<option value="1" >PÚBLICA</option>
					<option value="2" >PRIVADA</option>
					<option value="3" >GUBERNAMENTAL</option>		
				</select>
			</div>
		</div>   
		<div class="control-group">  
			<label class="control-label" for="codigo_parroquia">Parroquia</label>  
			<div class="controls">  
				<select class="selectpicker" data-live-search="true" title="Seleccione la Parroquia" name='codigo_parroquia' id='codigo_parroquia' required >
					<option value=0>Seleccione la Parroquia</option>
					<?php
					require_once('../class/class_bd.php');
					$pgsql = new Conexion();
					$sql = "SELECT * FROM general.tparroquia ORDER BY descripcion ASC";
					$query = $pgsql->Ejecutar($sql);
					while($rows=$pgsql->Respuesta($query)){
						echo "<option value=".$rows['codigo_parroquia'].">".$rows['descripcion']."</option>";
					}
					?>
				</select>
			</div>  
		</div> 
		<center>
			<div class="control-group">  
				<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
			</div>  
			<div class="form-actions">
			
				<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
				<a href="?organizacion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
			
			</div>  
		</center>
	</fieldset>  
</form>
<?php
}// Ventana de Registro
else if($_GET['Opt']=="3"){ 
// Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM general.torganizacion WHERE rif_organizacion=".$pgsql->comillas_inteligentes($_GET['rif_organizacion']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_organizacion.php" method="post" id="form1">  
		<fieldset>  
			<H3 align="center">ORGANIZACIÓN</H3> 
			<div class="control-group">  
				<label class="control-label" for="rif_organizacion">RIF Organización</label>  
				<div class="controls">
					<input type="hidden" id="lOpt" name="lOpt" value="Modificar"> 
					<input class="input-xlarge" title="Ingrese el RIF de la organización" onKeyPress="return isRif(event,this.value)" onKeyUp="this.value=this.value.toUpperCase()" maxlength=10 name="rif_organizacion" id="rif_organizacion" type="text" value="<?=$row['rif_organizacion']?>" required /> 
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="nombre">Organizacion</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese el nombre del organizacion" onKeyUp="this.value=this.value.toUpperCase()" name="nombre" id="nombre" type="text" value="<?=$row['nombre']?>" required />
				</div>  
			</div>   
			<div class="control-group">  
				<label class="control-label" for="telefono">Teléfono</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese el número de la organizacion" onKeyUp="this.value=this.value.toUpperCase()" name="telefono" id="telefono" type="text" value="<?=$row['telefono']?>" required />
				</div>  
			</div>   
			<div class="control-group">  
				<label class="control-label" for="direccion">Dirección</label>  
				<div class="controls">  
					<textarea class="input-xlarge" title="Ingrese la direccion de la organización" onKeyUp="this.value=this.value.toUpperCase()" name="direccion" id="direccion" type="text" required /><?php echo $row['direccion']; ?></textarea>
				</div>  
			</div>  
			<div class="control-group">  
				<label class="control-label" for="tipo_organizacion">Tipo de Organización</label>  
				<div class="controls">  
					<select class="selectpicker" data-live-search="true" name="tipo_organizacion" id="tipo_organizacion" title="Seleccione un tipo_organizacion" required > 
						<option value=0>Seleccione un tipo_organizacion </option>
						<option value="1" <?php if($row['tipo_organizacion']=="1") {echo "selected";} ?> >PÚBLICA</option>
						<option value="2" <?php if($row['tipo_organizacion']=="2") {echo "selected";} ?> >PRIVADA</option>
						<option value="3" <?php if($row['tipo_organizacion']=="3") {echo "selected";} ?> >GUBERNAMENTAL</option>		
					</select>
				</div>
			</div>   
			<div class="control-group">  
				<label class="control-label" for="codigo_parroquia">Parroquia</label>  
				<div class="controls">  
					<select class="selectpicker data-live-search="true" title="Seleccione una Parroquia" name="codigo_parroquia" id="codigo_parroquia" required />
					<option value=0>Seleccione la Parroquia</option>
					<?php
					require_once('../class/class_bd.php');
					$pgsql = new Conexion();
					$sql = "SELECT * FROM general.tparroquia ORDER BY descripcion ASC";
					$query = $pgsql->Ejecutar($sql);
					while($rows=$pgsql->Respuesta($query)){
						if($rows['codigo_parroquia']==$row['codigo_parroquia'])
							echo "<option value=".$rows['codigo_parroquia']." selected >".$rows['descripcion']."</option>";
						else
							echo "<option value=".$rows['codigo_parroquia'].">".$rows['descripcion']."</option>";
					}
					?>
				</select>
			</div>  
		</div>
		<center>
		<div class="control-group">  
			<?php if($row['estatus']=='1'){echo "<p id='estatus' class='Activo'>Activo </p>";}else{

				echo "<p id='estatus' class='Desactivado'>Desactivado</p>";} ?>
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
					<a href="?organizacion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div>  
		</center>
			</fieldset>  
		</form>
		<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT o.rif_organizacion, o.nombre,o.direccion,o.telefono,o.tipo_organizacion, p.descripcion AS parroquia 
	FROM general.torganizacion o 
	INNER JOIN general.tparroquia p ON o.codigo_parroquia = p.codigo_parroquia 
	WHERE rif_organizacion=".$pgsql->comillas_inteligentes($_GET['rif_organizacion']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<H3 align="center">ORGANIZACIÓN</H3>
	<div class="printer">
		<table class="bordered-table zebra-striped" >
			<tr>
				<td>
					<label>RIf Organización:</label>
				</td>
				<td>
					<label><?=$row['rif_organizacion']?></label>
				</td>
			</tr>
			<tr>
				<td>
					<label>Organizacion:</label>
				</td>
				<td>
					<label><?=$row['nombre']?></label>
				</td>
			</tr>
			<tr>
				<td>
					<label>Direción:</label>
				</td>
				<td>
					<label><?=$row['direccion']?></label>
				</td>
			</tr>
			<tr>
				<td>
					<label>Teléfono:</label>
				</td>
				<td>
					<label><?=$row['telefono']?></label>
				</td>
			</tr>
			<tr>
				<td>
					<label>Tipo Organizacion:</label>
				</td>
				<td>
					<label><?=$row['tipo_organizacion']?></label>
				</td>
			</tr>
			<tr>
				<td>
					<label>Parroquia:</label>
				</td>
				<td>
					<label><?=$row['parroquia']?></label>
				</td>
			</tr>
		</table>
		<center>
			<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
			<a href="?organizacion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
		</center>
	</div>
	<?php
} // Fin Ventana de Impresiones
?>