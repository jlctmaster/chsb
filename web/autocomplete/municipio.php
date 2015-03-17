<?php
require_once('../class/class_bd.php');
$conexion = new Conexion();
$sql = "SELECT codigo_municipio,m.descripcion AS municipio,m.descripcion||' ('||e.descripcion||', '||p.descripcion||')' AS descripcion 
		FROM general.tmunicipio m 
		INNER JOIN general.testado e ON m.codigo_estado = e.codigo_estado 
		INNER JOIN general.tpais p ON e.codigo_pais = p.codigo_pais 
   		WHERE m.descripcion||' ('||e.descripcion||', '||p.descripcion||')' LIKE '%".$_REQUEST['term']."%'";
$query = $conexion->Ejecutar($sql);
while($Obj=$conexion->Respuesta($query)){
	$rows[]=array(
		'label' => $Obj['descripcion'],
		'value' => $Obj['codigo_municipio'].'_'.$Obj['municipio']
		);
}
echo json_encode($rows);
?>