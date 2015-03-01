<?php
require_once('../class/class_bd.php');
$conexion = new Conexion();
$sql = "SELECT par.codigo_parroquia,par.descripcion AS parroquia,par.descripcion||' ('||m.descripcion||', '||e.descripcion||', '||p.descripcion||')' AS descripcion 
		FROM general.tparroquia par 
		INNER JOIN general.tmunicipio m ON par.codigo_municipio=m.codigo_municipio 
		INNER JOIN general.testado e ON m.codigo_estado = e.codigo_estado 
		INNER JOIN general.tpais p ON e.codigo_pais = p.codigo_pais 
   		WHERE par.descripcion||' ('||m.descripcion||', '||e.descripcion||', '||p.descripcion||')' LIKE '%".$_REQUEST['term']."%'";
$query = $conexion->Ejecutar($sql);
while($Obj=$conexion->Respuesta($query)){
	$rows[]=array(
		'label' => $Obj['descripcion'],
		'value' => $Obj['codigo_parroquia'].'_'.$Obj['parroquia']
		);
}
echo json_encode($rows);
?>