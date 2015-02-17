<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_tema']))
  $codigo_tema=trim($_POST['codigo_tema']);

if(isset($_POST['descripcion']))
  $descripcion=trim($_POST['descripcion']);

include_once("../class/class_tema.php");
$tema=new tema();
if($lOpt=='Registrar'){
  $tema->codigo_tema($codigo_tema);
  $tema->descripcion($descripcion);
  if(!$tema->Comprobar()){
    if($tema->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($tema->estatus()==1)
      $confirmacion=0;
    else{
    if($tema->Activar())            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Tema ha sido registrada con éxito!";
    header("Location: ../view/menu_principal.php?tema&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Tema!";
    header("Location: ../view/menu_principal.php?tema&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $tema->codigo_tema($codigo_tema);
  $tema->descripcion($descripcion);
  if(!$tema->Comprobar()){
    if($tema->Actualizar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Tema ha sido modificada con éxito!";
    header("Location: ../view/menu_principal.php?tema&Opt=3&codigo_tema=".$tema->codigo_tema());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Tema!";
    header("Location: ../view/menu_principal.php?tema&Opt=3&codigo_tema=".$tema->codigo_tema());
  }
}

if($lOpt=='Desactivar'){
  $tema->codigo_tema($codigo_tema);
  if($tema->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Tema ha sido desactivada con éxito!";
    header("Location: ../view/menu_principal.php?tema&Opt=3&codigo_tema=".$tema->codigo_tema());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Tema!";
    header("Location: ../view/menu_principal.php?tema&Opt=3&codigo_tema=".$tema->codigo_tema());
  }
}

if($lOpt=='Activar'){
  $tema->codigo_tema($codigo_tema);
  if($tema->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Tema ha sido activada con éxito!";
    header("Location: ../view/menu_principal.php?tema&Opt=3&codigo_tema=".$tema->codigo_tema());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Tema!";
    header("Location: ../view/menu_principal.php?tema&Opt=3&codigo_tema=".$tema->codigo_tema());
  }
}   
?>