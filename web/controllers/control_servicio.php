<?php
session_start();

//  Variables para indicar si hace la comprobación del registro

$comprobar=true;

if(isset($_POST['oldservicio']))
  $oldservicio=trim($_POST['oldservicio']);

//  Fin

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_servicio']))
  $codigo_servicio=trim($_POST['codigo_servicio']);

if(isset($_POST['nombre_servicio']))
  $nombre_servicio=trim($_POST['nombre_servicio']);

if(isset($_POST['url']))
  $url=trim($_POST['url']);

if(isset($_POST['orden']))
  $orden=trim($_POST['orden']);

if(isset($_POST['codigo_modulo']))
  $codigo_modulo=trim($_POST['codigo_modulo']);

include_once("../class/class_servicio.php");
$servicio=new servicio();
if($lOpt=='Registrar'){
  $servicio->codigo_servicio($codigo_servicio);
  $servicio->nombre_servicio($nombre_servicio);
  $servicio->url($url);
  $servicio->orden($orden);
  $servicio->codigo_modulo($codigo_modulo);
  if(!$servicio->Comprobar($comprobar)){
    if($servicio->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($servicio->estatus()==1)
      $confirmacion=0;
    else{
    if($servicio->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Servicio ha sido registrado con exito!";
    header("Location: ../view/menu_principal.php?servicio&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Servicio!";
    header("Location: ../view/menu_principal.php?servicio&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $servicio->codigo_servicio($codigo_servicio);
  $servicio->nombre_servicio($nombre_servicio);
  $servicio->url($url);
  $servicio->orden($orden);
  $servicio->codigo_modulo($codigo_modulo);
  if($oldservicio==$nombre_servicio)
    $comprobar=false;
  if(!$servicio->Comprobar($comprobar)){
    if($servicio->Actualizar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Servicio ha sido modificado con exito!";
    header("Location: ../view/menu_principal.php?servicio&Opt=3&codigo_servicio=".$servicio->codigo_servicio());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Servicio!";
    header("Location: ../view/menu_principal.php?servicio&Opt=3&codigo_servicio=".$servicio->codigo_servicio());
  }
}

if($lOpt=='Desactivar'){
  $servicio->codigo_servicio($codigo_servicio);
  if($servicio->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Servicio ha sido desactivado con exito!";
    header("Location: ../view/menu_principal.php?servicio&Opt=3&codigo_servicio=".$servicio->codigo_servicio());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Servicio!";
    header("Location: ../view/menu_principal.php?servicio&Opt=3&codigo_servicio=".$servicio->codigo_servicio());
  }
}

if($lOpt=='Activar'){
  $servicio->codigo_servicio($codigo_servicio);
  if($servicio->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Servicio ha sido activado con exito!";
    header("Location: ../view/menu_principal.php?servicio&Opt=3&codigo_servicio=".$servicio->codigo_servicio());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Servicio!";
    header("Location: ../view/menu_principal.php?servicio&Opt=3&codigo_servicio=".$servicio->codigo_servicio());
  }
}   
?>