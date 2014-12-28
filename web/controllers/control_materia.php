<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_materia']))
  $codigo_materia=trim($_POST['codigo_materia']);

if(isset($_POST['nombre_materia']))
  $nombre_materia=trim($_POST['nombre_materia']);

if(isset($_POST['unidad_credito']))
  $unidad_credito=trim($_POST['unidad_credito']);

if(isset($_POST['tipo_materia']))
  $tipo_materia=trim($_POST['tipo_materia']);

include_once("../class/class_materia.php");
$materia=new materia();
if($lOpt=='Registrar'){
  $materia->codigo_materia($codigo_materia);
  $materia->nombre_materia($nombre_materia);
  $materia->unidad_credito($unidad_credito);
  $materia->tipo_materia($tipo_materia);
  if(!$materia->Comprobar()){
    if($materia->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($materia->estatus()==1)
      $confirmacion=0;
    else{
    if($materia->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Materia ha sido registrada con éxito!";
    header("Location: ../view/menu_principal.php?materia&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar la Materia!";
    header("Location: ../view/menu_principal.php?materia&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $materia->codigo_materia($codigo_materia);
  $materia->nombre_materia($nombre_materia); 
  $materia->unidad_credito($unidad_credito);
  $materia->tipo_materia($tipo_materia);
  if($materia->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Materia ha sido modificada con éxito!";
    header("Location: ../view/menu_principal.php?materia&Opt=3&codigo_materia=".$materia->codigo_materia());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar la Materia!";
    header("Location: ../view/menu_principal.php?materia&Opt=3&codigo_materia=".$materia->codigo_materia());
  }
}

if($lOpt=='Desactivar'){
  $materia->codigo_materia($codigo_materia);
  if($materia->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Materia ha sido desactivada con éxito!";
    header("Location: ../view/menu_principal.php?materia&Opt=3&codigo_materia=".$materia->codigo_materia());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar la Materia!";
    header("Location: ../view/menu_principal.php?materia&Opt=3&codigo_materia=".$materia->codigo_materia());
  }
}

if($lOpt=='Activar'){
  $materia->codigo_materia($codigo_materia);
  if($materia->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Materia ha sido activada con éxito!";
    header("Location: ../view/menu_principal.php?materia&Opt=3&codigo_materia=".$materia->codigo_materia());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar la Materia!";
    header("Location: ../view/menu_principal.php?materia&Opt=3&codigo_materia=".$materia->codigo_materia());
  }
}   
?>