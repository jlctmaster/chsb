<?php
session_start();

//  Variables para indicar si hace la comprobación del registro

$comprobar=true;

if(isset($_POST['olddescripcion']))
  $olddescripcion=trim($_POST['olddescripcion']);

//  Fin

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_departamento']))
  $codigo_departamento=trim($_POST['codigo_departamento']);

if(isset($_POST['descripcion']))
  $descripcion=trim($_POST['descripcion']);

include_once("../class/class_departamento.php");
$departamento=new departamento();
if($lOpt=='Registrar'){
  $departamento->codigo_departamento($codigo_departamento);
  $departamento->descripcion($descripcion);
  if(!$departamento->Comprobar($comprobar)){
    if($departamento->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($departamento->estatus()==1)
      $confirmacion=0;
    else{
    if($departamento->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Departamento ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?departamento&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Departamento!";
    header("Location: ../view/menu_principal.php?departamento&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $departamento->codigo_departamento($codigo_departamento);
  $departamento->descripcion($descripcion);
  if($olddescripcion==$descripcion)
    $comprobar=false;
  if(!$departamento->Comprobar($comprobar)){
    if($departamento->Actualizar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Departamento ha sido modificado con éxito!";
    header("Location: ../view/menu_principal.php?departamento&Opt=3&codigo_departamento=".$departamento->codigo_departamento());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Departamento!";
    header("Location: ../view/menu_principal.php?departamento&Opt=3&codigo_departamento=".$departamento->codigo_departamento());
  }
}

if($lOpt=='Desactivar'){
  $departamento->codigo_departamento($codigo_departamento);
  if($departamento->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Departamento ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?departamento&Opt=3&codigo_departamento=".$departamento->codigo_departamento());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Departamento!";
    header("Location: ../view/menu_principal.php?departamento&Opt=3&codigo_departamento=".$departamento->codigo_departamento());
  }
}

if($lOpt=='Activar'){
  $departamento->codigo_departamento($codigo_departamento);
  if($departamento->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Departamento ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?departamento&Opt=3&codigo_departamento=".$departamento->codigo_departamento());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Departamento!";
    header("Location: ../view/menu_principal.php?departamento&Opt=3&codigo_departamento=".$departamento->codigo_departamento());
  }
}   
?>