<?php
require_once("class_bd.php");
class asignacion {
	private $codigo_asignacion; 
	private $fecha_asignacion;
	private $cedula_persona;
	private $motivo;
	private $estatus; 
	private $error; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_asignacion=null;
		$this->fecha_asignacion=null;
		$this->cedula_persona=null;
		$this->motivo=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_asignacion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_asignacion;

		if($Num_Parametro>0){
			$this->codigo_asignacion=func_get_arg(0);
		}
    }

    public function fecha_asignacion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->fecha_asignacion;
     
		if($Num_Parametro>0){
	   		$this->fecha_asignacion=func_get_arg(0);
	 	}
    }

    public function cedula_persona(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cedula_persona;

		if($Num_Parametro>0){
			$this->cedula_persona=func_get_arg(0);
		}
    }

    public function motivo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->motivo;

		if($Num_Parametro>0){
			$this->motivo=func_get_arg(0);
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

	public function EliminarAsignaciones(){
		$sql="DELETE FROM bienes_nacionales.tdetalle_asignacion WHERE codigo_asignacion='$this->codigo_asignacion'";
		if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
	}

	public function InsertarAsignaciones($user,$items,$cantidad,$ubicacion,$ubicacion_hasta){
	    $sql="INSERT INTO bienes_nacionales.tdetalle_asignacion(codigo_asignacion,codigo_item,cantidad,codigo_ubicacion,codigo_ubicacion_hasta,creado_por,fecha_creacion) VALUES ";
	    for ($i=0; $i < count($items); $i++){
	    	//	Extraemos el codigo del item y la ubicacion por cada registro
	    	$item=explode('_',$items[$i]);
	    	$codigo_item=$item[0];
	    	$ubicaciones=explode('_',$ubicacion[$i]);
	    	$codigo_ubicacion=$ubicaciones[0];
	    	$ubicaciones_hasta=explode('_',$ubicacion_hasta[$i]);
	    	$codigo_ubicacion_hasta=$ubicaciones_hasta[0];
	    	//	Fin
	    	$sql.="('$this->codigo_asignacion','$codigo_item','".$cantidad[$i]."','$codigo_ubicacion','$codigo_ubicacion_hasta','$user',NOW()),";
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
	    $sql="INSERT INTO bienes_nacionales.tasignacion (fecha_asignacion,cedula_persona,motivo,creado_por,fecha_creacion) VALUES 
	    ('$this->fecha_asignacion','$this->cedula_persona','$this->motivo','$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null){
	    	$sqlx="SELECT codigo_asignacion FROM bienes_nacionales.tasignacion 
	    	WHERE fecha_asignacion='$this->fecha_asignacion' AND cedula_persona = '$this->cedula_persona' 
	    	ORDER BY creado_por DESC LIMIT 1";
	    	$query=$this->pgsql->Ejecutar($sqlx);
	    	if($this->pgsql->Total_Filas($query)!=0){
				$tasignacion=$this->pgsql->Respuesta($query);
				$this->codigo_asignacion($tasignacion['codigo_asignacion']);
	    		return true;
			}
		    else{
		    	$this->error(pg_last_error());
		    	return false;
		    }
	    }
	    else{
	    	$this->error(pg_last_error());
	    	echo $this->error()." 1 <br>";
	    	return false;
	    }
   	}
   
    public function Activar($user){
	    $sql="UPDATE bienes_nacionales.tasignacion SET estatus = '1', modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_asignacion='$this->codigo_asignacion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
	    else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM bienes_nacionales.tasignacion a WHERE a.codigo_asignacion = '$this->codigo_asignacion' 
    	AND (EXISTS (SELECT 1 FROM bienes_nacionales.tdetalle_asignacion da WHERE a.codigo_asignacion = da.codigo_asignacion))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE bienes_nacionales.tasignacion SET estatus = '0', modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_asignacion=$this->codigo_asignacion";
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
	    $sql="UPDATE bienes_nacionales.tasignacion SET fecha_asignacion='$this->fecha_asignacion',cedula_persona='$this->cedula_persona',
	    motivo='$this->motivo',modificado_por='$user',fecha_modificacion=NOW() 
	    WHERE codigo_asignacion='$this->codigo_asignacion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
	    else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
   	}
}
?>