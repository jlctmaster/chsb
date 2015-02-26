<fieldset>
	<legend><center>Reporte: LISTADO DE ESTUDIANTE SOLVENTES</center></legend>
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<form class="form-horizontal" action="../pdf/pdf_solvencia.php"  method="post" id="form1">
				<div class="control-group">  
	                <label class="control-label">Seleccione un Estudiante:</label>
	                <div class="controls">
		                <select class="selectpicker" data-live-search="true" title="Seleccione un estudiante" name='cedula_persona' id='cedula_persona' >
							<option value=0> Seleccione un Estudiante</option>
							<?php
								$pgsql = new Conexion();
								$sql = "SELECT p.cedula_persona,p.cedula_persona||' - '||p.primer_nombre||' '||p.primer_apellido AS nombre 
								FROM general.tpersona p 
								INNER JOIN general.ttipo_persona tp ON p.codigo_tipopersona = tp.codigo_tipopersona 
								WHERE tp.descripcion LIKE '%ESTUDIANTE%' AND 
								(NOT EXISTS(SELECT 1 FROM biblioteca.tprestamo pr WHERE p.cedula_persona = pr.cedula_persona) OR 
								EXISTS(SELECT 1 FROM biblioteca.tprestamo pr INNER JOIN biblioteca.tdetalle_prestamo dp ON dp.codigo_prestamo = pr.codigo_prestamo 
								WHERE pr.cedula_persona = p.cedula_persona AND EXISTS(SELECT 1 FROM biblioteca.tentrega e 
								INNER JOIN biblioteca.tdetalle_entrega de ON e.codigo_entrega = de.codigo_entrega 
								WHERE e.codigo_prestamo = pr.codigo_prestamo AND dp.codigo_ejemplar = de.codigo_ejemplar 
								HAVING SUM(de.cantidad) = dp.cantidad)))
								ORDER BY p.cedula_persona DESC";
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
			alert("¡Debe seleccionar un Estudiante para imprimir la Solvencia!");
			send=false;
		}
		
		if(send==true)
			$('#form1').submit();
	})
}
</script>
<?php if(isset($_SESSION['datos'])) unset($_SESSION['datos']);?>