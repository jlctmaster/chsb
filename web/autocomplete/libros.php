<?php
require_once('../class/class_bd.php');
$conexion = new Conexion();
$sql = "SELECT e.codigo_ejemplar AS codigo_item, e.codigo_cra||' - '||e.numero_edicion||' '||l.titulo AS nombre_item 
		FROM biblioteca.tejemplar e 
		INNER JOIN biblioteca.tlibro l ON e.codigo_isbn_libro = l.codigo_isbn_libro 
		WHERE e.estatus = '1' AND e.codigo_cra||' - '||e.numero_edicion||' '||l.titulo LIKE '%".$_REQUEST['term']."%'";
$query = $conexion->Ejecutar($sql);
while($Obj=$conexion->Respuesta($query)){
	$rows[]=array(
		'label' => $Obj['nombre_item'],
		'value' => $Obj['codigo_item'].'_'.$Obj['nombre_item']
		);
}
echo json_encode($rows);
?>