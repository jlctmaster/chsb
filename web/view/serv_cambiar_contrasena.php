<script type="text/javascript" src="js/chsb_usuario.js"></script>
<?php
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$conexion = new Conexion();
	$sql = "SELECT c.* FROM seguridad.tconfiguracion c 
	INNER JOIN seguridad.tperfil p ON p.codigo_configuracion = c.codigo_configuracion 
	WHERE p.codigo_perfil = '".$_SESSION['user_codigo_perfil']."'";
	$query=$conexion->Ejecutar($sql);
	if($Obj=$conexion->Respuesta($query)){
		echo "<input type='hidden' id='longitud_minclave' value='".$Obj['longitud_minclave']."' />";
		echo "<input type='hidden' id='longitud_maxclave' value='".$Obj['longitud_maxclave']."' />";
		echo "<input type='hidden' id='cantidad_letrasmayusculas' value='".$Obj['cantidad_letrasmayusculas']."' />";
		echo "<input type='hidden' id='cantidad_letrasminusculas' value='".$Obj['cantidad_letrasminusculas']."' />";
		echo "<input type='hidden' id='cantidad_caracteresespeciales' value='".$Obj['cantidad_caracteresespeciales']."' />";
		echo "<input type='hidden' id='cantidad_numeros' value='".$Obj['cantidad_numeros']."' />";
	}
	?>
	<form class="form-horizontal" id="form1" name="form" action="../controllers/control_cambiar_clave.php" method="post">
		<fieldset>
			<legend><center>Vista: CAMBIAR CONTRASEÑA</center></legend>		
			<div id="paginador" class="enjoy-css">		
				<div class="control-group">  
					<label class="control-label" for="contrasena">Contraseña Actual</label>  
					<div class="controls">
						<span class="add-on"><i class="icon-lock"></i></span> 
						<input class="input-xlarge-add-on" value="<?php echo $_SESSION['user_password'];?>" type="password" name="contrasena" id="contrasena_actual" title="Contraseña Actual" readonly required/>
						<input type="hidden" name="cambiar_clave_con_logeo" value="0"/>
						<input type="hidden" name="lOpt" id="lOpt" value="Modificar"/>
					</div>  
				</div> 
				<div class="control-group">  
					<label class="control-label" for="nueva_contrasena">Nueva Contraseña</label>  
					<div class="controls">  
						<span class="add-on"><i class="icon-lock"></i></span> 
						<input class="input-xlarge-add-on" name="nueva_contrasena" type="password" id="nueva_contrasena" placeholder="Nueva contraseña" title="Por favor coloque su contraseña" required />
					</div>  
				</div> 
				<div class="control-group">  
					<label class="control-label" for="confirmar_contrasena">Confirmar Contraseña</label>  
					<div class="controls">  
						<span class="add-on"><i class="icon-lock"></i></span> 
						<input class="input-xlarge-add-on" name="confirmar_contrasena" type="password" id="confirmar_contrasena" placeholder="Repita la Contraseña" title="Repita la Contraseña" required/>
					</div>  
				</div>
				<div class="control-group">  
					<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
				</div>  
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
				</div>  
			</div>
		</fieldset>
	</form>
	<?php
}
?>