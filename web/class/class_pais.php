<?php
require_once("class_bd.php");
class pais {
	private $codigo_pais; 
	private $descripcion;
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_pais=null;
		$this->descripcion=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_pais(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_pais;

		if($Num_Parametro>0){
			$this->codigo_pais=func_get_arg(0);
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
	    $sql="INSERT INTO general.tpais (descripcion,creado_por,fecha_creacion) VALUES 
	    ('$this->descripcion','$user',NOW())";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE general.tpais SET estatus = '1',modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_pais=$this->codigo_pais";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM general.tpais p WHERE p.codigo_pais = $this->codigo_pais 
    	AND EXISTS (SELECT 1 FROM general.testado e WHERE e.codigo_pais = p.codigo_pais)";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE general.tpais SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_pais=$this->codigo_pais";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE general.tpais SET descripcion='$this->descripcion',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_pais='$this->codigo_pais'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

	public function Comprobar($comprobar){
	    if($comprobar==true){
		    $sql="SELECT * FROM general.tpais WHERE descripcion='$this->descripcion'";
			$query=$this->pgsql->Ejecutar($sql);
		    if($this->pgsql->Total_Filas($query)!=0){
				$tpais=$this->pgsql->Respuesta($query);
				$this->estatus($tpais['estatus']);
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
