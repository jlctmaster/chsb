<?php
require_once("class_bd.php");
class departamento {
	private $codigo_departamento; 
	private $descripcion;
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_departamento=null;
		$this->descripcion=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_departamento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_departamento;

		if($Num_Parametro>0){
			$this->codigo_departamento=func_get_arg(0);
		}
    }

    public function descripcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->descripcion;
     
		if($Num_Parametro>0){
	   		$this->descripcion=func_get_arg(0);
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
	    $sql="INSERT INTO general.tdepartamento (descripcion,creado_por,fecha_creacion) VALUES 
	    ('$this->descripcion','$user',NOW())";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE general.tdepartamento SET estatus = '1',modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_departamento=$this->codigo_departamento";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM general.tdepartamento d WHERE d.codigo_departamento = $this->codigo_departamento 
    	AND EXISTS (SELECT 1 FROM general.tarea a WHERE a.codigo_departamento = d.codigo_departamento)";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE general.tdepartamento SET estatus = '0', modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_departamento=$this->codigo_departamento";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE general.tdepartamento SET descripcion='$this->descripcion', modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_departamento='$this->codigo_departamento'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM general.tdepartamento WHERE descripcion='$this->descripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tdepartamento=$this->pgsql->Respuesta($query);
			$this->codigo_departamento($tdepartamento['codigo_departamento']);
			$this->descripcion($tdepartamento['descripcion']);
			$this->estatus($tdepartamento['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
