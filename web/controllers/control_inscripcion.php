<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_inscripcion']))
  $codigo_inscripcion=trim($_POST['codigo_inscripcion']);

if(isset($_POST['codigo_periodo']))
  $codigo_periodo=trim($_POST['codigo_periodo']);

if(isset($_POST['descripcion']))
  $descripcion=trim($_POST['descripcion']);

if(isset($_POST['fecha_inicio']))
  $fecha_inicio=trim($_POST['fecha_inicio']);

if(isset($_POST['fecha_fin']))
  $fecha_fin=trim($_POST['fecha_fin']);

if(isset($_POST['fecha_cierre']))
  $fecha_cierre=trim($_POST['fecha_cierre']);

if(isset($_POST['cerrado']))
  $cerrado=trim($_POST['cerrado']);

function comprobarCheckBox($value){
  if($value == "on")
    $chk = "Y";
  else
    $chk = "N";
  return $chk;
}

include_once("../class/class_inscripcion.php");
$inscripcion=new inscripcion();
if($lOpt=='Registrar'){
  $inscripcion->codigo_inscripcion($codigo_inscripcion);
  $inscripcion->descripcion($descripcion);
  $inscripcion->fecha_inicio($fecha_inicio);
  $inscripcion->fecha_fin($fecha_fin);
  $inscripcion->fecha_cierre($fecha_cierre);
  if(!$inscripcion->Comprobar()){
    $inscripcion->Cerrar($_SESSION['user_name']);
    if($inscripcion->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($inscripcion->estatus()==1)
      $confirmacion=0;
    else{
    if($inscripcion->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Período de Inscripción ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?inscripcion&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Período de Inscripción!";
    header("Location: ../view/menu_principal.php?inscripcion&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $inscripcion->codigo_inscripcion($codigo_inscripcion);
  $inscripcion->descripcion($descripcion);
  $inscripcion->codigo_periodo($codigo_periodo);
  $inscripcion->fecha_inicio($fecha_inicio);
  $inscripcion->fecha_fin($fecha_fin);
  $inscripcion->fecha_cierre($fecha_cierre);
  $inscripcion->cerrado(comprobarCheckBox($cerrado));
  $inscripcion->Cerrar($_SESSION['user_name']);
  if($inscripcion->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Período de Inscripción ha sido modificado con éxito!";
    header("Location: ../view/menu_principal.php?inscripcion&Opt=3&codigo_inscripcion=".$inscripcion->codigo_inscripcion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Período de Inscripción!";
    header("Location: ../view/menu_principal.php?inscripcion&Opt=3&codigo_inscripcion=".$inscripcion->codigo_inscripcion());
  }
}

if($lOpt=='Desactivar'){
  $inscripcion->codigo_inscripcion($codigo_inscripcion);
  if($inscripcion->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Período de Inscripción ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?inscripcion&Opt=3&codigo_inscripcion=".$inscripcion->codigo_inscripcion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Período de Inscripción!";
    header("Location: ../view/menu_principal.php?inscripcion&Opt=3&codigo_inscripcion=".$inscripcion->codigo_inscripcion());
  }
}

if($lOpt=='Activar'){
  $inscripcion->codigo_inscripcion($codigo_inscripcion);
  if($inscripcion->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Período de Inscripción ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?inscripcion&Opt=3&codigo_inscripcion=".$inscripcion->codigo_inscripcion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Período de Inscripción!";
    header("Location: ../view/menu_principal.php?inscripcion&Opt=3&codigo_inscripcion=".$inscripcion->codigo_inscripcion());
  }
}   
?>