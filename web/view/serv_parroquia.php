<script type="text/javascript" src="js/chsb_parroquia.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('parroquia');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT e.codigo_parroquia, e.descripcion, p.descripcion AS municipio FROM general.tparroquia e 
	INNER JOIN general.tmunicipio p ON e.codigo_municipio = p.codigo_municipio";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: PARROQUIA</center></legend>
		<div id="paginador" class="enjoy-css">	
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código:</th>
							<th>Parroquia:</th>
							<th>Municipio:</th>
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
							echo '<td>'.$filas['codigo_parroquia'].'</td>';
							echo '<td>'.$filas['descripcion'].'</td>';
							echo '<td>'.$filas['municipio'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?parroquia&Opt=3&codigo_parroquia='.$filas['codigo_parroquia'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?parroquia&Opt=4&codigo_parroquia='.$filas['codigo_parroquia'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?parroquia&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
						?>
						<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>
					</center>		
				 <div id="Imprimir" style="display:none;">
					<span>Descargar Como:</span>
					<br/><br/>
					<a href="<?php echo  '../pdf/pdf_parroquia.php';?>" target="_blank"> <img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"> </a>
					&nbsp;&nbsp;
					<a href="../excel/excel_parroquia.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
			    </div>
				</div>
			</div>
		</div>
	</fieldset>


	<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
	?>
	<form class="form-horizontal" action="../controllers/control_parroquia.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: PARROQUIA</center></legend>
			<div id="paginador" class="enjoy-css">  			
				<div class="control-group">  
					<label class="control-label" for="codigo_parroquia">Código:</label>  
					<div class="controls">  
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
						<input class="input-xlarge" title="el Código del Parroquia es generado por el sistema" name="codigo_parroquia" id="codigo_parroquia" type="text" readonly /> 
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="descripcion">Parroquia:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el nombre del parroquia" onKeyUp="this.value=this.value.toUpperCase()" name="descripcion" id="descripcion" type="text" size="50" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="codigo_municipio">Municipio:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el nombre del municipio" onKeyUp="this.value=this.value.toUpperCase()" name="codigo_municipio" id="codigo_municipio" type="text" size="50" required />
					</div>  
				</div>
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<center>
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
					<a href="?parroquia"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>  
		</fieldset>  
	</form>
	<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT p.codigo_parroquia,p.descripcion,p.codigo_municipio||'_'||m.descripcion AS municipio,p.estatus
	FROM general.tparroquia p 
	INNER JOIN general.tmunicipio m ON p.codigo_municipio = m.codigo_municipio 
	WHERE p.codigo_parroquia =".$pgsql->comillas_inteligentes($_GET['codigo_parroquia']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_parroquia.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: PARROQUIA</center></legend>
			<div id="paginador" class="enjoy-css">				
				<div class="control-group">  
					<label class="control-label" for="codigo_parroquia">Código:</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
						<input class="input-xlarge" title="el Código del Parroquia es generado por el sistema" name="codigo_parroquia" id="codigo_parroquia" type="text" value="<?=$row['codigo_parroquia']?>" readonly /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="descripcion">Parroquia:</label>  
					<div class="controls">  
						<input type="hidden" id="olddescripcion" name="olddescripcion" value="<?=$row['descripcion']?>">
						<input class="input-xlarge" title="Ingrese el nombre del parroquia" onKeyUp="this.value=this.value.toUpperCase()" name="descripcion" id="descripcion" type="text" value="<?=$row['descripcion']?>" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="codigo_municipio">Municipio:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el nombre del municipio" onKeyUp="this.value=this.value.toUpperCase()" name="codigo_municipio" id="codigo_municipio" type="text" size="50" value="<?=$row['municipio']?>" required />
					</div>  
				</div>
				<div class="control-group">  
					<?php if($row['estatus']=='1'){echo "<p id='estatus' class='Activo'>Activo </p>";}else{echo "<p id='estatus' class='Desactivado'>Desactivado</p>";} ?>
				</div>  
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<center>
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
						<a href="?parroquia"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
					</center>  
				</div>
			</fieldset>  
		</form>
		<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT e.codigo_parroquia, e.descripcion, p.descripcion AS municipio 
	FROM general.tparroquia e INNER JOIN general.tmunicipio p ON e.codigo_municipio = p.codigo_municipio 
	WHERE e.codigo_parroquia =".$pgsql->comillas_inteligentes($_GET['codigo_parroquia']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: PARROQUIA</center></legend>
		<div id="paginador" class="enjoy-css">			
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Código:</label>
						</td>
						<td>
							<label><?=$row['codigo_parroquia']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Parroquia:</label>
						</td>
						<td>
							<label><?=$row['descripcion']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Municipio:</label>
						</td>
						<td>
							<label><?=$row['municipio']?></label>
						</td>
					</tr>
				</table>
				<center>
					<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
					<a href="?parroquia"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana de Impresiones
?>