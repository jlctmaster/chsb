<?php
session_start();

include_once("../class/class_html.php");
$sql=$id=$descripcion=null;

$html=new Html();
if(isset($_POST['combo'])) {
    if($_POST['combo']=="seccion"){
        $id="codigo_materia";
        $descripcion="nombre_materia";
        $sql="SELECT m.codigo_materia, m.nombre_materia
        FROM educacion.tmateria m
        INNER JOIN educacion.tmateria_seccion AS tmats ON tmats.codigo_materia = m.codigo_materia
        INNER JOIN educacion.tseccion AS s ON s.seccion = tmats.seccion
        WHERE m.estatus='1' 
        AND s.seccion='".$_POST["elegido"]."' ORDER By m.nombre_materia";
        if(isset($_POST['elegido1'])) $Seleccionado=$_POST['elegido1']; else $Seleccionado='null';
    }
}
@$html->Generar_Opciones($sql,$id,$descripcion,$Seleccionado); 
?>