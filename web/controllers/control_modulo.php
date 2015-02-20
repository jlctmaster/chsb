<?php
session_start();

//  Variables para indicar si hace la comprobación del registro

$comprobar=true;

if(isset($_POST['oldmodulo']))
  $oldmodulo=trim($_POST['oldmodulo']);

//  Fin

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_modulo']))
  $codigo_modulo=trim($_POST['codigo_modulo']);

if(isset($_POST['nombre_modulo']))
  $nombre_modulo=trim($_POST['nombre_modulo']);

if(isset($_POST['icono']))
  $icono=trim($_POST['icono']);

if(isset($_POST['orden']))
  $orden=trim($_POST['orden']);

include_once("../class/class_modulo.php");
$modulo=new modulo();
if($lOpt=='Registrar'){
  $modulo->codigo_modulo($codigo_modulo);
  $modulo->nombre_modulo($nombre_modulo);
  $modulo->icono($icono);
  $modulo->orden($orden);
  if(!$modulo->Comprobar($comprobar)){
    if($modulo->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($modulo->estatus()==1)
      $confirmacion=0;
    else{
    if($modulo->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Módulo ha sido registrado con exito!";
    header("Location: ../view/menu_principal.php?modulo&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Módulo!";
    header("Location: ../view/menu_principal.php?modulo&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $modulo->codigo_modulo($codigo_modulo);
  $modulo->nombre_modulo($nombre_modulo);
  $modulo->icono($icono);
  $modulo->orden($orden);
  if($oldmodulo==$nombre_modulo)
    $comprobar=false;
  if(!$modulo->Comprobar($comprobar)){
    if($modulo->Actualizar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Módulo ha sido modificado con exito!";
    header("Location: ../view/menu_principal.php?modulo&Opt=3&codigo_modulo=".$modulo->codigo_modulo());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Módulo!";
    header("Location: ../view/menu_principal.php?modulo&Opt=3&codigo_modulo=".$modulo->codigo_modulo());
  }
}

if($lOpt=='Desactivar'){
  $modulo->codigo_modulo($codigo_modulo);
  if($modulo->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Módulo ha sido desactivado con exito!";
    header("Location: ../view/menu_principal.php?modulo&Opt=3&codigo_modulo=".$modulo->codigo_modulo());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Módulo!";
    header("Location: ../view/menu_principal.php?modulo&Opt=3&codigo_modulo=".$modulo->codigo_modulo());
  }
}

if($lOpt=='Activar'){
  $modulo->codigo_modulo($codigo_modulo);
  if($modulo->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Módulo ha sido activado con exito!";
    header("Location: ../view/menu_principal.php?modulo&Opt=3&codigo_modulo=".$modulo->codigo_modulo());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Módulo!";
    header("Location: ../view/menu_principal.php?modulo&Opt=3&codigo_modulo=".$modulo->codigo_modulo());
  }
}   
?>