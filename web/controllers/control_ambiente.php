<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_ambiente']))
  $codigo_ambiente=trim($_POST['codigo_ambiente']);

if(isset($_POST['descripcion']))
  $descripcion=trim($_POST['descripcion']);

if(isset($_POST['tipo_ambiente']))
  $tipo_ambiente=trim($_POST['tipo_ambiente']);

include_once("../class/class_ambiente.php");
$ambiente=new ambiente();
if($lOpt=='Registrar'){
  $ambiente->codigo_ambiente($codigo_ambiente);
  $ambiente->descripcion($descripcion);
  $ambiente->tipo_ambiente($tipo_ambiente);
  if(!$ambiente->Comprobar()){
    if($ambiente->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($ambiente->estatus()==1)
      $confirmacion=0;
    else{
    if($ambiente->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Ambiente ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?ambiente&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Ambiente!";
    header("Location: ../view/menu_principal.php?ambiente&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $ambiente->codigo_ambiente($codigo_ambiente);
  $ambiente->descripcion($descripcion);
  $ambiente->tipo_ambiente($tipo_ambiente);
  if($ambiente->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Ambiente ha sido modificado con éxito!";
    header("Location: ../view/menu_principal.php?ambiente&Opt=3&codigo_ambiente=".$ambiente->codigo_ambiente());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Ambiente!";
    header("Location: ../view/menu_principal.php?ambiente&Opt=3&codigo_ambiente=".$ambiente->codigo_ambiente());
  }
}

if($lOpt=='Desactivar'){
  $ambiente->codigo_ambiente($codigo_ambiente);
  if($ambiente->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Ambiente ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?ambiente&Opt=3&codigo_ambiente=".$ambiente->codigo_ambiente());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Ambiente!";
    header("Location: ../view/menu_principal.php?ambiente&Opt=3&codigo_ambiente=".$ambiente->codigo_ambiente());
  }
}

if($lOpt=='Activar'){
  $ambiente->codigo_ambiente($codigo_ambiente);
  if($ambiente->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Ambiente ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?ambiente&Opt=3&codigo_ambiente=".$ambiente->codigo_ambiente());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Ambiente!";
    header("Location: ../view/menu_principal.php?ambiente&Opt=3&codigo_ambiente=".$ambiente->codigo_ambiente());
  }
}   
?>