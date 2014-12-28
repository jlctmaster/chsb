<?php
require_once("class_bd.php");
class Seccion {
	private $seccion; 
	private $nombre_seccion;
	private $turno; 
	private $capacidad_min; 
	private $capacidad_max; 
	private $codigo_periodo;
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->nombre_seccion=null;
		$this->seccion=null;
		$this->turno=null;
		$this->capacidad_min=null;
		$this->capacidad_max=null;
		$this->codigo_periodo=null;
		$this->estatus=null;
		$this->pgsql=new Conexion();
	}

 public function __destruct(){}

 public function Transaccion($value){
	 if($value=='iniciando') return $this->mysql->Incializar_Transaccion();
	 if($value=='cancelado') return $this->mysql->Cancelar_Transaccion();
	 if($value=='finalizado') return $this->mysql->Finalizar_Transaccion();
	 }

    public function nombre_seccion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nombre_seccion;
     
		if($Num_Parametro>0){
	   		$this->nombre_seccion=func_get_arg(0);
	 	}
    }
       public function seccion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->seccion;
     
	 if($Num_Parametro>0){
	   $this->seccion=func_get_arg(0);
	 }
   }


    public function turno(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->turno;

		if($Num_Parametro>0){
			$this->turno=func_get_arg(0);
		}
    }

    public function capacidad_min(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->capacidad_min;

		if($Num_Parametro>0){
			$this->capacidad_min=func_get_arg(0);
		}
    }

    public function capacidad_max(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->capacidad_max;

		if($Num_Parametro>0){
			$this->capacidad_max=func_get_arg(0);
		}
    }

    public function codigo_periodo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_periodo;

		if($Num_Parametro>0){
			$this->codigo_periodo=func_get_arg(0);
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
	    $sql="INSERT INTO educacion.tseccion (seccion,nombre_seccion,turno,capacidad_min,
	    	capacidad_max,codigo_periodo, creado_por,fecha_creacion) VALUES 
	    ('$this->seccion','$this->nombre_seccion','$this->turno','$this->capacidad_min','$this->capacidad_max','$this->codigo_periodo','$user',NOW())";
		   echo $sql; die();
		    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE educacion.tseccion SET estatus = '1',modificado_por='$user',fecha_modificacion=NOW() WHERE seccion='$this->seccion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM educacion.tseccion s WHERE s.seccion = '$this->seccion' 
    	AND (EXISTS (SELECT 1 FROM educacion.tmateria_seccion ms WHERE ms.seccion = s.seccion) OR 
    	EXISTS (SELECT 1 FROM educacion.tinscrito_seccion is WHERE is.lugar_nacimiento = s.seccion) OR 
    	EXISTS (SELECT 1 FROM educacion.thorario_profesor h WHERE h.seccion = s.seccion) OR 
    	EXISTS (SELECT 1 FROM educacion.tproceso_inscripcion pi WHERE pi.seccion = s.seccion))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE educacion.tseccion SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE seccion='$this->seccion'";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE educacion.tseccion SET seccion='$this->seccion' nombre_seccion='$this->nombre_seccion',turno='$this->turno',
	    capacidad_min='$this->capacidad_min',capacidad_max='$this->capacidad_max',
	    codigo_periodo='$this->codigo_periodo',modificado_por='$user',fecha_modificacion=NOW() 
	    WHERE seccion='$this->seccion'";
	  	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM educacion.tseccion WHERE nombre_seccion='$this->nombre_seccion'";
			$query=$this->pgsql->Ejecutar($sql);
		    	if($this->pgsql->Total_Filas($query)!=0){
				$tseccion=$this->pgsql->Respuesta($query);
				$this->seccion($tseccion['seccion']);
				$this->nombre_seccion($tseccion['nombre_seccion']);
				$this->turno($tseccion['turno']);
				$this->capacidad_min($tseccion['capacidad_min']);
				$this->capacidad_max($tseccion['capacidad_max']);
				$this->codigo_periodo($tseccion['codigo_periodo']);
				$this->estatus($tseccion['estatus']);
			return true;
		}
		else{
			return false;
		}
   }
}
?>