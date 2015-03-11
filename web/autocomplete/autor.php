<?php
require_once('../class/class_bd.php');
$conexion = new Conexion();
$sql = "SELECT codigo_autor||' - '||nombre AS autor 
		FROM  biblioteca.tautor 
		WHERE estatus = '1' AND codigo_autor||' - '||nombre LIKE '%".$_REQUEST['term']."%'";
$query = $conexion->Ejecutar($sql);
while($Obj=$conexion->Respuesta($query)){
	$rows[]=array(
		'label' => $Obj['autor'],
		'value' => $Obj['autor']
		);
}
echo json_encode($rows);
?>