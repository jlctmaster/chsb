<?php
session_start();

include_once("../class/class_asignacion_libro.php");
include_once("../class/class_movimiento_inventario.php");

$asignacion_libro=new asignacion_libro();
$mov_inventario = new movimiento_inventario();

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_asignacion_libro']))
  $codigo_asignacion_libro=trim($_POST['codigo_asignacion_libro']);

if(isset($_POST['fecha_asignacion']))
  $fecha_asignacion=trim($_POST['fecha_asignacion']);

if(isset($_POST['cedula_persona']))
  $cedula_persona=trim($_POST['cedula_persona']);

if(isset($_POST['motivo']))
  $motivo=trim($_POST['motivo']);

if($lOpt=='Registrar'){
  $asignacion_libro->codigo_asignacion_libro($codigo_asignacion_libro);
  $asignacion_libro->fecha_asignacion($fecha_asignacion);
  $asignacion_libro->cedula_persona($cedula_persona);
  $asignacion_libro->motivo($motivo);
  $confirmacion=false;
  $asignacion_libro->Transaccion('iniciando');
  if($asignacion_libro->Registrar($_SESSION['user_name'])){
    if($asignacion_libro->EliminarAsignaciones()){
      if(isset($_POST['items']) && isset($_POST['cantidad']) && isset($_POST['ubicacion']) && isset($_POST['ubicacion_hasta'])){
        if($asignacion_libro->InsertarAsignaciones($_SESSION['user_name'],$_POST['items'],$_POST['cantidad'],$_POST['ubicacion'],$_POST['ubicacion_hasta'])){
          //  Registrar Salidas
          $mov_inventario->fecha_movimiento($fecha_asignacion);
          $mov_inventario->tipo_movimiento('S');
          $mov_inventario->numero_documento($asignacion_libro->codigo_asignacion_libro());
          $mov_inventario->tipo_transaccion('AL'); // Siglas para identificar la tabla relacionada al movimiento Biblioteca Asignacion de Libros (AL)
          if($mov_inventario->RegistrarMovimiento($_SESSION['user_name'])){
            $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
            $conS=0;
            for($i=0;$i<count($_POST['items']);$i++){
              $mov_inventario->codigo_item($_POST['items'][$i]);
              $mov_inventario->codigo_ubicacion($_POST['ubicacion'][$i]);
              $mov_inventario->cantidad_movimiento($_POST['cantidad'][$i]);
              $mov_inventario->valor_anterior($mov_inventario->ObtenerValorAnterior());
              $mov_inventario->valor_actual($mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]) == 0 ? $_POST['cantidad'][$i] : $mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]));
              $mov_inventario->sonlibros('Y');
              if($mov_inventario->RegistrarDetalleMovimiento($_SESSION['user_name']))
                $conS++;
            }
          }
          else
            $confirmacion=0;
          //  Registrar Entradas
          $mov_inventario->fecha_movimiento($fecha_asignacion);
          $mov_inventario->tipo_movimiento('E');
          $mov_inventario->numero_documento($asignacion_libro->codigo_asignacion_libro());
          $mov_inventario->tipo_transaccion('AL'); // Siglas para identificar la tabla relacionada al movimiento Biblioteca Asignacion de Libros (AL)
          if($mov_inventario->RegistrarMovimiento($_SESSION['user_name'])){
            $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
            $conE=0;
            for($i=0;$i<count($_POST['items']);$i++){
              $mov_inventario->codigo_item($_POST['items'][$i]);
              $mov_inventario->codigo_ubicacion($_POST['ubicacion_hasta'][$i]);
              $mov_inventario->cantidad_movimiento($_POST['cantidad'][$i]);
              $mov_inventario->valor_anterior($mov_inventario->ObtenerValorAnterior());
              $mov_inventario->valor_actual($mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]) == 0 ? $_POST['cantidad'][$i] : $mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]));
              $mov_inventario->sonlibros('Y');
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
    $asignacion_libro->Transaccion('finalizado');
    $_SESSION['datos']['procesado']="Y";
    $_SESSION['datos']['codigo_asignacion_libro']=$asignacion_libro->codigo_asignacion_libro();
    $_SESSION['datos']['mensaje']="¡La Asignación ha sido registrada con éxito!";
    header("Location: ../view/menu_principal.php?asignacion_libro&Opt=2");
  }else{
    $asignacion_libro->Transaccion('cancelado');
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar la Asignación!";
    header("Location: ../view/menu_principal.php?asignacion_libro&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $asignacion_libro->codigo_asignacion_libro($codigo_asignacion_libro);
  $asignacion_libro->fecha_asignacion($fecha_asignacion);
  $asignacion_libro->cedula_persona($cedula_persona);
  $asignacion_libro->motivo($motivo);
  $confirmacion=false;
  $asignacion_libro->Transaccion('iniciando');
  if($asignacion_libro->Actualizar($_SESSION['user_name'])){
    if($asignacion_libro->EliminarAsignaciones()){
      if(isset($_POST['items']) && isset($_POST['cantidad']) && isset($_POST['ubicacion']) && isset($_POST['ubicacion_hasta'])){
        if($asignacion_libro->InsertarAsignaciones($_SESSION['user_name'],$_POST['items'],$_POST['cantidad'],$_POST['ubicacion'],$_POST['ubicacion_hasta'])){
          //  Registrar Salidas
          $mov_inventario->fecha_movimiento($fecha_asignacion);
          $mov_inventario->tipo_movimiento('S');
          $mov_inventario->numero_documento($codigo_asignacion_libro);
          $mov_inventario->tipo_transaccion('AL'); // Siglas para identificar la tabla relacionada al movimiento Biblioteca Asignacion de Libros (AL)
          $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
          if($mov_inventario->ModificarMovimiento($_SESSION['user_name'])){
            $conS=0;
            for($i=0;$i<count($_POST['items']);$i++){
              $mov_inventario->codigo_item($_POST['items'][$i]);
              $mov_inventario->codigo_ubicacion($_POST['ubicacion'][$i]);
              $mov_inventario->cantidad_movimiento($_POST['cantidad'][$i]);
              $mov_inventario->valor_actual($mov_inventario->ObtenerValorActualModificado($_POST['cantidad'][$i]));
              $mov_inventario->codigo_detalle_movimiento($mov_inventario->ObtenerCodigoDetMovimiento());
              $mov_inventario->sonlibros('Y');
              if($mov_inventario->ModificarDetalleMovimiento($_SESSION['user_name']))
                $conS++;
            }
          }
          else
            $confirmacion=0;
          //  Registrar Entradas
          $mov_inventario->fecha_movimiento($fecha_asignacion);
          $mov_inventario->tipo_movimiento('E');
          $mov_inventario->numero_documento($codigo_asignacion_libro);
          $mov_inventario->tipo_transaccion('AL'); // Siglas para identificar la tabla relacionada al movimiento Biblioteca Asignacion de Libros (AL)
          $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
          if($mov_inventario->ModificarMovimiento($_SESSION['user_name'])){
            $conE=0;
            for($i=0;$i<count($_POST['items']);$i++){
              $mov_inventario->codigo_item($_POST['items'][$i]);
              $mov_inventario->codigo_ubicacion($_POST['ubicacion_hasta'][$i]);
              $mov_inventario->cantidad_movimiento($_POST['cantidad'][$i]);
              $mov_inventario->valor_actual($mov_inventario->ObtenerValorActualModificado($_POST['cantidad'][$i]));
              $mov_inventario->codigo_detalle_movimiento($mov_inventario->ObtenerCodigoDetMovimiento());
              $mov_inventario->sonlibros('Y');
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
    $asignacion_libro->Transaccion('finalizado');
    $_SESSION['datos']['mensaje']="¡La Asignación ha sido modificada con éxito!";
    header("Location: ../view/menu_principal.php?asignacion_libro&Opt=3&codigo_asignacion_libro=".$asignacion_libro->codigo_asignacion_libro());
  }else{
    $asignacion_libro->Transaccion('cancelado');
    echo $asignacion_libro->error()."<br>".$mov_inventario->error(); die();
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar la Asignación!";
    header("Location: ../view/menu_principal.php?asignacion_libro&Opt=3&codigo_asignacion_libro=".$asignacion_libro->codigo_asignacion_libro());
  }
}

if($lOpt=='Desactivar'){
  $asignacion_libro->codigo_asignacion_libro($codigo_asignacion_libro);
  if($asignacion_libro->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Asignación ha sido desactivada con éxito!";
    header("Location: ../view/menu_principal.php?asignacion_libro&Opt=3&codigo_asignacion_libro=".$asignacion_libro->codigo_asignacion_libro());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar la Asignación!";
    header("Location: ../view/menu_principal.php?asignacion_libro&Opt=3&codigo_asignacion_libro=".$asignacion_libro->codigo_asignacion_libro());
  }
}

if($lOpt=='Activar'){
  $asignacion_libro->codigo_asignacion_libro($codigo_asignacion_libro);
  if($asignacion_libro->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡La Asignación ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?asignacion_libro&Opt=3&codigo_asignacion_libro=".$asignacion_libro->codigo_asignacion_libro());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar la Asignación!";
    header("Location: ../view/menu_principal.php?asignacion_libro&Opt=3&codigo_asignacion_libro=".$asignacion_libro->codigo_asignacion_libro());
  }
}

if($lOpt=="BuscarCantidadDisponible"){
  echo $mov_inventario->BuscarCantidadDisponible($_POST['codigo_item'],$_POST['codigo_ubicacion']);
  unset($mov_inventario);
}
?>