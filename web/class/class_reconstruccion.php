<?php
require_once("class_bd.php");
class recuperacion {
	private $codigo_recuperacion; 
	private $fecha;
	private $cedula_persona;
	private $codigo_ubicacion;
	private $codigo_bien;
	private $cantidad;
	private $estatus; 
	private $error; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_recuperacion=null;
		$this->fecha=null;
		$this->cedula_persona=null;
		$this->codigo_ubicacion=null;
		$this->codigo_bien=null;
		$this->cantidad=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_recuperacion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_recuperacion;

		if($Num_Parametro>0){
			$this->codigo_recuperacion=func_get_arg(0);
		}
    }

    public function fecha(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->fecha;
     
		if($Num_Parametro>0){
	   		$this->fecha=func_get_arg(0);
	 	}
    }

    public function cedula_persona(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cedula_persona;

		if($Num_Parametro>0){
			$this->cedula_persona=func_get_arg(0);
		}
    }

    public function codigo_ubicacion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_ubicacion;

		if($Num_Parametro>0){
			$this->codigo_ubicacion=func_get_arg(0);
		}
    }

    public function codigo_bien(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_bien;

		if($Num_Parametro>0){
			$this->codigo_bien=func_get_arg(0);
		}
    }

    public function cantidad(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cantidad;

		if($Num_Parametro>0){
			$this->cantidad=func_get_arg(0);
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

	public function EliminarRecuperaciones(){
		$sql="DELETE FROM bienes_nacionales.tdetalle_recuperacion WHERE codigo_recuperacion='$this->codigo_recuperacion'";
		if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
	}

	public function InsertarRecuperaciones($user,$items,$cantidad,$ubicacion){
	    $sql="INSERT INTO bienes_nacionales.tdetalle_recuperacion(codigo_recuperacion,codigo_item,cantidad,codigo_ubicacion,creado_por,fecha_creacion) VALUES ";
	    for ($i=0; $i < count($items); $i++){
	    	$sql.="('$this->codigo_recuperacion','".$items[$i]."','".$cantidad[$i]."','".$ubicacion[$i]."','$user',NOW()),";
	    }
	    $sql=substr($sql,0,-1);
	    $sql=$sql.";";
	    if($this->pgsql->Ejecutar($sql)!=null)
	      return true;
	    else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
    }
   
   	public function Registrar($user){
	    $sql="INSERT INTO bienes_nacionales.trecuperacion (fecha,codigo_bien,codigo_ubicacion,cedula_persona,cantidad,esrecuperacion,creado_por,fecha_creacion) VALUES 
	    ('$this->fecha','$this->codigo_bien','$this->codigo_ubicacion','$this->cedula_persona','$this->cantidad','N','$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null){
	    	$sqlx="SELECT codigo_recuperacion FROM bienes_nacionales.trecuperacion 
	    	WHERE fecha='$this->fecha' AND codigo_ubicacion = '$this->codigo_ubicacion' 
	    	AND cedula_persona = '$this->cedula_persona' AND codigo_bien = '$this->codigo_bien' AND cantidad = '$this->cantidad'";
	    	$query=$this->pgsql->Ejecutar($sqlx);
	    	if($this->pgsql->Total_Filas($query)!=0){
				$trecuperacion=$this->pgsql->Respuesta($query);
				$this->codigo_recuperacion($trecuperacion['codigo_recuperacion']);
	    		return true;
			}
		    else{
		    	$this->error(pg_last_error());
		    	return false;
		    }
	    }
	    else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
   	}
   
    public function Activar($user){
	    $sql="UPDATE bienes_nacionales.trecuperacion SET estatus = '1', modificado_por='$user', fecha_modificacion=NOW() 
	    WHERE codigo_recuperacion='$this->codigo_recuperacion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
	    else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM bienes_nacionales.trecuperacion r WHERE r.codigo_recuperacion = '$this->codigo_recuperacion' 
    	AND (EXISTS (SELECT 1 FROM bienes_nacionales.tdetalle_recuperacion dr WHERE r.codigo_recuperacion = dr.codigo_recuperacion) 
    	OR (EXISTS (SELECT 1 FROM inventario.tmovimiento m WHERE r.codigo_recuperacion = m.numero_documento AND tipo_transaccion = 'BR')))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE bienes_nacionales.trecuperacion SET estatus = '0', modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_recuperacion=$this->codigo_recuperacion";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
		    else{
		    	$this->error(pg_last_error());
		    	return false;
		    }
		}
	    else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE bienes_nacionales.trecuperacion SET fecha='$this->fecha',codigo_bien='$this->codigo_bien',
	    codigo_ubicacion='$this->codigo_ubicacion',cedula_persona='$this->cedula_persona',cantidad='$this->cantidad',
	    modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_recuperacion='$this->codigo_recuperacion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
	    else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
   	}
}
?>
