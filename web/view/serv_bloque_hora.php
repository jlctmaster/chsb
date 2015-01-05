<script type="text/javascript" src="js/chsb_bloque_hora.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('bloque_hora');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql ="SELECT codigo_bloque_hora, CASE turno WHEN 'M' THEN TO_CHAR(hora_inicio,'HH:MI AM') ELSE TO_CHAR(hora_inicio,'HH:MI PM') END hora_inicio,
	CASE turno WHEN 'T' THEN TO_CHAR(hora_fin,'HH:MI PM') ELSE TO_CHAR(hora_fin,'HH:MI AM') END hora_fin,
	CASE turno WHEN 'M' THEN 'Mañana' ELSE 'Tarde' End turno 
	FROM educacion.tbloque_hora";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: BLOQUE DE HORAS</center></legend>		
		<div id="paginador" class="enjoy-css"> 
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código:</th>
							<th>Hora de Inicio:</th>
							<th>Hora de Culminación:</th>
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
							echo '<td>'.$filas['codigo_bloque_hora'].'</td>';
							echo '<td>'.$filas['hora_inicio'].'</td>';
							echo '<td>'.$filas['hora_fin'].'</td>';
							echo '<td>'.$filas['turno'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?bloque_hora&Opt=3&codigo_bloque_hora='.$filas['codigo_bloque_hora'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?bloque_hora&Opt=4&codigo_bloque_hora='.$filas['codigo_bloque_hora'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?bloque_hora&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
						?>
						<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>
					</center>		
					<div id="Imprimir" style="display:none;">
						<span>Descargar Como:</span>
						<br/><br/>
						<a href="<?php echo  '../pdf/pdf_bloque_hora.php';?>" target="_blank"><img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"></a>
						&nbsp;&nbsp;						
						<a href="../excel/excel_bloque_hora.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
					</div>
				</div>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
	?>
	<form class="form-horizontal" action="../controllers/control_bloque_hora.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: BLOQUE DE HORAS</center></legend>		
			<div id="paginador" class="enjoy-css"> 
				<div class="control-group">  
					<label class="control-label" for="codigo_bloque_hora">Código:</label>  
					<div class="controls">  
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
						<input class="input-xlarge" title="el Código del BLOQUE DE HORAS es generado por el sistema" name="codigo_bloque_hora" id="codigo_bloque_hora" type="text" readonly /> 
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="hora_inicio">Hora de Inicio:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Seleccione la hora de inicio" name="hora_inicio" id="hora_inicio" type="text" size="50" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="hora_fin">Hora de Culminación:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Seleccione la hora de culminación" name="hora_fin" id="hora_fin" type="text" size="50" required />
					</div>  
				</div>   
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
					<a href="?bloque_hora"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div> 
			</div> 
		</fieldset>  
	</form>
	<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT codigo_bloque_hora, CASE turno WHEN 'M' THEN TO_CHAR(hora_inicio,'HH:MI')||' a.m.' ELSE TO_CHAR(hora_inicio,'HH:MI')||' p.m.' END hora_inicio,
	CASE turno WHEN 'T' THEN TO_CHAR(hora_fin,'HH:MI')||' p.m.' ELSE TO_CHAR(hora_fin,'HH:MI')||' a.m.' END hora_fin,estatus
	FROM educacion.tbloque_hora WHERE codigo_bloque_hora =".$pgsql->comillas_inteligentes($_GET['codigo_bloque_hora']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_bloque_hora.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: BLOQUE DE HORAS</center></legend>		
			<div id="paginador" class="enjoy-css"> 
				<div class="control-group">  
					<label class="control-label" for="codigo_bloque_hora">Código:</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
						<input class="input-xlarge" title="el Código del bloque del de hora es generado por el sistema" name="codigo_bloque_hora" id="codigo_bloque_hora" type="text" value="<?=$row['codigo_bloque_hora']?>" readonly /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="hora_inicio">Hora de Inicio:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Seleccione la hora de inicio" name="hora_inicio" id="hora_inicio" type="text" value="<?=$row['hora_inicio']?>" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="hora_fin">Hora de Culminación:</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Seleccione la hora de culminación"  name="hora_fin" id="hora_fin" type="text" value="<?=$row['hora_fin']?>" required />
					</div>  
				</div> 

				<div class="control-group">  
					<?php if($row['estatus']=='1'){echo "<p id='estatus' class='Activo'>Activo </p>";}
					else{echo "<p id='estatus' class='Desactivado'>Desactivado</p>";} ?>
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
						<a href="?bloque_hora"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
					</div>  
				</div>
			</fieldset>  
		</form>
		<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT codigo_bloque_hora, CASE turno WHEN 'M' THEN TO_CHAR(hora_inicio,'HH:MI')||' a.m.' ELSE TO_CHAR(hora_inicio,'HH:MI')||' p.m.' END hora_inicio,
	CASE turno WHEN 'T' THEN TO_CHAR(hora_fin,'HH:MI')||' p.m.' ELSE TO_CHAR(hora_fin,'HH:MI')||' a.m.' END hora_fin,
	CASE turno WHEN 'M' THEN 'Mañana' ELSE 'Tarde' End turno 
	FROM educacion.tbloque_hora WHERE codigo_bloque_hora =".$pgsql->comillas_inteligentes($_GET['codigo_bloque_hora']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: BLOQUE DE HORAS</center></legend>		
		<div id="paginador" class="enjoy-css"> 
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Código:</label>
						</td>
						<td>
							<label><?=$row['codigo_bloque_hora']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Hora de Inicio:</label>
						</td>
						<td>
							<label><?=$row['hora_inicio']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Hora de Culminación:</label>
						</td>
						<td>
							<label><?=$row['hora_fin']?></label>
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
				</table>
				<center>
					<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
					<a href="?bloque_hora"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana de Impresiones
?>