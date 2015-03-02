<script type="text/javascript" src="js/chsb_libro.js"></script>
<?php
require_once('../class/class_bd.php'); 
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('libro');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	$pgsql=new Conexion();
	$sql = "SELECT l.codigo_isbn_libro,l.titulo,l.numero_paginas,t.descripcion as tema  
	FROM biblioteca.tlibro l 
	INNER JOIN biblioteca.ttema t ON l.codigo_tema = t.codigo_tema";
	$consulta = $pgsql->Ejecutar($sql);
?>
<fieldset>
	<legend><center>LIBROS</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
				<thead>
					<tr>
						<th>Código ISBN</th>
						<th>Título del Libro</th>
						<th>Nro Páginas</th>
						<th>Tema del Libro</th>
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
						echo '<td>'.$filas['codigo_isbn_libro'].'</td>';
						echo '<td>'.$filas['titulo'].'</td>';
						echo '<td>'.$filas['numero_paginas'].'</td>';
						echo '<td>'.$filas['tema'].'</td>';
						for($x=0;$x<count($a);$x++){
							if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
								echo '<td><a href="?libro&Opt=3&codigo_isbn_libro='.$filas['codigo_isbn_libro'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
							else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
								echo '<td><a href="?libro&Opt=4&codigo_isbn_libro='.$filas['codigo_isbn_libro'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
						echo '<a href="?libro&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
				?>
				<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>
			</center>		
		    <div id="Imprimir" style="display:none;">
				<span>Descargar Como:</span>
				<br/><br/>
				<a href="<?php echo  '../pdf/pdf_libro.php';?>" target="_blank"> <img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"> </a>
				&nbsp;&nbsp;
				<a href="../excel/excel_libro.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
		    </div>
		</div>
	</div>
</fieldset>
<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
?>
<form class="form-horizontal" action="../controllers/control_libro.php" method="post" id="form1">  
	<fieldset>
		<legend><center>LIBROS</center></legend>
		<div id="paginador" class="enjoy-css">
			<div class="control-group">  
				<label class="control-label" for="codigo_isbn_libro">ISBN DEL LIBRO</label> 
				<div class="controls">  
					<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
					<input class="input-xlarge" title="Ingrese el Código del Libro"  onKeyPress="return isNumberKey(event)" name="codigo_isbn_libro" maxlenght=13 id="codigo_isbn_libro" type="text" required/> 
				</div>  
			</div> 
			<div class="control-group">  
				<label class="control-label" for="titulo">Título</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese el titulo del Libro" onKeyUp="this.value=this.value.toUpperCase()" name="titulo" id="titulo" type="text" required />
				</div>
			</div>
			<div class="control-group">  
				<label class="control-label" for="codigo_editorial">Editorial</label>  
				<div class="controls">  
					<select class="bootstrap-select form-control" title="Seleccione un Editorial" name='codigo_editorial' id='codigo_editorial' required >
						<option value=0>Seleccione un Editorial</option>
						<?php
							$pgsql = new Conexion();
							$sql = "SELECT * FROM biblioteca.teditorial ORDER BY nombre ASC";
							$query = $pgsql->Ejecutar($sql);
							while($row=$pgsql->Respuesta($query)){
								echo "<option value=".$row['codigo_editorial'].">".$row['nombre']."</option>";
							}
						?>
					</select>
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="codigo_autor">Autor</label>  
				<div class="controls">  
					<select class="bootstrap-select form-control" title="Seleccione un Autor" name='codigo_autor' id='codigo_autor' required >
						<option value=0>Seleccione un Autor</option>
						<?php
							$pgsql = new Conexion();
							$sql = "SELECT * FROM biblioteca.tautor ORDER BY nombre ASC";
							$query = $pgsql->Ejecutar($sql);
							while($row=$pgsql->Respuesta($query)){
								echo "<option value=".$row['codigo_autor'].">".$row['nombre']."</option>";
							}
						?>
					</select>
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="codigo_tema">Tema</label>  
				<div class="controls">  
					<select class="bootstrap-select form-control" title="Seleccione un Tema" name='codigo_tema' id='codigo_tema' required >
						<option value=0>Seleccione un Tema</option>
						<?php
							$pgsql = new Conexion();
							$sql = "SELECT * FROM biblioteca.ttema ORDER BY descripcion ASC";
							$query = $pgsql->Ejecutar($sql);
							while($row=$pgsql->Respuesta($query)){
								echo "<option value=".$row['codigo_tema'].">".$row['descripcion']."</option>";
							}
						?>
					</select>
				</div>  
			</div>   
			<div class="control-group">  
				<label class="control-label" for="numero_paginas">Número de Páginas</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese el teléfono" onKeyPress="return isNumberKey(event)" name="numero_paginas" id="numero_paginas" type="text" />
				</div>  
			</div>  
			<div class="control-group">  
				<label class="control-label" for="fecha_edicion">Fecha de Edición</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese la fecha de edicion de la persona" name="fecha_edicion" id="fecha_edicion" type="text" required />
				</div>  
			</div>    
			<div class="control-group">  
				<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
			</div>  
			<div class="form-actions">
				<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
				<a href="?libro"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
			</div>
		</div>
	</fieldset>  
</form>
<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	$pgsql=new Conexion();
	$sql = "SELECT * FROM biblioteca.tlibro 
	WHERE codigo_isbn_libro =".$pgsql->comillas_inteligentes($_GET['codigo_isbn_libro']);	
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
?>
<form class="form-horizontal" action="../controllers/control_libro.php" method="post" id="form1">  
	<fieldset>  
		<legend><center>LIBROS</center></legend>
		<div id="paginador" class="enjoy-css">
			<div class="control-group">  
				<label class="control-label" for="codigo_isbn_libro">ISBN DEL LIBRO</label> 
				<div class="controls">
					<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
						<input type="hidden" id="oldcl" name="oldcl" value="<?=$row['codigo_isbn_libro']?>"> 
					<input class="input-xlarge"  title="el Código del Libro es generado por el sistema" onKeyPress="return isNumberKey(event)"  maxlenght=13 name="codigo_isbn_libro" id="codigo_isbn_libro" type="text" value="<?=$row['codigo_isbn_libro']?>" /> 
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="titulo">Título</label>  
				<div class="controls">  
					<input class="input-xlarge" onKeyUp="this.value=this.value.toUpperCase()" title="Ingrese el Título del Libro" name="titulo" id="titulo" type="text" value="<?=$row['titulo']?>" />
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="codigo_editorial">Editorial</label>  
				<div class="controls">  
					<select class="bootstrap-select form-control" title="Seleccione un Editorial" name='codigo_editorial' id='codigo_editorial' value="<?=$row['codigo_editorial']?>" required >
						<option value=0>Seleccione un Editorial</option>
						<?php
							$pgsql = new Conexion();
									$sql = "SELECT * FROM biblioteca.teditorial ORDER BY nombre ASC";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								if($rows['codigo_editorial']==$row['codigo_editorial'])
									echo "<option value=".$rows['codigo_editorial']." selected >".$rows['nombre']."</option>";
								else
									echo "<option value=".$rows['codigo_editorial'].">".$rows['nombre']."</option>";
							}
						?>
					</select>
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="codigo_autor">Autor</label>  
				<div class="controls">  
					<select class="bootstrap-select form-control" title="Seleccione un Autor" name='codigo_autor' id='codigo_autor' value="<?=$row['codigo_autor']?>" required >
						<option value=0>Seleccione un Autor</option>
						<?php
							$pgsql = new Conexion();
							$sql = "SELECT * FROM biblioteca.tautor ORDER BY nombre ASC";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								if($rows['codigo_autor']==$row['codigo_autor'])
									echo "<option value=".$rows['codigo_autor']." selected >".$rows['nombre']."</option>";
								else
									echo "<option value=".$rows['codigo_autor'].">".$rows['nombre']."</option>";
							}
						?>
					</select>
				</div>  
			</div> 
			<div class="control-group">  
				<label class="control-label" for="codigo_tema">Tema</label>  
				<div class="controls">  
					<select class="bootstrap-select form-control" title="Seleccione un Tema" name='codigo_tema' id='codigo_tema' value="<?=$row['codigo_tema']?>" required >
						<option value=0>Seleccione un Tema</option>
						<?php
							$pgsql = new Conexion();
							$sql = "SELECT * FROM biblioteca.ttema ORDER BY descripcion ASC";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								if($rows['codigo_tema']==$row['codigo_tema'])
									echo "<option value=".$rows['codigo_tema']." selected >".$rows['descripcion']."</option>";
								else
									echo "<option value=".$rows['codigo_tema'].">".$rows['descripcion']."</option>";
							}
						?>
					</select>
				</div>  
			</div>     
			<div class="control-group">  
				<label class="control-label" for="numero_paginas">Número de Páginas</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese el teléfono" onKeyPress="return isNumberKey(event)" name="numero_paginas" id="numero_paginas" type="text" value="<?=$row['numero_paginas']?>" />
				</div>  
			</div>  
			<div class="control-group">  
				<label class="control-label" for="fecha_edicion">Fecha de Edición</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese la fecha de edicion de la persona" name="fecha_edicion" id="fecha_edicion" type="text"  value="<?=$row['fecha_edicion']?>" required />
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
				<a href="?libro"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
			</div>
		</div>
	</fieldset>  
</form>
<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	$pgsql=new Conexion();
	$sql = "SELECT l.codigo_isbn_libro, l.titulo, l.codigo_autor, a.nombre AS autor, l.codigo_editorial, e.nombre, l.codigo_tema, t.descripcion, l.numero_paginas, 
			TO_CHAR (l.fecha_edicion, 'DD/MM/YYYY') AS fecha
			FROM biblioteca.tlibro AS l
			INNER JOIN biblioteca.tautor AS a ON l.codigo_autor = a.codigo_autor
			INNER JOIN biblioteca.teditorial AS e ON l.codigo_editorial = e.codigo_editorial
			INNER JOIN biblioteca.ttema AS t ON l.codigo_tema = t.codigo_tema
			WHERE codigo_isbn_libro =".$pgsql->comillas_inteligentes($_GET['codigo_isbn_libro']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
?>
<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
<fieldset>  
	<legend><center>LIBROS</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="printer">
			<table class="bordered-table zebra-striped" >
				<tr>
					<td>
						<label>Código:</label>
					</td>
					<td>
						<label><?=$row['codigo_isbn_libro']?></label>
					</td>
				</tr>
				<tr>
					<td>
						<label>Título:</label>
					</td>
					<td>
						<label><?=$row['titulo']?></label>
					</td>
				</tr>
				<tr>
					<td>
						<label>Editorial:</label>
					</td>
					<td>
						<label><?=$row['nombre']?></label>
					</td>
				</tr>
				<tr>
					<td>
						<label>Autor:</label>
					</td>
					<td>
						<label><?=$row['autor']?></label>
					</td>
				</tr>
				<tr>
					<td>
						<label>Tema:</label>
					</td>
					<td>
						<label><?=$row['descripcion']?></label>
					</td>
				</tr>
				<tr>
					<td>
						<label>Número de Páginas:</label>
					</td>
					<td>
						<label><?=$row['numero_paginas']?></label>
					</td>
				</tr>
				<tr>
					<td>
						<label>Fecha de Edición:</label>
					</td>
					<td>
						<label><?=$row['fecha']?></label>
					</td>
				</tr>

			</table>
			<center>
				<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
				<a href="?libro"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
			</center>
		</div>
	</div>
</fieldset>
<?php
} // Fin Ventana de Impresiones
?>