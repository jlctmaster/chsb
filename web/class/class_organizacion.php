<?php
require_once("class_bd.php");
class organizacion {
	private $rif_organizacion; 
	private $nombre;
	private $direccion;
	private $telefono;
	private $tipo_organizacion;
	private $codigo_parroquia; 
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->rif_organizacion=null;
		$this->nombre=null;
		$this->direccion=null;
		$this->telefono=null;
		$this->tipo_organizacion=null;
		$this->codigo_parroquia=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function rif_organizacion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->rif_organizacion;

		if($Num_Parametro>0){
			$this->rif_organizacion=func_get_arg(0);
		}
    }

    public function nombre(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nombre;
     
		if($Num_Parametro>0){
	   		$this->nombre=func_get_arg(0);
	 	}
    }

        public function direccion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->direccion;
     
		if($Num_Parametro>0){
	   		$this->direccion=func_get_arg(0);
	 	}
    }

        public function telefono(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->telefono;
     
		if($Num_Parametro>0){
	   		$this->telefono=func_get_arg(0);
	 	}
    }

        public function tipo_organizacion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->tipo_organizacion;
     
		if($Num_Parametro>0){
	   		$this->tipo_organizacion=func_get_arg(0);
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
   
   	public function Registrar($user){
	    $sql="INSERT INTO general.torganizacion (rif_organizacion,nombre,direccion,telefono,tipo_organizacion,codigo_parroquia,creado_por,fecha_creacion) VALUES 
	    ('$this->rif_organizacion','$this->nombre','$this->direccion','$this->telefono','$this->tipo_organizacion','$this->codigo_parroquia','$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Activar($user){
	    $sql="UPDATE general.torganizacion SET estatus = '1',modificado_por='$user', fecha_modificacion=NOW() WHERE rif_organizacion='$this->rif_organizacion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM general.torganizacion WHERE rif_organizacion = '$this->rif_organizacion'"; 
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE general.torganizacion SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE rif_organizacion=$this->rif_organizacion";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}

   
    public function Actualizar($user,$oldrif){
	    $sql="UPDATE general.torganizacion SET rif_organizacion='$this->rif_organizacion',nombre='$this->nombre',
	    direccion='$this->direccion',telefono='$this->telefono',tipo_organizacion='$this->tipo_organizacion',
	    codigo_parroquia='$this->codigo_parroquia',modificado_por='$user', fecha_modificacion=NOW() 
	    WHERE rif_organizacion='$oldrif'";
	    if($this->pgsql->Ejecutar($sql)!=null)

			return true;
		else
			return false;
   	}

	public function Comprobar($comprobar){
	    if($comprobar==true){
		    $sql="SELECT * FROM general.torganizacion WHERE rif_organizacion='$this->rif_organizacion'";
			$query=$this->pgsql->Ejecutar($sql);
		    if($this->pgsql->Total_Filas($query)!=0){
				$organizacion=$this->pgsql->Respuesta($query);
				$this->estatus($organizacion['estatus']);
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
