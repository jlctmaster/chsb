<?php
require_once("class_bd.php");
class tipobien {
	private $codigo_tipo_bien; 
	private $descripcion;
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_tipo_bien=null;
		$this->descripcion=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_tipo_bien(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_tipo_bien;

		if($Num_Parametro>0){
			$this->codigo_tipo_bien=func_get_arg(0);
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
	    $sql="INSERT INTO bienes_nacionales.ttipo_bien (descripcion,creado_por,fecha_creacion) VALUES 
	    ('$this->descripcion','$user',NOW())";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE bienes_nacionales.ttipo_bien SET estatus = '1',modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_tipo_bien='$this->codigo_tipo_bien'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM bienes_nacionales.ttipo_bien p WHERE p.codigo_tipo_bien = '$this->codigo_tipo_bien' 
    	AND EXISTS (SELECT 1 FROM bienes_nacionales.testado e WHERE e.codigo_tipo_bien = p.codigo_tipo_bien)";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE bienes_nacionales.ttipo_bien SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_tipo_bien='$this->codigo_tipo_bien'";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE bienes_nacionales.ttipo_bien SET descripcion='$this->descripcion',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_tipo_bien='$this->codigo_tipo_bien'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM bienes_nacionales.ttipo_bien WHERE descripcion='$this->descripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$ttipo_bien=$this->pgsql->Respuesta($query);
			$this->codigo_tipo_bien($ttipo_bien['codigo_tipo_bien']);
			$this->descripcion($ttipo_bien['descripcion']);
			$this->estatus($ttipo_bien['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
