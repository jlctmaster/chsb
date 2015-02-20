<?php
session_start();

//  Variables para indicar si hace la comprobación del registro

$comprobar=true;

if(isset($_POST['olddescripcion']))
  $olddescripcion=trim($_POST['olddescripcion']);

//  Fin

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_parroquia']))
  $codigo_parroquia=trim($_POST['codigo_parroquia']);

if(isset($_POST['descripcion']))
  $descripcion=trim($_POST['descripcion']);

if(isset($_POST['codigo_municipio']))
  $codigo_municipio=trim($_POST['codigo_municipio']);

include_once("../class/class_parroquia.php");
$parroquia=new parroquia();
if($lOpt=='Registrar'){
  $parroquia->codigo_parroquia($codigo_parroquia);
  $parroquia->descripcion($descripcion);
  $parroquia->codigo_municipio($codigo_municipio);
  if(!$parroquia->Comprobar($comprobar)){
    if($parroquia->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($parroquia->estatus()==1)
      $confirmacion=0;
    else{
    if($parroquia->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Parroquia ha sido registrada con éxito!";
    header("Location: ../view/menu_principal.php?parroquia&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar la Parroquia!";
    header("Location: ../view/menu_principal.php?parroquia&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $parroquia->codigo_parroquia($codigo_parroquia);
  $parroquia->descripcion($descripcion);
  $parroquia->codigo_municipio($codigo_municipio);
  if($olddescripcion==$descripcion)
    $comprobar=false;
  if(!$parroquia->Comprobar($comprobar)){
    if($parroquia->Actualizar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Parroquia ha sido modificada con éxito!";
    header("Location: ../view/menu_principal.php?parroquia&Opt=3&codigo_parroquia=".$parroquia->codigo_parroquia());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar la Parroquia!";
    header("Location: ../view/menu_principal.php?parroquia&Opt=3&codigo_parroquia=".$parroquia->codigo_parroquia());
  }
}

if($lOpt=='Desactivar'){
  $parroquia->codigo_parroquia($codigo_parroquia);
  if($parroquia->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Parroquia ha sido desactivada con éxito!";
    header("Location: ../view/menu_principal.php?parroquia&Opt=3&codigo_parroquia=".$parroquia->codigo_parroquia());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar la Parroquia!";
    header("Location: ../view/menu_principal.php?parroquia&Opt=3&codigo_parroquia=".$parroquia->codigo_parroquia());
  }
}

if($lOpt=='Activar'){
  $parroquia->codigo_parroquia($codigo_parroquia);
  if($parroquia->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Parroquia ha sido activada con éxito!";
    header("Location: ../view/menu_principal.php?parroquia&Opt=3&codigo_parroquia=".$parroquia->codigo_parroquia());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar la Parroquia!";
    header("Location: ../view/menu_principal.php?parroquia&Opt=3&codigo_parroquia=".$parroquia->codigo_parroquia());
  }
}   
?>