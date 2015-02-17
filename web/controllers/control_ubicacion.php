<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_ubicacion']))
  $codigo_ubicacion=trim($_POST['codigo_ubicacion']);

if(isset($_POST['descripcion']))
  $descripcion=trim($_POST['descripcion']);

if(isset($_POST['codigo_ambiente']))
  $codigo_ambiente=trim($_POST['codigo_ambiente']);

if(isset($_POST['ubicacionprincipal']))
  $ubicacionprincipal=trim($_POST['ubicacionprincipal']);

if(isset($_POST['itemsdefectuoso']))
  $itemsdefectuoso=trim($_POST['itemsdefectuoso']);

function comprobarCheckBox($value){
  if($value == "on")
    $chk = "Y";
  else
    $chk = "N";
  return $chk;
}

include_once("../class/class_ubicacion.php");
$ubicacion=new ubicacion();
if($lOpt=='Registrar'){
  $ubicacion->codigo_ubicacion($codigo_ubicacion);
  $ubicacion->descripcion($descripcion);
  $ubicacion->codigo_ambiente($codigo_ambiente);
  $ubicacion->ubicacionprincipal(comprobarCheckBox($ubicacionprincipal));
  $ubicacion->itemsdefectuoso(comprobarCheckBox($itemsdefectuoso));
  if(!$ubicacion->Comprobar()){
    if($ubicacion->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($ubicacion->estatus()==1)
      $confirmacion=0;
    else{
    if($ubicacion->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Ubicación ha sido registrada con éxito!";
    header("Location: ../view/menu_principal.php?ubicacion&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar la Ubicación!";
    header("Location: ../view/menu_principal.php?ubicacion&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $ubicacion->codigo_ubicacion($codigo_ubicacion);
  $ubicacion->descripcion($descripcion);
  $ubicacion->codigo_ambiente($codigo_ambiente);
  $ubicacion->ubicacionprincipal(comprobarCheckBox($ubicacionprincipal));
  $ubicacion->itemsdefectuoso(comprobarCheckBox($itemsdefectuoso));
  if(!$ubicacion->Comprobar()){
    if($ubicacion->Actualizar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Ubicación ha sido modificada con éxito!";
    header("Location: ../view/menu_principal.php?ubicacion&Opt=3&codigo_ubicacion=".$ubicacion->codigo_ubicacion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar la Ubicación!";
    header("Location: ../view/menu_principal.php?ubicacion&Opt=3&codigo_ubicacion=".$ubicacion->codigo_ubicacion());
  }
}

if($lOpt=='Desactivar'){
  $ubicacion->codigo_ubicacion($codigo_ubicacion);
  if($ubicacion->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Ubicación ha sido desactivada con éxito!";
    header("Location: ../view/menu_principal.php?ubicacion&Opt=3&codigo_ubicacion=".$ubicacion->codigo_ubicacion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar la Ubicación!";
    header("Location: ../view/menu_principal.php?ubicacion&Opt=3&codigo_ubicacion=".$ubicacion->codigo_ubicacion());
  }
}

if($lOpt=='Activar'){
  $ubicacion->codigo_ubicacion($codigo_ubicacion);
  if($ubicacion->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Ubicación ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?ubicacion&Opt=3&codigo_ubicacion=".$ubicacion->codigo_ubicacion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar la Ubicación!";
    header("Location: ../view/menu_principal.php?ubicacion&Opt=3&codigo_ubicacion=".$ubicacion->codigo_ubicacion());
  }
}   
?>