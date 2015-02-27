<?php
session_start();

//  Variables para indicar si hace la comprobación del registro

$comprobar=true;

if(isset($_POST['oldseccion']))
  $oldseccion=trim($_POST['oldseccion']);

//  Fin

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['seccion']))
  $nro_seccion=trim($_POST['seccion']);

if(isset($_POST['nombre_seccion']))
  $nombre_seccion=trim($_POST['nombre_seccion']);

if(isset($_POST['turno']))
  $turno=trim($_POST['turno']);

if(isset($_POST['capacidad_min']))
  $capacidad_min=trim($_POST['capacidad_min']);

if(isset($_POST['capacidad_max']))
  $capacidad_max=trim($_POST['capacidad_max']);

if(isset($_POST['indice_min']))
  $indice_min=trim($_POST['indice_min']);

if(isset($_POST['indice_max']))
  $indice_max=trim($_POST['indice_max']);

include_once("../class/class_seccion.php");
$seccion=new Seccion();
if($lOpt=='Registrar'){
  $seccion->seccion($nro_seccion);
  $seccion->nombre_seccion($nombre_seccion);
  $seccion->turno($turno);
  $seccion->capacidad_min($capacidad_min);
  $seccion->capacidad_max($capacidad_max);
  $seccion->indice_min($indice_min);
  $seccion->indice_max($indice_max);
  $confirmacion=false;
  $seccion->Transaccion('iniciando');
  if(!$seccion->Comprobar($comprobar)){
    if($seccion->Registrar($_SESSION['user_name']))
      $confirmacion=1;
      if(isset($_POST['materias'])){
        $seccion->EliminarMaterias();
        $seccion->InsertarMaterias($_SESSION['user_name'],$_POST['materias']);
      }
    else
      $confirmacion=-1;
  }else{
    if($seccion->estatus()==1)
      $seccion=0;
    else{
    if($seccion->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $seccion->Transaccion('finalizado');
    $_SESSION['datos']['mensaje']="¡La Sección ha sido registrada con éxito!";
    header("Location: ../view/menu_principal.php?seccion&Opt=2");
  }else{
    $seccion->Transaccion('cancelado');
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar La Sección!";
    header("Location: ../view/menu_principal.php?seccion&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $seccion->seccion($nro_seccion);
  $seccion->nombre_seccion($nombre_seccion); 
  $seccion->turno($turno);
  $seccion->capacidad_min($capacidad_min);
  $seccion->capacidad_max($capacidad_max);  
  $seccion->indice_min($indice_min);
  $seccion->indice_max($indice_max);
  $confirmacion=false;
  $seccion->Transaccion('iniciando');
  if($oldseccion==$nro_seccion)
    $comprobar=false;
  if(!$seccion->Comprobar($comprobar)){
    if($seccion->Actualizar($_SESSION['user_name'],$oldseccion)){
      $confirmacion=1;
      if(isset($_POST['materias'])){
        if($nro_seccion!=$oldseccion)
          $seccion->seccion($oldseccion); 
        $seccion->EliminarMaterias();
        $seccion->InsertarMaterias($_SESSION['user_name'],$_POST['materias']);
      }
    }
    else
      $confirmacion=-1;
  }else
    $confirmacion=-1;
  if($confirmacion==1){
    $seccion->Transaccion('finalizado');
    $_SESSION['datos']['mensaje']="¡La Sección ha sido modificada con éxito!";
    header("Location: ../view/menu_principal.php?seccion&Opt=3&seccion=".$seccion->seccion());
  }else{
    $seccion->Transaccion('cancelado');
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar la Sección!";
    header("Location: ../view/menu_principal.php?seccion&Opt=3&seccion=".$oldseccion);
  }
}

if($lOpt=='Desactivar'){
  $seccion->seccion($nro_seccion);
  if($seccion->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Sección ha sido desactivada con éxito!";
    header("Location: ../view/menu_principal.php?materia&Opt=3&seccion=".$seccion->seccion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar La Sección!";
    header("Location: ../view/menu_principal.php?seccion&Opt=3&seccion=".$seccion->seccion());
  }
}

if($lOpt=='Activar'){
  $seccion->seccion($nro_seccion);
  if($seccion->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Sección ha sido activada con éxito!";
    header("Location: ../view/menu_principal.php?seccion&Opt=3&seccion=".$seccion->seccion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar La Sección!";
    header("Location: ../view/menu_principal.php?seccion&Opt=3&seccion=".$seccion->seccion());
  }
}   
?>