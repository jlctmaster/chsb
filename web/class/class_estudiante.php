<?php
require_once("class_bd.php");
class estudiante {
	private $cedula_persona; 
	private $primer_nombre;
	private $segundo_nombre;
	private $primer_apellido;
	private $segundo_apellido;
	private $sexo;
	private $fecha_nacimiento;
	private $lugar_nacimiento;
	private $direccion;
	private $telefono_local;
	private $telefono_movil;
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cedula_persona=null;
		$this->primer_nombre=null;
		$this->segundo_nombre=null;
		$this->primer_apellido=null;
		$this->segundo_apellido=null;
		$this->sexo=null;
		$this->fecha_nacimiento=null;
		$this->lugar_nacimiento=null;
		$this->direccion=null;
		$this->telefono_local=null;
		$this->telefono_movil=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function cedula_persona(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cedula_persona;

		if($Num_Parametro>0){
			$this->cedula_persona=func_get_arg(0);
		}
    }

    public function primer_nombre(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->primer_nombre;
     
		if($Num_Parametro>0){
	   		$this->primer_nombre=func_get_arg(0);
	 	}
    }

public function segundo_nombre(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->segundo_nombre;
     
		if($Num_Parametro>0){
	   		$this->segundo_nombre=func_get_arg(0);
	 	}
    }
    public function primer_apellido(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->primer_apellido;
     
		if($Num_Parametro>0){
	   		$this->primer_apellido=func_get_arg(0);
	 	}
    }
    public function segundo_apellido(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->segundo_apellido;
     
		if($Num_Parametro>0){
	   		$this->segundo_apellido=func_get_arg(0);
	 	}
    }

    public function sexo(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->sexo;
     
		if($Num_Parametro>0){
	   		$this->sexo=func_get_arg(0);
	 	}
    }

    public function fecha_nacimiento(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->fecha_nacimiento;
     
		if($Num_Parametro>0){
	   		$this->fecha_nacimiento=func_get_arg(0);
	 	}
    }
    public function lugar_nacimiento(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->lugar_nacimiento;
     
		if($Num_Parametro>0){
	   		$this->lugar_nacimiento=func_get_arg(0);
	 	}
    }

    public function direccion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->direccion;
     
		if($Num_Parametro>0){
	   		$this->direccion=func_get_arg(0);
	 	}
    }

    public function telefono_local(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->telefono_local;
     
		if($Num_Parametro>0){
	   		$this->telefono_local=func_get_arg(0);
	 	}
    }

    public function telefono_movil(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->telefono_movil;
     
		if($Num_Parametro>0){
	   		$this->telefono_movil=func_get_arg(0);
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
	    $sql="INSERT INTO general.tpersona (cedula_persona,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,sexo,
	    fecha_nacimiento,lugar_nacimiento,direccion,telefono_local,telefono_movil,codigo_tipopersona,creado_por,fecha_creacion) VALUES 
	    ('$this->cedula_persona','$this->primer_nombre','$this->segundo_nombre','$this->primer_apellido','$this->segundo_apellido',
	    	'$this->sexo','$this->fecha_nacimiento','$this->lugar_nacimiento','$this->direccion','$this->telefono_local',
	    	'$this->telefono_movil',(SELECT codigo_tipopersona FROM general.ttipo_persona WHERE LOWER(descripcion) LIKE '%estudiante%'),'$user',NOW())";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE general.tpersona SET estatus = '1', modificado_por='$user',fecha_modificacion=NOW() WHERE cedula_persona='$this->cedula_persona'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM general.tpersona p WHERE p.cedula_persona = '$this->cedula_persona' 
		AND (EXISTS (SELECT 1 FROM educacion.tinscrito_seccion ins WHERE ins.cedula_persona = p.cedula_persona) OR
		EXISTS (SELECT 1 FROM educacion.tproceso_inscripcion pins WHERE pins.cedula_persona = p.cedula_persona) OR 
		EXISTS (SELECT 1 FROM biblioteca.tprestamo pres WHERE pres.cedula_persona = p.cedula_persona) OR 
		EXISTS (SELECT 1 FROM biblioteca.tentrega ent WHERE ent.cedula_persona = p.cedula_persona))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE general.tpersona SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE cedula_persona='$this->cedula_persona'";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user,$oldci){
	    $sql="UPDATE general.tpersona SET cedula_persona='$this->cedula_persona',primer_nombre='$this->primer_nombre',
	    segundo_nombre='$this->segundo_nombre',primer_apellido='$this->primer_apellido',segundo_apellido='$this->segundo_apellido',sexo='$this->sexo',
	    fecha_nacimiento='$this->fecha_nacimiento',lugar_nacimiento='$this->lugar_nacimiento',direccion='$this->direccion',
	    telefono_local='$this->telefono_local',telefono_movil='$this->telefono_movil',modificado_por='$user',fecha_modificacion=NOW() 
	    WHERE cedula_persona='$oldci'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM general.tpersona WHERE cedula_persona='$this->cedula_persona'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tpersona=$this->pgsql->Respuesta($query);
			$this->cedula_persona($tpersona['cedula_persona']);
			$this->primer_nombre($tpersona['primer_nombre']);
			$this->segundo_nombre($tpersona['segundo_nombre']);
			$this->primer_apellido($tpersona['primer_apellido']);
			$this->segundo_apellido($tpersona['segundo_apellido']);
			$this->sexo($tpersona['sexo']);
			$this->fecha_nacimiento($tpersona['fecha_nacimiento']);
			$this->lugar_nacimiento($tpersona['lugar_nacimiento']);
			$this->direccion($tpersona['direccion']);
			$this->telefono_local($tpersona['telefono_local']);
			$this->telefono_movil($tpersona['telefono_movil']);
			$this->estatus($tpersona['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
