<?php
require_once("class_bd.php");
class asignacion_libro {
	private $codigo_asignacion_libro; 
	private $fecha_asignacion;
	private $cedula_persona;
	private $motivo;
	private $estatus; 
	private $error; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_asignacion_libro=null;
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

    public function codigo_asignacion_libro(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_asignacion_libro;

		if($Num_Parametro>0){
			$this->codigo_asignacion_libro=func_get_arg(0);
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
		$sql="DELETE FROM biblioteca.tdetalle_asignacion_libro WHERE codigo_asignacion_libro='$this->codigo_asignacion_libro'";
		if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
	}

	public function InsertarAsignaciones($user,$items,$cantidad,$ubicacion,$ubicacion_hasta){
	    $sql="INSERT INTO biblioteca.tdetalle_asignacion_libro(codigo_asignacion_libro,codigo_item,cantidad,codigo_ubicacion,codigo_ubicacion_hasta,creado_por,fecha_creacion) VALUES ";
	    for ($i=0; $i < count($items); $i++){
	    	$sql.="('$this->codigo_asignacion_libro','".$items[$i]."','".$cantidad[$i]."','".$ubicacion[$i]."','".$ubicacion_hasta[$i]."','$user',NOW()),";
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
	    $sql="INSERT INTO biblioteca.tasignacion_libro (fecha_asignacion,cedula_persona,motivo,creado_por,fecha_creacion) VALUES 
	    ('$this->fecha_asignacion','$this->cedula_persona','$this->motivo','$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null){
	    	$sqlx="SELECT codigo_asignacion_libro FROM biblioteca.tasignacion_libro 
	    	WHERE fecha_asignacion='$this->fecha_asignacion' AND cedula_persona = '$this->cedula_persona' 
	    	ORDER BY creado_por DESC LIMIT 1";
	    	$query=$this->pgsql->Ejecutar($sqlx);
	    	if($this->pgsql->Total_Filas($query)!=0){
				$tasignacion=$this->pgsql->Respuesta($query);
				$this->codigo_asignacion_libro($tasignacion['codigo_asignacion_libro']);
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
	    $sql="UPDATE biblioteca.tasignacion_libro SET estatus = '1', modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_asignacion_libro='$this->codigo_asignacion_libro'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
	    else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM biblioteca.tasignacion_libro a WHERE a.codigo_asignacion_libro = '$this->codigo_asignacion_libro' 
    	AND (EXISTS (SELECT 1 FROM biblioteca.tdetalle_asignacion_libro da WHERE a.codigo_asignacion_libro = da.codigo_asignacion_libro))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE biblioteca.tasignacion_libro SET estatus = '0', modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_asignacion_libro=$this->codigo_asignacion_libro";
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
	    $sql="UPDATE biblioteca.tasignacion_libro SET fecha_asignacion='$this->fecha_asignacion',cedula_persona='$this->cedula_persona',
	    motivo='$this->motivo',modificado_por='$user',fecha_modificacion=NOW() 
	    WHERE codigo_asignacion_libro='$this->codigo_asignacion_libro'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
	    else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
   	}
}
?>