<?php
session_start();

include_once("../class/class_asignacion.php");
include_once("../class/class_movimiento_inventario.php");

$asignacion=new asignacion();
$mov_inventario = new movimiento_inventario();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_asignacion']))
  $codigo_asignacion=trim($_POST['codigo_asignacion']);

if(isset($_POST['fecha_asignacion']))
  $fecha_asignacion=trim($_POST['fecha_asignacion']);

if(isset($_POST['cedula_persona']))
  $cedula_persona=trim($_POST['cedula_persona']);

if(isset($_POST['motivo']))
  $motivo=trim($_POST['motivo']);

if($lOpt=='Registrar'){
  $asignacion->codigo_asignacion($codigo_asignacion);
  $asignacion->fecha_asignacion($fecha_asignacion);
  $asignacion->cedula_persona($cedula_persona);
  $asignacion->motivo($motivo);
  $confirmacion=false;
  $asignacion->Transaccion('iniciando');
  if($asignacion->Registrar($_SESSION['user_name'])){
    if($asignacion->EliminarAsignaciones()){
      if(isset($_POST['items']) && isset($_POST['cantidad']) && isset($_POST['ubicacion']) && isset($_POST['ubicacion_hasta'])){
        if($asignacion->InsertarAsignaciones($_SESSION['user_name'],$_POST['items'],$_POST['cantidad'],$_POST['ubicacion'],$_POST['ubicacion_hasta'])){
          //  Registrar Salidas
          $mov_inventario->fecha_movimiento($fecha_asignacion);
          $mov_inventario->tipo_movimiento('S');
          $mov_inventario->numero_documento($asignacion->codigo_asignacion());
          $mov_inventario->tipo_transaccion('BA'); // Siglas para identificar la tabla relacionada al movimiento Bienes Nacionales Asignacion (BA)
          if($mov_inventario->RegistrarMovimiento($_SESSION['user_name'])){
            $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
            $conS=0;
            for($i=0;$i<count($_POST['items']);$i++){
              $mov_inventario->codigo_item($_POST['items'][$i]);
              $mov_inventario->codigo_ubicacion($_POST['ubicacion'][$i]);
              $mov_inventario->cantidad_movimiento($_POST['cantidad'][$i]);
              $mov_inventario->valor_anterior($mov_inventario->ObtenerValorAnterior());
              $mov_inventario->valor_actual($mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]) == 0 ? $_POST['cantidad'][$i] : $mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]));
              $mov_inventario->sonlibros('N');
              if($mov_inventario->RegistrarDetalleMovimiento($_SESSION['user_name']))
                $conS++;
            }
          }
          else
            $confirmacion=0;
          //  Registrar Entradas
          $mov_inventario->fecha_movimiento($fecha_asignacion);
          $mov_inventario->tipo_movimiento('E');
          $mov_inventario->numero_documento($asignacion->codigo_asignacion());
          $mov_inventario->tipo_transaccion('BA'); // Siglas para identificar la tabla relacionada al movimiento Bienes Nacionales Asignacion (BA)
          if($mov_inventario->RegistrarMovimiento($_SESSION['user_name'])){
            $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
            $conE=0;
            for($i=0;$i<count($_POST['items']);$i++){
              $mov_inventario->codigo_item($_POST['items'][$i]);
              $mov_inventario->codigo_ubicacion($_POST['ubicacion_hasta'][$i]);
              $mov_inventario->cantidad_movimiento($_POST['cantidad'][$i]);
              $mov_inventario->valor_anterior($mov_inventario->ObtenerValorAnterior());
              $mov_inventario->valor_actual($mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]) == 0 ? $_POST['cantidad'][$i] : $mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]));
              $mov_inventario->sonlibros('N');
              if($mov_inventario->RegistrarDetalleMovimiento($_SESSION['user_name']))
                $conE++;
            }
          }
          else
            $confirmacion=0;

          if($conS==count($_POST['items']) && $conS==$conE)
            $confirmacion=1;
          else
            $confirmacion=0;
        }
        else
          $confirmacion=0;
      }
      else
        $confirmacion=0;
    }
    else
      $confirmacion=0;
  }
  else
    $confirmacion=0;

  if($confirmacion==1){
    $asignacion->Transaccion('finalizado');
    $_SESSION['datos']['procesado']="Y";
    $_SESSION['datos']['codigo_asignacion']=$asignacion->codigo_asignacion();
    $_SESSION['datos']['mensaje']="¡La Asignación ha sido registrada con éxito!";
    header("Location: ../view/menu_principal.php?asignacion&Opt=2");
  }else{
    $asignacion->Transaccion('cancelado');
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar la Asignación!";
    header("Location: ../view/menu_principal.php?asignacion&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $asignacion->codigo_asignacion($codigo_asignacion);
  $asignacion->fecha_asignacion($fecha_asignacion);
  $asignacion->cedula_persona($cedula_persona);
  $asignacion->motivo($motivo);
  $confirmacion=false;
  $asignacion->Transaccion('iniciando');
  if($asignacion->Actualizar($_SESSION['user_name'])){
    if($asignacion->EliminarAsignaciones()){
      if(isset($_POST['items']) && isset($_POST['cantidad']) && isset($_POST['ubicacion']) && isset($_POST['ubicacion_hasta'])){
        if($asignacion->InsertarAsignaciones($_SESSION['user_name'],$_POST['items'],$_POST['cantidad'],$_POST['ubicacion'],$_POST['ubicacion_hasta'])){
          //  Registrar Salidas
          $mov_inventario->fecha_movimiento($fecha_asignacion);
          $mov_inventario->tipo_movimiento('S');
          $mov_inventario->numero_documento($codigo_asignacion);
          $mov_inventario->tipo_transaccion('BA'); // Siglas para identificar la tabla relacionada al movimiento Bienes Nacionales Asignacion (BA)
          $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
          if($mov_inventario->ModificarMovimiento($_SESSION['user_name'])){
            $conS=0;
            for($i=0;$i<count($_POST['items']);$i++){
              $mov_inventario->codigo_item($_POST['items'][$i]);
              $mov_inventario->codigo_ubicacion($_POST['ubicacion'][$i]);
              $mov_inventario->cantidad_movimiento($_POST['cantidad'][$i]);
              $mov_inventario->valor_actual($mov_inventario->ObtenerValorActualModificado($_POST['cantidad'][$i]));
              $mov_inventario->codigo_detalle_movimiento($mov_inventario->ObtenerCodigoDetMovimiento());
              $mov_inventario->sonlibros('N');
              if($mov_inventario->ModificarDetalleMovimiento($_SESSION['user_name']))
                $conS++;
            }
          }
          else
            $confirmacion=0;
          //  Registrar Entradas
          $mov_inventario->fecha_movimiento($fecha_asignacion);
          $mov_inventario->tipo_movimiento('E');
          $mov_inventario->numero_documento($codigo_asignacion);
          $mov_inventario->tipo_transaccion('BA'); // Siglas para identificar la tabla relacionada al movimiento Bienes Nacionales Asignacion (BA)
          $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
          if($mov_inventario->ModificarMovimiento($_SESSION['user_name'])){
            $conE=0;
            for($i=0;$i<count($_POST['items']);$i++){
              $mov_inventario->codigo_item($_POST['items'][$i]);
              $mov_inventario->codigo_ubicacion($_POST['ubicacion_hasta'][$i]);
              $mov_inventario->cantidad_movimiento($_POST['cantidad'][$i]);
              $mov_inventario->valor_actual($mov_inventario->ObtenerValorActualModificado($_POST['cantidad'][$i]));
              $mov_inventario->codigo_detalle_movimiento($mov_inventario->ObtenerCodigoDetMovimiento());
              $mov_inventario->sonlibros('N');
              if($mov_inventario->ModificarDetalleMovimiento($_SESSION['user_name']))
                $conE++;
            }
          }
          else
            $confirmacion=0;

          if($conS==count($_POST['items']) && $conS==$conE)
            $confirmacion=1;
          else
            $confirmacion=0;
        }
        else
          $confirmacion=0;
      }
      else
        $confirmacion=1;
    }
    else
      $confirmacion=1;
  }
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $asignacion->Transaccion('finalizado');
    $_SESSION['datos']['mensaje']="¡La Asignación ha sido modificada con éxito!";
    header("Location: ../view/menu_principal.php?asignacion&Opt=3&codigo_asignacion=".$asignacion->codigo_asignacion());
  }else{
    $asignacion->Transaccion('cancelado');
    echo $asignacion->error()."<br>".$mov_inventario->error(); die();
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar la Asignación!";
    header("Location: ../view/menu_principal.php?asignacion&Opt=3&codigo_asignacion=".$asignacion->codigo_asignacion());
  }
}

if($lOpt=='Desactivar'){
  $asignacion->codigo_asignacion($codigo_asignacion);
  if($asignacion->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Asignación ha sido desactivada con éxito!";
    header("Location: ../view/menu_principal.php?asignacion&Opt=3&codigo_asignacion=".$asignacion->codigo_asignacion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar la Asignación!";
    header("Location: ../view/menu_principal.php?asignacion&Opt=3&codigo_asignacion=".$asignacion->codigo_asignacion());
  }
}

if($lOpt=='Activar'){
  $asignacion->codigo_asignacion($codigo_asignacion);
  if($asignacion->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Asignación ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?asignacion&Opt=3&codigo_asignacion=".$asignacion->codigo_asignacion());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar la Asignación!";
    header("Location: ../view/menu_principal.php?asignacion&Opt=3&codigo_asignacion=".$asignacion->codigo_asignacion());
  }
}

if($lOpt=="BuscarCantidadDisponible"){
  echo $mov_inventario->BuscarCantidadDisponible($_POST['codigo_item'],$_POST['codigo_ubicacion']);
  unset($mov_inventario);
}
?>