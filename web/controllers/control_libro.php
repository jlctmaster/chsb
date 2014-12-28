<?php
session_start();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);      

if(isset($_POST['codigo_isbn_libro']))
  $codigo_isbn_libro=trim($_POST['codigo_isbn_libro']);

if(isset($_POST['titulo']))
  $titulo=trim($_POST['titulo']);

if(isset($_POST['codigo_editorial']))
  $codigo_editorial=trim($_POST['codigo_editorial']);

if(isset($_POST['codigo_autor']))
  $codigo_autor=trim($_POST['codigo_autor']);

if(isset($_POST['codigo_tema']))
  $codigo_tema=trim($_POST['codigo_tema']);

if(isset($_POST['numero_paginas']))
  $numero_paginas=trim($_POST['numero_paginas']);

if(isset($_POST['fecha_edicion']))
  $fecha_edicion=trim($_POST['fecha_edicion']);

include_once("../class/class_libro.php");
$libro= new libro();
if($lOpt=='Registrar'){
  $libro->codigo_isbn_libro($codigo_isbn_libro);
  $libro->titulo($titulo);
  $libro->codigo_editorial($codigo_editorial);
  $libro->codigo_autor($codigo_autor);
  $libro->codigo_tema($codigo_tema);
  $libro->numero_paginas($numero_paginas);
  $libro->fecha_edicion($fecha_edicion);
  if(!$libro->Comprobar()){
    if($libro->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($libro->estatus()==1)
      $confirmacion=0;
    else{
    if($libro->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Libro ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?libro&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Libro!";
    header("Location: ../view/menu_principal.php?libro&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $libro->codigo_isbn_libro($codigo_isbn_libro);
  $libro->titulo($titulo);
  $libro->codigo_editorial($codigo_editorial);
  $libro->codigo_autor($codigo_autor);
  $libro->codigo_tema($codigo_tema);
  $libro->numero_paginas($numero_paginas);
  $libro->fecha_edicion($fecha_edicion);
  if($libro->Actualizar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Libro ha sido modificado con éxito!";
    header("Location: ../view/menu_principal.php?libro&Opt=3&codigo_isbn_libro=".$libro->codigo_isbn_libro());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Libro!";
    header("Location: ../view/menu_principal.php?libro&Opt=3&codigo_isbn_libro=".$libro->codigo_isbn_libro());
  }
}

if($lOpt=='Desactivar'){
  $libro->codigo_isbn_libro($codigo_isbn_libro);
  if($libro->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Libro ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?libro&Opt=3&codigo_isbn_libro=".$libro->codigo_isbn_libro());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Libro!";
    header("Location: ../view/menu_principal.php?libro&Opt=3&codigo_isbn_libro=".$libro->codigo_isbn_libro());
  }
}

if($lOpt=='Activar'){
  $libro->codigo_isbn_libro($codigo_isbn_libro);
  if($libro->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Libro ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?libro&Opt=3&codigo_isbn_libro=".$libro->codigo_isbn_libro());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Libro!";
    header("Location: ../view/menu_principal.php?libro&Opt=3&codigo_isbn_libro=".$libro->codigo_isbn_libro());
  }
}   
?>