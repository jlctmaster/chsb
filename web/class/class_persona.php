<?php
require_once("class_bd.php");
class persona {
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
	private $codigo_tipopersona; 
	private $profesion;
	private $grado_instruccion;
	private $maxhoras;
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
		$this->codigo_tipopersona=null;
		$this->profesion=null;
		$this->grado_instruccion=null;
		$this->maxhoras=0;
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
    public function codigo_tipopersona(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_tipopersona;

		if($Num_Parametro>0){
			$this->codigo_tipopersona=func_get_arg(0);
		}
    }
    public function profesion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->profesion;

		if($Num_Parametro>0){
			$this->profesion=func_get_arg(0);
		}
    }
    public function grado_instruccion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->grado_instruccion;

		if($Num_Parametro>0){
			$this->grado_instruccion=func_get_arg(0);
		}
    }
    public function maxhoras(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->maxhoras;

		if($Num_Parametro>0){
			$this->maxhoras=func_get_arg(0);
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
    	if($this->fecha_nacimiento!=""){
    		$sql="INSERT INTO general.tpersona (cedula_persona,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,sexo,
		    fecha_nacimiento,lugar_nacimiento,direccion,telefono_local,telefono_movil,codigo_tipopersona,profesion,grado_instruccion,
		    maxhoras,creado_por,fecha_creacion) VALUES 
		    ('$this->cedula_persona','$this->primer_nombre','$this->segundo_nombre','$this->primer_apellido','$this->segundo_apellido',
		    '$this->sexo','$this->fecha_nacimiento','$this->lugar_nacimiento','$this->direccion','$this->telefono_local','$this->telefono_movil',
		    $this->codigo_tipopersona,'$this->profesion','$this->grado_instruccion','$this->maxhoras','$user',NOW())";
    	}else{
    		$sql="INSERT INTO general.tpersona (cedula_persona,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,sexo,
		    lugar_nacimiento,direccion,telefono_local,telefono_movil,codigo_tipopersona,profesion,grado_instruccion,maxhoras,
		    creado_por,fecha_creacion) VALUES 
		    ('$this->cedula_persona','$this->primer_nombre','$this->segundo_nombre','$this->primer_apellido','$this->segundo_apellido',
		    '$this->sexo','$this->lugar_nacimiento','$this->direccion','$this->telefono_local','$this->telefono_movil',$this->codigo_tipopersona,
		    '$this->profesion','$this->grado_instruccion','$this->maxhoras','$user',NOW())";
    	}
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
    	AND (EXISTS (SELECT 1 FROM seguridad.tusuario u WHERE u.cedula_persona = p.cedula_persona) OR 
    	EXISTS (SELECT 1 FROM educacion.thorario_profesor hp WHERE hp.cedula_persona = p.cedula_persona) OR 
    	EXISTS (SELECT 1 FROM educacion.tproceso_inscripcion pins WHERE (pins.cedula_responsable = p.cedula_persona OR 
    	pins.cedula_madre = p.cedula_persona OR pins.cedula_padre = p.cedula_persona OR pins.cedula_representante = p.cedula_persona)) OR 
		EXISTS (SELECT 1 FROM bienes_nacionales.tasignacion a WHERE a.cedula_persona = p.cedula_persona) OR 
		EXISTS (SELECT 1 FROM bienes_nacionales.treasignacion ra WHERE ra.cedula_persona = p.cedula_persona) OR 
		EXISTS (SELECT 1 FROM bienes_nacionales.trecuperacion r WHERE r.cedula_persona = p.cedula_persona) OR 
		EXISTS (SELECT 1 FROM biblioteca.tprestamo pres WHERE pres.cedula_responsable = p.cedula_persona) OR 
		EXISTS (SELECT 1 FROM biblioteca.tentrega ent WHERE ent.cedula_responsable = p.cedula_persona))";
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
    	if($this->fecha_nacimiento!=""){
    		$sql="UPDATE general.tpersona SET cedula_persona='$this->cedula_persona',primer_nombre='$this->primer_nombre',
		    segundo_nombre='$this->segundo_nombre',primer_apellido='$this->primer_apellido',segundo_apellido='$this->segundo_apellido',sexo='$this->sexo',
		    fecha_nacimiento='$this->fecha_nacimiento',lugar_nacimiento='$this->lugar_nacimiento',direccion='$this->direccion',
		    telefono_local='$this->telefono_local',telefono_movil='$this->telefono_movil',codigo_tipopersona=$this->codigo_tipopersona,
		    profesion='$this->profesion',grado_instruccion='$this->grado_instruccion',maxhoras='$this->maxhoras',modificado_por='$user',fecha_modificacion=NOW() 
		    WHERE cedula_persona='$oldci'";
    	}else{
    		$sql="UPDATE general.tpersona SET cedula_persona='$this->cedula_persona',primer_nombre='$this->primer_nombre',
		    segundo_nombre='$this->segundo_nombre',primer_apellido='$this->primer_apellido',segundo_apellido='$this->segundo_apellido',sexo='$this->sexo',
		    lugar_nacimiento='$this->lugar_nacimiento',direccion='$this->direccion',telefono_local='$this->telefono_local',telefono_movil='$this->telefono_movil',
		    codigo_tipopersona=$this->codigo_tipopersona,profesion='$this->profesion',grado_instruccion='$this->grado_instruccion',maxhoras='$this->maxhoras',
		    modificado_por='$user',fecha_modificacion=NOW() 
		    WHERE cedula_persona='$oldci'";
    	}
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar($comprobar){
   		if($comprobar==true){
		    $sql="SELECT * FROM general.tpersona WHERE cedula_persona='$this->cedula_persona'";
			$query=$this->pgsql->Ejecutar($sql);
		    if($this->pgsql->Total_Filas($query)!=0){
				$tpersona=$this->pgsql->Respuesta($query);
				$this->estatus($tpersona['estatus']);
				return true;
			}
			else{
				return false;
			}
	    }else
	      return false;
   	}

   	public function BuscarDatosRepresentante($representante){
   		$sql="SELECT p.cedula_persona,p.primer_nombre,p.segundo_nombre,p.primer_apellido,p.segundo_apellido,p.sexo,
   		TO_CHAR(p.fecha_nacimiento,'DD/MM/YYYY') AS fecha_nacimiento,p.direccion,p.telefono_local,p.telefono_movil,
   		p.profesion,p.grado_instruccion,CASE WHEN df.codigo_parentesco IS NOT NULL THEN df.codigo_parentesco ELSE 0 END AS codigo_parentesco, 
   		p.lugar_nacimiento||'_'||par.descripcion AS lugar_nacimiento 
   		FROM general.tpersona p 
   		INNER JOIN general.tparroquia par ON p.lugar_nacimiento = par.codigo_parroquia 
   		LEFT JOIN general.tdetalle_familiar df ON p.cedula_persona = df.cedula_familiar 
   		WHERE p.cedula_persona = '$representante'";
		$query = $this->pgsql->Ejecutar($sql);
        while($Obj=$this->pgsql->Respuesta_assoc($query)){
                $rows[]=array_map("html_entity_decode",$Obj);
            }
            if(!empty($rows)){
                $json = json_encode($rows);
            }
            else{
                $rows[] = array("msj" => "Error al Buscar Registros ");
                $json = json_encode($rows);
            }
        return $json;
   	}

   	public function BuscarDatosPersona($persona){
   		$sql="SELECT p.cedula_persona,p.primer_nombre,p.segundo_nombre,p.primer_apellido,p.segundo_apellido,p.sexo,
   		TO_CHAR(p.fecha_nacimiento,'DD/MM/YYYY') AS fecha_nacimiento,p.lugar_nacimiento,p.direccion,p.telefono_local,p.telefono_movil,
   		p.profesion,p.grado_instruccion 
   		FROM general.tpersona p 
   		WHERE p.cedula_persona = '$persona'";
		$query = $this->pgsql->Ejecutar($sql);
        while($Obj=$this->pgsql->Respuesta_assoc($query)){
                $rows[]=array_map("html_entity_decode",$Obj);
            }
            if(!empty($rows)){
                $json = json_encode($rows);
            }
            else{
                $rows[] = array("msj" => "Error al Buscar Registros ");
                $json = json_encode($rows);
            }
        return $json;
   	}
}
?>
