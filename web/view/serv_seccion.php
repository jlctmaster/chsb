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
	$sql = "SELECT seccion,nombre_seccion,CASE turno WHEN 'M' THEN 'MAÑANA' ELSE 'TARDE' END AS turno FROM educacion.tseccion ";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: SECCIÓN</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Código:</th>
							<th>Sección:</th>
							<th>Turno:</th>
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
						<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>
					</center>
					<div id="Imprimir" style="display:none;">
						<span>Descargar Como:</span>
						<br/><br/>
						&nbsp;&nbsp;
						<a href="<?php echo  '../pdf/pdf_seccion.php';?>" target="_blank"><img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"></a>
						<a href="../excel/excel_seccion.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>

					</div>
				</div>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
?>
<form class="form-horizontal" action="../controllers/control_seccion.php" method="post" id="form1">  
	<fieldset>
		<legend><center>Vista: SECCIÓN</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="control-group">  
				<label class="control-label" for="seccion">Código:</label>  
				<div class="controls">  
					<input type="hidden" id="lOpt" name="lOpt" value="Registrar">
					<input class="input-xlarge" title="Ingrese el Código de la Sección" onKeyUp="this.value=this.value.toUpperCase()" name="seccion" id="seccion" type="text" required/> 
				</div>  
			</div>   
			<div class="control-group">  
				<label class="control-label" for="nombre_seccion">Sección:</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese el nombre de la Sección" onKeyUp="this.value=this.value.toUpperCase()" name="nombre_seccion" id="nombre_seccion" type="text" required />
				</div>  
			</div>   
			<div class="control-group">  
				<label class="control-label" for="turno">Turno:</label>  
				<div class="controls">  
					<select class="bootstrap-select form-control" name="turno" id="turno" title="Seleccione un turno" placeholder="Seleccione un turno"  required >
						<option value='0'>Seleccione un Turno</option>
						<option value="M" >Mañana</option>
						<option value="T" >Tarde</option>
					</select>
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="capacidad_min">Capacidad Mínima:</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese la capacidad Mínima" onKeyPress="return isNumberKey(event)" maxlength=2 name="capacidad_min" id="capacidad_min" type="text" required />
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="capacidad_max">Capacidad Máxima:</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese la Capacidad Máxima" onKeyPress="return isNumberKey(event)" maxlength=2 name="capacidad_max" id="capacidad_max" type="text" required />
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="indice_min">Índice Mínimo</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese el Índice Corporal Mínimo" onKeyPress="return isNumberKey(event)" maxlength=2 name="indice_min" id="indice_min" type="text" required />
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="indice_max">Índice Máximo</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese el Índice Corporal Máximo" onKeyPress="return isNumberKey(event)" maxlength=2 name="indice_max" id="indice_max" type="text" required />
				</div>  
			</div>
			<br>
			<div class="table-responsive">
				<table id='tablaMaterias' class="table-bordered zebra-striped">
					<tr>
						<td><center><label class="control-label" >Materias:</label></center></td>
						<td><center><button type="button" onclick="agrega_campos()" class="btn btn-primary"><i class="icon-plus"></i></button></center></td>
					</tr>
				</table>
			</div>
			<div class="control-group">  
				<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
			</div>
			<div class="form-actions">
				<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
				<a href="?seccion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
			</div>
		</div>
	</fieldset>
</form>
<script type="text/javascript">
	var materias = document.getElementsByName('materias[]');
	var contador=materias.length;
	function agrega_campos(){
		$("#tablaMaterias").append("<tr id='"+contador+"'>"+
		"<td>"+
		"<center>"+
		"<select class='bootstrap-select form-control' name='materias[]' id='materia_"+contador+"' title='Seleccione una materia para la sección'>"+
		"<option value='0'>Seleccione una materia para la sección</option>"+
		<?php
			require_once("../class/class_bd.php");
			$pgsql=new Conexion();
			$sql = "SELECT TRIM(codigo_materia) codigo_materia,nombre_materia 
			FROM educacion.tmateria  
			WHERE estatus = '1'
			ORDER BY codigo_materia ASC";
			$query = $pgsql->Ejecutar($sql);
			$comillasimple=chr(34);
			while ($rows = $pgsql->Respuesta($query)){
			echo $comillasimple."<option value='".$rows['codigo_materia']."'>".$rows['nombre_materia']." (".$rows['codigo_materia'].")</option>".$comillasimple."+";
		}
		?>
		"</select>"+
		"</center>"+
		"</td>"+
		"<td>"+
		"<center>"+
		"<button type='button' class='btn btn-primary' onclick='elimina_me("+contador+")'><i class='icon-minus'></i></button>"+
		"</center>"+
		"</td>"+
		"</tr>");
		//	Modificamos el width de la cantidad para este elemento
	    $('#materia_'+contador).css("width","auto");
		contador++;
	}

	function elimina_me(elemento){
		$("#"+elemento).remove();
		for(var i=0;i<materias.length;i++){
			materias[i].removeAttribute('id');
		}
		for(var i=0;i<materias.length;i++){
			materias[i].setAttribute('id','materia_'+i);
		}
	}
</script>
<?php
} // Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM educacion.tseccion WHERE seccion =".$pgsql->comillas_inteligentes($_GET['seccion']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
?>
<form class="form-horizontal" action="../controllers/control_seccion.php" method="post" id="form1">  
	<fieldset>
		<legend><center>Vista: SECCIÓN</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="control-group">  
				<label class="control-label" for="seccion">Código:</label>  
				<div class="controls">
					<input type="hidden" id="lOpt" name="lOpt" value="Modificar">  
					<input type="hidden" id="oldseccion" name="oldseccion" value="<?=$row['seccion']?>">  
					<input class="input-xlarge" title="Ingrese el Código de la Sección" name="seccion" id="seccion" type="text" value="<?=$row['seccion']?>" /> 
				</div>  
			</div>  
			<div class="control-group">  
				<label class="control-label" for="nombre_seccion">Nombre Sección:</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese el nombre de la Sección" onKeyUp="this.value=this.value.toUpperCase()" name="nombre_seccion" id="nombre_seccion" type="text" value="<?=$row['nombre_seccion']?>" required />
				</div>  
			</div>   
			<div class="control-group">  
				<label class="control-label" for="turno">Turno:</label>  
				<div class="controls">  
					<select class="bootstrap-select form-control" name="turno" id="turno" title="Seleccione un turno" placeholder="Seleccione un turno"  required >
						<option value='0'>Seleccione un Turno</option>
						<option value="M" <?php if($row['turno']=="M") {echo "selected";} ?> >Mañana</option>
						<option value="T" <?php if($row['turno']=="T") {echo "selected";} ?> >Tarde</option>	
					</select>	
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="capacidad_min">Capacidad Minima:</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese Capacidad Minina" onKeyPress="return isNumberKey(event)" maxlength=2 name="capacidad_min" id="capacidad_min" type="text" value="<?=$row['capacidad_min']?>" required />
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="capacidad_max">Capacidad Máxima:</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese la Capacidad Máxima" onKeyPress="return isNumberKey(event)" maxlength=2 name="capacidad_max" id="capacidad_max" type="text" value="<?=$row['capacidad_max']?>" required />
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="indice_min">Índice Mínimo
				</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese el Índice Corporal Mínimo" onKeyPress="return isNumberKey(event)" maxlength=2 name="indice_min" id="indice_min" type="text" value="<?=$row['indice_min']?>" required />
				</div>  
			</div>
			<div class="control-group">  
				<label class="control-label" for="indice_max">Índice Máximo</label>  
				<div class="controls">  
					<input class="input-xlarge" title="Ingrese el Índice Corporal Máximo" onKeyPress="return isNumberKey(event)" maxlength=2 name="indice_max" id="indice_max" type="text" value="<?=$row['indice_max']?>" required />
				</div>  
			</div>
			<div class="control-group">  
				<?php if($row['estatus']=='1'){echo "<p id='estatus' class='Activo'>Activo </p>";}else{echo "<p id='estatus' class='Desactivado'>Desactivado</p>";} ?>
			</div> 
			<br>
			<div class="table-responsive">
				<table id='tablaMaterias' class="table-bordered zebra-striped">
					<tr>
						<td><center><label class="control-label" >Materias:</label></center></td>
						<td><center><button type="button" onclick="agrega_campos()" class="btn btn-primary"><i class="icon-plus"></i></button></center></td>
					</tr>
					<?php
					$pgsql=new Conexion();
					$sql = "SELECT TRIM(m.codigo_materia) codigo_materia, m.nombre_materia 
					FROM educacion.tmateria m 
					INNER JOIN educacion.tmateria_seccion ms ON m.codigo_materia = ms.codigo_materia 
					WHERE ms.seccion = '".$row['seccion']."' 
					ORDER BY ms.codigo_materia_seccion ASC";
					$query = $pgsql->Ejecutar($sql);
					$con=0;
					while ($row = $pgsql->Respuesta($query)){
						echo "<tr id='".$con."'>
						<td>
						<center>
						<select class='bootstrap-select form-control' name='materias[]' id='materia_".$con."' title='Seleccione una materia para la sección' >
						<option value='0'>Seleccione una materia para la sección</option>";
						$sqlx = "SELECT TRIM(codigo_materia) codigo_materia,nombre_materia 
						FROM educacion.tmateria  
						WHERE estatus = '1'
						ORDER BY codigo_materia ASC";
						$querys = $pgsql->Ejecutar($sqlx);
						while ($rows = $pgsql->Respuesta($querys)){
							if($rows['codigo_materia']==$row['codigo_materia']){
								echo "<option value='".$rows['codigo_materia']."' selected>".$rows['nombre_materia']." (".$rows['codigo_materia'].")</option>";
							}else{
								echo "<option value='".$rows['codigo_materia']."'>".$rows['nombre_materia']." (".$rows['codigo_materia'].")</option>";
							}
						}
						echo "</select>
						</center>
						</td>
						<td>
						<center>
						<button type='button' class='btn btn-primary' onclick='elimina_me('".$con."')'><i class='icon-minus'></i></button>
						</center>
						</td>
						</tr>";
						echo "<script>$('#materia_'+".$con.").css('width','auto');</script>";
						$con++;
					}
					?>
				</table>
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
		</div>
	</fieldset>  
</form>
<script type="text/javascript">
	var materias = document.getElementsByName('materias[]');
	var contador=materias.length;
	function agrega_campos(){
		$("#tablaMaterias").append("<tr id='"+contador+"'>"+
		"<td>"+
		"<center>"+
		"<select class='bootstrap-select form-control' name='materias[]' id='materia_"+contador+"' title='Seleccione una materia para la sección'>"+
		"<option value='0'>Seleccione una materia para la sección</option>"+
		<?php
			require_once("../class/class_bd.php");
			$pgsql=new Conexion();
			$sql = "SELECT TRIM(codigo_materia) codigo_materia,nombre_materia 
			FROM educacion.tmateria  
			WHERE estatus = '1'
			ORDER BY codigo_materia ASC";
			$query = $pgsql->Ejecutar($sql);
			$comillasimple=chr(34);
			while ($rows = $pgsql->Respuesta($query)){
				echo $comillasimple."<option value='".$rows['codigo_materia']."'>".$rows['nombre_materia']." (".$rows['codigo_materia'].")</option>".$comillasimple."+";
			}
		?>
		"</select>"+
		"</center>"+
		"</td>"+
		"<td>"+
		"<center>"+
		"<button type='button' class='btn btn-primary' onclick='elimina_me("+contador+")' ><i class='icon-minus'></i></button>"+
		"</center>"+
		"</td>"+
		"</tr>");
		//	Modificamos el width de la cantidad para este elemento
	    $('#materia_'+contador).css("width","auto");
		contador++;
	}

	function elimina_me(elemento){
		$("#"+elemento).remove();
		for(var i=0;i<materias.length;i++){
			materias[i].removeAttribute('id');
		}
		for(var i=0;i<materias.length;i++){
			materias[i].setAttribute('id','materia_'+i);
		}
	}
</script>
<?php
} // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT seccion,nombre_seccion,CASE turno WHEN 'M' THEN 'MAÑANA' WHEN 'T' THEN 'TARDE' ELSE 'NOCHE' END AS turno,
	capacidad_min,capacidad_max,indice_min,indice_max 
	FROM educacion.tseccion 
	WHERE seccion =".$pgsql->comillas_inteligentes($_GET['seccion']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
?>
<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
<fieldset>
	<legend><center>Vista: SECCIÓN</center></legend>		
	<div id="paginador" class="enjoy-css">
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
						<label>Índice Mínimo:</label>
					</td>
					<td>
						<label><?=$row['indice_min']?></label>
					</td>
				</tr>
				<tr>
					<td>
						<label>Índice Máximo:</label>
					</td>
					<td>
						<label><?=$row['indice_max']?></label>
					</td>
				</tr>
				</table>
				<center>
				<button id="btnPrint" type="button" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
				<a href="?seccion"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
			</center>
		</div>
	</div>
</fieldset>
<?php
} // Fin Ventana de Impresiones
?>