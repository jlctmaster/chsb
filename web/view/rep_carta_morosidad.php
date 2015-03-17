<fieldset>
	<legend><center>Reporte: CARTA DE MOROSIDAD POR ESTUDIANTES</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<form class="form-horizontal" action="../pdf/pdf_carta_morosidad.php"  method="post" id="form1">
				<div class="control-group">  
	                <label class="control-label">Seleccione una Persona:</label>
	                <div class="controls">
		                <select class="bootstrap-select form-control" title="Seleccione una persona" name='cedula_persona' id='cedula_persona' >
							<option value=0> Seleccione una Persona</option>
							<?php
								$pgsql = new Conexion();
								$sql = "SELECT p.cedula_persona,p.cedula_persona||' - '||p.primer_nombre||' '||p.primer_apellido AS nombre
								FROM  biblioteca.tprestamo b 
								INNER JOIN biblioteca.tdetalle_prestamo da ON b.codigo_prestamo = da.codigo_prestamo 
								INNER JOIN general.tpersona p ON b.cedula_persona = p.cedula_persona 
								WHERE b.fecha_entrada < NOW() AND (NOT EXISTS(SELECT 1 FROM biblioteca.tentrega e WHERE b.codigo_prestamo = e.codigo_prestamo) OR 
								EXISTS(SELECT 1 FROM biblioteca.tentrega e INNER JOIN biblioteca.tdetalle_entrega de ON e.codigo_entrega = de.codigo_entrega 
								WHERE e.codigo_prestamo = b.codigo_prestamo AND da.codigo_ejemplar = de.codigo_ejemplar 
								HAVING SUM(de.cantidad) < da.cantidad))";
								$query = $pgsql->Ejecutar($sql);
								while($row=$pgsql->Respuesta($query)){
									echo "<option value=".$row['cedula_persona'].">".$row['nombre']."</option>";
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
		if($('#cedula_persona').val()==""){
			alert("¡Debe seleccionar un estudiante para imprimir la Carta de Morosidad!");
			send=false;
		}

		if(send==true)
			$('#form1').submit();
	})
}
</script>