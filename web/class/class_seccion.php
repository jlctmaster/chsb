<?php
require_once("class_bd.php");
class Seccion {
	private $seccion; 
	private $nombre_seccion;
	private $turno; 
	private $capacidad_min; 
	private $capacidad_max;
	private $peso_min; 
	private $peso_max;  
	private $talla_min; 
	private $talla_max;
    private $codigo_materia;
	private $estatus;
	private $pgsql; 
	 
	public function __construct(){
		$this->nombre_seccion=null;
		$this->seccion=null;
		$this->turno=null;
		$this->capacidad_min=null;
		$this->capacidad_max=null;
		$this->peso_min=null;
		$this->peso_max=null;
		$this->talla_min=null;
		$this->talla_max=null;
		$this->codigo_materia=null;
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

        public function peso_min(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->peso_min;

		if($Num_Parametro>0){
			$this->peso_min=func_get_arg(0);
		}
    }

    public function peso_max(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->peso_max;

		if($Num_Parametro>0){
			$this->peso_max=func_get_arg(0);
		}
    }

        public function talla_min(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->talla_min;

		if($Num_Parametro>0){
			$this->talla_min=func_get_arg(0);
		}
    }

    public function talla_max(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->talla_max;

		if($Num_Parametro>0){
			$this->talla_max=func_get_arg(0);
		}
    }

   public function codigo_materia(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->codigo_materia;
     
	 if($Num_Parametro>0){
	   $this->codigo_materia=func_get_arg(0);
	 }
   }
    
    public function estatus(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus;

		if($Num_Parametro>0){
			$this->estatus=func_get_arg(0);
		}
    }

	public function EliminarMaterias(){
		$sql="DELETE FROM educacion.tmateria_seccion WHERE (seccion='$this->seccion');";
		if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
	} 

	public function InsertarMaterias($user,$materias){
    $sql="INSERT INTO educacion.tmateria_seccion(seccion,codigo_materia,creado_por,fecha_creacion) VALUES ";
    foreach ($materias as $key => $value) {
		$sql.="('$this->seccion','$value','$user',NOW()),";
    }
    $sql=substr($sql,0,-1);
    $sql=$sql.";";
    if($this->pgsql->Ejecutar($sql)!=null)
      return true;
    else
      return false;
    }
   
   	public function Registrar($user){
	    $sql="INSERT INTO educacion.tseccion (seccion,nombre_seccion,turno,capacidad_min,capacidad_max,peso_min,
	    peso_max,talla_min,talla_max,creado_por,fecha_creacion) 
		VALUES ('$this->seccion','$this->nombre_seccion','$this->turno','$this->capacidad_min','$this->capacidad_max',
		'$this->peso_min','$this->peso_max','$this->talla_min','$this->talla_max','$user',NOW())";
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
   
    public function Actualizar($user,$oldseccion){
	    $sql="UPDATE educacion.tseccion SET seccion='$this->seccion',nombre_seccion='$this->nombre_seccion',turno='$this->turno',
	    capacidad_min='$this->capacidad_min',capacidad_max='$this->capacidad_max',peso_min='$this->peso_min',peso_max='$this->peso_max',
	    talla_min='$this->talla_min',talla_max='$this->talla_max',modificado_por='$user',fecha_modificacion=NOW() 
	    WHERE seccion='$oldseccion'";
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
			$this->peso_min($tseccion['peso_min']);
			$this->peso_max($tseccion['peso_max']);
			$this->talla_min($tseccion['talla_min']);
			$this->talla_max($tseccion['talla_max']);
			$this->estatus($tseccion['estatus']);
			return true;
		}
		else{
			return false;
		}
   }
}
?>
