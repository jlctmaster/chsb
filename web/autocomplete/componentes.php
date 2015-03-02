<?php
require_once('../class/class_bd.php');
$conexion = new Conexion();
$sql = "SELECT b.codigo_bien AS codigo_item,b.nro_serial||' - '||b.nombre as nombre_item 
 		FROM bienes_nacionales.ttipo_bien tb
 		INNER JOIN bienes_nacionales.tbien b ON tb.codigo_tipo_bien= b.codigo_tipo_bien 
 		WHERE tb.descripcion NOT LIKE '%ITEM FINAL%' AND b.estatus = '1' 
 		AND b.nro_serial||' - '||b.nombre LIKE '%".$_REQUEST['term']."%'";
$query = $conexion->Ejecutar($sql);
while($Obj=$conexion->Respuesta($query)){
	$rows[]=array(
		'label' => $Obj['nombre_item'],
		'value' => $Obj['codigo_item'].'_'.$Obj['nombre_item']
		);
}
echo json_encode($rows);
?>