<?php
require_once('../class/class_bd.php');
$conexion = new Conexion();
$sql = "SELECT codigo_isbn_libro||' - '||titulo AS nombre_item 
		FROM  biblioteca.tlibro 
		WHERE estatus = '1' AND codigo_isbn_libro||' - '||titulo LIKE '%".$_REQUEST['term']."%'";
$query = $conexion->Ejecutar($sql);
while($Obj=$conexion->Respuesta($query)){
	$rows[]=array(
		'label' => $Obj['nombre_item'],
		'value' => $Obj['nombre_item']
		);
}
echo json_encode($rows);
?>