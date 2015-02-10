<script type="text/javascript" src="js/chsb_persona.js"></script>
<?php
require_once("../class/class_perfil.php");
$perfil=new Perfil();
$perfil->codigo_perfil($_SESSION['user_codigo_perfil']);
$perfil->url('persona');
$a=$perfil->IMPRIMIR_OPCIONES(); // el arreglo $a contiene las opciones del menú. 
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT e.cedula_persona, e.primer_nombre,e.primer_apellido,t.descripcion AS tipo_persona 
	FROM general.tpersona e
	INNER JOIN general.ttipo_persona t ON e.codigo_tipopersona=t.codigo_tipopersona";
	$consulta = $pgsql->Ejecutar($sql);
	?>
	<fieldset>
		<legend><center>Vista: PERSONA</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div class="container">
				<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
					<thead>
						<tr>
							<th>Cédula</th>
							<th>Primer Nombre</th>
							<th>Primer Apellido</th>
							<th>Tipo de Persona</th>
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
							echo '<td>'.$filas['cedula_persona'].'</td>';
							echo '<td>'.$filas['primer_nombre'].'</td>';
							echo '<td>'.$filas['primer_apellido'].'</td>';
							echo '<td>'.$filas['tipo_persona'].'</td>';
							for($x=0;$x<count($a);$x++){
						if($a[$x]['orden']=='2') //Actualizar, Modificar o Alterar el valor del Registro
						echo '<td><a href="?persona&Opt=3&cedula_persona='.$filas['cedula_persona'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
						else if($a[$x]['orden']=='5') //Imprimir o Ver el Registro
						echo '<td><a href="?persona&Opt=4&cedula_persona='.$filas['cedula_persona'].'" style="border:0px;"><i class="'.$a[$x]['icono'].'"></i></a></td>';
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
							echo '<a href="?persona&Opt=2"><button type="button" class="btn btn-large btn-primary"><i class='.$a[$x]['icono'].'></i>&nbsp;'.$a[$x]['nombre_opcion'].'</button></a>';
						?>
						<button type="button" id="btnImprimirTodos" class="btn btn-large btn-primary"><i class="icon-download-alt"></i>&nbsp;Descargar Archivo</button>
					</center>		
				<div id="Imprimir" style="display:none;">
					<span>Descargar Como:</span>
					<br/><br/>
					<a href="<?php echo  '../pdf/pdf_persona.php';?>" target="_blank"> <img src="images/icon-pdf.png" alt="Exportar a PDF" style="width:60px;heigth:60px;float:center;"> </a>
					&nbsp;&nbsp;
					<a href="../excel/excel_persona.php" ><img src="images/icon-excel.png" alt="Exportar a Excel" style="width:60px;heigth:60px;float:center;"></a>
			    </div>
				</div>
			</div>
		</div>
	</fieldset>
	<?php
} // Fin Ventana Principal
else if($_GET['Opt']=="2"){ // Ventana de Registro
	?>
	<form class="form-horizontal" action="../controllers/control_persona.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: PERSONA</center></legend>		
			<div id="paginador" class="enjoy-css">			
				<div class="control-group">  
					<label class="control-label" for="cedula_persona">Cédula</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Registrar"> 
						<input class="input-xlarge" title="Ingrese el número de cédula" onKeyPress="return isRif(event,this.value)" onKeyUp="this.value=this.value.toUpperCase()" maxlength=10 name="cedula_persona" id="cedula_persona" type="text" required /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="primer_nombre">Primer Nombre</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el primer nombre de la persona" onKeyUp="this.value=this.value.toUpperCase()" name="primer_nombre" id="primer_nombre" type="text" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="segundo_nombre">Segundo Nombre</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el segundo  nombre del persona" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_nombre" id="segundo_nombre" type="text" />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="primer_apellido">Primer Apellido</label>  
					<div class="controls">   
						<input class="input-xlarge" title="Ingrese elprimer apellido de la persona" onKeyUp="this.value=this.value.toUpperCase()" name="primer_apellido" id="se" type="text" required />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="segundo_apellido">Segundo Apellido</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el segundo apellido de la persona" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_apellido" id="segundo_apellido" type="text" />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="sexo">Sexo</label>  
					<div class="controls">  
						<div class="radios">
							<input type="radio" name="sexo" id="sexo" value="F" checked="checked" required /> Femenino
							<input type="radio" name="sexo" id="sexo" value="M" required /> Masculino
						</div>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="fecha_nacimiento">Fecha de Nacimiento</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de nacimiento de la persona" name="fecha_nacimiento" id="fecha_nacimiento" type="text" readonly required />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="lugar_nacimiento">Lugar de Nacimiento</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione el lugar" name='lugar_nacimiento' id='lugar_nacimiento' required >
							<option value=0>Seleccione el Lugar</option>
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
				<div class="control-group">  
					<label class="control-label" for="direccion">Dirección</label>  
					<div class="controls">  
						<textarea class="input-xlarge" title="Ingrese la direccion de la persona" onKeyUp="this.value=this.value.toUpperCase()" name="direccion" id="direccion" type="text" required /></textarea>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="telefono_local">Teléfono Local</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el número de teléfono local" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_local" id="telefono_local" type="text" />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="telefono_movil">Teléfono Móvil</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el número de teléfono movil" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_movil" id="telefono_movil" type="text" />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="codigo_tipopersona">Tipo Persona</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione el Tipo de persona" name='codigo_tipopersona' id='codigo_tipopersona' required >
							<option value=0>Seleccione el Tipo Persona</option>
							<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT * FROM general.ttipo_persona 
							WHERE descripcion NOT LIKE '%ESTUDIANTE%' 
							ORDER BY descripcion ASC";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								echo "<option value=".$rows['codigo_tipopersona'].">".$rows['descripcion']."</option>";
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
					<a href="?persona"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</div>
			</div>
		</fieldset>  
	</form>
	<?php
}// Fin Ventana de Registro
else if($_GET['Opt']=="3"){ // Ventana de Modificaciones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT *,TO_CHAR(fecha_nacimiento,'DD/MM/YYYY') as fecha_nacimiento FROM general.tpersona WHERE cedula_persona =".$pgsql->comillas_inteligentes($_GET['cedula_persona']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<form class="form-horizontal" action="../controllers/control_persona.php" method="post" id="form1">  
		<fieldset>
			<legend><center>Vista: PERSONA</center></legend>		
			<div id="paginador" class="enjoy-css">  			
				<div class="control-group">  
					<label class="control-label" for="cedula_persona">Cédula</label>  
					<div class="controls">
						<input type="hidden" id="lOpt" name="lOpt" value="Modificar"> 
						<input type="hidden" id="oldci" name="oldci" value="<?=$row['cedula_persona']?>">  
						<input class="input-xlarge" title="Ingrese el número de cédula" onKeyPress="return isRif(event,this.value)" onKeyUp="this.value=this.value.toUpperCase()" maxlength=10 name="cedula_persona" id="cedula_persona" type="text" value="<?=$row['cedula_persona']?>" required /> 
					</div>  
				</div>
				<div class="control-group">  
					<label class="control-label" for="primer_nombre">Primer Nombre</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el primer nombre de la persona" onKeyUp="this.value=this.value.toUpperCase()" name="primer_nombre" id="primer_nombre" type="text" value="<?=$row['primer_nombre']?>" required />
					</div>  
				</div>   
				<div class="control-group">  
					<label class="control-label" for="segundo_nombre">Segundo Nombre</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el segundo  nombre del persona" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_nombre" id="segundo_nombre" type="text" value="<?=$row['segundo_nombre']?>" />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="primer_apellido">Primer Apellido</label>  
					<div class="controls">   
						<input class="input-xlarge" title="Ingrese elprimer apellido de la persona" onKeyUp="this.value=this.value.toUpperCase()" name="primer_apellido" id="se" type="text" value="<?=$row['primer_apellido']?>" required />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="segundo_apellido">Segundo Apellido</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el segundo apellido de la persona" onKeyUp="this.value=this.value.toUpperCase()" name="segundo_apellido" id="segundo_apellido" type="text" value="<?=$row['segundo_apellido']?>" />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="sexo">Sexo</label>  
					<div class="controls">  
						<div class="radios">
							<input type="radio" name="sexo" id="sexo" <?php if($row['sexo']=="F"){echo "value='F' checked='checked'";}?> required /> Femenino
							<input type="radio" name="sexo" id="sexo" <?php if($row['sexo']=="M"){echo "value='M' checked='checked'";}?> required /> Masculino
						</div>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="fecha_nacimiento">Fecha de Nacimiento</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese la fecha de nacimiento de la persona" name="fecha_nacimiento" id="fecha_nacimiento" type="text" value="<?=$row['fecha_nacimiento']?>" readonly required />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="lugar_nacimiento">Lugar de Nacimiento</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione el lugar" name='lugar_nacimiento' id='lugar_nacimiento' required >
							<option value=0>Seleccione el Lugar</option>
							<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT * FROM general.tparroquia ORDER BY descripcion ASC";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								if($rows['codigo_parroquia']==$row['lugar_nacimiento'])
									echo "<option value=".$rows['codigo_parroquia']." selected >".$rows['descripcion']."</option>";
								else
									echo "<option value=".$rows['codigo_parroquia'].">".$rows['descripcion']."</option>";
							}
							?>
						</select>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="direccion">Dirección</label>  
					<div class="controls">  
						<textarea class="input-xlarge" title="Ingrese la direccion de la persona" onKeyUp="this.value=this.value.toUpperCase()" name="direccion" id="direccion" type="text" required /><?php echo $row['direccion']; ?></textarea>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="telefono_local">Teléfono Local</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el número de teléfono local" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_local" id="telefono_local" type="text" value="<?=$row['telefono_local']?>"/>
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="telefono_movil">Teléfono Móvil</label>  
					<div class="controls">  
						<input class="input-xlarge" title="Ingrese el número de teléfono movil" maxlength=11 onKeyPress="return isNumberKey(event)" name="telefono_movil" id="telefono_movil" type="text" value="<?=$row['telefono_movil']?>" />
					</div>  
				</div>  
				<div class="control-group">  
					<label class="control-label" for="codigo_tipopersona">Tipo Persona</label>  
					<div class="controls">  
						<select class="selectpicker" data-live-search="true" title="Seleccione el Tipo de persona" name='codigo_tipopersona' id='codigo_tipopersona' required >
							<option value=0>Seleccione el Tipo Persona</option>
							<?php
							require_once('../class/class_bd.php');
							$pgsql = new Conexion();
							$sql = "SELECT * FROM general.ttipo_persona 
							WHERE descripcion NOT LIKE '%ESTUDIANTE%' 
							ORDER BY descripcion ASC";
							$query = $pgsql->Ejecutar($sql);
							while($rows=$pgsql->Respuesta($query)){
								if($rows['codigo_tipopersona']==$row['codigo_tipopersona'])
									echo "<option value=".$rows['codigo_tipopersona']." selected >".$rows['descripcion']."</option>";
								else
									echo "<option value=".$rows['codigo_tipopersona'].">".$rows['descripcion']."</option>";
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
							<a href="?persona"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
						</div>  
					</div>
				</fieldset>  
			</form>
			<?php
}  // Fin Ventana de Modificaciones
else if($_GET['Opt']=="4"){ // Ventana de Impresiones
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT e.cedula_persona,INITCAP(e.primer_nombre) primer_nombre,INITCAP(e.segundo_nombre) segundo_nombre
	,INITCAP(e.primer_apellido) primer_apellido,INITCAP(e.segundo_apellido) segundo_apellido,CASE e.sexo WHEN 'F' THEN 'FEMENINO' ELSE 'MASCULINO' END sexo
	,TO_CHAR(fecha_nacimiento,'DD/MM/YYYY') fecha_nacimiento,p.descripcion As lugar_nacimiento,e.direccion,e.telefono_local,e.telefono_movil
	,t.descripcion AS tipo_persona 
	FROM general.tpersona e
	INNER JOIN general.tparroquia p ON e.lugar_nacimiento= p.codigo_parroquia
	INNER JOIN general.ttipo_persona t ON e.codigo_tipopersona=t.codigo_tipopersona
	WHERE e.cedula_persona =".$pgsql->comillas_inteligentes($_GET['cedula_persona']);
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
	?>
	<link rel="STYLESHEET" type="text/css" href="css/print.css" media="print" />
	<fieldset>
		<legend><center>Vista: PERSONA</center></legend>		
		<div id="paginador" class="enjoy-css">	
			<div class="printer">
				<table class="bordered-table zebra-striped" >
					<tr>
						<td>
							<label>Cédula:</label>
						</td>
						<td>
							<label><?=$row['cedula_persona']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Primer Nombre:</label>
						</td>
						<td>
							<label><?=$row['primer_nombre']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Segundo Nombre:</label>
						</td>
						<td>
							<label><?=$row['segundo_nombre']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Primer Apellido:</label>
						</td>
						<td>
							<label><?=$row['primer_apellido']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Segundo Apellido:</label>
						</td>
						<td>
							<label><?=$row['segundo_apellido']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Sexo:</label>
						</td>
						<td>
							<label><?=$row['sexo']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Fecha Nacimiento:</label>
						</td>
						<td>
							<label><?=$row['fecha_nacimiento']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Lugar Nacimiento:</label>
						</td>
						<td>
							<label><?=$row['lugar_nacimiento']?></label>
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
							<label>Teléfono local:</label>
						</td>
						<td>
							<label><?=$row['telefono_local']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Teléfono Móvil:</label>
						</td>
						<td>
							<label><?=$row['telefono_movil']?></label>
						</td>
					</tr>
					<tr>
						<td>
							<label>Tipo Persona:</label>
						</td>
						<td>
							<label><?=$row['tipo_persona']?></label>
						</td>
					</tr>
				</table>
				<center>
					<button id="btnPrint" type="button"class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Imprimir</button>
					<a href="?persona"><button type="button" class="btn btn-large btn-primary"/><i class="icon-repeat"></i>&nbsp;Volver</button></a>
				</center>
			</div>
		</div>
		<?php
} // Fin Ventana de Impresiones
?>