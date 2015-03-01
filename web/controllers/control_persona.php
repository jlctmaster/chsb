<?php
session_start();

//  Variables para indicar si hace la comprobación del registro

$comprobar=true;

if(isset($_POST['oldci']))
  $oldci=trim($_POST['oldci']);

//  Fin

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['filtro']))
  $filtro=$_POST['filtro'];

if(isset($_POST['cedula_persona']))
  $cedula_persona=trim($_POST['cedula_persona']);

if(isset($_POST['primer_nombre']))
  $primer_nombre=trim($_POST['primer_nombre']);

if(isset($_POST['segundo_nombre']))
  $segundo_nombre=trim($_POST['segundo_nombre']);

if(isset($_POST['primer_apellido']))
  $primer_apellido=trim($_POST['primer_apellido']);

if(isset($_POST['segundo_apellido']))
  $segundo_apellido=trim($_POST['segundo_apellido']);

if(isset($_POST['sexo']))
  $sexo=trim($_POST['sexo']);

if(isset($_POST['fecha_nacimiento']))
  $fecha_nacimiento=trim($_POST['fecha_nacimiento']);

if(isset($_POST['lugar_nacimiento'])){
  $parroquia=explode("_",trim($_POST['lugar_nacimiento']));
  $lugar_nacimiento=$parroquia[0];
}

if(isset($_POST['direccion']))
  $direccion=trim($_POST['direccion']);

if(isset($_POST['telefono_local']))
  $telefono_local=trim($_POST['telefono_local']);

if(isset($_POST['telefono_movil']))
  $telefono_movil=trim($_POST['telefono_movil']);

if(isset($_POST['codigo_tipopersona']))
  $codigo_tipopersona=trim($_POST['codigo_tipopersona']);

if(isset($_POST['maxhoras']))
  $maxhoras=trim($_POST['maxhoras']);

include_once("../class/class_persona.php");
$persona=new persona();
if($lOpt=='Registrar'){
  $persona->cedula_persona($cedula_persona);
  $persona->primer_nombre($primer_nombre);
  $persona->segundo_nombre($segundo_nombre);
  $persona->primer_apellido($primer_apellido);
  $persona->segundo_apellido($segundo_apellido);
  $persona->sexo($sexo);
  $persona->fecha_nacimiento($fecha_nacimiento);
  $persona->lugar_nacimiento($lugar_nacimiento);
  $persona->direccion($direccion);
  $persona->telefono_local($telefono_local);
  $persona->telefono_movil($telefono_movil);
  $persona->codigo_tipopersona($codigo_tipopersona);
  $persona->maxhoras($maxhoras);
  if(!$persona->Comprobar($comprobar)){
    if($persona->Registrar($_SESSION['user_name']))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else{
    if($persona->estatus()==1)
      $confirmacion=0;
    else{
    if($persona->Activar($_SESSION['user_name']))            
      $confirmacion=1;
    }
  }
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Persona ha sido registrada con éxito!";
    header("Location: ../view/menu_principal.php?persona&Opt=2");
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar la Persona!";
    header("Location: ../view/menu_principal.php?persona&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $persona->cedula_persona($cedula_persona);
  $persona->primer_nombre($primer_nombre);
  $persona->segundo_nombre($segundo_nombre);
  $persona->primer_apellido($primer_apellido);
  $persona->segundo_apellido($segundo_apellido);
  $persona->sexo($sexo);
  $persona->fecha_nacimiento($fecha_nacimiento);
  $persona->lugar_nacimiento($lugar_nacimiento);
  $persona->direccion($direccion);
  $persona->telefono_local($telefono_local);
  $persona->telefono_movil($telefono_movil);
  $persona->codigo_tipopersona($codigo_tipopersona);
  $persona->maxhoras($maxhoras);
  if($oldci==$cedula_persona)
    $comprobar=false;
  if(!$persona->Comprobar($comprobar)){
    if($persona->Actualizar($_SESSION['user_name'],$oldci))
      $confirmacion=1;
    else
      $confirmacion=-1;
  }else
    $confirmacion=-1;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Persona ha sido modificada con éxito!";
    header("Location: ../view/menu_principal.php?persona&Opt=3&cedula_persona=".$persona->cedula_persona());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar la Persona!";
    header("Location: ../view/menu_principal.php?persona&Opt=3&cedula_persona=".$oldci);
  }
}

if($lOpt=='Desactivar'){
  $persona->cedula_persona($cedula_persona);
  if($persona->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Persona ha sido desactivada con éxito!";
    header("Location: ../view/menu_principal.php?persona&Opt=3&cedula_persona=".$persona->cedula_persona());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar la Persona!";
    header("Location: ../view/menu_principal.php?persona&Opt=3&cedula_persona=".$persona->cedula_persona());
  }
}

if($lOpt=='Activar'){
  $persona->cedula_persona($cedula_persona);
  if($persona->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Persona ha sido activada con éxito!";
    header("Location: ../view/menu_principal.php?persona&Opt=3&cedula_persona=".$persona->cedula_persona());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar la Persona!";
    header("Location: ../view/menu_principal.php?persona&Opt=3&cedula_persona=".$persona->cedula_persona());
  }
}

if($lOpt=="BuscarDatosRepresentante"){
  echo $persona->BuscarDatosRepresentante($filtro);
  unset($persona);
}

if($lOpt=="BuscarDatosPersona"){
  echo $persona->BuscarDatosPersona($filtro);
  unset($persona);
}
?>