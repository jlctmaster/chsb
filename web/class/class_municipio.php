<?php
require_once("class_bd.php");
class municipio {
	private $codigo_municipio; 
	private $descripcion;
	private $codigo_estado; 
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_municipio=null;
		$this->descripcion=null;
		$this->codigo_estado=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_municipio(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_municipio;

		if($Num_Parametro>0){
			$this->codigo_municipio=func_get_arg(0);
		}
    }

    public function descripcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->descripcion;
     
		if($Num_Parametro>0){
	   		$this->descripcion=func_get_arg(0);
	 	}
    }

    public function codigo_estado(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_estado;

		if($Num_Parametro>0){
			$this->codigo_estado=func_get_arg(0);
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
	    $sql="INSERT INTO general.tmunicipio (descripcion,codigo_estado,creado_por,fecha_creacion) VALUES 
	    ('$this->descripcion',$this->codigo_estado,'$user',NOW())";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE general.tmunicipio SET estatus = '1',modificado_por='$user',fecha_modificacion=NOW()  WHERE codigo_municipio=$this->codigo_municipio";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM general.tmunicipio m WHERE m.codigo_municipio = $this->codigo_municipio 
    	AND (EXISTS (SELECT 1 FROM general.tparroquia p WHERE p.codigo_municipio = m.codigo_municipio))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE general.tmunicipio SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_municipio=$this->codigo_municipio";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE general.tmunicipio SET descripcion='$this->descripcion',codigo_estado=$this->codigo_estado,modificado_por='$user' 
	    WHERE codigo_municipio='$this->codigo_municipio'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

	public function Comprobar($comprobar){
	    if($comprobar==true){
		    $sql="SELECT * FROM general.tmunicipio WHERE descripcion='$this->descripcion'";
			$query=$this->pgsql->Ejecutar($sql);
		    if($this->pgsql->Total_Filas($query)!=0){
				$tmunicipio=$this->pgsql->Respuesta($query);
				$this->estatus($tmunicipio['estatus']);
				return true;
			}
			else{
				return false;
			}
	    }else
	      return false;
   	}
}
?>
