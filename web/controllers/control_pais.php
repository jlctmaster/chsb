<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_pais']))
  $codigo_pais=trim($_POST['codigo_pais']);

if(isset($_POST['descripcion']))
  $descripcion=trim($_POST['descripcion']);

include_once("../class/class_pais.php");
$pais=new pais();
if($lOpt=='Registrar'){
  $pais->codigo_pais($codigo_pais);
  $pais->descripcion($descripcion);
  if(!$pais->Comprobar()){
    if($pais->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($pais->estatus()==1)
      $confirmacion=0;
    else{
    if($pais->Activar())            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El País ha sido registrado con exito!";
    header("Location: ../view/menu_principal.php?pais&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el País!";
    header("Location: ../view/menu_principal.php?pais&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $pais->codigo_pais($codigo_pais);
  $pais->descripcion($descripcion);
  if($pais->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El País ha sido modificado con exito!";
    header("Location: ../view/menu_principal.php?pais&Opt=3&codigo_pais=".$pais->codigo_pais());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el País!";
    header("Location: ../view/menu_principal.php?pais&Opt=3&codigo_pais=".$pais->codigo_pais());
  }
}

if($lOpt=='Desactivar'){
  $pais->codigo_pais($codigo_pais);
  if($pais->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El País ha sido desactivado con exito!";
    header("Location: ../view/menu_principal.php?pais&Opt=3&codigo_pais=".$pais->codigo_pais());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el País!";
    header("Location: ../view/menu_principal.php?pais&Opt=3&codigo_pais=".$pais->codigo_pais());
  }
}

if($lOpt=='Activar'){
  $pais->codigo_pais($codigo_pais);
  if($pais->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El País ha sido activado con exito!";
    header("Location: ../view/menu_principal.php?pais&Opt=3&codigo_pais=".$pais->codigo_pais());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el País!";
    header("Location: ../view/menu_principal.php?pais&Opt=3&codigo_pais=".$pais->codigo_pais());
  }
}   
?>