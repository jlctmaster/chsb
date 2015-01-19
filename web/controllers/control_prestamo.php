<?php
session_start();

include_once("../class/class_prestamo.php");
include_once("../class/class_movimiento_inventario.php");

if(isset($_POST['lOpt']))
  $lOpt=trim($_POST['lOpt']);

if(isset($_POST['codigo_prestamo']))
  $codigo_prestamo=trim($_POST['codigo_prestamo']);

if(isset($_POST['cedula_responsable']))
  $cedula_responsable=trim($_POST['cedula_responsable']);

if(isset($_POST['cedula_persona']))
  $cedula_persona=trim($_POST['cedula_persona']);

if(isset($_POST['codigo_area']))
  $codigo_area=trim($_POST['codigo_area']);

if(isset($_POST['cota']))
  $cota=trim($_POST['cota']);

if(isset($_POST['fecha_salida']))
  $fecha_salida=trim($_POST['fecha_salida']);

if(isset($_POST['fecha_entrada']))
  $fecha_entrada=trim($_POST['fecha_entrada']);

$prestamo=new prestamo();
$mov_inventario = new movimiento_inventario();
if($lOpt=='Registrar'){
  $prestamo->codigo_prestamo($codigo_prestamo);
  $prestamo->cedula_responsable($cedula_responsable);
  $prestamo->cedula_persona($cedula_persona);
  $prestamo->codigo_area($codigo_area);
  $prestamo->cota($cota);
  $prestamo->fecha_salida($fecha_salida);
  $prestamo->fecha_entrada($fecha_entrada);
  $confirmacion=false;
  $prestamo->Transaccion('iniciando');
     if($prestamo->Registrar($_SESSION['user_name'])){
      if($prestamo->EliminarPrestamos()){
        if(isset($_POST['ejemplar']) && isset($_POST['ubicacion']) && isset($_POST['cantidad'])){
          if($prestamo->InsertarPrestamos($_SESSION['user_name'],$_POST['ejemplar'],$_POST['ubicacion'],$_POST['cantidad'])){
            $mov_inventario->fecha_movimiento($fecha_salida);
            $mov_inventario->tipo_movimiento('S');
            $mov_inventario->numero_documento($prestamo->codigo_prestamo());
            $mov_inventario->tipo_transaccion('BP'); // Siglas para identificar la tabla relacionada al movimiento Biblioteca Préstamo (BP)
            if($mov_inventario->RegistrarMovimiento($_SESSION['user_name'])){
              $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
              $con=0;
              for($i=0;$i<count($_POST['ejemplar']);$i++){
                $mov_inventario->codigo_item($_POST['ejemplar'][$i]);
                $mov_inventario->codigo_ubicacion($_POST['ubicacion'][$i]);
                $mov_inventario->cantidad_movimiento($_POST['cantidad'][$i]);
                $mov_inventario->valor_anterior($mov_inventario->ObtenerValorAnterior());
                $mov_inventario->valor_actual($mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]) == 0 ? $_POST['cantidad'][$i] : $mov_inventario->ObtenerValorActual($_POST['cantidad'][$i]));
                $mov_inventario->sonlibros('Y');
                if($mov_inventario->RegistrarDetalleMovimiento($_SESSION['user_name']))
                  $con++;
              }
              if($con==count($_POST['ejemplar']))
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
    }
    else
      $confirmacion=0;

  if($confirmacion==1){
    $prestamo->Transaccion('finalizado');
    $_SESSION['datos']['procesado']="Y";
    $_SESSION['datos']['codigo_prestamo']=$prestamo->codigo_prestamo();
    $_SESSION['datos']['mensaje']="¡El Préstamo ha sido registrado con éxito!";
    header("Location: ../view/menu_principal.php?prestamo&Opt=2");
  }else{
    $prestamo->Transaccion('cancelado');
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al registrar el Préstamo!";
    header("Location: ../view/menu_principal.php?prestamo&Opt=2");
  }
}

if($lOpt=='Modificar'){
  $prestamo->codigo_prestamo($codigo_prestamo);
  $prestamo->cedula_responsable($cedula_responsable);
  $prestamo->cedula_persona($cedula_persona);
  $prestamo->codigo_area($codigo_area);
  $prestamo->cota($cota);
  $prestamo->fecha_salida($fecha_salida);
  $prestamo->fecha_entrada($fecha_entrada);
  $confirmacion=false;
  $prestamo->Transaccion('iniciando');
  if($prestamo->Actualizar($_SESSION['user_name'])){
    if($prestamo->EliminarPrestamos()){
      if(isset($_POST['ejemplar']) && isset($_POST['ubicacion']) && isset($_POST['cantidad'])){
        if($prestamo->InsertarPrestamos($_SESSION['user_name'],$_POST['ejemplar'],$_POST['ubicacion'],$_POST['cantidad'])){
          $mov_inventario->fecha_movimiento($fecha_salida);
          $mov_inventario->tipo_movimiento('S');
          $mov_inventario->numero_documento($codigo_prestamo);
          $mov_inventario->tipo_transaccion('BP'); // Siglas para identificar la tabla relacionada al movimiento Biblioteca Préstamo (BP)
          $mov_inventario->codigo_movimiento($mov_inventario->ObtenerCodigoMovimiento());
          if($mov_inventario->ModificarMovimiento($_SESSION['user_name'])){
            $con=0;
            for($i=0;$i<count($_POST['ejemplar']);$i++){
              $mov_inventario->codigo_item($_POST['ejemplar'][$i]);
              $mov_inventario->codigo_ubicacion($_POST['ubicacion'][$i]);
              $mov_inventario->cantidad_movimiento($_POST['cantidad'][$i]);
              $mov_inventario->valor_actual($mov_inventario->ObtenerValorActualModificado($_POST['cantidad'][$i]));
              $mov_inventario->sonlibros('Y');
              $mov_inventario->codigo_detalle_movimiento($mov_inventario->ObtenerCodigoDetMovimiento());
              if($mov_inventario->ModificarDetalleMovimiento($_SESSION['user_name']))
                $con++;
            }
            if($con==count($_POST['ejemplar']))
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
        $confirmacion=1;
    }
    else
      $confirmacion=1;
  }
  else
    $confirmacion=-1;
  if($confirmacion==1){
    $prestamo->Transaccion('finalizado');
    $_SESSION['datos']['mensaje']="¡El Préstamo ha sido modificado con éxito!";
    header("Location: ../view/menu_principal.php?prestamo&Opt=3&codigo_prestamo=".$prestamo->codigo_prestamo());
  }else{
    $prestamo->Transaccion('cancelado');
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al modificar el Préstamo!";
    header("Location: ../view/menu_principal.php?prestamo&Opt=3&codigo_prestamo=".$prestamo->codigo_prestamo());
  }
}

if($lOpt=='Desactivar'){
  $prestamo->codigo_prestamo($codigo_prestamo);
  if($prestamo->Desactivar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Préstamo ha sido desactivado con éxito!";
    header("Location: ../view/menu_principal.php?prestamo&Opt=3&codigo_prestamo=".$prestamo->codigo_prestamo());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al desactivar el Préstamo!";
    header("Location: ../view/menu_principal.php?prestamo&Opt=3&codigo_prestamo=".$prestamo->codigo_prestamo());
  }
}

if($lOpt=='Activar'){
  $prestamo->codigo_prestamo($codigo_prestamo);
  if($prestamo->Activar($_SESSION['user_name']))
    $confirmacion=1;
  else
    $confirmacion=0;
  if($confirmacion==1){
    $_SESSION['datos']['mensaje']="¡El Préstamo ha sido activado con éxito!";
    header("Location: ../view/menu_principal.php?prestamo&Opt=3&codigo_prestamo=".$prestamo->codigo_prestamo());
  }else{
    $_SESSION['datos']['mensaje']="¡Ocurrió un error al activar el Préstamo!";
    header("Location: ../view/menu_principal.php?prestamo&Opt=3&codigo_prestamo=".$prestamo->codigo_prestamo());
  }
}

if($lOpt=="BuscarCantidadDisponible"){
  echo $mov_inventario->BuscarCantidadDisponible($_POST['codigo_ejemplar'],$_POST['codigo_ubicacion']);
  unset($mov_inventario);
}
?>