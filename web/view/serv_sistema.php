<script type="text/javascript" src="js/chsb_sistema.js"></script>
<?php 
if(!isset($_GET['Opt'])){ // Ventana principal 
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT * FROM seguridad.tsistema";
	$query = $pgsql->Ejecutar($sql);
	$row=$pgsql->Respuesta($query);
?>
<form class="form-horizontal" action="../controllers/control_sistema.php" method="post" id="form1">  
	<fieldset>  
	<H3 align="center">DATOS DEL NEGOCIO DEL SISTEMA</H3> 
	<div class="control-group">  
		<label class="control-label" for="rif_negocio">RIF Negocio</label>  
		<div class="controls">
			<input type="hidden" id="lOpt" name="lOpt" value="Modificar"> 
			<input type="hidden" id="oldrif" name="oldrif" value="<?=$row['rif_negocio']?>">  
			<input class="input-xlarge" title="Ingrese el RIF del negocio" name="rif_negocio" id="rif_negocio" type="text" value="<?=$row['rif_negocio']?>" readonly /> 
		</div>  
	</div>  
	<div class="control-group">  
		<label class="control-label" for="nombre">Nombre</label>  
		<div class="controls">  
			<input class="input-xlarge" title="Ingrese el nombre del negocio" onKeyUp="this.value=this.value.toUpperCase()" name="nombre" id="nombre" type="text" value="<?=$row['nombre']?>" required />
		</div>  
	</div>   
	<div class="control-group">  
		<label class="control-label" for="telefono">Teléfono</label>  
		<div class="controls">  
			<input class="input-xlarge" title="Ingrese el número telefónico" onKeyUp="this.value=tHis.vaLue.toupperCase()" name="telefono" id="telefono" type="text" value="<?=$row['telefono']?>" required />
		</div>  
	</div>
	<div class="control-group">  
		<label class="control-label" for="email">Correo Electrónico</label>  
		<div class="controls">  
			<input class="input-xlarge" title="Ingrese el correo electrónico del negocio" onKeyUp="this.value=tHis.vaLue.toupperCase()" name="email" id="email" type="text" value="<?=$row['email']?>" required />
		</div>  
	</div>
	<div class="control-group">  
		<label class="control-label" for="clave_email">Clave del Correo Electrónico</label>  
		<div class="controls">  
			<input class="input-xlarge" title="Ingrese la clave del correo electrónico" onKeyUp="this.value=tHis.vaLue.toupperCase()" name="clave_email" id="clave_email" type="password" value="<?=$row['clave_email']?>" />
		</div>  
	</div>
	<div class="control-group">  
		<label class="control-label" for="codigo_parroquia">Parroquia</label>  
		<div class="controls">  
			<select class="selectpicker" data-live-search="true" title="Seleccione una Parroquia" name='codigo_parroquia' id='codigo_parroquia' required >
				<option value=0>Seleccione una Parroquia</option>
				<?php
					require_once('../class/class_bd.php');
					$pgsql = new Conexion();
					$sql = "SELECT * FROM general.tparroquia ORDER BY descripcion ASC";
					$query = $pgsql->Ejecutar($sql);
					while($rows=$pgsql->Respuesta($query)){
						if($row['codigo_parroquia']==$rows['codigo_parroquia'])
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
			<textarea class="input-xlarge" title="Ingrese la direccion del negocio" onKeyUp="this.value=tHis.vaLue.toupperCase()" name="direccion" id="direccion" required /><?=$row['direccion']?></textarea>
		</div>  
	</div>
	<div class="control-group">  
		<label class="control-label" for="mision">Misión</label>  
		<div class="controls">  
			<textarea class="jqte-test" title="Ingrese la misión del negocio" onKeyUp="this.value=tHis.vaLue.toupperCase()" name="mision" id="mision" required /><?=$row['mision']?></textarea>
		</div>  
	</div>
	<div class="control-group">  
		<label class="control-label" for="vision">Visión</label>  
		<div class="controls">  
			<textarea class="jqte-test" title="Ingrese la visión del negocio" onKeyUp="this.value=tHis.vaLue.toupperCase()" name="vision" id="vision" required /><?=$row['vision']?></textarea>
		</div>  
	</div>
	<div class="control-group">  
		<label class="control-label" for="objetivo">Objetivo</label>  
		<div class="controls">  
			<textarea class="jqte-test" title="Ingrese el objetivo seguridad y especificos del negocio" onKeyUp="this.value=tHis.vaLue.toupperCase()" name="objetivo" id="objetivo" required /><?=$row['objetivo']?></textarea>
		</div>  
	</div>
	<div class="control-group">  
		<label class="control-label" for="historia">Reseña Histórica</label>  
		<div class="controls">  
			<textarea class="jqte-test" title="Ingrese la reseña histórica del negocio" onKeyUp="this.value=tHis.vaLue.toupperCase()" name="historia" id="historia" required /><?=$row['historia']?></textarea>
		</div>  
	</div>
	<div class="control-group">  
		<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
	</div>  
	<div class="form-actions">
		<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
	</div>  
	</fieldset>  
</form>
<?php
} // Fin Ventana Principal
?>