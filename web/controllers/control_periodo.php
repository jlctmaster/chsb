<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_periodo']))
  $codigo_periodo=trim($_POST['codigo_periodo']);

if(isset($_POST['descripcion']))
  $descripcion=trim($_POST['descripcion']);

if(isset($_POST['fecha_inicio']))
  $fecha_inicio=trim($_POST['fecha_inicio']);

if(isset($_POST['fecha_fin']))
  $fecha_fin=trim($_POST['fecha_fin']);

if(isset($_POST['codigo_lapso']))
  $codigo_lapso=trim($_POST['codigo_lapso']);

if(isset($_POST['esinscripcion']))
  $esinscripcion=trim($_POST['esinscripcion']);


include_once("../class/class_periodo.php");
$periodo=new periodo();
if($lOpt=='Registrar'){
  $periodo->codigo_periodo($codigo_periodo);
  $periodo->descripcion($descripcion);
  $periodo->fecha_inicio($fecha_inicio);
  $periodo->fecha_fin($fecha_fin);
  $periodo->codigo_lapso($codigo_lapso);
  if(!$periodo->Comprobar()){
    if($periodo->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($periodo->estatus()==1)
      $confirmacion=0;
    else{
    if($periodo->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Trayecto ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?periodo&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Trayecto!";
    header("Location: ../view/menu_principal.php?periodo&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $periodo->codigo_periodo($codigo_periodo);
  $periodo->descripcion($descripcion);
  $periodo->fecha_inicio($fecha_inicio);
  $periodo->fecha_fin($fecha_fin);
  $periodo->codigo_lapso($codigo_lapso);
  if(!$periodo->Comprobar()){
    if($periodo->Actualizar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Trayecto ha sido modificado con éxito!";
    header("Location: ../view/menu_principal.php?periodo&Opt=3&codigo_periodo=".$periodo->codigo_periodo());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Trayecto!";
    header("Location: ../view/menu_principal.php?periodo&Opt=3&codigo_periodo=".$periodo->codigo_periodo());
  }
}

if($lOpt=='Desactivar'){
  $periodo->codigo_periodo($codigo_periodo);
  if($periodo->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Trayecto ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?periodo&Opt=3&codigo_periodo=".$periodo->codigo_periodo());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Trayecto!";
    header("Location: ../view/menu_principal.php?periodo&Opt=3&codigo_periodo=".$periodo->codigo_periodo());
  }
}

if($lOpt=='Activar'){
  $periodo->codigo_periodo($codigo_periodo);
  if($periodo->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Trayecto ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?periodo&Opt=3&codigo_periodo=".$periodo->codigo_periodo());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Trayecto!";
    header("Location: ../view/menu_principal.php?periodo&Opt=3&codigo_periodo=".$periodo->codigo_periodo());
  }
}   
?>