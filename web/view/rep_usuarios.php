<fieldset>
	<legend><center>Reporte: USUARIO</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<form class="form-horizontal" action="../pdf/pdf_usuario.php"  method="post" id="form1">
				<div class="control-group">  
	                <label class="control-label">Rol Desde:</label>
	                <div class="controls">
		                <select class="selectpicker" data-live-search="true" title="Seleccione un Rol" name='perfil_desde' id='perfil_desde' >
							<option value=0> Seleccione un Rol</option>
							<?php
								$pgsql = new Conexion();
								$sql = "SELECT codigo_perfil,nombre_perfil
								FROM seguridad.tperfil 
								ORDER BY codigo_perfil ASC";
								$query = $pgsql->Ejecutar($sql);
								while($row=$pgsql->Respuesta($query)){
									echo "<option value=".$row['codigo_perfil']."-".$row['nombre_perfil'].">".$row['nombre_perfil']."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div class="control-group">  
	                <label class="control-label">Rol Hasta:</label>
	                <div class="controls">
		                <select class="selectpicker" data-live-search="true" title="Seleccione un Rol" name='perfil_hasta' id='perfil_hasta' >
							<option value=0> Seleccione un Rol</option>
							<?php
								$pgsql = new Conexion();
								$sql = "SELECT codigo_perfil,nombre_perfil
								FROM seguridad.tperfil 
								ORDER BY codigo_perfil ASC";
								$query = $pgsql->Ejecutar($sql);
								while($row=$pgsql->Respuesta($query)){
									echo "<option value=".$row['codigo_perfil']."-".$row['nombre_perfil'].">".$row['nombre_perfil']."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-actions">
					<button type="button" id="btnGuardar" class="btn btn-large btn-primary"><i class="icon-print"></i>&nbsp;Generar Reporte</button>
				</div>
			</form>
		</div>
	</div>
</fieldset>
<script type="text/javascript">
$(document).ready(init);
function init(){
	$('#btnGuardar').click(function(){
		var send=true;
		if($('#perfil_desde').val()==""){
			alert("¡Debe seleccionar un Rol desde la cual desea ver los usuarios!");
			send=false;
		}
		
		if($('#perfil_hasta').val()==""){
			alert("¡Debe seleccionar la fecha hasta donde desea ver los usuarios!");
			send=false;
		}

		if(send==true)
			$('#form1').submit();
	})
}
</script>
<?php if(isset($_SESSION['datos'])) unset($_SESSION['datos']);?>