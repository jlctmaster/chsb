<?php
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT codigo_auditoria,usuario_aplicacion,usuario_db,nombre_esquema,nombre_tabla,
	proceso,identificador_tabla,valor_nuevo,valor_anterior,TO_CHAR(fecha_operacion,'DD/MM/YYYY HH:MM') AS fecha_operacion 
	FROM seguridad.tauditoria 
	WHERE nombre_esquema <> 'seguridad'
	ORDER BY codigo_auditoria DESC";
	$consulta = $pgsql->Ejecutar($sql);
?>
	<fieldset>
		<legend><center>Vista: BITACORA TRANSACIONAL</center></legend>		
		<div id="paginador" class="enjoy-css">
			<div id="bitacora" class="container">
				<div class="scrollBitacora">
					<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
						<thead>
							<tr>
								<th>Código:</th>
								<th>Usuario App.:</th>
								<th>Usuario BD:</th>
								<th>Esquema:</th>
								<th>Entidad:</th>
								<th>Proceso:</th>
								<th>ID Entidad:</th>
								<th>Valor Nuevo:</th>
								<th>Valor Anterior:</th>
								<th>Fecha Op.:</th>
							</tr>
						</thead>
						<tbody>
							<?php
							while ($filas = $pgsql->Respuesta($consulta))
							{
								echo '<tr>';
								echo '<td>'.$filas['codigo_auditoria'].'</td>';
								echo '<td>'.$filas['usuario_aplicacion'].'</td>';
								echo '<td>'.$filas['usuario_db'].'</td>';
								echo '<td>'.$filas['nombre_esquema'].'</td>';
								echo '<td>'.$filas['nombre_tabla'].'</td>';
								echo '<td>'.$filas['proceso'].'</td>';
								echo '<td>'.$filas['identificador_tabla'].'</td>';
								echo '<td>'.$filas['valor_nuevo'].'</td>';
								echo '<td>'.$filas['valor_anterior'].'</td>';
								echo '<td>'.$filas['fecha_operacion'].'</td>';
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</fieldset>
		<?php
} // Fin Ventana Principal
?>