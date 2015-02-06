<?php
require_once("class_bd.php");
class ano_academico {
	private $codigo_ano_academico; 
	private $ano;
	private $estatus; 
	private $cerrado; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_ano_academico=null;
		$this->ano=null;
		$this->estatus=null;
		$this->cerrado=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_ano_academico(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_ano_academico;

		if($Num_Parametro>0){
			$this->codigo_ano_academico=func_get_arg(0);
		}
    }

    public function ano(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->ano;
     
		if($Num_Parametro>0){
	   		$this->ano=func_get_arg(0);
	 	}
    }
  
    public function estatus(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus;

		if($Num_Parametro>0){
			$this->estatus=func_get_arg(0);
		}
    }
  
    public function cerrado(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cerrado;

		if($Num_Parametro>0){
			$this->cerrado=func_get_arg(0);
		}
    }

    public function Cerrar(){
    	$sql="UPDATE educacion.tano_academico SET cerrado='Y' WHERE ano <> '$this->ano'";
    	if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
    }
   
   	public function Registrar($user){
	    $sql="INSERT INTO educacion.tano_academico (ano,creado_por,fecha_creacion) VALUES 
	    ('$this->ano','$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE educacion.tano_academico SET estatus = '1',modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_ano_academico='$this->codigo_ano_academico'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM educacion.tano_academico WHERE codigo_ano_academico = '$this->codigo_ano_academico'";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE educacion.tano_academico SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_ano_academico='$this->codigo_ano_academico'";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE educacion.tano_academico SET ano='$this->ano',cerrado='$this->cerrado',modificado_por='$user',fecha_modificacion=NOW() 
	    WHERE codigo_ano_academico='$this->codigo_ano_academico'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM educacion.tano_academico WHERE ano='$this->ano'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tano_academico=$this->pgsql->Respuesta($query);
			$this->codigo_ano_academico($tano_academico['codigo_ano_academico']);
			$this->ano($tano_academico['ano']);
			$this->estatus($tano_academico['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
