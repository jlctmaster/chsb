<?php
session_start();

//  Variables para indicar si hace la comprobación del registro

$comprobar=true;

if(isset($_POST['oldarea']))
  $oldarea=trim($_POST['oldarea']);

//  Fin

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_area']))
  $codigo_area=trim($_POST['codigo_area']);

if(isset($_POST['descripcion']))
  $descripcion=trim($_POST['descripcion']);

if(isset($_POST['codigo_departamento']))
  $codigo_departamento=trim($_POST['codigo_departamento']);

include_once("../class/class_area.php");
$area=new area();
if($lOpt=='Registrar'){
  $area->codigo_area($codigo_area);
  $area->descripcion($descripcion);
  $area->codigo_departamento($codigo_departamento);
  if(!$area->Comprobar($comprobar)){
    if($area->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($area->estatus()==1)
      $confirmacion=0;
    else{
    if($area->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Área ha sido registrada con éxito!";
    header("Location: ../view/menu_principal.php?area&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Área!";
    header("Location: ../view/menu_principal.php?area&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $area->codigo_area($codigo_area);
  $area->descripcion($descripcion);
  $area->codigo_departamento($codigo_departamento);
  if($oldarea==$area)
    $comprobar=false;
  if(!$area->Comprobar($comprobar)){
    if($area->Actualizar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Área ha sido modificada con éxito!";
    header("Location: ../view/menu_principal.php?area&Opt=3&codigo_area=".$area->codigo_area());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Área!";
    header("Location: ../view/menu_principal.php?area&Opt=3&codigo_area=".$area->codigo_area());
  }
}

if($lOpt=='Desactivar'){
  $area->codigo_area($codigo_area);
  if($area->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Área ha sido desactivada con éxito!";
    header("Location: ../view/menu_principal.php?area&Opt=3&codigo_area=".$area->codigo_area());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Área!";
    header("Location: ../view/menu_principal.php?area&Opt=3&codigo_area=".$area->codigo_area());
  }
}

if($lOpt=='Activar'){
  $area->codigo_area($codigo_area);
  if($area->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Área ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?area&Opt=3&codigo_area=".$area->codigo_area());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Área!";
    header("Location: ../view/menu_principal.php?area&Opt=3&codigo_area=".$area->codigo_area());
  }
}   
?>