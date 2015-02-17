<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_editorial']))
  $codigo_editorial=trim($_POST['codigo_editorial']);

if(isset($_POST['nombre']))
  $nombre=trim($_POST['nombre']);

include_once("../class/class_editorial.php");
$editorial= new editorial();
if($lOpt=='Registrar'){
  $editorial->codigo_editorial($codigo_editorial);
  $editorial->nombre($nombre);
  if(!$editorial->Comprobar()){
    if($editorial->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($editorial->estatus()==1)
      $confirmacion=0;
    else{
    if($editorial->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Editorial ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?editorial&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Editorial!";
    header("Location: ../view/menu_principal.php?editorial&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $editorial->codigo_editorial($codigo_editorial);
  $editorial->nombre($nombre);
  if(!$editorial->Comprobar()){
    if($editorial->Actualizar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Editorial ha sido modificado con éxito!";
    header("Location: ../view/menu_principal.php?editorial&Opt=3&codigo_editorial=".$editorial->codigo_editorial());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Editorial!";
    header("Location: ../view/menu_principal.php?editorial&Opt=3&codigo_editorial=".$editorial->codigo_editorial());
  }
}

if($lOpt=='Desactivar'){
  $editorial->codigo_editorial($codigo_editorial);
  if($editorial->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Editorial ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?editorial&Opt=3&codigo_editorial=".$editorial->codigo_editorial());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Editorial!";
    header("Location: ../view/menu_principal.php?editorial&Opt=3&codigo_editorial=".$editorial->codigo_editorial());
  }
}

if($lOpt=='Activar'){
  $editorial->codigo_editorial($codigo_editorial);
  if($editorial->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Editorial ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?editorial&Opt=3&codigo_editorial=".$editorial->codigo_editorial());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Editorial!";
    header("Location: ../view/menu_principal.php?editorial&Opt=3&codigo_editorial=".$editorial->codigo_editorial());
  }
}   
?>