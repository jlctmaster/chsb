<?php
require_once("class_bd.php");
class Combovalor{
	private $nid_combovalor; 
	private $ctabla;
	private $cdescripcion;
	private $dfecha_desactivacion; 
	private $estatus_combovalor; 
	private $pgsql; 
	 
	public function __construct(){
		$this->ctabla=null;
		$this->cdescripcion=null;
		$this->nid_combovalor=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function nid_combovalor(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nid_combovalor;

		if($Num_Parametro>0){
			$this->nid_combovalor=func_get_arg(0);
		}
    }

    public function estatus_combovalor(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus_combovalor;

		if($Num_Parametro>0){
			$this->estatus_combovalor=func_get_arg(0);
		}
    }
   
    public function ctabla(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->ctabla;

		if($Num_Parametro>0){
			$this->ctabla=func_get_arg(0);
		}
    }
   
    public function cdescripcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cdescripcion;
     
		if($Num_Parametro>0){
	   		$this->cdescripcion=func_get_arg(0);
	 	}
    }
   
	public function dfecha_desactivacion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->dfecha_desactivacion;

		if($Num_Parametro>0){
			$this->dfecha_desactivacion=func_get_arg(0);
		}
	}
   
   	public function Registrar(){
	    $sql="INSERT INTO general.tcombo_valor (ctabla,cdescripcion,dcreado_desde,ccreado_por,dmodificado_desde,cmodificado_por) VALUES 
	    ('$this->ctabla','$this->cdescripcion',NOW(),'ADMI-V203895867',NOW(),'ADMI-V203895867');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar(){
	    $sql="UPDATE general.tcombo_valor SET dfecha_desactivacion=NULL,dmodificado_desde=NOW(),
	    cmodificado_por='ADMI-V203895867' WHERE nid_combovalor='$this->nid_combovalor'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar(){
    	$sqlx="SELECT * FROM general.tcombo_valor cv WHERE nid_combovalor = '$this->nid_combovalor' 
    	AND (EXISTS (SELECT 1 FROM general.tpersona p WHERE p.ntipo_persona = cv.nid_combovalor))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE general.tcombo_valor SET dfecha_desactivacion=NOW(),dmodificado_desde=NOW(),
	    cmodificado_por='ADMI-V203895867' WHERE nid_combovalor='$this->nid_combovalor'";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar(){
	    $sql="UPDATE general.tcombo_valor SET ctabla='$this->ctabla',cdescripcion='$this->cdescripcion',dmodificado_desde=NOW(), 
	    cmodificado_por='ADMI-V203895867' WHERE nid_combovalor='$this->nid_combovalor'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
   	public function Consultar(){
	    $sql="SELECT *,
	    (CASE WHEN dfecha_desactivacion IS NULL THEN  'Activo' 
	    	ELSE 'Desactivado' END) AS estatus_combovalor FROM general.tcombo_valor 
		WHERE cdescripcion='$this->cdescripcion' AND ctabla='$this->ctabla'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$localidad=$this->pgsql->Respuesta($query);
			$this->nid_combovalor($localidad['nid_combovalor']);
			$this->ctabla($localidad['ctabla']);
			$this->cdescripcion($localidad['cdescripcion']);
		   	$this->estatus_combovalor($localidad['estatus_combovalor']);
			$this->dfecha_desactivacion($tcombo_valor['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM general.tcombo_valor WHERE cdescripcion='$this->cdescripcion' AND ctabla='$this->ctabla'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$localidad=$this->pgsql->Respuesta($query);
			$this->nid_combovalor($localidad['nid_combovalor']);
			$this->ctabla($localidad['ctabla']);
			$this->cdescripcion($localidad['cdescripcion']);
			$this->dfecha_desactivacion($localidad['dfecha_desactivacion']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
