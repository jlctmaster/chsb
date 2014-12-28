<?php
require_once("class_bd.php");
class estado {
	private $codigo_estado; 
	private $descripcion;
	private $codigo_pais; 
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_estado=null;
		$this->descripcion=null;
		$this->codigo_pais=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_estado(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_estado;

		if($Num_Parametro>0){
			$this->codigo_estado=func_get_arg(0);
		}
    }

    public function descripcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->descripcion;
     
		if($Num_Parametro>0){
	   		$this->descripcion=func_get_arg(0);
	 	}
    }

    public function codigo_pais(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_pais;

		if($Num_Parametro>0){
			$this->codigo_pais=func_get_arg(0);
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
	    $sql="INSERT INTO general.testado (descripcion,codigo_pais,creado_por,fecha_creacion) VALUES 
	    ('$this->descripcion',$this->codigo_pais,'$user',NOW())";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE general.testado SET estatus = '1',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_estado=$this->codigo_estado";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM general.testado e WHERE codigo_estado = $this->codigo_estado 
    	AND (EXISTS (SELECT 1 FROM general.tmunicipio m WHERE m.codigo_estado = e.codigo_estado))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE general.testado SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_estado=$this->codigo_estado";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE general.testado SET descripcion='$this->descripcion',codigo_pais=$this->codigo_pais,modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_estado='$this->codigo_estado'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM general.testado WHERE descripcion='$this->descripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$testado=$this->pgsql->Respuesta($query);
			$this->codigo_estado($testado['codigo_estado']);
			$this->descripcion($testado['descripcion']);
			$this->codigo_pais($testado['codigo_pais']);
			$this->estatus($testado['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
