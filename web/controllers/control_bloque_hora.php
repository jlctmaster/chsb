<?php
session_start();

//  Variables para indicar si hace la comprobación del registro

$comprobar=true;

if(isset($_POST['oldhi']))
  $oldhi=trim($_POST['oldhi']);

if(isset($_POST['oldhf']))
  $oldhf=trim($_POST['oldhf']);

if(trim($hora_inicio[0])<'12:00'){
  $oldturno = 'M';
}else{
  $oldturno = 'T';
}

//  Fin

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_bloque_hora']))
  $codigo_bloque_hora=trim($_POST['codigo_bloque_hora']);

if(isset($_POST['hora_inicio']))
  $hora_inicio=explode(" ",$_POST['hora_inicio']);

if(isset($_POST['hora_fin']))
  $hora_fin=explode(" ",$_POST['hora_fin']);

if(trim($hora_inicio[0])<'12:00'){
  $turno = 'M';
}else{
  $turno = 'T';
}

include_once("../class/class_bloque_hora.php");
$bloque_hora=new bloque_hora();
if($lOpt=='Registrar'){
  $bloque_hora->codigo_bloque_hora($codigo_bloque_hora);
  $bloque_hora->hora_inicio($hora_inicio[0]);
  $bloque_hora->hora_fin($hora_fin[0]);
  $bloque_hora->turno($turno);
  if(!$bloque_hora->Comprobar($comprobar)){
    if($bloque_hora->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($bloque_hora->estatus()==1)
      $confirmacion=0;
    else{
    if($bloque_hora->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Bloque de horas ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?bloque_hora&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Bloque de horas!";
    header("Location: ../view/menu_principal.php?bloque_hora&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $bloque_hora->codigo_bloque_hora($codigo_bloque_hora);
  $bloque_hora->hora_inicio($hora_inicio[0]);
  $bloque_hora->hora_fin($hora_fin[0]);
  $bloque_hora->turno($turno);
  if(($oldhi==$hora_inicio && $oldturno==$turno) || ($oldhf==$hora_fin && $oldturno==$turno))
    $comprobar=false;
  if(!$bloque_hora->Comprobar($comprobar)){
    if($bloque_hora->Actualizar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Bloque de horas ha sido modificado con éxito!";
    header("Location: ../view/menu_principal.php?bloque_hora&Opt=3&codigo_bloque_hora=".$bloque_hora->codigo_bloque_hora());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Bloque de horas!";
    header("Location: ../view/menu_principal.php?bloque_hora&Opt=3&codigo_bloque_hora=".$bloque_hora->codigo_bloque_hora());
  }
}

if($lOpt=='Desactivar'){
  $bloque_hora->codigo_bloque_hora($codigo_bloque_hora);
  if($bloque_hora->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Bloque de horas ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?bloque_hora&Opt=3&codigo_bloque_hora=".$bloque_hora->codigo_bloque_hora());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Bloque de horas!";
    header("Location: ../view/menu_principal.php?bloque_hora&Opt=3&codigo_bloque_hora=".$bloque_hora->codigo_bloque_hora());
  }
}

if($lOpt=='Activar'){
  $bloque_hora->codigo_bloque_hora($codigo_bloque_hora);
  if($bloque_hora->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Bloque de horas ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?bloque_hora&Opt=3&codigo_bloque_hora=".$bloque_hora->codigo_bloque_hora());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Bloque de horas!";
    header("Location: ../view/menu_principal.php?bloque_hora&Opt=3&codigo_bloque_hora=".$bloque_hora->codigo_bloque_hora());
  }
}   
?>