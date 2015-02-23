<?php
if(!isset($_GET['Opt'])){ // Ventana principal -> Paginación
	require_once('../class/class_bd.php'); 
	$pgsql=new Conexion();
	$sql = "SELECT item,ubicacion,existencia   
	FROM inventario.vw_inventario 
	WHERE sonlibros='Y' AND existencia <> 0 
	ORDER BY ubicacion,item ASC ";
	$consulta = $pgsql->Ejecutar($sql);
?>
<fieldset>
	<legend><center>Vista: INVENTARIO</center></legend>		
	<div id="paginador" class="enjoy-css">
		<div class="container">
			<table cellpadding="0" cellspacing="5" border="0" class="bordered-table zebra-striped" id="registro">
				<thead>
					<tr>
						<th>Ubicación:</th>
						<th>Item:</th>
						<th>Existencia:</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ($filas = $pgsql->Respuesta($consulta))
					{
						echo '<tr>';
						echo '<td>'.$filas['ubicacion'].'</td>';
						echo '<td>'.$filas['item'].'</td>';
						echo '<td>'.$filas['existencia'].'</td>';
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