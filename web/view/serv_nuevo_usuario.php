<script type="text/javascript" src="js/chsb_nuevo_usuario.js"></script>
<?php
	if(!isset($_GET['Opt'])){ // Ventana principal
		?>
		<form class="form-horizontal" action="../controllers/control_cambiar_clave.php" method="post" id="form1">  
			<fieldset>
				<legend><center>Vista: NUEVO USUARIO</center></legend>		
				<div id="paginador" class="enjoy-css">	
					<div class="control-group">  
						<label class="control-label" for="cedula_usuario">Cédula Persona:</label>  
						<div class="controls"> 
							<input type="hidden" name="lOpt" id="lOpt" value="Registrar"/>
							<input class="input-xlarge" title="ingrese la cédula ej: V123456789" onKeyPress="return isRif(event,this.value)" 
							onKeyUp="this.value=this.value.toUpperCase()" name="cedula_persona" id="cedula_persona" type="text" size="70" 
							placeholder="ingrese la cédula ej: V123456789" type="text" required />
						</div>  
					</div>
					<div class="control-group">  
						<label class="control-label" for="codigo_perfil">Perfil:</label>  
						<div class="controls">  
							<select class="selectpicker" data-live-search="true" title="Seleccione un Perfil" name='codigo_perfil' id='codigo_perfil' required >
								<?php 
								include_once("../class/class_html.php");
								$html=new Html();
								$id="codigo_perfil";
								$descripcion="nombre_perfil";
								$sql="SELECT * FROM seguridad.tperfil WHERE estatus = '1'";
								$Seleccionado='null';
								$html->Generar_Opciones($sql,$id,$descripcion,$Seleccionado); 
								?>
							</select>
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
} // Fin Ventana Principal
?>