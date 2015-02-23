<?php

session_start();

if($_POST['combo']=="codigo_ambiente"){
	include_once("../class/class_horario.php");
	$horario=new horario();
	echo $horario->Resultado_Json_de_Consulta($_POST['codigo_ambiente'],$_POST['codigo_ano_academico']);
}
if($_POST['combo']=="seccion"){
	include_once("../class/class_horario.php");
	$horario=new horario();
	echo $horario->Resultado_Json_de_Consulta_Seccion($_POST['codigo_ambiente'],$_POST['seccion'],$_POST['codigo_ano_academico']);
}
if($_POST['combo']=="profesor"){
	include_once("../class/class_horario.php");
	$horario=new horario();
	echo $horario->Resultado_Json_de_Consulta_Validar_Profesor($_POST['celda'],$_POST['codigo_ano_academico'],$_POST['profesor']);
}
if($_POST['combo']=="horas"){
	include_once("../class/class_horario.php");
	$horario=new horario();
	echo $horario->Resultado_Json_de_Consulta_Horas_Maximas($_POST['codigo_ano_academico'],$_POST['profesor']);
}
?>
