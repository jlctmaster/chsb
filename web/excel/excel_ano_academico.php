<?php
require_once("../class/class_bd.php");

$tbHtml = "<table>
             <header>
                <tr>
                  <th>C&oacute;digo</th>
                  <th>A&ntilde;o Acad&eacute;mico</th>
                  <th>Creado por</th>
                  <th>Fecha de creacion</th>
                  <th>Modificado por</th>
                  <th>Fecha de modificacion</th>
                  <th>Estatus</th>
                </tr>
            </header>";

$mysql = new Conexion();
$sql = "SELECT * FROM educacion.tano_academico ORDER BY codigo_ano_academico DESC";
$query = $mysql->Ejecutar($sql);
while ($row = $mysql->Respuesta($query)){
	$tbHtml .= "<tr><td>".$row['codigo_ano_academico']."</td><td>".$row['ano']."</td><td>".$row['creado_por']."</td><td>".$row['fecha_creacion']."</td><td>".$row['fecha_modificacion']."</td><td>".$row['fecha_modificacion']."</td><td>".$row['estatus']."</td></tr>";
}

$tbHtml .= "</table>";
 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=ano_academicos.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo $tbHtml;
 
?>
