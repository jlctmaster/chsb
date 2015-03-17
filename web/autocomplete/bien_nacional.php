<?php
require_once('../class/class_bd.php');
$conexion = new Conexion();
$sql = "SELECT codigo_bien AS codigo_item, nro_serial||' - '||nombre AS nombre_item 
		FROM bienes_nacionales.tbien  
   		WHERE estatus = '1' AND nro_serial||' - '||nombre LIKE '%".$_REQUEST['term']."%'";
$query = $conexion->Ejecutar($sql);
while($Obj=$conexion->Respuesta($query)){
	$rows[]=array(
		'label' => $Obj['nombre_item'],
		'value' => $Obj['codigo_item'].'_'.$Obj['nombre_item']
		);
}
echo json_encode($rows);
?>