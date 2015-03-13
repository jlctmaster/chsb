<?php
require_once('../class/class_bd.php');
$conexion = new Conexion();
$sql = "SELECT i.codigo_item,b.nro_serial||' - '|| b.nombre AS nombre_item
		FROM bienes_nacionales.tbien b 
		INNER JOIN inventario.vw_inventario i ON b.codigo_bien = i.codigo_item 
		WHERE i.sonlibros='N' AND b.estatus = '1' 
		AND b.nro_serial||' - '||b.nombre LIKE '%".$_REQUEST['term']."%' 
		GROUP BY i.codigo_item,b.nro_serial,b.nombre";
$query = $conexion->Ejecutar($sql);
while($Obj=$conexion->Respuesta($query)){
	$rows[]=array(
		'label' => $Obj['nombre_item'],
		'value' => $Obj['codigo_item'].'_'.$Obj['nombre_item']
		);
}
echo json_encode($rows);
?>