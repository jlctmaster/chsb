<?php
require_once("class_bd.php");
class sistema {
	private $rif_negocio; 
	private $nombre;
	private $telefono; 
	private $email; 
	private $clave_email; 
	private $direccion; 
	private $mision; 
	private $vision; 
	private $objetivo; 
	private $historia;
	private $codigo_parroquia; 
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->rif_negocio=null;
		$this->nombre=null;
		$this->telefono=null;
		$this->email=null;
		$this->clave_email=null;
		$this->direccion=null;
		$this->mision=null;
		$this->vision=null;
		$this->objetivo=null;
		$this->historia=null;
		$this->codigo_parroquia=null;
		$this->estatus=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function rif_negocio(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->rif_negocio;

		if($Num_Parametro>0){
			$this->rif_negocio=func_get_arg(0);
		}
    }

    public function nombre(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nombre;
     
		if($Num_Parametro>0){
	   		$this->nombre=func_get_arg(0);
	 	}
    }

    public function telefono(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->telefono;

		if($Num_Parametro>0){
			$this->telefono=func_get_arg(0);
		}
    }

    public function email(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->email;

		if($Num_Parametro>0){
			$this->email=func_get_arg(0);
		}
    }

    public function clave_email(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->clave_email;

		if($Num_Parametro>0){
			$this->clave_email=func_get_arg(0);
		}
    }

    public function direccion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->direccion;

		if($Num_Parametro>0){
			$this->direccion=func_get_arg(0);
		}
    }

    public function mision(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->mision;

		if($Num_Parametro>0){
			$this->mision=func_get_arg(0);
		}
    }

    public function vision(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->vision;

		if($Num_Parametro>0){
			$this->vision=func_get_arg(0);
		}
    }

    public function objetivo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->objetivo;

		if($Num_Parametro>0){
			$this->objetivo=func_get_arg(0);
		}
    }

    public function historia(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->historia;

		if($Num_Parametro>0){
			$this->historia=func_get_arg(0);
		}
    }

    public function codigo_parroquia(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_parroquia;

		if($Num_Parametro>0){
			$this->codigo_parroquia=func_get_arg(0);
		}
    }

    public function estatus(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus;

		if($Num_Parametro>0){
			$this->estatus=func_get_arg(0);
		}
    }

    public function Actualizar($user,$oldrif){
	    $sql="UPDATE seguridad.tsistema SET rif_negocio='$this->rif_negocio',nombre='$this->nombre',telefono='$this->telefono'
	    ,email='$this->email',clave_email='$this->clave_email',direccion='$this->direccion',mision='$this->mision',vision='$this->vision'
	    ,objetivo='$this->objetivo',historia='$this->historia',codigo_parroquia=$this->codigo_parroquia,modificado_por='$user',fecha_modificacion=NOW()
	    WHERE rif_negocio='$oldrif'";
	    //echo $sql; die();
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
}
?>
