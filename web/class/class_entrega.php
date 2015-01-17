<?php
require_once("class_bd.php");
class entrega {
	private $codigo_entrega; 
	private $codigo_prestamo;
	private $cedula_responsable;
	private $cedula_persona;
	private $fecha_entrada;
	private $cantidad;
	private $estatus; 
	private $error; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_entrega=null;
		$this->codigo_prestamo=null;
		$this->cedula_responsable=null;
		$this->cedula_persona=null;
		$this->fecha_entrada=null;
		$this->cantidad=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_entrega(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_entrega;

		if($Num_Parametro>0){
			$this->codigo_entrega=func_get_arg(0);
		}
    }

    public function codigo_prestamo(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_prestamo;
     
		if($Num_Parametro>0){
	   		$this->codigo_prestamo=func_get_arg(0);
	 	}
    }

    public function cedula_responsable(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cedula_responsable;

		if($Num_Parametro>0){
			$this->cedula_responsable=func_get_arg(0);
		}
    }

    public function cedula_persona(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cedula_persona;

		if($Num_Parametro>0){
			$this->cedula_persona=func_get_arg(0);
		}
    }

    public function fecha_entrada(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->fecha_entrada;

		if($Num_Parametro>0){
			$this->fecha_entrada=func_get_arg(0);
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

	public function EliminarEntregas(){
		$sql="DELETE FROM biblioteca.tdetalle_entrega WHERE codigo_entrega='$this->codigo_entrega'";
		if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
	}

	public function InsertarEntregas($user,$ejemplar,$cantidad,$ubicacion){
	    $sql="INSERT INTO biblioteca.tdetalle_entrega(codigo_entrega,codigo_ubicacion,codigo_ejemplar,cantidad,creado_por,fecha_creacion) VALUES ";
	    for ($i=0; $i < count($ejemplar); $i++){
	    	$sql.="('$this->codigo_entrega','".$ejemplar[$i]."','".$ubicacion[$i]."','".$cantidad[$i]."','$user',NOW()),";
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
	    $sql="INSERT INTO biblioteca.tentrega (codigo_prestamo,cedula_responsable,cedula_persona,fecha_entrada,cantidad,creado_por,fecha_creacion) VALUES 
	    ('$this->codigo_prestamo','$this->cedula_responsable','$this->cedula_persona','$this->fecha_entrada','$this->cantidad','$user',NOW());";
	    echo $sql; die();
	    if($this->pgsql->Ejecutar($sql)!=null){
	    	$sqlx="SELECT codigo_entrega FROM biblioteca.tentrega 
	    	WHERE codigo_prestamo='$this->codigo_prestamo' AND cedula_persona = '$this->cedula_persona' 
	    	ORDER BY creado_por DESC LIMIT 1";
	    	$query=$this->pgsql->Ejecutar($sqlx);
	    	if($this->pgsql->Total_Filas($query)!=0){
				$tentrega=$this->pgsql->Respuesta($query);
				$this->codigo_entrega($tentrega['codigo_entrega']);
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
	    $sql="UPDATE biblioteca.tentrega SET estatus = '1', modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_entrega='$this->codigo_entrega'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
	    else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM biblioteca.tentrega a WHERE a.codigo_entrega = '$this->codigo_entrega' 
    	AND (EXISTS (SELECT 1 FROM biblioteca.tdetalle_entrega da WHERE a.codigo_entrega = da.codigo_entrega))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE biblioteca.tentrega SET estatus = '0', modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_entrega=$this->codigo_entrega";
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
	    $sql="UPDATE biblioteca.tentrega SET codigo_prestamo='$this->codigo_prestamo',cedula_responsable='$this->cedula_responsable',
	    cedula_persona='$this->cedula_persona',fecha_entrada='$this->fecha_entrada',cantidad='$this->cantidad',
	    modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_entrega='$this->codigo_entrega'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
	    else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
   	}
}
?>