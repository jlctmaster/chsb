<?php
require_once('../class/class_bd.php');
$conexion = new Conexion();
$sql = "SELECT TRIM(p.cedula_persona) AS cedula_persona,CASE WHEN p.segundo_nombre IS NOT NULL AND p.segundo_apellido IS NOT NULL THEN INITCAP(p.primer_nombre||' '||p.segundo_nombre||' '||p.primer_apellido||' '||p.segundo_apellido) 
	    WHEN p.segundo_nombre IS NOT NULL AND p.segundo_apellido IS NULL THEN INITCAP(p.primer_nombre||' '||p.segundo_nombre||' '||p.primer_apellido) 
	    WHEN p.segundo_nombre IS NULL AND p.segundo_apellido IS NOT NULL THEN INITCAP(p.primer_nombre||' '||p.primer_apellido||' '||p.segundo_apellido) 
	    ELSE INITCAP(p.primer_nombre||' '||p.primer_apellido) END AS nombre 
	    FROM general.tpersona p 
	    INNER JOIN general.ttipo_persona tp ON p.codigo_tipopersona = tp.codigo_tipopersona 
   		WHERE tp.es_usuariosistema = 'Y' 
   		AND (p.cedula_persona LIKE '%".$_REQUEST['term']."%' OR p.primer_nombre LIKE '%".$_REQUEST['term']."%' OR p.segundo_nombre LIKE '%".$_REQUEST['term']."%' 
   		OR p.primer_apellido LIKE '%".$_REQUEST['term']."%' OR p.segundo_apellido LIKE '%".$_REQUEST['term']."%')";
$query = $conexion->Ejecutar($sql);
while($Obj=$conexion->Respuesta($query)){
	$rows[]=array(
		'label' => $Obj['cedula_persona'].'_'.$Obj['nombre'],
		'value' => $Obj['cedula_persona'].'_'.$Obj['nombre']
		);
}
echo json_encode($rows);
?>