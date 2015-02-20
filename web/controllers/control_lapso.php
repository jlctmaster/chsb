<?php
session_start();

//  Variables para indicar si hace la comprobación del registro

$comprobar=true;

if(isset($_POST['oldlapso']))
  $oldlapso=trim($_POST['oldlapso']);

if(isset($_POST['oldcaa']))
  $oldcaa=trim($_POST['oldcaa']);

//  Fin

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_lapso']))
  $codigo_lapso=trim($_POST['codigo_lapso']);

if(isset($_POST['lapso']))
  $nombre_lapso=trim($_POST['lapso']);

if(isset($_POST['codigo_ano_academico']))
  $codigo_ano_academico=trim($_POST['codigo_ano_academico']);

include_once("../class/class_lapso.php");
$lapso=new tlapso();
if($lOpt=='Registrar'){
  $lapso->codigo_lapso($codigo_lapso);
  $lapso->lapso($nombre_lapso);
  $lapso->codigo_ano_academico($codigo_ano_academico);
  if(!$lapso->Comprobar($comprobar)){
    if($lapso->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($lapso->estatus()==1)
      $confirmacion=0;
    else{
    if($lapso->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El lapso ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?lapso&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el lapso!";
    header("Location: ../view/menu_principal.php?lapso&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $lapso->codigo_lapso($codigo_lapso);
  $lapso->lapso($nombre_lapso);
  $lapso->codigo_ano_academico($codigo_ano_academico);
  if(!$lapso->Comprobar($comprobar)){
    if($lapso->Actualizar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El lapso ha sido modificado con éxito!";
    header("Location: ../view/menu_principal.php?lapso&Opt=3&codigo_lapso=".$lapso->codigo_lapso());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el lapso!";
    header("Location: ../view/menu_principal.php?lapso&Opt=3&codigo_lapso=".$lapso->codigo_lapso());
  }
}

if($lOpt=='Desactivar'){
  $lapso->codigo_lapso($codigo_lapso);
  if($lapso->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El lapso ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?lapso&Opt=3&codigo_lapso=".$lapso->codigo_lapso());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el lapso!";
    header("Location: ../view/menu_principal.php?lapso&Opt=3&codigo_lapso=".$lapso->codigo_lapso());
  }
}

if($lOpt=='Activar'){
  $lapso->codigo_lapso($codigo_lapso);
  if($lapso->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El lapso ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?lapso&Opt=3&codigo_lapso=".$lapso->codigo_lapso());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el lapso!";
    header("Location: ../view/menu_principal.php?lapso&Opt=3&codigo_lapso=".$lapso->codigo_lapso());
  }
}   
?>