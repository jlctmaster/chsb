<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_ano_academico']))
  $codigo_ano_academico=trim($_POST['codigo_ano_academico']);

if(isset($_POST['ano']))
  $ano=trim($_POST['ano']);

if(isset($_POST['cerrado']))
  $cerrado=trim($_POST['cerrado']);

function comprobarCheckBox($value){
  if($value == "on")
    $chk = "Y";
  else
    $chk = "N";
  return $chk;
}

include_once("../class/class_ano_academico.php");
$ano_academico=new ano_academico();
if($lOpt=='Registrar'){
  $ano_academico->codigo_ano_academico($codigo_ano_academico);
  $ano_academico->ano($ano);
  if(!$ano_academico->Comprobar()){
    $ano_academico->Cerrar($_SESSION['user_name']);
    if($ano_academico->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($ano_academico->estatus()==1)
      $confirmacion=0;
    else{
    if($ano_academico->Activar())            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Año Académico ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?ano_academico&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Año Académico!";
    header("Location: ../view/menu_principal.php?ano_academico&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $ano_academico->codigo_ano_academico($codigo_ano_academico);
  $ano_academico->ano($ano);
  $ano_academico->cerrado(comprobarCheckBox($cerrado));
  $ano_academico->Cerrar($_SESSION['user_name']);
  if($ano_academico->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Año Académico ha sido modificado con éxito!";
    header("Location: ../view/menu_principal.php?ano_academico&Opt=3&codigo_ano_academico=".$ano_academico->codigo_ano_academico());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Año Académico!";
    header("Location: ../view/menu_principal.php?ano_academico&Opt=3&codigo_ano_academico=".$ano_academico->codigo_ano_academico());
  }
}

if($lOpt=='Desactivar'){
  $ano_academico->codigo_ano_academico($codigo_ano_academico);
  if($ano_academico->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Año Académico ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?ano_academico&Opt=3&codigo_ano_academico=".$ano_academico->codigo_ano_academico());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Año Académico!";
    header("Location: ../view/menu_principal.php?ano_academico&Opt=3&codigo_ano_academico=".$ano_academico->codigo_ano_academico());
  }
}

if($lOpt=='Activar'){
  $ano_academico->codigo_ano_academico($codigo_ano_academico);
  if($ano_academico->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Año Académico ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?ano_academico&Opt=3&codigo_ano_academico=".$ano_academico->codigo_ano_academico());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Año Académico!";
    header("Location: ../view/menu_principal.php?ano_academico&Opt=3&codigo_ano_academico=".$ano_academico->codigo_ano_academico());
  }
}   
?>