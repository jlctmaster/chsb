<?php
require_once('../class/class_bd.php');
$conexion = new Conexion();
$sql = "SELECT i.codigo_ubicacion,u.descripcion,u.descripcion||' ('||a.descripcion||')' AS ubicacion  
		FROM inventario.tubicacion u 
		INNER JOIN general.tambiente a ON u.codigo_ambiente = a.codigo_ambiente 
		INNER JOIN inventario.vw_inventario i ON u.codigo_ubicacion = i.codigo_ubicacion 
		WHERE u.estatus = '1' AND a.tipo_ambiente <> '5' AND u.itemsdefectuoso ='N' 
		AND u.descripcion||' ('||a.descripcion||')' LIKE '%".$_REQUEST['term']."%' 
		GROUP BY i.codigo_ubicacion,u.descripcion,a.descripcion";
$query = $conexion->Ejecutar($sql);
while($Obj=$conexion->Respuesta($query)){
	$rows[]=array(
		'label' => $Obj['ubicacion'],
		'value' => $Obj['codigo_ubicacion'].'_'.$Obj['descripcion']
		);
}
echo json_encode($rows);
?>