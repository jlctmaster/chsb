<?php
require_once('../class/class_bd.php');
$conexion = new Conexion();
$sql = "SELECT codigo_tema||'_'||descripcion AS tema 
		FROM  biblioteca.ttema 
		WHERE estatus = '1' AND codigo_tema||'_'||descripcion LIKE '%".$_REQUEST['term']."%'";
$query = $conexion->Ejecutar($sql);
while($Obj=$conexion->Respuesta($query)){
	$rows[]=array(
		'label' => $Obj['tema'],
		'value' => $Obj['tema']
		);
}
echo json_encode($rows);
?>