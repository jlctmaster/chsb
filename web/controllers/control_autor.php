<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_autor']))
  $codigo_autor=trim($_POST['codigo_autor']);

if(isset($_POST['nombre']))
  $nombre=trim($_POST['nombre']);

include_once("../class/class_autor.php");
$autor=new autor();
if($lOpt=='Registrar'){
  $autor->codigo_autor($codigo_autor);
  $autor->nombre($nombre);
  if(!$autor->Comprobar()){
    if($autor->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($autor->estatus()==1)
      $confirmacion=0;
    else{
    if($autor->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El autor ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?autor&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el autor!";
    header("Location: ../view/menu_principal.php?autor&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $autor->codigo_autor($codigo_autor);
  $autor->nombre($nombre);
  if(!$autor->Comprobar()){
    if($autor->Actualizar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El autor ha sido modificado con éxito!";
    header("Location: ../view/menu_principal.php?autor&Opt=3&codigo_autor=".$autor->codigo_autor());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el autor!";
    header("Location: ../view/menu_principal.php?autor&Opt=3&codigo_autor=".$autor->codigo_autor());
  }
}

if($lOpt=='Desactivar'){
  $autor->codigo_autor($codigo_autor);
  if($autor->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El autor ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?autor&Opt=3&codigo_autor=".$autor->codigo_autor());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el autor!";
    header("Location: ../view/menu_principal.php?autor&Opt=3&codigo_autor=".$autor->codigo_autor());
  }
}

if($lOpt=='Activar'){
  $autor->codigo_autor($codigo_autor);
  if($autor->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El autor ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?autor&Opt=3&codigo_autor=".$autor->codigo_autor());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el autor!";
    header("Location: ../view/menu_principal.php?autor&Opt=3&codigo_autor=".$autor->codigo_autor());
  }
}   
?>