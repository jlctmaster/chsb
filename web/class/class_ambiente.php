<?php
require_once("class_bd.php");
class ambiente {
	private $codigo_ambiente; 
	private $descripcion;
	private $tipo_ambiente; 
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_ambiente=null;
		$this->descripcion=null;
		$this->tipo_ambiente=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_ambiente(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_ambiente;

		if($Num_Parametro>0){
			$this->codigo_ambiente=func_get_arg(0);
		}
    }

    public function descripcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->descripcion;
     
		if($Num_Parametro>0){
	   		$this->descripcion=func_get_arg(0);
	 	}
    }

    public function tipo_ambiente(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->tipo_ambiente;

		if($Num_Parametro>0){
			$this->tipo_ambiente=func_get_arg(0);
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
	    $sql="INSERT INTO general.tambiente (descripcion,tipo_ambiente,creado_por,fecha_creacion) VALUES 
	    ('$this->descripcion',$this->tipo_ambiente,'$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE general.tambiente SET estatus = '1',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_ambiente=$this->codigo_ambiente";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM general.tambiente a WHERE a.codigo_ambiente = $this->codigo_ambiente AND 
    	(EXISTS (SELECT 1 FROM inventario.tubicacion u WHERE u.codigo_ambiente = a.codigo_ambiente) OR 
    	EXISTS (SELECT 1 FROM educacion.thorario h WHERE h.codigo_ambiente = a.codigo_ambiente))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE general.tambiente SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_ambiente=$this->codigo_ambiente";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE general.tambiente SET descripcion='$this->descripcion',tipo_ambiente=$this->tipo_ambiente,modificado_por='$user',fecha_modificacion=NOW() 
	    WHERE codigo_ambiente='$this->codigo_ambiente'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM general.tambiente WHERE descripcion='$this->descripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tambiente=$this->pgsql->Respuesta($query);
			$this->codigo_ambiente($tambiente['codigo_ambiente']);
			$this->descripcion($tambiente['descripcion']);
			$this->tipo_ambiente($tambiente['tipo_ambiente']);
			$this->estatus($tambiente['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
