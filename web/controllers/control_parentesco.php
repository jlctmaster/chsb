<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_parentesco']))
  $codigo_parentesco=trim($_POST['codigo_parentesco']);

if(isset($_POST['descripcion']))
  $descripcion=trim($_POST['descripcion']);

include_once("../class/class_parentesco.php");
$parentesco=new parentesco();
if($lOpt=='Registrar'){
  $parentesco->codigo_parentesco($codigo_parentesco);
  $parentesco->descripcion($descripcion);
  if(!$parentesco->Comprobar()){
    if($parentesco->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($parentesco->estatus()==1)
      $confirmacion=0;
    else{
    if($parentesco->Activar())            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Parentesco ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?parentesco&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Parentesco!";
    header("Location: ../view/menu_principal.php?parentesco&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $parentesco->codigo_parentesco($codigo_parentesco);
  $parentesco->descripcion($descripcion);
  if($parentesco->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Parentesco ha sido modificado con éxito!";
    header("Location: ../view/menu_principal.php?parentesco&Opt=3&codigo_parentesco=".$parentesco->codigo_parentesco());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Parentesco!";
    header("Location: ../view/menu_principal.php?parentesco&Opt=3&codigo_parentesco=".$parentesco->codigo_parentesco());
  }
}

if($lOpt=='Desactivar'){
  $parentesco->codigo_parentesco($codigo_parentesco);
  if($parentesco->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Parentesco ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?parentesco&Opt=3&codigo_parentesco=".$parentesco->codigo_parentesco());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Parentesco!";
    header("Location: ../view/menu_principal.php?parentesco&Opt=3&codigo_parentesco=".$parentesco->codigo_parentesco());
  }
}

if($lOpt=='Activar'){
  $parentesco->codigo_parentesco($codigo_parentesco);
  if($parentesco->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Parentesco ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?parentesco&Opt=3&codigo_parentesco=".$parentesco->codigo_parentesco());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Parentesco!";
    header("Location: ../view/menu_principal.php?parentesco&Opt=3&codigo_parentesco=".$parentesco->codigo_parentesco());
  }
}   
?>