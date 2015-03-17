<?php
require_once('../class/class_bd.php');
$conexion = new Conexion();
$sql = "SELECT codigo_editorial||'_'||nombre AS editorial 
		FROM  biblioteca.teditorial 
		WHERE estatus = '1' AND codigo_editorial||'_'||nombre LIKE '%".$_REQUEST['term']."%'";
$query = $conexion->Ejecutar($sql);
while($Obj=$conexion->Respuesta($query)){
	$rows[]=array(
		'label' => $Obj['editorial'],
		'value' => $Obj['editorial']
		);
}
echo json_encode($rows);
?>