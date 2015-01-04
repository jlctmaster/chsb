<?php
require_once("class_bd.php");
class movimiento_inventario {
	private $codigo_movimiento;
	private $fecha_movimiento;
	private $tipo_movimiento;
	private $numero_documento;
    private $tipo_transaccion;
	private $codigo_detalle_movimiento;
	private $codigo_item;
	private $codigo_ubicacion;
	private $cantidad_movimiento;
	private $valor_anterior;
	private $valor_actual;
	private $estatus;
	private $error; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_movimiento=null;
		$this->fecha_movimiento=null;
		$this->tipo_movimiento=null;
		$this->numero_documento=null;
        $this->tipo_transaccion=null;
		$this->codigo_detalle_movimiento=null;
		$this->codigo_item=null;
		$this->codigo_ubicacion=null;
		$this->cantidad_movimiento=null;
		$this->valor_anterior=null;
		$this->valor_actual=null;
		$this->estatus=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_movimiento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_movimiento;

		if($Num_Parametro>0){
			$this->codigo_movimiento=func_get_arg(0);
		}
    }

    public function fecha_movimiento(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->fecha_movimiento;
     
		if($Num_Parametro>0){
	   		$this->fecha_movimiento=func_get_arg(0);
	 	}
    }

    public function tipo_movimiento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->tipo_movimiento;

		if($Num_Parametro>0){
			$this->tipo_movimiento=func_get_arg(0);
		}
    }

    public function numero_documento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->numero_documento;

		if($Num_Parametro>0){
			$this->numero_documento=func_get_arg(0);
		}
    }

    public function tipo_transaccion(){
        $Num_Parametro=func_num_args();
        if($Num_Parametro==0) return $this->tipo_transaccion;

        if($Num_Parametro>0){
            $this->tipo_transaccion=func_get_arg(0);
        }
    }

    public function codigo_detalle_movimiento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_detalle_movimiento;

		if($Num_Parametro>0){
			$this->codigo_detalle_movimiento=func_get_arg(0);
		}
    }

    public function codigo_item(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_item;

		if($Num_Parametro>0){
			$this->codigo_item=func_get_arg(0);
		}
    }

    public function codigo_ubicacion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_ubicacion;

		if($Num_Parametro>0){
			$this->codigo_ubicacion=func_get_arg(0);
		}
    }

    public function cantidad_movimiento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cantidad_movimiento;

		if($Num_Parametro>0){
			$this->cantidad_movimiento=func_get_arg(0);
		}
    }

    public function valor_anterior(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->valor_anterior;

		if($Num_Parametro>0){
			$this->valor_anterior=func_get_arg(0);
		}
    }

    public function valor_actual(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->valor_actual;

		if($Num_Parametro>0){
			$this->valor_actual=func_get_arg(0);
		}
    }

    public function estatus(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus;

		if($Num_Parametro>0){
			$this->estatus=func_get_arg(0);
		}
    }

    public function error(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->error;

		if($Num_Parametro>0){
			$this->error=func_get_arg(0);
		}
    }

    public function ObtenerCodigoMovimiento(){
    	$sql="SELECT codigo_movimiento FROM inventario.tmovimiento 
    	WHERE tipo_transaccion = '$this->tipo_transaccion' AND numero_documento = '$this->numero_documento' 
        AND tipo_movimiento = '$this->tipo_movimiento' 
        ORDER BY fecha_creacion DESC LIMIT 1";
    	$query=$this->pgsql->Ejecutar($sql);
   		if($row=$this->pgsql->Respuesta($query)){
   			return $row['codigo_movimiento'];
   		}
        else{
            $this->error(pg_last_error());
            return null;
        }
    }

    public function ObtenerCodigoDetMovimiento(){
    	$sql="SELECT codigo_detalle_movimiento FROM inventario.tdetalle_movimiento 
    	WHERE codigo_movimiento = '$this->codigo_movimiento' AND codigo_item = '$this->codigo_item'";
    	$query=$this->pgsql->Ejecutar($sql);
   		if($row=$this->pgsql->Respuesta($query)){
   			return $row['codigo_detalle_movimiento'];
   		}
   		else{
            $this->error(pg_last_error());
            return null;
        }
    }

    public function ObtenerValorAnterior(){
    	$sql="SELECT LAST(CASE WHEN valor_actual IS NULL THEN 0 ELSE valor_actual END) AS valor_anterior 
    	FROM inventario.tdetalle_movimiento 
    	WHERE codigo_item = '$this->codigo_item' AND codigo_ubicacion = '$this->codigo_ubicacion'
    	GROUP BY codigo_item,codigo_ubicacion";
    	$query=$this->pgsql->Ejecutar($sql);
   		if($row=$this->pgsql->Respuesta($query)){
   			return $row['valor_anterior'];
   		}
   		else{
            $this->error(pg_last_error());
            return 0;
        }
    }

    public function ObtenerValorActual($cantidad){
    	$sql="SELECT LAST(CASE '".$this->tipo_movimiento()."' 
    	WHEN 'E' THEN (CASE WHEN dm.valor_actual IS NULL THEN dm.cantidad_movimiento ELSE $cantidad+dm.valor_actual END)
    	WHEN 'S' THEN (CASE WHEN dm.valor_actual IS NULL THEN dm.cantidad_movimiento*-1 ELSE dm.valor_actual-$cantidad END)
    	ELSE 0 END) AS valor_actual 
    	FROM inventario.tmovimiento m 
    	INNER JOIN inventario.tdetalle_movimiento dm ON m.codigo_movimiento = dm.codigo_movimiento 
    	WHERE dm.codigo_item = '$this->codigo_item' AND dm.codigo_ubicacion = '$this->codigo_ubicacion'
    	GROUP BY dm.codigo_item,dm.codigo_ubicacion";
    	$query=$this->pgsql->Ejecutar($sql);
   		if($row=$this->pgsql->Respuesta($query)){
   			return $row['valor_actual'];
   		}
   		else{
            $this->error(pg_last_error());
            return 0;
        }
    }

    public function ObtenerValorActualModificado($cantidad){
        $sql="SELECT LAST(CASE '".$this->tipo_movimiento()."' 
        WHEN 'E' THEN (dm.valor_anterior+$cantidad)
        WHEN 'S' THEN (dm.valor_anterior-$cantidad)
        ELSE 0 END) AS valor_actual 
        FROM inventario.tmovimiento m 
        INNER JOIN inventario.tdetalle_movimiento dm ON m.codigo_movimiento = dm.codigo_movimiento 
        WHERE dm.codigo_item = '$this->codigo_item' AND dm.codigo_ubicacion = '$this->codigo_ubicacion'
        GROUP BY dm.codigo_item,dm.codigo_ubicacion";
        $query=$this->pgsql->Ejecutar($sql);
        if($row=$this->pgsql->Respuesta($query)){
            return $row['valor_actual'];
        }
        else{
            $this->error(pg_last_error());
            return null;
        }
    }

    public function RegistrarMovimiento($user){
    	$sql="INSERT INTO inventario.tmovimiento (fecha_movimiento,tipo_movimiento,numero_documento,tipo_transaccion,creado_por,fecha_creacion) 
    	VALUES ('$this->fecha_movimiento','$this->tipo_movimiento','$this->numero_documento','$this->tipo_transaccion','$user',NOW())";
    	if($this->pgsql->Ejecutar($sql)!=null)
    		return true;
    	else{
            $this->error(pg_last_error());
            return false;
        }
    }

    public function RegistrarDetalleMovimiento($user){
    	$sql="INSERT INTO inventario.tdetalle_movimiento (codigo_movimiento,codigo_item,codigo_ubicacion,cantidad_movimiento,valor_anterior,valor_actual,creado_por,fecha_creacion) 
    	VALUES ('$this->codigo_movimiento','$this->codigo_item','$this->codigo_ubicacion','$this->cantidad_movimiento','$this->valor_anterior','$this->valor_actual','$user',NOW())";
    	if($this->pgsql->Ejecutar($sql)!=null){
            return true;
        }
    	else{
            $this->error(pg_last_error());
            return false;
        }
    }

    public function ModificarMovimiento($user){
    	$sql="UPDATE inventario.tmovimiento SET fecha_movimiento='$this->fecha_movimiento',tipo_movimiento='$this->tipo_movimiento',
        tipo_transaccion='$this->tipo_transaccion',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_movimiento = '$this->codigo_movimiento'";
    	if($this->pgsql->Ejecutar($sql)!=null)
    		return true;
    	else{
            $this->error(pg_last_error());
            return false;
        }
    }

    public function ModificarDetalleMovimiento($user){
    	$sql="UPDATE inventario.tdetalle_movimiento SET codigo_item='$this->codigo_item',codigo_ubicacion='$this->codigo_ubicacion',
        cantidad_movimiento='$this->cantidad_movimiento',valor_actual='$this->valor_actual',modificado_por='$user',fecha_modificacion=NOW() 
    	WHERE codigo_detalle_movimiento ='$this->codigo_detalle_movimiento'";
    	if($this->pgsql->Ejecutar($sql)!=null)
    		return true;
    	else{
            $this->error(pg_last_error());
            return false;
        }
    }

    public function BuscarCantidadDisponible($item,$ubicacion){
        $sql="SELECT * FROM inventario.vw_inventario WHERE codigo_ubicacion = '$ubicacion' AND codigo_item = '$item'";
        $query = $this->pgsql->Ejecutar($sql);
        while($Obj=$this->pgsql->Respuesta_assoc($query)){
            $rows[]=array_map("html_entity_decode",$Obj);
        }
        if(!empty($rows)){
            $json = json_encode($rows);
        }
        else{
            $rows[] = array("msj" => "Error al Buscar Registros ");
            $json = json_encode($rows);
        }
        return $json;
    }

    public function BuscarItems($ubicacion){
        $sql="SELECT * FROM inventario.vw_inventario WHERE codigo_ubicacion = '$ubicacion'";
        $query = $this->pgsql->Ejecutar($sql);
        while($Obj=$this->pgsql->Respuesta_assoc($query)){
            $rows[]=array_map("html_entity_decode",$Obj);
        }
        if(!empty($rows)){
            $json = json_encode($rows);
        }
        else{
            $rows[] = array("msj" => "Error al Buscar Registros ");
            $json = json_encode($rows);
        }
        return $json;
    }

    public function BuscarItemsConfigurables($ubicacion){
        $sql="SELECT i.codigo_ubicacion,i.ubicacion,i.codigo_item,i.item,i.sonlibros,i.existencia 
        FROM inventario.vw_inventario i 
        INNER JOIN bienes_nacionales.tbien b ON i.codigo_item = b.codigo_bien 
        WHERE i.codigo_ubicacion = '$ubicacion' AND i.sonlibros = 'N' AND b.esconfigurable='Y'";
        $query = $this->pgsql->Ejecutar($sql);
        while($Obj=$this->pgsql->Respuesta_assoc($query)){
            $rows[]=array_map("html_entity_decode",$Obj);
        }
        if(!empty($rows)){
            $json = json_encode($rows);
        }
        else{
            $rows[] = array("msj" => "Error al Buscar Registros ");
            $json = json_encode($rows);
        }
        return $json;
    }

    public function BuscarConfiguracion($item,$cantidad){
        $sql="SELECT i.codigo_item,i.item,cb.codigo_item AS codigo_item_recuperado,
        b.nro_serial||' '||b.nombre AS item_recuperado,b.esconfigurable,
        u.codigo_ubicacion,u.descripcion AS ubicacion,
        MAX($cantidad) AS cantidad_a_recuperar,MAX($cantidad*cb.cantidad) AS cantidad_recuperada
        FROM inventario.vw_inventario i 
        INNER JOIN bienes_nacionales.tconfiguracion_bien cb ON i.codigo_item = cb.codigo_bien 
        INNER JOIN bienes_nacionales.tbien b ON cb.codigo_item = b.codigo_bien,
        inventario.tubicacion u 
        WHERE i.codigo_item = $item AND i.sonlibros='N' AND u.ubicacionprincipal = 'Y'
        GROUP BY i.codigo_item,i.item,cb.codigo_item,b.nro_serial,b.nombre,b.esconfigurable,cb.item_base,
        u.codigo_ubicacion,u.descripcion 
        ORDER BY cb.item_base DESC";
        $query = $this->pgsql->Ejecutar($sql);
        while($Obj=$this->pgsql->Respuesta_assoc($query)){
            $rows[]=array_map("html_entity_decode",$Obj);
        }
        if(!empty($rows)){
            $json = json_encode($rows);
        }
        else{
            $rows[] = array("msj" => "Error al Buscar Registros ");
            $json = json_encode($rows);
        }
        return $json;
    }

    public function BuscarDisponibilidad($item){
        $sql="SELECT i.codigo_item,i.item,cb.codigo_item AS codigo_item_recuperado,
        b.nro_serial||' '||b.nombre AS item_recuperado,b.esconfigurable,
        u.codigo_ubicacion,u.descripcion AS ubicacion,
        MAX($cantidad) AS cantidad_a_recuperar,MAX($cantidad*cb.cantidad) AS cantidad_recuperada
        FROM inventario.vw_inventario i 
        INNER JOIN bienes_nacionales.tconfiguracion_bien cb ON i.codigo_item = cb.codigo_bien 
        INNER JOIN bienes_nacionales.tbien b ON cb.codigo_item = b.codigo_bien,
        inventario.tubicacion u 
        WHERE i.codigo_item = $item AND i.sonlibros='N' AND u.ubicacionprincipal = 'Y'
        GROUP BY i.codigo_item,i.item,cb.codigo_item,b.nro_serial,b.nombre,b.esconfigurable,cb.item_base,
        u.codigo_ubicacion,u.descripcion 
        ORDER BY cb.item_base DESC";
        $query = $this->pgsql->Ejecutar($sql);
        while($Obj=$this->pgsql->Respuesta_assoc($query)){
            $rows[]=array_map("html_entity_decode",$Obj);
        }
        if(!empty($rows)){
            $json = json_encode($rows);
        }
        else{
            $rows[] = array("msj" => "Error al Buscar Registros ");
            $json = json_encode($rows);
        }
        return $json;
    }
}
?>