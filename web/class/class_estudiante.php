<?php
require_once("class_bd.php");
class estudiante {
	private $codigo_proceso_inscripcion; 
	private $codigo_inscripcion;
	private $fecha_inscripcion;
	private $codigo_ano_academico;
	private $cedula_responsable;
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
	private $anio_a_cursar;
	private $coordinacion_pedagogica;
	private $peso;
	private $talla;
	private $indice;
	private $cedula_representante;
	private $codigo_parentesco;
	private $seccion;
	private $observacion;
	private $estatus; 
	private $error; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_proceso_inscripcion=null;
		$this->codigo_inscripcion=null;
		$this->fecha_inscripcion=null;
		$this->codigo_ano_academico=null;
		$this->cedula_responsable=null;
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
		$this->anio_a_cursar=null;
		$this->coordinacion_pedagogica=null;
		$this->peso=null;
		$this->talla=null;
		$this->indice=null;
		$this->cedula_representante=null;
		$this->codigo_parentesco=null;
		$this->seccion=null;
		$this->observacion=null;
		$this->estatus=null;
		$this->error=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_proceso_inscripcion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_proceso_inscripcion;

		if($Num_Parametro>0){
			$this->codigo_proceso_inscripcion=func_get_arg(0);
		}
    }

    public function codigo_inscripcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_inscripcion;
     
		if($Num_Parametro>0){
	   		$this->codigo_inscripcion=func_get_arg(0);
	 	}
    }

	public function fecha_inscripcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->fecha_inscripcion;
     
		if($Num_Parametro>0){
	   		$this->fecha_inscripcion=func_get_arg(0);
	 	}
    }

    public function codigo_ano_academico(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_ano_academico;
     
		if($Num_Parametro>0){
	   		$this->codigo_ano_academico=func_get_arg(0);
	 	}
    }
    
    public function cedula_responsable(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cedula_responsable;
     
		if($Num_Parametro>0){
	   		$this->cedula_responsable=func_get_arg(0);
	 	}
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

    public function anio_a_cursar(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->anio_a_cursar;
     
		if($Num_Parametro>0){
	   		$this->anio_a_cursar=func_get_arg(0);
	 	}
    }

    public function coordinacion_pedagogica(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->coordinacion_pedagogica;
     
		if($Num_Parametro>0){
	   		$this->coordinacion_pedagogica=func_get_arg(0);
	 	}
    }

    public function peso(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->peso;
     
		if($Num_Parametro>0){
	   		$this->peso=func_get_arg(0);
	 	}
    }

    public function talla(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->talla;
     
		if($Num_Parametro>0){
	   		$this->talla=func_get_arg(0);
	 	}
    }

    public function indice(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->indice;
     
		if($Num_Parametro>0){
	   		$this->indice=func_get_arg(0);
	 	}
    }

    public function cedula_representante(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cedula_representante;
     
		if($Num_Parametro>0){
	   		$this->cedula_representante=func_get_arg(0);
	 	}
    }

    public function codigo_parentesco(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_parentesco;
     
		if($Num_Parametro>0){
	   		$this->codigo_parentesco=func_get_arg(0);
	 	}
    }

    public function seccion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->seccion;
     
		if($Num_Parametro>0){
	   		$this->seccion=func_get_arg(0);
	 	}
    }

    public function observacion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->observacion;
     
		if($Num_Parametro>0){
	   		$this->observacion=func_get_arg(0);
	 	}
    }

    public function estatus(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus;

		if($Num_Parametro>0){
			$this->estatus=func_get_arg(0);
		}
    }

    public function error(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->error;

		if($Num_Parametro>0){
			$this->error=func_get_arg(0);
		}
    }

    public function Inscribir($user){
    	$sql="INSERT INTO educacion.tproceso_inscripcion (codigo_inscripcion,fecha_inscripcion,codigo_ano_academico,cedula_responsable,cedula_persona,
    	anio_a_cursar,coordinacion_pedagogica,peso,talla,indice,cedula_representante,codigo_parentesco,procesado,creado_por,fecha_creacion) VALUES 
		($this->codigo_inscripcion,'$this->fecha_inscripcion',$this->codigo_ano_academico,'$this->cedula_responsable','$this->cedula_persona',
		'$this->anio_a_cursar','$this->coordinacion_pedagogica','$this->peso','$this->talla','$this->indice','$this->cedula_representante',
		$this->codigo_parentesco,'Y','$user',NOW())";
		if($this->pgsql->Ejecutar($sql)!=null){
			$sqlx="UPDATE educacion.tproceso_inscripcion SET seccion=(SELECT s.seccion FROM educacion.tseccion s 
	   		LEFT JOIN educacion.tinscrito_seccion isec ON s.seccion = isec.seccion WHERE EXISTS (SELECT * FROM educacion.tproceso_inscripcion pi 
	   		WHERE pi.peso BETWEEN s.peso_min AND s.peso_max AND pi.talla BETWEEN s.talla_min AND s.talla_max AND pi.cedula_persona='$this->cedula_persona') 
	   		GROUP BY s.seccion,s.nombre_seccion ORDER BY s.seccion,MAX(s.capacidad_max)-COUNT(isec.seccion) ASC LIMIT 1),observacion='ASIGNACIÓN AUTOMATICA POR EL SISTEMA',
			procesado='Y',modificado_por='$user',fecha_modificacion=NOW() WHERE cedula_persona='$this->cedula_persona'";
			if($this->pgsql->Ejecutar($sqlx)!=null)
				return true;
			else{
				$this->error(pg_last_error());
				return false;
			}
		}
		else{
			$this->error(pg_last_error());
			return false;
		}
    }

    public function ActualizarInscripcion($user){
    	$sql="UPDATE educacion.tproceso_inscripcion SET codigo_inscripcion=$this->codigo_inscripcion,fecha_inscripcion='$this->fecha_inscripcion',
    	codigo_ano_academico=$this->codigo_ano_academico,cedula_responsable='$this->cedula_responsable',cedula_persona='$this->cedula_persona',
    	anio_a_cursar='$this->anio_a_cursar',coordinacion_pedagogica='$this->coordinacion_pedagogica',peso='$this->peso',talla='$this->talla',
    	indice='$this->indice',cedula_representante='$this->cedula_representante',codigo_parentesco=$this->codigo_parentesco,seccion=(SELECT s.seccion 
    	FROM educacion.tseccion s LEFT JOIN educacion.tinscrito_seccion isec ON s.seccion = isec.seccion WHERE EXISTS (SELECT * FROM educacion.tproceso_inscripcion pi 
   		WHERE pi.peso BETWEEN s.peso_min AND s.peso_max AND pi.talla BETWEEN s.talla_min AND s.talla_max AND pi.cedula_persona='$this->cedula_persona') 
   		GROUP BY s.seccion,s.nombre_seccion ORDER BY s.seccion,MAX(s.capacidad_max)-COUNT(isec.seccion) ASC LIMIT 1),observacion='$this->observacion',
   		modificado_por='$user',fecha_modificacion=NOW() 
		WHERE codigo_proceso_inscripcion = $this->codigo_proceso_inscripcion";
		if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else{
			$this->error(pg_last_error());
			return false;
		}
    }

   	public function ObtenerCodigoPI(){
	    $sql="SELECT * FROM educacion.tproceso_inscripcion WHERE cedula_persona='$this->cedula_persona'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tproceso_inscripcion=$this->pgsql->Respuesta($query);
			$this->codigo_proceso_inscripcion($tproceso_inscripcion['codigo_proceso_inscripcion']);
			return true;
		}
		else{
			$this->error(pg_last_error());
			return false;
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
		else{
			$this->error(pg_last_error());
			return false;
		}
   	}
   
    public function Activar($user){
	    $sql="UPDATE general.tpersona SET estatus = '1', modificado_por='$user',fecha_modificacion=NOW() WHERE cedula_persona='$this->cedula_persona'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else{
			$this->error(pg_last_error());
			return false;
		}
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
			else{
				$this->error(pg_last_error());
				return false;
			}
		}
		else{
			$this->error(pg_last_error());
			return false;
		}
   	}
   
    public function Actualizar($user,$oldci){
	    $sql="UPDATE general.tpersona SET cedula_persona='$this->cedula_persona',primer_nombre='$this->primer_nombre',
	    segundo_nombre='$this->segundo_nombre',primer_apellido='$this->primer_apellido',segundo_apellido='$this->segundo_apellido',sexo='$this->sexo',
	    fecha_nacimiento='$this->fecha_nacimiento',lugar_nacimiento='$this->lugar_nacimiento',direccion='$this->direccion',
	    telefono_local='$this->telefono_local',telefono_movil='$this->telefono_movil',modificado_por='$user',fecha_modificacion=NOW() 
	    WHERE cedula_persona='$oldci'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else{
			$this->error(pg_last_error());
			return false;
		}
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
			$this->error(pg_last_error());
			return false;
		}
   	}
}
?>
