<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_municipio']))
  $codigo_municipio=trim($_POST['codigo_municipio']);

if(isset($_POST['descripcion']))
  $descripcion=trim($_POST['descripcion']);

if(isset($_POST['codigo_estado']))
  $codigo_estado=trim($_POST['codigo_estado']);

include_once("../class/class_municipio.php");
$municipio=new municipio();
if($lOpt=='Registrar'){
  $municipio->codigo_municipio($codigo_municipio);
  $municipio->descripcion($descripcion);
  $municipio->codigo_estado($codigo_estado);
  if(!$municipio->Comprobar()){
    if($municipio->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($municipio->estatus()==1)
      $confirmacion=0;
    else{
    if($municipio->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Municipio ha sido registrado con exito!";
    header("Location: ../view/menu_principal.php?municipio&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Municipio!";
    header("Location: ../view/menu_principal.php?municipio&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $municipio->codigo_municipio($codigo_municipio);
  $municipio->descripcion($descripcion);
  $municipio->codigo_estado($codigo_estado);
  if($municipio->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Municipio ha sido modificado con exito!";
    header("Location: ../view/menu_principal.php?municipio&Opt=3&codigo_municipio=".$municipio->codigo_municipio());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Municipio!";
    header("Location: ../view/menu_principal.php?municipio&Opt=3&codigo_municipio=".$municipio->codigo_municipio());
  }
}

if($lOpt=='Desactivar'){
  $municipio->codigo_municipio($codigo_municipio);
  if($municipio->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Municipio ha sido desactivado con exito!";
    header("Location: ../view/menu_principal.php?municipio&Opt=3&codigo_municipio=".$municipio->codigo_municipio());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Municipio!";
    header("Location: ../view/menu_principal.php?municipio&Opt=3&codigo_municipio=".$municipio->codigo_municipio());
  }
}

if($lOpt=='Activar'){
  $municipio->codigo_municipio($codigo_municipio);
  if($municipio->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Municipio ha sido activado con exito!";
    header("Location: ../view/menu_principal.php?municipio&Opt=3&codigo_municipio=".$municipio->codigo_municipio());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Municipio!";
    header("Location: ../view/menu_principal.php?municipio&Opt=3&codigo_municipio=".$municipio->codigo_municipio());
  }
}   
?>