<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_tipopersona']))
  $codigo_tipopersona=trim($_POST['codigo_tipopersona']);

if(isset($_POST['descripcion']))
  $descripcion=trim($_POST['descripcion']);

if(isset($_POST['es_usuariosistema']))
  $es_usuariosistema=trim($_POST['es_usuariosistema']);

function comprobarCheckBox($value){
  if($value == "on")
    $chk = "Y";
  else
    $chk = "N";
  return $chk;
}

include_once("../class/class_tipo_persona.php");
$tipo_persona=new tipopersona();
if($lOpt=='Registrar'){
  $tipo_persona->codigo_tipopersona($codigo_tipopersona);
  $tipo_persona->descripcion($descripcion);
  $tipo_persona->es_usuariosistema(comprobarCheckBox($es_usuariosistema));
  if(!$tipo_persona->Comprobar()){
    if($tipo_persona->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($tipo_persona->estatus()==1)
      $confirmacion=0;
    else{
    if($tipo_persona->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Tipo de Persona ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?tipo_persona&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Tipo de Persona!";
    header("Location: ../view/menu_principal.php?tipo_persona&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $tipo_persona->codigo_tipopersona($codigo_tipopersona);
  $tipo_persona->descripcion($descripcion);
  $tipo_persona->es_usuariosistema(comprobarCheckBox($es_usuariosistema));
  if($tipo_persona->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Tipo de Persona ha sido modificado con éxito!";
    header("Location: ../view/menu_principal.php?tipo_persona&Opt=3&codigo_tipopersona=".$tipo_persona->codigo_tipopersona());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Tipo de Persona!";
    header("Location: ../view/menu_principal.php?tipo_persona&Opt=3&codigo_tipopersona=".$tipo_persona->codigo_tipopersona());
  }
}

if($lOpt=='Desactivar'){
  $tipo_persona->codigo_tipopersona($codigo_tipopersona);
  if($tipo_persona->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Tipo de Persona ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?tipo_persona&Opt=3&codigo_tipopersona=".$tipo_persona->codigo_tipopersona());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Tipo de Persona!";
    header("Location: ../view/menu_principal.php?tipo_persona&Opt=3&codigo_tipopersona=".$tipo_persona->codigo_tipopersona());
  }
}

if($lOpt=='Activar'){
  $tipo_persona->codigo_tipopersona($codigo_tipopersona);
  if($tipo_persona->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Tipo de Persona ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?tipo_persona&Opt=3&codigo_tipopersona=".$tipo_persona->codigo_tipopersona());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Tipo de Persona!";
    header("Location: ../view/menu_principal.php?tipo_persona&Opt=3&codigo_tipopersona=".$tipo_persona->codigo_tipopersona());
  }
}   
?>