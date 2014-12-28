<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_estado']))
  $codigo_estado=trim($_POST['codigo_estado']);

if(isset($_POST['descripcion']))
  $descripcion=trim($_POST['descripcion']);

if(isset($_POST['codigo_pais']))
  $codigo_pais=trim($_POST['codigo_pais']);

include_once("../class/class_estado.php");
$estado=new estado();
if($lOpt=='Registrar'){
  $estado->codigo_estado($codigo_estado);
  $estado->descripcion($descripcion);
  $estado->codigo_pais($codigo_pais);
  if(!$estado->Comprobar()){
    if($estado->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($estado->estatus()==1)
      $confirmacion=0;
    else{
    if($estado->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Estado ha sido registrado con exito!";
    header("Location: ../view/menu_principal.php?estado&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Estado!";
    header("Location: ../view/menu_principal.php?estado&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $estado->codigo_estado($codigo_estado);
  $estado->descripcion($descripcion);
  $estado->codigo_pais($codigo_pais);
  if($estado->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Estado ha sido modificado con exito!";
    header("Location: ../view/menu_principal.php?estado&Opt=3&codigo_estado=".$estado->codigo_estado());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Estado!";
    header("Location: ../view/menu_principal.php?estado&Opt=3&codigo_estado=".$estado->codigo_estado());
  }
}

if($lOpt=='Desactivar'){
  $estado->codigo_estado($codigo_estado);
  if($estado->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Estado ha sido desactivado con exito!";
    header("Location: ../view/menu_principal.php?estado&Opt=3&codigo_estado=".$estado->codigo_estado());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Estado!";
    header("Location: ../view/menu_principal.php?estado&Opt=3&codigo_estado=".$estado->codigo_estado());
  }
}

if($lOpt=='Activar'){
  $estado->codigo_estado($codigo_estado);
  if($estado->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Estado ha sido activado con exito!";
    header("Location: ../view/menu_principal.php?estado&Opt=3&codigo_estado=".$estado->codigo_estado());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Estado!";
    header("Location: ../view/menu_principal.php?estado&Opt=3&codigo_estado=".$estado->codigo_estado());
  }
}   
?>