<?php
require_once("class_bd.php");
class ubicacion {
	private $codigo_ubicacion; 
	private $descripcion;
	private $codigo_ambiente; 
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_ubicacion=null;
		$this->descripcion=null;
		$this->codigo_ambiente=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_ubicacion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_ubicacion;

		if($Num_Parametro>0){
			$this->codigo_ubicacion=func_get_arg(0);
		}
    }

    public function descripcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->descripcion;
     
		if($Num_Parametro>0){
	   		$this->descripcion=func_get_arg(0);
	 	}
    }

    public function codigo_ambiente(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_ambiente;

		if($Num_Parametro>0){
			$this->codigo_ambiente=func_get_arg(0);
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
	    $sql="INSERT INTO inventario.tubicacion (descripcion,codigo_ambiente,creado_por,fecha_creacion) VALUES 
	    ('$this->descripcion',$this->codigo_ambiente,'$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE inventario.tubicacion SET estatus = '1',modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_ubicacion=$this->codigo_ubicacion";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM inventario.tubicacion u WHERE u.codigo_ubicacion = $this->codigo_ubicacion 
    	AND (EXISTS (SELECT 1 FROM inventario.tdetalle_adquisicion da WHERE u.codigo_ubicacion = da.codigo_ubicacion) OR 
    	EXISTS (SELECT 1 FROM inventario.tdetalle_movimiento dm WHERE u.codigo_ubicacion = dm.codigo_ubicacion))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE inventario.tubicacion SET estatus = '0',modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_ubicacion=$this->codigo_ubicacion";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE inventario.tubicacion SET descripcion='$this->descripcion',codigo_ambiente=$this->codigo_ambiente,
	    modificado_por='$user', fecha_modificacion=NOW() 
	    WHERE codigo_ubicacion='$this->codigo_ubicacion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM inventario.tubicacion WHERE descripcion='$this->descripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tubicacion=$this->pgsql->Respuesta($query);
			$this->codigo_ubicacion($tubicacion['codigo_ubicacion']);
			$this->descripcion($tubicacion['descripcion']);
			$this->codigo_ambiente($tubicacion['codigo_ambiente']);
			$this->estatus($tubicacion['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
