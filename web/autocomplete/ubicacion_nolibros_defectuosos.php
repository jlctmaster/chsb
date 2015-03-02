<?php
require_once('../class/class_bd.php');
$conexion = new Conexion();
$sql = "SELECT u.codigo_ubicacion,u.descripcion,u.descripcion||' ('||a.descripcion||')' AS ubicacion  
		FROM inventario.tubicacion u 
		INNER JOIN general.tambiente a ON u.codigo_ambiente = a.codigo_ambiente 
		WHERE u.estatus = '1' AND a.tipo_ambiente <> '5' AND u.itemsdefectuoso ='Y' 
		AND u.descripcion||' ('||a.descripcion||')' LIKE '%".$_REQUEST['term']."%'";
$query = $conexion->Ejecutar($sql);
while($Obj=$conexion->Respuesta($query)){
	$rows[]=array(
		'label' => $Obj['ubicacion'],
		'value' => $Obj['codigo_ubicacion'].'_'.$Obj['descripcion']
		);
}
echo json_encode($rows);
?>