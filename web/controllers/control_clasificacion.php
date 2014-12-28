<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_clasificacion']))
  $codigo_clasificacion=trim($_POST['codigo_clasificacion']);

if(isset($_POST['descripcion']))
  $descripcion=trim($_POST['descripcion']);

include_once("../class/class_clasificacion.php");
$clasificacion=new clasificacion();
if($lOpt=='Registrar'){
  $clasificacion->codigo_clasificacion($codigo_clasificacion);
  $clasificacion->descripcion($descripcion);
  if(!$clasificacion->Comprobar()){
    if($clasificacion->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($clasificacion->estatus()==1)
      $confirmacion=0;
    else{
    if($clasificacion->Activar())            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Clasificación ha sido registrada con éxito!";
    header("Location: ../view/menu_principal.php?clasificacion&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar la Clasificación!";
    header("Location: ../view/menu_principal.php?clasificacion&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $clasificacion->codigo_clasificacion($codigo_clasificacion);
  $clasificacion->descripcion($descripcion);
  if($clasificacion->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Clasificación ha sido modificada con éxito!";
    header("Location: ../view/menu_principal.php?clasificacion&Opt=3&codigo_clasificacion=".$clasificacion->codigo_clasificacion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar la Clasificación!";
    header("Location: ../view/menu_principal.php?clasificacion&Opt=3&codigo_clasificacion=".$clasificacion->codigo_clasificacion());
  }
}

if($lOpt=='Desactivar'){
  $clasificacion->codigo_clasificacion($codigo_clasificacion);
  if($clasificacion->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Clasificación ha sido desactivada con éxito!";
    header("Location: ../view/menu_principal.php?clasificacion&Opt=3&codigo_clasificacion=".$clasificacion->codigo_clasificacion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar la Clasificación!";
    header("Location: ../view/menu_principal.php?clasificacion&Opt=3&codigo_clasificacion=".$clasificacion->codigo_clasificacion());
  }
}

if($lOpt=='Activar'){
  $clasificacion->codigo_clasificacion($codigo_clasificacion);
  if($clasificacion->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Clasificación ha sido activada con éxito!";
    header("Location: ../view/menu_principal.php?clasificacion&Opt=3&codigo_clasificacion=".$clasificacion->codigo_clasificacion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar la Clasificación!";
    header("Location: ../view/menu_principal.php?clasificacion&Opt=3&codigo_clasificacion=".$clasificacion->codigo_clasificacion());
  }
}   
?>
