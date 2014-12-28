<?php
require_once("class_bd.php");
class area {
	private $codigo_area; 
	private $descripcion;
	private $codigo_departamento; 
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_area=null;
		$this->descripcion=null;
		$this->codigo_departamento=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_area(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_area;

		if($Num_Parametro>0){
			$this->codigo_area=func_get_arg(0);
		}
    }

    public function descripcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->descripcion;
     
		if($Num_Parametro>0){
	   		$this->descripcion=func_get_arg(0);
	 	}
    }

    public function codigo_departamento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_departamento;

		if($Num_Parametro>0){
			$this->codigo_departamento=func_get_arg(0);
		}
    }

    public function estatus(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus;

		if($Num_Parametro>0){
			$this->estatus=func_get_arg(0);
		}
    }
   
   	public function Registrar($user){
	    $sql="INSERT INTO general.tarea (descripcion,codigo_departamento,creado_por,fecha_creacion) VALUES 
	    ('$this->descripcion',$this->codigo_departamento,'$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE general.tarea SET estatus = '1',modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_area=$this->codigo_area";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM general.tarea a WHERE a.codigo_area = $this->codigo_area 
    	AND (EXISTS (SELECT 1 FROM biblioteca.tprestamo p WHERE p.codigo_area = a.codigo_area))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE general.tarea SET estatus = '0',modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_area=$this->codigo_area";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE general.tarea SET descripcion='$this->descripcion',codigo_departamento=$this->codigo_departamento,
	    modificado_por='$user', fecha_modificacion=NOW() 
	    WHERE codigo_area='$this->codigo_area'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM general.tarea WHERE descripcion='$this->descripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tarea=$this->pgsql->Respuesta($query);
			$this->codigo_area($tarea['codigo_area']);
			$this->descripcion($tarea['descripcion']);
			$this->codigo_departamento($tarea['codigo_departamento']);
			$this->estatus($tarea['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
