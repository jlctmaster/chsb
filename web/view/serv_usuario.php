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
		echo "<input type='hidden' id='numero_preguntas' value='".$Obj['numero_preguntas']."' />";
		$preguntas = $Obj['numero_preguntas'];
	}
	?>
	<form class="form-horizontal" id="form1" name="form" action="../controllers/control_cambiar_clave.php" method="post">
		<fieldset>
			<legend><center>Vista: DATOS USUARIO</center></legend>		
			<div id="paginador" class="enjoy-css">		
				<div class="row">
					<div class="span6">
						<div class="row-fluid">
							<div class="span6">
								<label>Cédula:</label>
								<input type="hidden" name="lOpt" id="lOpt" value="Modificar"/>
								<input class="span12" type="text" name="cedula_usuario" id="cedula_persona" value="<?php echo $_SESSION['user_cedula'];?>" readonly required /> 
							</div>
							<div class="span6">
								<label>Nombre de Usuario:</label>
								<input class="span12" type="text" name="nombre_usuario" id="nombre_usuario" value="<?php echo $_SESSION['user_name'];?>" readonly required /> 
							</div>
						</div>
					</div>
				</div>
				<?php
				for($i=0;$i<$preguntas;$i++){
					$numero=$i+1;
					echo '<div class="row">
					<div class="span6">
					<div class="row-fluid">
					<div class="span6">
					<label>Pregunta '.$numero.':</label>
					<textarea class="span12" onKeyUp="this.value=this.value.toUpperCase()" name="pregunta[]" id="pregunta_'.$i.'" title="Ingrese la pregunta '.$numero.' de seguridad" required/>'.$_SESSION['user_pregunta'][$i].'</textarea>
					</div>
					<div class="span6">
					<label>Respuesta '.$numero.':</label>
					<textarea class="span12" onKeyUp="this.value=this.value.toUpperCase()" name="respuesta[]" id="respuesta_'.$i.'" title="Ingrese la respuesta de la pregunta '.$numero.' de seguridad" required/>'.$_SESSION['user_respuesta'][$i].'</textarea>
					</div>
					</div>
					</div>
					</div>';
				}
				if ($_SESSION['user_estado']==3) {
					?>
					<div class="require_password">
						<div class="control-group">  
							<label class="control-label" for="codigo_modulo">Contraseña Actual:</label>  
							<div class="controls">
								<span class="add-on"><i class="icon-lock"></i></span> 
								<input class="input-xlarge-add-on" value="12345678" type="password" name="contrasena" id="contrasena_actual" title="Contraseña Actual" readonly required/>
								<input type="hidden" name="cambiar_clave_con_logeo" value="1"/>
							</div>  
						</div> 
						<div class="control-group">  
							<label class="control-label" for="nueva_contrasena">Nueva Contraseña:</label>  
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
						<?php } ?>
						<div class="control-group">  
							<p class="help-block"> Los campos resaltados en rojo son obligatorios </p>  
						</div>  
						<div class="form-actions">
							<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-hdd"></i>&nbsp;Guardar</button>
						</div>  
					</div>
				</div>
			</fieldset>
		</form>
		<?php
	}
	?>