<?php
require_once("class_bd.php");
class inscripcion {
	private $codigo_inscripcion; 
	private $codigo_periodo; 
	private $descripcion; 
	private $fecha_inicio;
    private $fecha_fin;
	private $fecha_cierre;
	private $estatus; 
	private $cerrado; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_inscripcion=null;
		$this->descripcion=null;
		$this->fecha_inicio=null;
     	$this->fecha_fin=null;
		$this->fecha_cierre=null;
		$this->cerrado=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_inscripcion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_inscripcion;

		if($Num_Parametro>0){
			$this->codigo_inscripcion=func_get_arg(0);
		}
    }

    public function codigo_periodo(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->codigo_periodo;
     
	 if($Num_Parametro>0){
	   $this->codigo_periodo=func_get_arg(0);
	 }
   }

    public function descripcion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->descripcion;
     
	 if($Num_Parametro>0){
	   $this->descripcion=func_get_arg(0);
	 }
   }

    public function fecha_inicio(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->fecha_inicio;
     
	 if($Num_Parametro>0){
	   $this->fecha_inicio=func_get_arg(0);
	 }
   }

   public function fecha_fin(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->fecha_fin;
     
	 if($Num_Parametro>0){
	   $this->fecha_fin=func_get_arg(0);
	 }
   }

    public function fecha_cierre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->fecha_cierre;

		if($Num_Parametro>0){
			$this->fecha_cierre=func_get_arg(0);
		}
    }

    public function estatus(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus;

		if($Num_Parametro>0){
			$this->estatus=func_get_arg(0);
		}
    }
  
    public function cerrado(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cerrado;

		if($Num_Parametro>0){
			$this->cerrado=func_get_arg(0);
		}
    }

    public function Cerrar($user){
    	$sql="UPDATE educacion.tinscripcion SET cerrado='Y',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_periodo IN 
    	(SELECT codigo_periodo FROM educacion.tperiodo WHERE descripcion <> '$this->descripcion')";
    	if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
    }
   
   	public function Registrar($user){
   		$sqlx="INSERT INTO educacion.tperiodo (descripcion,fecha_inicio,fecha_fin,esinscripcion,creado_por,fecha_creacion) 
   		VALUES ('$this->descripcion','$this->fecha_inicio','$this->fecha_fin','Y','$user',NOW())";
	    $sql="INSERT INTO educacion.tinscripcion (fecha_cierre,codigo_periodo,creado_por,fecha_creacion) VALUES 
	    ('$this->fecha_cierre',(SELECT codigo_periodo FROM educacion.tperiodo WHERE descripcion = '$this->descripcion' 
	    AND fecha_inicio = '$this->fecha_inicio' AND fecha_fin = '$this->fecha_fin' AND esinscripcion = 'Y'),'$user',NOW());";
	    if($this->pgsql->Ejecutar($sqlx)!=null)
			if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql1="UPDATE educacion.tinscripcion SET estatus = '1',modificado_por='$user',fecha_modificacion=NOW()
    	WHERE codigo_inscripcion=$this->codigo_inscripcion";
    	$sql2="UPDATE educacion.tperiodo SET estatus = '1',modificado_por='$user',fecha_modificacion=NOW() 
	    WHERE codigo_periodo=(SELECT p.codigo_periodo FROM educacion.tinscripcion i 
	    INNER JOIN educacion.tperiodo p ON p.codigo_periodo = i.codigo_periodo WHERE i.codigo_inscripcion = $this->codigo_inscripcion)";
	    if($this->pgsql->Ejecutar($sql1)!=null)
			if($this->pgsql->Ejecutar($sql2)!=null)
				return true;
			else
				return false;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM educacion.tinscripcion i WHERE i.codigo_inscripcion = $this->codigo_inscripcion 
    	AND (EXISTS (SELECT 1 FROM educacion.tproceso_inscripcion pi WHERE i.codigo_inscripcion = pi.codigo_inscripcion))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql1="UPDATE educacion.tinscripcion SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW()
	    	WHERE codigo_inscripcion=$this->codigo_inscripcion";
	    	$sql2="UPDATE educacion.tperiodo SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() 
		    WHERE codigo_periodo=(SELECT p.codigo_periodo FROM educacion.tinscripcion i 
		    INNER JOIN educacion.tperiodo p ON p.codigo_periodo = i.codigo_periodo WHERE i.codigo_inscripcion = $this->codigo_inscripcion)";
		    if($this->pgsql->Ejecutar($sql1)!=null)
				if($this->pgsql->Ejecutar($sql2)!=null)
					return true;
				else
					return false;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
    	$sql="UPDATE educacion.tinscripcion SET fecha_cierre='$this->fecha_cierre',cerrado='$this->cerrado',modificado_por='$user',fecha_modificacion=NOW() 
    	WHERE codigo_inscripcion='$this->codigo_inscripcion'";
	    $sqlx="UPDATE educacion.tperiodo SET descripcion='$this->descripcion',fecha_inicio='$this->fecha_inicio',
	    fecha_fin='$this->fecha_fin',modificado_por='$user',fecha_modificacion=NOW() 
	    WHERE codigo_periodo = '$this->codigo_periodo'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			if($this->pgsql->Ejecutar($sqlx)!=null)
				return true;
			else
				return false;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT i.codigo_inscripcion,p.descripcion,p.fecha_inicio,p.fecha_fin,i.fecha_cierre,i.estatus 
	    FROM educacion.tinscripcion i 
	    INNER JOIN educacion.tperiodo p ON i.codigo_periodo = p.codigo_periodo 
	    WHERE p.descripcion='$this->descripcion' AND p.fecha_inicio = '$this->fecha_inicio'
	    AND p.fecha_fin = '$this->fecha_fin' AND i.fecha_cierre = '$this->fecha_cierre' AND p.esinscripcion = 'Y'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tinscripcion=$this->pgsql->Respuesta($query);
			$this->codigo_inscripcion($tinscripcion['codigo_inscripcion']);
			$this->descripcion($tinscripcion['descripcion']);
			$this->fecha_inicio($tinscripcion['fecha_inicio']);
			$this->fecha_fin($tinscripcion['fecha_fin']);
			$this->fecha_cierre($tinscripcion['fecha_cierre']);
			$this->estatus($tinscripcion['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
