<?php
require_once("class_bd.php");
	class configuracion_bien {
	private $codigo_configuracion_bien;
	private $codigo_bien;  
	private $codigo_item;
	private $cantidad;
	private $item_base;
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_configuracion_bien=null;
		$this->codigo_bien=null;
		$this->codigo_item=null;
		$this->cantidad=null;
		$this->item_base=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_configuracion_bien(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_configuracion_bien;

		if($Num_Parametro>0){
			$this->codigo_configuracion_bien=func_get_arg(0);
		}
    }
        public function codigo_bien(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_bien;

		if($Num_Parametro>0){
			$this->codigo_bien=func_get_arg(0);
		}
    }

    public function codigo_item(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_item;
     
		if($Num_Parametro>0){
	   		$this->codigo_item=func_get_arg(0);
	 	}
    }

    public function cantidad(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cantidad;

		if($Num_Parametro>0){
			$this->cantidad=func_get_arg(0);
		}
    }

    public function item_base(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->item_base;

		if($Num_Parametro>0){
			$this->item_base=func_get_arg(0);
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
	    $sql="INSERT INTO bienes_nacionales.tconfiguracion_bien (codigo_bien,codigo_item,cantidad,item_base,creado_por,fecha_creacion) VALUES 
	    ('$this->codigo_bien','$this->codigo_item','$this->cantidad','$this->item_base','$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE bienes_nacionales.tconfiguracion_bien SET estatus = '1', modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_configuracion_bien='$this->codigo_configuracion_bien'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM bienes_nacionales.tconfiguracion_bien cb WHERE cb.codigo_configuracion_bien ='$this->codigo_configuracion_bien' 
    	AND (EXISTS (SELECT 1 FROM bienes_nacionales.tbien b WHERE b.codigo_configuracion_bien = cb.codigo_configuracion_bien))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE bienes_nacionales.tconfiguracion_bien SET estatus = '0', modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_configuracion_bien='$this->codigo_configuracion_bien'";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE bienes_nacionales.tconfiguracion_bien SET codigo_bien='$this->codigo_bien', codigo_item='$this->codigo_item',cantidad='$this->cantidad', item_base='$this->item_base',
	    modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_configuracion_bien='$this->codigo_configuracion_bien'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM bienes_nacionales.tconfiguracion_bien WHERE item_base='$this->item_base'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tconfiguacion_bien=$this->pgsql->Respuesta($query);
			$this->codigo_configuracion_bien($tconfiguacion_bien['codigo_configuracion_bien']);
			$this->codigo_bien($tconfiguacion_bien['codigo_bien']);
			$this->codigo_item($tconfiguacion_bien['codigo_item']);
			$this->cantidad($tconfiguacion_bien['cantidad']);
			$this->item_base($tconfiguacion_bien['item_base']);
			$this->estatus($tconfiguacion_bien['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
