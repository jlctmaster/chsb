<script type="text/javascript" src="js/chsb_ejemplar.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('ejemplar');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT e.*,c.descripcion AS clasificacion,l.titulo As libro 
	FROM biblioteca.tejemplar e
	INNER JOIN biblioteca.tclasificacion c ON e.codigo_clasificacion = c.codigo_clasificacion 
	INNER JOIN biblioteca.tlibro l ON e.codigo_isbn_libro = l.codigo_isbn_libro";
	$consulta = $pgsql->Ejecutar($sql);
?>
<fieldset>
	<legend><center>EJEMPLARES DE LOS LIBROS</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
				<thead>
					<tr>
						<th>Código</th>
						<th>Clasificación</th>
						<th>Número Edición</th>
						<th>Libro</th>
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
						echo '<td>'.$filas['codigo_ejemplar'].'</td>';
						echo '<td>'.$filas['clasificacion'].'</td>';
						echo '<td>'.$filas['numero_edicion'].'</td>';
						echo '<td>'.$filas['libro'].'</td>';
						
						for($x=0;$x<count($a);$x++){
							if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
								echo '<td><a href="?ejemplar&Opt=3&codigo_ejemplar='.$filas['codigo_ejemplar'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
							else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
								echo '<td><a href="?ejemplar&Opt=4&codigo_ejemplar='.$filas['codigo_ejemplar'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
						echo '<a href="?ejemplar&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
				?>
				<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>
			</center>		
		    <div id="Imprimir" style="display:none;">
				<span>Descargar Como:</span>
				<br/><br/>
				<a href="<?php echo  '../pdf/pdf_ejemplar.php';?>" target="_blank"> <img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"> </a>
				&nbsp;&nbsp;
				<a href="../excel/excel_ejemplar.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
		    </div>
		</div>
	</div>
</fieldset>
<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
?>
<form class="form-horizontal" action="../controllers/control_ejemplar.php" method="post" id="form1">
	<fieldset>
		<legend><center>EJEMPLARES DE LOS LIBROS</center></legend>
		<div id="paginador" class="enjoy-css">
			<div class="control-group">  
				<label class="control-label" for="codigo_ejemplar">Código</label>  
				<div class="controls">  
					<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
					<input class="input-xlarge" title="el Código del ejemplar es generado por el sistema" name="codigo_ejemplar" id="codigo_ejemplar" type="text" readonly /> 
				</div>  
			</div>   
			<div class="control-group">  
				<label class="control-label" for="codigo_clasificacion">Clasificación</label>  
				<div class="controls">  
					<select class="selectpicker" data-live-search="true" title="Seleccione una Clasificación" name='codigo_clasificacion' id='codigo_clasificacion' required />
						<option value=0>Seleccione una Clasificación</option>
						<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT * FROM biblioteca.tclasificacion ORDER BY descripcion ASC";
							$query = $pgsql->Ejecutar($sql);
							while($row=$pgsql->Respuesta($query)){
								echo "<option value=".$row['codigo_clasificacion'].">".$row['descripcion']."</option>";
							}
						?>
					</select>
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="numero_edicion">Número Edición</label>  
				<div class="controls">  
					<input class="input-xlarge" onKeyPress="return isNumberKey(event)" title="Ingrese el número de edicion" name="numero_edicion" id="numero_edicion" type="text" required />
				</div> 
			</div>	
			<div class="control-group">  
				<label class="control-label" for="codigo_isbn_libro">Libro</label>  
				<div class="controls">  
					<select class="selectpicker" data-live-search="true" title="Seleccione un Libro" name='codigo_isbn_libro' id='codigo_isbn_libro' required />
						<option value=0>Seleccione el Libro</option>
						<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT * FROM biblioteca.tlibro ORDER BY codigo_isbn_libro ASC";
							$query = $pgsql->Ejecutar($sql);
							while($row=$pgsql->Respuesta($query)){
								echo "<option value=".$row['codigo_isbn_libro'].">".$row['titulo']."</option>";
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
				<a href="?ejemplar"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
			</div>
		</div>
	</fieldset>  
</form>
<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM biblioteca.tejemplar WHERE codigo_ejemplar =".$pgsql->comillas_inteligentes($_GET['codigo_ejemplar']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
?>
<form class="form-horizontal" action="../controllers/control_ejemplar.php" method="post" id="form1">  
	<fieldset>
		<legend><center>EJEMPLARES DE LOS LIBROS</center></legend>
		<div id="paginador" class="enjoy-css">
			<div class="control-group">  
				<label class="control-label" for="codigo_ejemplar">Código</label>  
				<div class="controls">
					<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
					<input class="input-xlarge" title="el Código del ejemplar es generado por el sistema" name="codigo_ejemplar" id="codigo_ejemplar" type="text" value="<?=$row['codigo_ejemplar']?>" readonly /> 
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="codigo_clasificacion">Clasificación</label>  
				<div class="controls">  
					<select class="selectpicker" data-live-search="true" title="Seleccione una Clasificación" name='codigo_clasificacion' id='codigo_clasificacion' value="<?=$row['codigo_clasificacion']?>" required >
						<option value=0>Seleccione una Clasificación</option>
						<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT * FROM biblioteca.tclasificacion ORDER BY descripcion ASC";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								if($rows['codigo_clasificacion']==$row['codigo_clasificacion'])
									echo "<option value=".$rows['codigo_clasificacion']." selected >".$rows['descripcion']."</option>";
								else
									echo "<option value=".$row['codigo_clasificacion'].">".$row['descripcion']."</option>";
							}
						?>
					</select>
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="numero_edicion">Número Edición</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese el número de edicion" name="numero_edicion" id="numero_edicion" type="text" value="<?=$row['numero_edicion']?>" required />
				</div>  
			</div> 
			<div class="control-group">  
				<label class="control-label" for="codigo_isbn_libro">Libro</label>  
				<div class="controls">  
					<select class="selectpicker" data-live-search="true" title="Seleccione el Libro" name='codigo_isbn_libro' id='codigo_isbn_libro' value="<?=$row['codigo_isbn_libro']?>" required />
						<option value=0>Seleccione el Libro</option>
						<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT * FROM biblioteca.tlibro ORDER BY titulo ASC";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								if($rows['codigo_isbn_libro']==$row['codigo_isbn_libro'])
									echo "<option value=".$rows['codigo_isbn_libro']." selected >".$rows['titulo']."</option>";
								else
									echo "<option value=".$row['codigo_isbn_libro'].">".$row['titulo']."</option>";
							}
						?>
					</select>
				</div>  
			</div>
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
				<a href="?ejemplar"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
			</div>
		</div>
	</fieldset>  
</form>
<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT *, c.descripcion as clasificacion,l.titulo as libro
	FROM biblioteca.tejemplar e
	INNER JOIN biblioteca.tclasificacion c ON e.codigo_clasificacion = c.codigo_clasificacion
	INNER JOIN biblioteca.tlibro l ON e.codigo_isbn_libro = l.codigo_isbn_libro  
	WHERE e.codigo_ejemplar =".$pgsql->comillas_inteligentes($_GET['codigo_ejemplar']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
?>
<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
<fieldset>
	<legend><center>EJEMPLARES DE LOS LIBROS</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="printer">
			<table class="bordered-table zebra-striped" >
				<tr>
					<td>
						<label>Código:</label>
					</td>
					<td>
						<label><?=$row['codigo_ejemplar']?></label>
					</td>
				</tr>
				<tr>
					<td>
						<label>Clasificación:</label>
					</td>
					<td>
						<label><?=$row['clasificacion']?></label>
					</td>
				</tr>
				<tr>
					<td>
						<label>Número Edición:</label>
					</td>
					<td>
						<label><?=$row['numero_edicion']?></label>
					</td>
				</tr>
						<tr>
					<td>
						<label>ISBN del Libro:</label>
					</td>
					<td>
						<label><?=$row['libro']?></label>
					</td>
				</tr>
			</table>
			<center>
				<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
				<a href="?ejemplar"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
			</center>
		</div>
	</div>
</fieldset>
<?php
} // Fin Ventana de Impresiones
?>