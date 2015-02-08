<fieldset>
	<legend><center>Reporte: LISTADO DE ESTUDIANTE POR SECCIÓN</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<form class="form-horizontal" action="../pdf/pdf_estudiante_seccion.php"  method="post" id="form1">
				<div class="control-group">  
	                <label class="control-label">Sección Desde:</label>
	                <div class="controls">
		                <select class="selectpicker" data-live-search="true" title="Seleccione una Sección" name='seccion_desde' id='seccion_desde' >
							<option value=0> Seleccione una Sección</option>
							<?php
								$pgsql = new Conexion();
								$sql = "SELECT seccion,nombre_seccion 
								FROM educacion.tseccion 
								ORDER BY seccion ASC";
								$query = $pgsql->Ejecutar($sql);
								while($row=$pgsql->Respuesta($query)){
									echo "<option value=".$row['seccion'].">".$row['nombre_seccion']."</option>";
								}
							?>
						</select>
					</div>
				</div>
				<div class="control-group">  
	                <label class="control-label">Sección Hasta:</label>
	                <div class="controls">
		                <select class="selectpicker" data-live-search="true" title="Seleccione una Sección" name='seccion_hasta' id='seccion_hasta' >
							<option value=0>Seleccione una Sección</option>
							<?php
								$pgsql = new Conexion();
								$sql = "SELECT seccion,nombre_seccion 
								FROM educacion.tseccion 
								ORDER BY seccion ASC";
								$query = $pgsql->Ejecutar($sql);
								while($row=$pgsql->Respuesta($query)){
									echo "<option value=".$row['seccion'].">".$row['nombre_seccion']."</option>";
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
		if($('#seccion_desde').val()==""){
			alert("¡Debe seleccionar una Sección Desde a listar!");
			send=false;
		}
		
		if($('#seccion_hasta').val()==""){
			alert("¡Debe seleccionar una Sección Hasta a listar!");
			send=false;
		}

		if(send==true)
			$('#form1').submit();
	})
}
</script>
<?php if(isset($_SESSION['datos'])) unset($_SESSION['datos']);?>