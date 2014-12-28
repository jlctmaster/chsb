<?php
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT codigo_movimiento,nro_documento,TO_CHAR(fecha_movimiento,'DD/MM/YYYY') AS fecha_movimiento,
	descrip_tipo_movimiento as tipo,item,ubicacion,cantidad_movimiento  
	FROM inventario.vw_movimiento_inventario  
	ORDER BY fecha_movimiento ASC";
	$consulta = $pgsql->Ejecutar($sql);
?>
<fieldset>
	<legend><center>Vista: MOVIMIENTO DE INVENTARIO</center></legend>		
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
				<thead>
					<tr>
						<th>Código:</th>
						<th>Nro. Documento:</th>
						<th>Fecha:</th>
						<th>Tipo:</th>
						<th>Item:</th>
						<th>Ubicación:</th>
						<th>Cantidad:</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ($filas = $pgsql->Respuesta($consulta))
					{
						echo '<tr>';
						echo '<td>'.$filas['codigo_movimiento'].'</td>';
						echo '<td>'.$filas['nro_documento'].'</td>';
						echo '<td>'.$filas['fecha_movimiento'].'</td>';
						echo '<td>'.$filas['tipo'].'</td>';
						echo '<td>'.$filas['item'].'</td>';
						echo '<td>'.$filas['ubicacion'].'</td>';
						echo '<td>'.$filas['cantidad_movimiento'].'</td>';
						echo "</tr>";
					}
					?>
				<tbody>
			</table>
		</div>
	</div>
</fieldset>
<?php
} // Fin Ventana Principal
?>