<script type="text/javascript" src="js/chsb_materia.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('materia');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT codigo_materia,nombre_materia,CASE tipo_materia WHEN 'N' THEN 'NORMAL' ELSE 'POR EQUIVALENCIA' END AS tipo_materia 
	FROM educacion.tmateria";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: MATERIA</center></legend>		
		<div id="paginador" class="enjoy-css"> 
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Codigo</th>
							<th>Nombre de la Materia</th>
							<th>Tipo de Materia</th>
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
							echo '<td>'.$filas['codigo_materia'].'</td>';
							echo '<td>'.$filas['nombre_materia'].'</td>';
							echo '<td>'.$filas['tipo_materia'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?materia&Opt=3&codigo_materia='.$filas['codigo_materia'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?materia&Opt=4&codigo_materia='.$filas['codigo_materia'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?materia&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
						?>
						<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>
					</center>		
					<div id="Imprimir" style="display:none;">
						<span>Descargar Como:</span>
						<br/><br/>
						<a href="<?php echo  '../pdf/pdf_materia.php';?>" target="_blank"><img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"></a>
						&nbsp;&nbsp;						
						<a href="../excel/excel_materia.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
					</div>
				</div>
			</div>
		</fieldset>
		<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ 
// Ventana de Registro
	?>
	<form class="form-horizontal" action="../controllers/control_materia.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: MATERIA</center></legend>		
			<div id="paginador" class="enjoy-css"> 
				<div class="control-group">  
					<label class="control-label" for="codigo_materia">Codigo Materia:</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar"> 
						<input class="input-xlarge" title="El C´´odigo es genereado por el sistma" onKeyUp="this.value=this.value.toUpperCase()" maxlength="10" name="codigo_materia" id="codigo_materia" type="text" required /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="nombre_materia">Materia:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el nombre de la materia" onKeyUp="this.value=this.value.toUpperCase()" name="nombre_materia" id="nombre_materia" type="text" required />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="unidad_credito">Unidad de Crédito:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la unidad de crédito" onKeyUp="this.value=this.value.toUpperCase()" name="unidad_credito" id="unidad_credito" type="text" required />
					</div>  
				</div>    
				<div class="control-group">  
					<label class="control-label" for="tipo_materia">Tipo materia:</label>  
					<div class="controls">  
						<select class="bootstrap-select form-control" name="tipo_materia" id="tipo_materia" title="Seleccione un tipo de materia" required > 
							<option value=0>Seleccione Tipo de Materia</option>
							<option value="N" >Normal</option>
							<option value="E" >Por Equivalencia</option>
						</select>
					</div>
				</div> 
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
					<a href="?materia"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div>  
			</div>
		</fieldset>  
	</form>
	<?php
}// Ventana de Registro
else if($_GET['Opt']=="3"){ 
// Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM educacion.tmateria WHERE codigo_materia =".$pgsql->comillas_inteligentes($_GET['codigo_materia']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_materia.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: MATERIA</center></legend>		
			<div id="paginador" class="enjoy-css"> 
				<div class="control-group">  
					<label class="control-label" for="codigo_materia">Codigo Materia:</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar"> 
						<input type="hidden" id="oldmateria" name="oldmateria" value="<?=$row['codigo_materia']?>">
						<input class="input-xlarge" title="Ingrese el Código de la materia" onKeyUp="this.value=this.value.toUpperCase()" maxlength=10 name="codigo_materia" id="codigo_materia" type="text" value="<?=$row['codigo_materia']?>" required /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="nombre_materia">Materia:</label>  
					<div class="controls">   
						<input class="input-xlarge" title="Ingrese el nombre de la materia del materia" onKeyUp="this.value=this.value.toUpperCase()" name="nombre_materia" id="nombre_materia" type="text" value="<?=$row['nombre_materia']?>" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="unidad_credito">Unidad de Crédito:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la unidad de crédito" onKeyUp="this.value=this.value.toUpperCase()" name="unidad_credito" id="unidad_credito" type="text" value="<?=$row['unidad_credito']?>" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="tipo_materia">Tipo Materia:</label>  
					<div class="controls">  
						<select class="bootstrap-select form-control" name="tipo_materia" id="tipo_materia" title="Seleccione un tipo de materia" required > 
							<option value=0>Seleccione un Tipo de Materia</option>
							<option value="N" <?php if($row['tipo_materia']=="N") {echo "selected";} ?>> Normal</option>
							<option value="E" <?php if($row['tipo_materia']=="E") {echo "selected";} ?>> Por Equivalencia</option>
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
							<a href="?materia"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
						</div>  
					</div>
				</fieldset>  
			</form>
			<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql ="	SELECT * ,
			CASE tipo_materia WHEN 'N' THEN 'NORMAL' WHEN 'E' THEN 'POR EQUIVALENCIA' END AS tipo
			FROM educacion.tmateria 
			WHERE codigo_materia =".$pgsql->comillas_inteligentes($_GET['codigo_materia']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: MATERIA</center></legend>		
		<div id="paginador" class="enjoy-css"> 
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Codigo Materia:</label>
						</td>
						<td>
							<label><?=$row['codigo_materia']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Materia:</label>
						</td>
						<td>
							<label><?=$row['nombre_materia']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Unidad Crédito:</label>
						</td>
						<td>
							<label><?=$row['unidad_credito']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Tipo Materia:</label>
						</td>
						<td>
							<label><?=$row['tipo']?></label>
						</td>
					</tr>

				</table>
				<center>
					<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
					<a href="?materia"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana de Impresiones
?>