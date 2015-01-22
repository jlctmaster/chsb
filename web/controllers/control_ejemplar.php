<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_ejemplar']))
  $codigo_ejemplar=trim($_POST['codigo_ejemplar']);

if(isset($_POST['codigo_clasificacion']))
  $codigo_clasificacion=trim($_POST['codigo_clasificacion']);

if(isset($_POST['numero_edicion']))
  $numero_edicion=trim($_POST['numero_edicion']);

if(isset($_POST['codigo_isbn_libro']))
  $codigo_isbn_libro=trim($_POST['codigo_isbn_libro']);


include_once("../class/class_ejemplar.php");
$ejemplar=new ejemplar();
if($lOpt=='Registrar'){
  $ejemplar->codigo_ejemplar($codigo_ejemplar);
  $ejemplar->codigo_clasificacion($codigo_clasificacion);
  $ejemplar->numero_edicion($numero_edicion);
  $ejemplar->codigo_isbn_libro($codigo_isbn_libro);
  if(!$ejemplar->Comprobar()){
    if($ejemplar->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($ejemplar->estatus()==1)
      $confirmacion=0;
    else{
    if($ejemplar->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Ejemplar ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?ejemplar&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Ejemplar!";
    header("Location: ../view/menu_principal.php?ejemplar&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $ejemplar->codigo_ejemplar($codigo_ejemplar);
  $ejemplar->codigo_clasificacion($codigo_clasificacion); 
  $ejemplar->numero_edicion($numero_edicion);
  $ejemplar->codigo_isbn_libro($codigo_isbn_libro);
  if($ejemplar->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Ejemplar ha sido modificado con éxito!";
    header("Location: ../view/menu_principal.php?ejemplar&Opt=3&codigo_ejemplar=".$ejemplar->codigo_ejemplar());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Ejemplar!";
    header("Location: ../view/menu_principal.php?ejemplar&Opt=3&codigo_ejemplar=".$ejemplar->codigo_ejemplar());
  }
}

if($lOpt=='Desactivar'){
  $ejemplar->codigo_ejemplar($codigo_ejemplar);
  if($ejemplar->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Ejemplar ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?ejemplar&Opt=3&codigo_ejemplar=".$ejemplar->codigo_ejemplar());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Ejemplar!";
    header("Location: ../view/menu_principal.php?ejemplar&Opt=3&codigo_ejemplar=".$ejemplar->codigo_ejemplar());
  }
}

if($lOpt=='Activar'){
  $ejemplar->codigo_ejemplar($codigo_ejemplar);
  if($ejemplar->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Ejemplar ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?ejemplar&Opt=3&codigo_ejemplar=".$ejemplar->codigo_ejemplar());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Ejemplar!";
    header("Location: ../view/menu_principal.php?ejemplar&Opt=3&codigo_ejemplar=".$ejemplar->codigo_ejemplar());
  }
}   
?>