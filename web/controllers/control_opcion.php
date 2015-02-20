<?php
session_start();

//  Variables para indicar si hace la comprobación del registro

$comprobar=true;

if(isset($_POST['oldopcion']))
  $oldopcion=trim($_POST['oldopcion']);

//  Fin

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_opcion']))
  $codigo_opcion=trim($_POST['codigo_opcion']);

if(isset($_POST['nombre_opcion']))
  $nombre_opcion=trim($_POST['nombre_opcion']);

if(isset($_POST['accion']))
  $accion=trim($_POST['accion']);

if(isset($_POST['orden']))
  $orden=trim($_POST['orden']);

if(isset($_POST['icono']))
  $icono=trim($_POST['icono']);

include_once("../class/class_opcion.php");
$opcion=new opcion();
if($lOpt=='Registrar'){
  $opcion->codigo_opcion($codigo_opcion);
  $opcion->nombre_opcion($nombre_opcion);
  $opcion->accion($accion);
  $opcion->orden($orden);
  $opcion->icono($icono);
  if(!$opcion->Comprobar($comprobar)){
    if($opcion->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($opcion->estatus()==1)
      $confirmacion=0;
    else{
    if($opcion->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Botón ha sido registrado con exito!";
    header("Location: ../view/menu_principal.php?botones&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Botón!";
    header("Location: ../view/menu_principal.php?botones&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $opcion->codigo_opcion($codigo_opcion);
  $opcion->nombre_opcion($nombre_opcion);
  $opcion->accion($accion);
  $opcion->orden($orden);
  $opcion->icono($icono);
  if($oldopcion==$nombre_opcion)
    $comprobar=false;
  if(!$opcion->Comprobar($comprobar)){
    if($opcion->Actualizar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else
    $confirmacion=-1; 
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Botón ha sido modificado con exito!";
    header("Location: ../view/menu_principal.php?botones&Opt=3&codigo_opcion=".$opcion->codigo_opcion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Botón!";
    header("Location: ../view/menu_principal.php?botones&Opt=3&codigo_opcion=".$opcion->codigo_opcion());
  }
}

if($lOpt=='Desactivar'){
  $opcion->codigo_opcion($codigo_opcion);
  if($opcion->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Botón ha sido desactivado con exito!";
    header("Location: ../view/menu_principal.php?botones&Opt=3&codigo_opcion=".$opcion->codigo_opcion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Botón!";
    header("Location: ../view/menu_principal.php?botones&Opt=3&codigo_opcion=".$opcion->codigo_opcion());
  }
}

if($lOpt=='Activar'){
  $opcion->codigo_opcion($codigo_opcion);
  if($opcion->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Botón ha sido activado con exito!";
    header("Location: ../view/menu_principal.php?botones&Opt=3&codigo_opcion=".$opcion->codigo_opcion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Botón!";
    header("Location: ../view/menu_principal.php?botones&Opt=3&codigo_opcion=".$opcion->codigo_opcion());
  }
}   
?>