<?php
session_start();
if(isset($_POST['lOpt']))
$lOpt=trim($_POST['lOpt']);

include_once("../class/class_usuario.php");
$usuario = new Usuario();
$confirmacion=0;
if($lOpt=='DesbloquearUsuario'){
	if(isset($_POST['bloqueados'])){               
	  foreach($_POST['bloqueados'] as $indice => $valor){
	    $usuario->nombre_usuario($valor);
	    if($usuario->DesbloquearUsuario($_SESSION['user_name']))
	    	$confirmacion++;
	    else
	    	$confirmacion=0;
	  }                                                        
	}
	if($confirmacion!=0){
		$_SESSION['datos']['mensaje']="¡Se han desbloqueado los usuarios correctamente!";
		header("Location: ../view/menu_principal.php?desbloquearusuario");
	}else{
		$_SESSION['datos']['mensaje']="¡Ocurrió un error al desbloquear los usuarios!";
		header("Location: ../view/menu_principal.php?desbloquearusuario");
	}
}
?>