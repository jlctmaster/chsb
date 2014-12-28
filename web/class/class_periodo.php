<?php
require_once("class_bd.php");
class periodo {
	private $codigo_periodo; 
	private $descripcion;
	private $fecha_inicio;
    private $fecha_fin;
	private $codigo_lapso;
	private $esinscripcion; 
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_periodo=null;
		$this->descripcion=null;
		$this->fecha_inicio=null;
     	$this->fecha_fin=null;
		$this->codigo_lapso=null;
		$this->esinscripcion=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
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

    public function codigo_lapso(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_lapso;

		if($Num_Parametro>0){
			$this->codigo_lapso=func_get_arg(0);
		}
    }

	public function esinscripcion(){
      $Num_Parametro=func_num_args();
	 if($Num_Parametro==0) return $this->esinscripcion;
     
	 if($Num_Parametro>0){
	   $this->esinscripcion=func_get_arg(0);
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
	    $sql="INSERT INTO educacion.tperiodo (descripcion,fecha_inicio,fecha_fin,codigo_lapso,esinscripcion,creado_por,fecha_creacion) VALUES 
	    ('$this->descripcion','$this->fecha_inicio','$this->fecha_fin','$this->codigo_lapso','N','$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE educacion.tperiodo SET estatus = '1',modificado_por='$user',fecha_modificacion=NOW() 
	    WHERE codigo_periodo=$this->codigo_periodo AND esinscripcion='N'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM educacion.tperiodo p WHERE p.codigo_periodo = $this->codigo_periodo AND esinscripcion='N' 
    	AND (EXISTS (SELECT 1 FROM educacion.tseccion s WHERE s.codigo_periodo = p.codigo_periodo) OR 
    	EXISTS (SELECT 1 FROM educacion.tinscripcion i WHERE i.codigo_periodo = p.codigo_periodo))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE educacion.tperiodo SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_periodo=$this->codigo_periodo";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE educacion.tperiodo SET descripcion='$this->descripcion',fecha_inicio='$this->fecha_inicio',
	    fecha_fin='$this->fecha_fin',codigo_lapso=$this->codigo_lapso,
	    modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_periodo='$this->codigo_periodo' AND esinscripcion='N'";
	    //echo $sql; die();
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM educacion.tperiodo WHERE descripcion='$this->descripcion' AND esinscripcion='N'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tperiodo=$this->pgsql->Respuesta($query);
			$this->codigo_periodo($tperiodo['codigo_periodo']);
			$this->descripcion($tperiodo['descripcion']);
			$this->descripcion($tperiodo['descripcion']);
			$this->fecha_inicio($tperiodo['fecha_inicio']);
			$this->codigo_lapso($tperiodo['codigo_lapso']);
			$this->estatus($tperiodo['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
