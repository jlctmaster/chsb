<?php
require_once("class_bd.php");
class materia {
	private $codigo_materia; 
	private $nombre_materia;
	private $unidad_credito;
	private $tipo_materia;
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_materia=null;
		$this->nombre_materia=null;
		$this->unidad_credito=null;
		$this->tipo_materia=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_materia(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_materia;

		if($Num_Parametro>0){
			$this->codigo_materia=func_get_arg(0);
		}
    }

    public function nombre_materia(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nombre_materia;
     
		if($Num_Parametro>0){
	   		$this->nombre_materia=func_get_arg(0);
	 	}
    }

        public function unidad_credito(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->unidad_credito;
     
		if($Num_Parametro>0){
	   		$this->unidad_credito=func_get_arg(0);
	 	}
    }

        
        public function tipo_materia(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->tipo_materia;
     
		if($Num_Parametro>0){
	   		$this->tipo_materia=func_get_arg(0);
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
	    $sql="INSERT INTO educacion.tmateria (codigo_materia,nombre_materia,unidad_credito,tipo_materia,creado_por) VALUES 
	    ('$this->codigo_materia','$this->nombre_materia','$this->unidad_credito','$this->tipo_materia','$user');";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Activar($user){
	    $sql="UPDATE educacion.tmateria SET estatus = '1',modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_materia='$this->codigo_materia'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM educacion.tmateria WHERE codigo_materia = '$this->codigo_materia'"; 
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE educacion.tmateria SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_materia=$this->codigo_materia";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}

   
    public function Actualizar($user){
	    $sql="UPDATE educacion.tmateria SET nombre_materia='$this->nombre_materia',
	    unidad_credito='$this->unidad_credito',tipo_materia='$this->tipo_materia',
	    modificado_por='$user', fecha_modificacion=NOW()  WHERE codigo_materia='$this->codigo_materia'";
	    if($this->pgsql->Ejecutar($sql)!=null)

			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM educacion.tmateria WHERE nombre_materia='$this->nombre_materia'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$materia=$this->pgsql->Respuesta($query);
			$this->codigo_materia($materia['codigo_materia']);
			$this->nombre_materia($materia['nombre_materia']);
			$this->unidad_credito($materia['unidad_credito']);
			$this->tipo_materia($materia['tipo_materia']);
			$this->estatus($materia['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
