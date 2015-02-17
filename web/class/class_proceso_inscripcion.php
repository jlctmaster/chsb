<?php
require_once("class_bd.php");
require_once("class_tipo_persona.php");
require_once("class_parentesco.php");
require_once("class_estudiante.php");
require_once("class_persona.php");
require_once("class_tabulador.php");
class proceso_inscripcion {
	private $codigo_proceso_inscripcion; 
	private $codigo_inscripcion;
	private $fecha_inscripcion; 
	private $codigo_ano_academico; 
	private $cedula_persona; 
	private $cedula_responsable;
	private $primer_nombre;
	private $segundo_nombre;
	private $primer_apellido;
	private $segundo_apellido;
	private $sexo;
	private $fecha_nacimiento_estudiante;
	private $lugar_nacimiento;
	private $direccion;
	private $telefono_local;
	private $telefono_movil;
	private $anio_a_cursar;
	private $coordinacion_pedagogica;
	private $estado_salud; 
	private $alergico;
	private $impedimento_deporte; 
	private $especifique_deporte; 
	private $materia_pendiente; 
	private $cual_materia;
	private $practica_deporte; 
	private $cual_deporte;
	private $tiene_beca;
	private $organismo;
	private $tiene_hermanos;
	private $cuantas_hembras;
	private $cuantos_varones;
	private $estudian_aca;
	private $que_anio;
	private $peso;
	private $talla;
	private $indice;
	private $tiene_talento;
	private $cual_talento;
	private $cedula_padre;
	private $fecha_nacimiento_padre;
	private $primer_nombre_padre;
	private $segundo_nombre_padre;
	private $primer_apellido_padre;
	private $segundo_apellido_padre;
	private $lugar_nacimiento_padre;
	private $direccion_padre;
	private $telefono_local_padre;
	private $telefono_movil_padre;
	private $profesion_padre;
	private $grado_instruccion_padre;
	private $cedula_madre;
	private $fecha_nacimiento_madre;
	private $primer_nombre_madre;
	private $segundo_nombre_madre;
	private $primer_apellido_madre;
	private $segundo_apellido_madre;
	private $lugar_nacimiento_madre;
	private $direccion_madre;
	private $telefono_local_madre;
	private $telefono_movil_madre;
	private $profesion_madre;
	private $grado_instruccion_madre;
	private $codigo_parentesco;
	private $cedula_representante;
	private $fecha_nacimiento_representante;
	private $primer_nombre_representante;
	private $segundo_nombre_representante;
	private $primer_apellido_representante;
	private $segundo_apellido_representante;
	private $lugar_nacimiento_representante;
	private $sexo_representante;
	private $direccion_representante;
	private $telefono_local_representante;
	private $telefono_movil_representante;
	private $profesion_representante;
	private $grado_instruccion_representante;
	private $integracion_escuela_comunidad;
	private $especifique_integracion;
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
		$this->cedula_persona=null;
		$this->cedula_responsable=null;
		$this->primer_nombre=null;
		$this->segundo_nombre=null;
		$this->primer_apellido=null;
		$this->segundo_apellido=null;
		$this->sexo=null;
		$this->fecha_nacimiento_estudiante=null;
		$this->lugar_nacimiento=null;
		$this->direccion=null;
		$this->telefono_local=null;
		$this->telefono_movil=null;
		$this->anio_a_cursar=null;
		$this->coordinacion_pedagogica=null;
		$this->estado_salud=null;
		$this->alergico=null;
		$this->impedimento_deporte=null;
		$this->especifique_deporte=null;
		$this->materia_pendiente=null;
		$this->cual_materia=null;
		$this->practica_deporte=null;
		$this->cual_deporte=null;
		$this->tiene_beca=null;
		$this->organismo=null;
		$this->tiene_hermanos=null;
		$this->cuantas_hembras=null;
		$this->cuantos_varones=null;
		$this->estudian_aca=null;
		$this->que_anio=null;
		$this->peso=null;
		$this->talla=null;
		$this->indice=null;
		$this->tiene_talento=null;
		$this->cual_talento=null;
		$this->cedula_padre=null;
		$this->fecha_nacimiento_padre=null;
		$this->primer_nombre_padre=null;
		$this->segundo_nombre_padre=null;
		$this->primer_apellido_padre=null;
		$this->segundo_apellido_padre=null;
		$this->lugar_nacimiento_padre=null;
		$this->direccion_padre=null;
		$this->telefono_local_padre=null;
		$this->telefono_movil_padre=null;
		$this->profesion_padre=null;
		$this->grado_instruccion_padre=null;
		$this->cedula_madre=null;
		$this->fecha_nacimiento_madre=null;
		$this->primer_nombre_madre=null;
		$this->segundo_nombre_madre=null;
		$this->primer_apellido_madre=null;
		$this->segundo_apellido_madre=null;
		$this->lugar_nacimiento_madre=null;
		$this->direccion_madre=null;
		$this->telefono_local_madre=null;
		$this->telefono_movil_madre=null;
		$this->profesion_madre=null;
		$this->grado_instruccion_madre=null;
		$this->codigo_parentesco=null;
		$this->cedula_representante=null;
		$this->fecha_nacimiento_representante=null;
		$this->primer_nombre_representante=null;
		$this->segundo_nombre_representante=null;
		$this->primer_apellido_representante=null;
		$this->segundo_apellido_representante=null;
		$this->lugar_nacimiento_representante=null;
		$this->sexo_representante=null;
		$this->direccion_representante=null;
		$this->telefono_local_representante=null;
		$this->telefono_movil_representante=null;
		$this->profesion_representante=null;
		$this->grado_instruccion_representante=null;
		$this->integracion_escuela_comunidad=null;
		$this->especifique_integracion=null;
		$this->seccion=null;
		$this->observacion=null;
		$this->estatus=null;
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

    public function cedula_persona(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cedula_persona;
     
		if($Num_Parametro>0){
	   		$this->cedula_persona=func_get_arg(0);
	 	}
    }

    public function cedula_responsable(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cedula_responsable;

		if($Num_Parametro>0){
			$this->cedula_responsable=func_get_arg(0);
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

    public function fecha_nacimiento_estudiante(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->fecha_nacimiento_estudiante;

		if($Num_Parametro>0){
			$this->fecha_nacimiento_estudiante=func_get_arg(0);
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

    public function estado_salud(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estado_salud;

		if($Num_Parametro>0){
			$this->estado_salud=func_get_arg(0);
		}
    }

    public function alergico(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->alergico;
     
		if($Num_Parametro>0){
	   		$this->alergico=func_get_arg(0);
	 	}
    }

    public function impedimento_deporte(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->impedimento_deporte;

		if($Num_Parametro>0){
			$this->impedimento_deporte=func_get_arg(0);
		}
    }

    public function especifique_deporte(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->especifique_deporte;

		if($Num_Parametro>0){
			$this->especifique_deporte=func_get_arg(0);
		}
    }

    public function materia_pendiente(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->materia_pendiente;
     
		if($Num_Parametro>0){
	   		$this->materia_pendiente=func_get_arg(0);
	 	}
    }

    public function cual_materia(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cual_materia;

		if($Num_Parametro>0){
			$this->cual_materia=func_get_arg(0);
		}
    }

    public function practica_deporte(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->practica_deporte;
     
		if($Num_Parametro>0){
	   		$this->practica_deporte=func_get_arg(0);
	 	}
    }

    public function cual_deporte(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cual_deporte;

		if($Num_Parametro>0){
			$this->cual_deporte=func_get_arg(0);
		}
    }

    public function tiene_beca(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->tiene_beca;

		if($Num_Parametro>0){
			$this->tiene_beca=func_get_arg(0);
		}
    }

    public function organismo(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->organismo;
     
		if($Num_Parametro>0){
	   		$this->organismo=func_get_arg(0);
	 	}
    }

    public function tiene_hermanos(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->tiene_hermanos;

		if($Num_Parametro>0){
			$this->tiene_hermanos=func_get_arg(0);
		}
    }

    public function cuantas_hembras(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cuantas_hembras;

		if($Num_Parametro>0){
			$this->cuantas_hembras=func_get_arg(0);
		}
    }

    public function cuantos_varones(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cuantos_varones;
     
		if($Num_Parametro>0){
	   		$this->cuantos_varones=func_get_arg(0);
	 	}
    }

    public function estudian_aca(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estudian_aca;

		if($Num_Parametro>0){
			$this->estudian_aca=func_get_arg(0);
		}
    }

    public function que_anio(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->que_anio;

		if($Num_Parametro>0){
			$this->que_anio=func_get_arg(0);
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

    public function tiene_talento(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->tiene_talento;
     
		if($Num_Parametro>0){
	   		$this->tiene_talento=func_get_arg(0);
	 	}
    }

    public function cual_talento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cual_talento;

		if($Num_Parametro>0){
			$this->cual_talento=func_get_arg(0);
		}
    }

    public function cedula_padre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cedula_padre;

		if($Num_Parametro>0){
			$this->cedula_padre=func_get_arg(0);
		}
    }

    public function fecha_nacimiento_padre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->fecha_nacimiento_padre;

		if($Num_Parametro>0){
			$this->fecha_nacimiento_padre=func_get_arg(0);
		}
    }

    public function primer_nombre_padre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->primer_nombre_padre;

		if($Num_Parametro>0){
			$this->primer_nombre_padre=func_get_arg(0);
		}
    }

    public function segundo_nombre_padre(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->segundo_nombre_padre;
     
		if($Num_Parametro>0){
	   		$this->segundo_nombre_padre=func_get_arg(0);
	 	}
    }

    public function primer_apellido_padre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->primer_apellido_padre;

		if($Num_Parametro>0){
			$this->primer_apellido_padre=func_get_arg(0);
		}
    }

    public function segundo_apellido_padre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->segundo_apellido_padre;

		if($Num_Parametro>0){
			$this->segundo_apellido_padre=func_get_arg(0);
		}
    }

    public function lugar_nacimiento_padre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->lugar_nacimiento_padre;

		if($Num_Parametro>0){
			$this->lugar_nacimiento_padre=func_get_arg(0);
		}
    }

    public function direccion_padre(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->direccion_padre;
     
		if($Num_Parametro>0){
	   		$this->direccion_padre=func_get_arg(0);
	 	}
    }

    public function telefono_local_padre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->telefono_local_padre;

		if($Num_Parametro>0){
			$this->telefono_local_padre=func_get_arg(0);
		}
    }

    public function telefono_movil_padre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->telefono_movil_padre;

		if($Num_Parametro>0){
			$this->telefono_movil_padre=func_get_arg(0);
		}
    }

    public function profesion_padre(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->profesion_padre;
     
		if($Num_Parametro>0){
	   		$this->profesion_padre=func_get_arg(0);
	 	}
    }

    public function grado_instruccion_padre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->grado_instruccion_padre;

		if($Num_Parametro>0){
			$this->grado_instruccion_padre=func_get_arg(0);
		}
    }

    public function cedula_madre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cedula_madre;

		if($Num_Parametro>0){
			$this->cedula_madre=func_get_arg(0);
		}
    }

    public function fecha_nacimiento_madre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->fecha_nacimiento_madre;

		if($Num_Parametro>0){
			$this->fecha_nacimiento_madre=func_get_arg(0);
		}
    }

    public function primer_nombre_madre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->primer_nombre_madre;

		if($Num_Parametro>0){
			$this->primer_nombre_madre=func_get_arg(0);
		}
    }

    public function segundo_nombre_madre(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->segundo_nombre_madre;
     
		if($Num_Parametro>0){
	   		$this->segundo_nombre_madre=func_get_arg(0);
	 	}
    }

    public function primer_apellido_madre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->primer_apellido_madre;

		if($Num_Parametro>0){
			$this->primer_apellido_madre=func_get_arg(0);
		}
    }

    public function segundo_apellido_madre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->segundo_apellido_madre;

		if($Num_Parametro>0){
			$this->segundo_apellido_madre=func_get_arg(0);
		}
    }

    public function lugar_nacimiento_madre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->lugar_nacimiento_madre;

		if($Num_Parametro>0){
			$this->lugar_nacimiento_madre=func_get_arg(0);
		}
    }

    public function direccion_madre(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->direccion_madre;
     
		if($Num_Parametro>0){
	   		$this->direccion_madre=func_get_arg(0);
	 	}
    }

    public function telefono_local_madre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->telefono_local_madre;

		if($Num_Parametro>0){
			$this->telefono_local_madre=func_get_arg(0);
		}
    }

    public function telefono_movil_madre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->telefono_movil_madre;

		if($Num_Parametro>0){
			$this->telefono_movil_madre=func_get_arg(0);
		}
    }

    public function profesion_madre(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->profesion_madre;
     
		if($Num_Parametro>0){
	   		$this->profesion_madre=func_get_arg(0);
	 	}
    }

    public function grado_instruccion_madre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->grado_instruccion_madre;

		if($Num_Parametro>0){
			$this->grado_instruccion_madre=func_get_arg(0);
		}
    }

    public function codigo_parentesco(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_parentesco;

		if($Num_Parametro>0){
			$this->codigo_parentesco=func_get_arg(0);
		}
    }

    public function cedula_representante(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cedula_representante;

		if($Num_Parametro>0){
			$this->cedula_representante=func_get_arg(0);
		}
    }

    public function fecha_nacimiento_representante(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->fecha_nacimiento_representante;

		if($Num_Parametro>0){
			$this->fecha_nacimiento_representante=func_get_arg(0);
		}
    }

    public function primer_nombre_representante(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->primer_nombre_representante;

		if($Num_Parametro>0){
			$this->primer_nombre_representante=func_get_arg(0);
		}
    }

    public function segundo_nombre_representante(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->segundo_nombre_representante;
     
		if($Num_Parametro>0){
	   		$this->segundo_nombre_representante=func_get_arg(0);
	 	}
    }

    public function primer_apellido_representante(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->primer_apellido_representante;

		if($Num_Parametro>0){
			$this->primer_apellido_representante=func_get_arg(0);
		}
    }

    public function segundo_apellido_representante(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->segundo_apellido_representante;

		if($Num_Parametro>0){
			$this->segundo_apellido_representante=func_get_arg(0);
		}
    }

    public function lugar_nacimiento_representante(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->lugar_nacimiento_representante;

		if($Num_Parametro>0){
			$this->lugar_nacimiento_representante=func_get_arg(0);
		}
    }

    public function sexo_representante(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->sexo_representante;

		if($Num_Parametro>0){
			$this->sexo_representante=func_get_arg(0);
		}
    }

    public function direccion_representante(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->direccion_representante;
     
		if($Num_Parametro>0){
	   		$this->direccion_representante=func_get_arg(0);
	 	}
    }

    public function telefono_local_representante(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->telefono_local_representante;

		if($Num_Parametro>0){
			$this->telefono_local_representante=func_get_arg(0);
		}
    }

    public function telefono_movil_representante(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->telefono_movil_representante;

		if($Num_Parametro>0){
			$this->telefono_movil_representante=func_get_arg(0);
		}
    }

    public function profesion_representante(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->profesion_representante;
     
		if($Num_Parametro>0){
	   		$this->profesion_representante=func_get_arg(0);
	 	}
    }

    public function grado_instruccion_representante(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->grado_instruccion_representante;

		if($Num_Parametro>0){
			$this->grado_instruccion_representante=func_get_arg(0);
		}
    }

    public function integracion_escuela_comunidad(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->integracion_escuela_comunidad;

		if($Num_Parametro>0){
			$this->integracion_escuela_comunidad=func_get_arg(0);
		}
    }

    public function especifique_integracion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->especifique_integracion;

		if($Num_Parametro>0){
			$this->especifique_integracion=func_get_arg(0);
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

    public function ObtenerCodigo($cedula_estudiante){
    	$sql="SELECT codigo_proceso_inscripcion FROM educacion.tproceso_inscripcion WHERE cedula_persona='$cedula_estudiante' ORDER BY fecha_modificacion DESC";
   		$query=$this->pgsql->Ejecutar($sql);
   		if($row=$this->pgsql->Respuesta($query)){
   			return $row['codigo_proceso_inscripcion'];
   		}
   		else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
    }
   
   	public function Registrar_Paso1($user){
   		$ok=true;
   		$this->Transaccion('iniciando');
   		$estudiante = new estudiante();
		$estudiante->cedula_persona($this->cedula_persona);
		$estudiante->primer_nombre($this->primer_nombre);
		$estudiante->segundo_nombre($this->segundo_nombre);
		$estudiante->primer_apellido($this->primer_apellido);
		$estudiante->segundo_apellido($this->segundo_apellido);
		$estudiante->sexo($this->sexo);
		$estudiante->fecha_nacimiento($this->fecha_nacimiento_estudiante);
		$estudiante->lugar_nacimiento($this->lugar_nacimiento);
		$estudiante->direccion($this->direccion);
		$estudiante->telefono_local($this->telefono_local);
		$estudiante->telefono_movil($this->telefono_movil);
		if(!$estudiante->Comprobar()){
			if($estudiante->Registrar($user)){
				$sql="INSERT INTO educacion.tproceso_inscripcion (codigo_inscripcion,fecha_inscripcion,codigo_ano_academico,cedula_persona,cedula_responsable,
				anio_a_cursar,coordinacion_pedagogica,creado_por,fecha_creacion) VALUES ('$this->codigo_inscripcion','$this->fecha_inscripcion','$this->codigo_ano_academico',
				'$this->cedula_persona','$this->cedula_responsable','$this->anio_a_cursar','$this->coordinacion_pedagogica','$user',NOW());";
			    if($this->pgsql->Ejecutar($sql)!=null){
			    	$this->codigo_proceso_inscripcion($this->ObtenerCodigo($this->cedula_persona));
					$ok=true;
			    }
				else{
			    	$this->error(pg_last_error());
					$ok=false;
			    }
			}
			else{
		    	$this->error(pg_last_error());
				$ok=false;
		    }
		}else{
			if($estudiante->estatus()==1)
				$ok=false;
			else{
				if($estudiante->Activar($user)){
					$sql="INSERT INTO educacion.tproceso_inscripcion (codigo_inscripcion,fecha_inscripcion,codigo_ano_academico,cedula_persona,cedula_responsable,
					anio_a_cursar,coordinacion_pedagogica,creado_por,fecha_creacion) VALUES ('$this->codigo_inscripcion','$this->fecha_inscripcion','$this->codigo_ano_academico',
					'$this->cedula_persona','$this->cedula_responsable','$this->anio_a_cursar','$this->coordinacion_pedagogica','$user',NOW());";
				    if($this->pgsql->Ejecutar($sql)!=null){
				    	$this->codigo_proceso_inscripcion($this->ObtenerCodigo($this->cedula_persona));
						$ok=true;
				    }
					else{
				    	$this->error(pg_last_error());
						$ok=false;
				    }
				}
			}
		}
		if($ok==true){
			$this->Transaccion('finalizado');
			return true;
		}
		else{
			$this->Transaccion('cancelado');
			return false;
		}
   	}

   	public function Registrar_Paso2($user){
   		$sqlx="SELECT CAST(EXTRACT(Year FROM age(NOW(),p.fecha_nacimiento))||'.'||EXTRACT(Month FROM age(NOW(),p.fecha_nacimiento)) AS numeric) edad,
		i.peso,i.talla  
		FROM educacion.tproceso_inscripcion i 
		INNER JOIN general.tpersona p ON i.cedula_persona = p.cedula_persona 
		WHERE i.codigo_proceso_inscripcion = $this->codigo_proceso_inscripcion";
		$query=$this->pgsql->Ejecutar($sqlx);
		if($this->pgsql->Total_Filas($query)!=0){
			$testudiante=$this->pgsql->Respuesta($query);
			$tabulador=new tabulador();
			$this->indice($tabulador->ObtenerIndice($testudiante['edad'],$testudiante['peso'],$testudiante['talla']));
		}else{
	    	$this->error(pg_last_error());
			return false;
	    }
   		$sql="UPDATE educacion.tproceso_inscripcion SET estado_salud='$this->estado_salud',alergico='$this->alergico',impedimento_deporte='$this->impedimento_deporte',
   		especifique_deporte='$this->especifique_deporte',materia_pendiente='$this->materia_pendiente',cual_materia='$this->cual_materia',practica_deporte='$this->practica_deporte',
   		cual_deporte='$this->cual_deporte',tiene_beca='$this->tiene_beca',organismo='$this->organismo',tiene_hermanos='$this->tiene_hermanos',cuantas_hembras='$this->cuantas_hembras',
   		cuantos_varones='$this->cuantos_varones',estudian_aca='$this->estudian_aca',que_anio='$this->que_anio',peso='$this->peso',talla='$this->talla',indice='$this->indice',tiene_talento='$this->tiene_talento',
   		cual_talento='$this->cual_talento',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_proceso_inscripcion='$this->codigo_proceso_inscripcion' AND cedula_persona='$this->cedula_persona'";
	    if($this->pgsql->Ejecutar($sql)!=null){
	    	$this->codigo_proceso_inscripcion($this->ObtenerCodigo($this->cedula_persona));
			return true;
	    }
		else{
	    	$this->error(pg_last_error());
			return false;
	    }
   	}

   	public function Registrar_Paso3($user){
   		// Verificamos si existe un padre o una madre
   		if($this->cedula_padre!="" || $this->cedula_madre!=""){
   			$ok=true;
	   		$ok2=true;
	   		$tipo_persona = new tipopersona();
	   		$parentesco = new parentesco();
	   		$this->Transaccion('iniciando');
	   		$padre = new persona();
			$padre->cedula_persona($this->cedula_padre);
			$padre->primer_nombre($this->primer_nombre_padre);
			$padre->segundo_nombre($this->segundo_nombre_padre);
			$padre->primer_apellido($this->primer_apellido_padre);
			$padre->segundo_apellido($this->segundo_apellido_padre);
			$padre->sexo('M');
			$padre->fecha_nacimiento($this->fecha_nacimiento_padre);
			$padre->lugar_nacimiento($this->lugar_nacimiento_padre);
			$padre->direccion($this->direccion_padre);
			$padre->telefono_local($this->telefono_local_padre);
			$padre->telefono_movil($this->telefono_movil_padre);
			$padre->codigo_tipopersona($tipo_persona->BuscarCodigo('REPRESENTANTE'));
			$padre->profesion($this->profesion_padre);
			$padre->grado_instruccion($this->grado_instruccion_padre);
			if($this->cedula_padre!=""){
				if(!$padre->Comprobar()){
					if($padre->Registrar($user)){
						$sql="UPDATE educacion.tproceso_inscripcion SET cedula_padre='$this->cedula_padre',modificado_por='$user',fecha_modificacion=NOW() 
						WHERE codigo_proceso_inscripcion='$this->codigo_proceso_inscripcion' AND cedula_persona='$this->cedula_persona'";
					    if($this->pgsql->Ejecutar($sql)!=null)
							if($this->GenerarCargaFamiliar($this->cedula_persona,$this->cedula_padre,$parentesco->BuscarCodigo('PADRE'),'N',$user)){
	    						$this->codigo_proceso_inscripcion($this->ObtenerCodigo($this->cedula_persona));
								$ok=true;
							}
							else{
						    	$this->error(pg_last_error());
								$ok=false;
						    }
						else{
					    	$this->error(pg_last_error());
							$ok=false;
					    }
					}
					else{
				    	$this->error(pg_last_error());
						$ok=false;
				    }
				}else{
					if($padre->estatus()==1)
						$ok=false;
					else{
						if($padre->Activar($user)){
							$sql="UPDATE educacion.tproceso_inscripcion SET cedula_padre='$this->cedula_padre',modificado_por='$user',fecha_modificacion=NOW() 
							WHERE codigo_proceso_inscripcion='$this->codigo_proceso_inscripcion' AND cedula_persona='$this->cedula_persona'";
						    if($this->pgsql->Ejecutar($sql)!=null)
								if($this->GenerarCargaFamiliar($this->cedula_persona,$this->cedula_padre,$parentesco->BuscarCodigo('PADRE'),'N',$user)){
	    							$this->codigo_proceso_inscripcion($this->ObtenerCodigo($this->cedula_persona));
									$ok=true;
								}
								else{
							    	$this->error(pg_last_error());
									$ok=false;
							    }
							else{
						    	$this->error(pg_last_error());
								$ok=false;
						    }
						}
					}
				}
			}else{
		    	$this->error(pg_last_error());
				$ok=false;
		    }
	   		$madre = new persona();
			$madre->cedula_persona($this->cedula_madre);
			$madre->primer_nombre($this->primer_nombre_madre);
			$madre->segundo_nombre($this->segundo_nombre_madre);
			$madre->primer_apellido($this->primer_apellido_madre);
			$madre->segundo_apellido($this->segundo_apellido_madre);
			$madre->sexo('F');
			$madre->fecha_nacimiento($this->fecha_nacimiento_madre);
			$madre->lugar_nacimiento($this->lugar_nacimiento_madre);
			$madre->direccion($this->direccion_madre);
			$madre->telefono_local($this->telefono_local_madre);
			$madre->telefono_movil($this->telefono_movil_madre);
			$madre->codigo_tipopersona($tipo_persona->BuscarCodigo('REPRESENTANTE'));
			$madre->profesion($this->profesion_madre);
			$madre->grado_instruccion($this->grado_instruccion_madre);
			if($this->cedula_madre!=""){
				if(!$madre->Comprobar()){
					if($madre->Registrar($user)){
						$sql="UPDATE educacion.tproceso_inscripcion SET cedula_madre='$this->cedula_madre',modificado_por='$user',fecha_modificacion=NOW() 
						WHERE codigo_proceso_inscripcion='$this->codigo_proceso_inscripcion' AND cedula_persona='$this->cedula_persona'";
					    if($this->pgsql->Ejecutar($sql)!=null){
					    	if($this->GenerarCargaFamiliar($this->cedula_persona,$this->cedula_madre,$parentesco->BuscarCodigo('MADRE'),'N',$user)){
					    		$this->codigo_proceso_inscripcion($this->ObtenerCodigo($this->cedula_persona));
								$ok2=true;
					    	}
							else{
						    	$this->error(pg_last_error());
								$ok2=false;
						    }
					    }
						else{
					    	$this->error(pg_last_error());
							$ok2=false;
					    }
					}
					else{
				    	$this->error(pg_last_error());
						$ok2=false;
				    }
				}else{
					if($madre->estatus()==1)
						$ok2=false;
					else{
						if($madre->Activar($user)){
							$sql="UPDATE educacion.tproceso_inscripcion SET cedula_madre='$this->cedula_madre',modificado_por='$user',fecha_modificacion=NOW() 
							WHERE codigo_proceso_inscripcion='$this->codigo_proceso_inscripcion' AND cedula_persona='$this->cedula_persona'";
						    if($this->pgsql->Ejecutar($sql)!=null)
								if($this->GenerarCargaFamiliar($this->cedula_persona,$this->cedula_madre,$parentesco->BuscarCodigo('MADRE'),'N',$user)){
									$this->codigo_proceso_inscripcion($this->ObtenerCodigo($this->cedula_persona));
									$ok2=true;
								}
								else{
							    	$this->error(pg_last_error());
									$ok2=false;
							    }
							else{
						    	$this->error(pg_last_error());
								$ok2=false;
						    }
						}
					}
				}
			}else{
		    	$this->error(pg_last_error());
				$ok2=false;
		    }
			if($ok==true && $ok2==true){
				$this->Transaccion('finalizado');
				return true;
			}
			else{
				$this->Transaccion('cancelado');
				return false;
			}
   		}else{
   			return true;
   		}
   	}

   	public function Registrar_Paso4($user){
   		if($this->cedula_representante!=$this->cedula_padre && $this->cedula_representante!=$this->cedula_madre){
	   		$ok=true;
	   		$tipo_persona = new tipopersona();
	   		$this->Transaccion('iniciando');
	   		$representante = new persona();
			$representante->cedula_persona($this->cedula_representante);
			$representante->primer_nombre($this->primer_nombre_representante);
			$representante->segundo_nombre($this->segundo_nombre_representante);
			$representante->primer_apellido($this->primer_apellido_representante);
			$representante->segundo_apellido($this->segundo_apellido_representante);
			$representante->sexo($this->sexo_representante);
			$representante->fecha_nacimiento($this->fecha_nacimiento_representante);
			$representante->lugar_nacimiento($this->lugar_nacimiento_representante);
			$representante->direccion($this->direccion_representante);
			$representante->telefono_local($this->telefono_local_representante);
			$representante->telefono_movil($this->telefono_movil_representante);
			$representante->codigo_tipopersona($tipo_persona->BuscarCodigo('REPRESENTANTE'));
			$representante->profesion($this->profesion_representante);
			$representante->grado_instruccion($this->grado_instruccion_representante);
			if(!$representante->Comprobar()){
				if($representante->Registrar($user)){
					$sql="UPDATE educacion.tproceso_inscripcion SET cedula_representante='$this->cedula_representante',codigo_parentesco='$this->codigo_parentesco',
					modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_proceso_inscripcion='$this->codigo_proceso_inscripcion' AND cedula_persona='$this->cedula_persona'";
				    if($this->pgsql->Ejecutar($sql)!=null)
						if($this->GenerarCargaFamiliar($this->cedula_persona,$this->cedula_representante,$this->codigo_parentesco,'Y',$user)){
							$this->codigo_proceso_inscripcion($this->ObtenerCodigo($this->cedula_persona));
							$ok=true;
						}
						else{
					    	$this->error(pg_last_error());
							$ok=false;
					    }
					else{
				    	$this->error(pg_last_error());
						$ok=false;
				    }
				}
				else{
			    	$this->error(pg_last_error());
					$ok=false;
			    }
			}else{
				if($representante->estatus()==1)
					$ok=false;
				else{
					if($representante->Activar($user)){
						$sql="UPDATE educacion.tproceso_inscripcion SET cedula_representante='$this->cedula_representante',codigo_parentesco='$this->codigo_parentesco',
						modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_proceso_inscripcion='$this->codigo_proceso_inscripcion' AND cedula_persona='$this->cedula_persona'";
					    if($this->pgsql->Ejecutar($sql)!=null)
							if($this->GenerarCargaFamiliar($this->cedula_persona,$this->cedula_representante,$this->codigo_parentesco,'Y',$user)){
								$this->codigo_proceso_inscripcion($this->ObtenerCodigo($this->cedula_persona));
								$ok=true;
							}
							else{
						    	$this->error(pg_last_error());
								$ok=false;
						    }
						else{
					    	$this->error(pg_last_error());
							$ok=false;
					    }
					}
				}
			}
			if($ok==true){
				$this->Transaccion('finalizado');
				return true;
			}
			else{
				$this->Transaccion('cancelado');
				return false;
			}
   		}
   		else{
   			$ok=true;
	   		$this->Transaccion('iniciando');
   			$sql="UPDATE educacion.tproceso_inscripcion SET cedula_representante='$this->cedula_representante',codigo_parentesco='$this->codigo_parentesco',
   			modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_proceso_inscripcion='$this->codigo_proceso_inscripcion' AND cedula_persona = '$this->cedula_persona'";
		    if($this->pgsql->Ejecutar($sql)!=null){
		    	$this->codigo_proceso_inscripcion($this->ObtenerCodigo($this->cedula_persona));
		    	$sqlx="UPDATE general.tdetalle_familiar SET es_representantelegal='Y',modificado_por='$user',fecha_modificacion=NOW() 
		    	WHERE cedula_persona='$this->cedula_persona' AND cedula_familiar='$this->cedula_representante' AND codigo_parentesco='$this->codigo_parentesco'";
		    	if($this->pgsql->Ejecutar($sqlx)!=null)
					$ok=true;
				else{
			    	$this->error(pg_last_error());
					$ok=false;
			    }
		    }
			else{
		    	$this->error(pg_last_error());
				$ok=false;
		    }

			if($ok==true){
				$this->Transaccion('finalizado');
				return true;
			}
			else{
				$this->Transaccion('cancelado');
				return false;
			}
   		}
   	}

   	public function Registrar_Paso5($user){
   		$ok=true;
	   	$this->Transaccion('iniciando');
   		$sql="UPDATE educacion.tproceso_inscripcion SET integracion_escuela_comunidad='$this->integracion_escuela_comunidad',especifique_integracion='$this->especifique_integracion',
   		modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_proceso_inscripcion='$this->codigo_proceso_inscripcion' AND cedula_persona='$this->cedula_persona'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			$ok=true;
		else{
	    	$this->error(pg_last_error());
			$ok=false;
	    }

		if($ok==true){
			$this->Transaccion('finalizado');
			return true;
		}
		else{
			$this->Transaccion('cancelado');
			return false;
		}
   	}
   
    public function Actualizar_Paso1($user,$oldci){
	    $ok=true;
   		$this->Transaccion('iniciando');
   		$estudiante = new estudiante();
		$estudiante->cedula_persona($this->cedula_persona);
		$estudiante->primer_nombre($this->primer_nombre);
		$estudiante->segundo_nombre($this->segundo_nombre);
		$estudiante->primer_apellido($this->primer_apellido);
		$estudiante->segundo_apellido($this->segundo_apellido);
		$estudiante->sexo($this->sexo);
		$estudiante->fecha_nacimiento($this->fecha_nacimiento_estudiante);
		$estudiante->lugar_nacimiento($this->lugar_nacimiento);
		$estudiante->direccion($this->direccion);
		$estudiante->telefono_local($this->telefono_local);
		$estudiante->telefono_movil($this->telefono_movil);
		if($estudiante->Actualizar($user,$oldci)){
			$sql="UPDATE educacion.tproceso_inscripcion SET codigo_inscripcion='$this->codigo_inscripcion',fecha_inscripcion='$this->fecha_inscripcion',
			codigo_ano_academico='$this->codigo_ano_academico',cedula_persona='$this->cedula_persona',cedula_responsable='$this->cedula_responsable',
			anio_a_cursar='$this->anio_a_cursar',coordinacion_pedagogica='$this->coordinacion_pedagogica',modificado_por='$user',fecha_creacion=NOW() 
			WHERE codigo_proceso_inscripcion = '$this->codigo_proceso_inscripcion' AND cedula_persona = '$oldci'";
		    if($this->pgsql->Ejecutar($sql)!=null)
				$ok=true;
			else{
		    	$this->error(pg_last_error());
				$ok=false;
		    }
		}
		else{
	    	$this->error(pg_last_error());
			$ok=false;
	    }

		if($ok==true){
			$this->Transaccion('finalizado');
			return true;
		}
		else{
			$this->Transaccion('cancelado');
			return false;
		}
   	}

   	public function Actualizar_Paso2($user){
   		$sqlx="SELECT CAST(EXTRACT(Year FROM age(NOW(),p.fecha_nacimiento))||'.'||EXTRACT(Month FROM age(NOW(),p.fecha_nacimiento)) AS numeric) edad   
		FROM educacion.tproceso_inscripcion i 
		INNER JOIN general.tpersona p ON i.cedula_persona = p.cedula_persona 
		WHERE i.codigo_proceso_inscripcion = $this->codigo_proceso_inscripcion";
		$query=$this->pgsql->Ejecutar($sqlx);
		if($this->pgsql->Total_Filas($query)!=0){
			$testudiante=$this->pgsql->Respuesta($query);
			$tabulador=new tabulador();
			$this->indice($tabulador->ObtenerIndice($testudiante['edad'],$this->peso,$this->talla));
		}else{
	    	$this->error(pg_last_error());
			return false;
	    }
   		$sql="UPDATE educacion.tproceso_inscripcion SET estado_salud='$this->estado_salud',alergico='$this->alergico',impedimento_deporte='$this->impedimento_deporte',
   		especifique_deporte='$this->especifique_deporte',materia_pendiente='$this->materia_pendiente',cual_materia='$this->cual_materia',practica_deporte='$this->practica_deporte',
   		cual_deporte='$this->cual_deporte',tiene_beca='$this->tiene_beca',organismo='$this->organismo',tiene_hermanos='$this->tiene_hermanos',cuantas_hembras='$this->cuantas_hembras',
   		cuantos_varones='$this->cuantos_varones',estudian_aca='$this->estudian_aca',que_anio='$this->que_anio',peso='$this->peso',talla='$this->talla',indice='$this->indice',tiene_talento='$this->tiene_talento',
   		cual_talento='$this->cual_talento',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_proceso_inscripcion='$this->codigo_proceso_inscripcion' AND cedula_persona='$this->cedula_persona'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else{
	    	$this->error(pg_last_error());
			return false;
	    }
   	}

   	public function Actualizar_Paso3($user,$oldcip,$oldcim){
   		// Verificamos si existe un padre o una madre
   		if($this->cedula_padre!="" || $this->cedula_madre!=""){
   			$ok=true;
	   		$ok2=true;
	   		$tipo_persona = new tipopersona();
	   		$parentesco = new parentesco();
	   		$this->Transaccion('iniciando');
	   		$padre = new persona();
			$padre->cedula_persona($this->cedula_padre);
			$padre->primer_nombre($this->primer_nombre_padre);
			$padre->segundo_nombre($this->segundo_nombre_padre);
			$padre->primer_apellido($this->primer_apellido_padre);
			$padre->segundo_apellido($this->segundo_apellido_padre);
			$padre->sexo('M');
			$padre->fecha_nacimiento($this->fecha_nacimiento_padre);
			$padre->lugar_nacimiento($this->lugar_nacimiento_padre);
			$padre->direccion($this->direccion_padre);
			$padre->telefono_local($this->telefono_local_padre);
			$padre->telefono_movil($this->telefono_movil_padre);
			$padre->codigo_tipopersona($tipo_persona->BuscarCodigo('REPRESENTANTE'));
			$padre->profesion($this->profesion_padre);
			$padre->grado_instruccion($this->grado_instruccion_padre);
			if($this->cedula_padre!=""){
				if($padre->Actualizar($user,$oldcip)){
					$sql="UPDATE educacion.tproceso_inscripcion SET cedula_padre='$this->cedula_padre',modificado_por='$user',fecha_modificacion=NOW() 
					WHERE codigo_proceso_inscripcion='$this->codigo_proceso_inscripcion' AND cedula_persona='$this->cedula_persona'";
				    if($this->pgsql->Ejecutar($sql)!=null){
				    	$parentesco_padre = $parentesco->BuscarCodigo('PADRE');
				    	$sqlx="UPDATE general.tdetalle_familiar SET es_representantelegal='Y',modificado_por='$user',fecha_modificacion=NOW() 
				    	WHERE cedula_persona='$this->cedula_persona' AND cedula_familiar='$this->cedula_padre' AND codigo_parentesco='$parentesco_padre'";
				    	if($this->pgsql->Ejecutar($sqlx)!=null)
							$ok=true;
						else{
					    	$this->error(pg_last_error());
							$ok=false;
					    }
				    }
					else{
				    	$this->error(pg_last_error());
						$ok=false;
				    }
				}
			}else{
		    	$this->error(pg_last_error());
				$ok=false;
		    }
	   		$madre = new persona();
			$madre->cedula_persona($this->cedula_madre);
			$madre->primer_nombre($this->primer_nombre_madre);
			$madre->segundo_nombre($this->segundo_nombre_madre);
			$madre->primer_apellido($this->primer_apellido_madre);
			$madre->segundo_apellido($this->segundo_apellido_madre);
			$madre->sexo('F');
			$madre->fecha_nacimiento($this->fecha_nacimiento_madre);
			$madre->lugar_nacimiento($this->lugar_nacimiento_madre);
			$madre->direccion($this->direccion_madre);
			$madre->telefono_local($this->telefono_local_madre);
			$madre->telefono_movil($this->telefono_movil_madre);
			$madre->codigo_tipopersona($tipo_persona->BuscarCodigo('REPRESENTANTE'));
			$madre->profesion($this->profesion_madre);
			$madre->grado_instruccion($this->grado_instruccion_madre);
			if($this->cedula_madre!=""){
				if($madre->Actualizar($user,$oldcim)){
					$sql="UPDATE educacion.tproceso_inscripcion SET cedula_madre='$this->cedula_madre',modificado_por='$user',fecha_modificacion=NOW() 
					WHERE codigo_proceso_inscripcion='$this->codigo_proceso_inscripcion' AND cedula_persona='$this->cedula_persona'";
				    if($this->pgsql->Ejecutar($sql)!=null){
				    	$parentesco_madre = $parentesco->BuscarCodigo('MADRE');
				    	$sqlx="UPDATE general.tdetalle_familiar SET es_representantelegal='Y',modificado_por='$user',fecha_modificacion=NOW() 
				    	WHERE cedula_persona='$this->cedula_persona' AND cedula_familiar='$this->cedula_madre' AND codigo_parentesco='$parentesco_madre'";
				    	if($this->pgsql->Ejecutar($sqlx)!=null)
							$ok2=true;
						else{
					    	$this->error(pg_last_error());
							$ok2=false;
					    }
				    }
					else{
				    	$this->error(pg_last_error());
						$ok2=false;
				    }
				}
			}else{
		    	$this->error(pg_last_error());
				$ok2=false;
		    }
			if($ok==true && $ok2==true){
				$this->Transaccion('finalizado');
				return true;
			}
			else{
				$this->Transaccion('cancelado');
				return false;
			}
   		}else{
   			return true;
   		}
   	}

   	public function Actualizar_Paso4($user){
   		if($this->cedula_representante!=$this->cedula_padre && $this->cedula_representante!=$this->cedula_madre){
	   		$ok=true;
	   		$tipo_persona = new tipopersona();
	   		$this->Transaccion('iniciando');
	   		$representante = new persona();
			$representante->cedula_persona($this->cedula_representante);
			$representante->primer_nombre($this->primer_nombre_representante);
			$representante->segundo_nombre($this->segundo_nombre_representante);
			$representante->primer_apellido($this->primer_apellido_representante);
			$representante->segundo_apellido($this->segundo_apellido_representante);
			$representante->sexo($this->sexo_representante);
			$representante->fecha_nacimiento($this->fecha_nacimiento_representante);
			$representante->lugar_nacimiento($this->lugar_nacimiento_representante);
			$representante->direccion($this->direccion_representante);
			$representante->telefono_local($this->telefono_local_representante);
			$representante->telefono_movil($this->telefono_movil_representante);
			$representante->codigo_tipopersona($tipo_persona->BuscarCodigo('REPRESENTANTE'));
			$representante->profesion($this->profesion_representante);
			$representante->grado_instruccion($this->grado_instruccion_representante);
			if(!$representante->Comprobar()){
				if($representante->Registrar($user)){
					$sql="UPDATE educacion.tproceso_inscripcion SET cedula_representante='$this->cedula_representante',codigo_parentesco='$this->codigo_parentesco',
					modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_proceso_inscripcion='$this->codigo_proceso_inscripcion' AND cedula_persona='$this->cedula_persona'";
				    if($this->pgsql->Ejecutar($sql)!=null)
						if($this->GenerarCargaFamiliar($this->cedula_persona,$this->cedula_representante,$this->codigo_parentesco,'Y',$user))
							$ok=true;
						else{
					    	$this->error(pg_last_error());
							$ok=false;
					    }
					else{
				    	$this->error(pg_last_error());
						$ok=false;
				    }
				}
				else{
			    	$this->error(pg_last_error());
					$ok=false;
			    }
			}else{
				if($representante->estatus()==1)
					$ok=false;
				else{
					if($representante->Activar($user)){
						$sql="UPDATE educacion.tproceso_inscripcion SET cedula_representante='$this->cedula_representante',codigo_parentesco='$this->codigo_parentesco',
						modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_proceso_inscripcion='$this->codigo_proceso_inscripcion' AND cedula_persona='$this->cedula_persona'";
					    if($this->pgsql->Ejecutar($sql)!=null)
							if($this->GenerarCargaFamiliar($this->cedula_persona,$this->cedula_representante,$this->codigo_parentesco,'Y',$user))
								$ok=true;
							else{
						    	$this->error(pg_last_error());
								$ok=false;
						    }
						else{
					    	$this->error(pg_last_error());
							$ok=false;
					    }
					}
				}
			}
			if($ok==true){
				$this->Transaccion('finalizado');
				return true;
			}
			else{
				$this->Transaccion('cancelado');
				return false;
			}
   		}
   		else{
   			$ok=true;
	   		$this->Transaccion('iniciando');
   			$sql="UPDATE educacion.tproceso_inscripcion SET cedula_representante='$this->cedula_representante',codigo_parentesco='$this->codigo_parentesco',
   			modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_proceso_inscripcion='$this->codigo_proceso_inscripcion' AND cedula_persona = '$this->cedula_persona'";
		    if($this->pgsql->Ejecutar($sql)!=null){
		    	$sqlx="UPDATE general.tdetalle_familiar SET es_representantelegal='Y',modificado_por='$user',fecha_modificacion=NOW() 
		    	WHERE cedula_persona='$this->cedula_persona' AND cedula_familiar='$this->cedula_representante' AND codigo_parentesco='$this->codigo_parentesco'";
		    	if($this->pgsql->Ejecutar($sqlx)!=null)
					$ok=true;
				else{
			    	$this->error(pg_last_error());
					$ok=false;
			    }
		    }
			else{
		    	$this->error(pg_last_error());
				$ok=false;
		    }

			if($ok==true){
				$this->Transaccion('finalizado');
				return true;
			}
			else{
				$this->Transaccion('cancelado');
				return false;
			}
   		}
   	}

   	public function Actualizar_Paso5($user){
   		$sql="UPDATE educacion.tproceso_inscripcion SET integracion_escuela_comunidad='$this->integracion_escuela_comunidad',especifique_integracion='$this->especifique_integracion',
   		modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_proceso_inscripcion='$this->codigo_proceso_inscripcion' AND cedula_persona='$this->cedula_persona'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else{
	    	$this->error(pg_last_error());
			return false;
	    }
   	}

   	public function Actualizar_Paso6($user,$oldseccion){
   		$ok=true;
	   	$this->Transaccion('iniciando');
   		$sql="UPDATE educacion.tproceso_inscripcion SET seccion='$this->seccion',observacion='$this->observacion',procesado='Y',modificado_por='$user',
   		fecha_modificacion=NOW() WHERE codigo_proceso_inscripcion='$this->codigo_proceso_inscripcion' AND cedula_persona='$this->cedula_persona'";
	    if($this->pgsql->Ejecutar($sql)!=null){
	    	if($this->seccion!="0"){
	    		$sqlx="DELETE FROM educacion.tinscrito_seccion WHERE cedula_persona = '$this->cedula_persona' AND seccion = '$oldseccion'";
	    		$this->pgsql->Ejecutar($sqlx);
		    	$sqlx1="INSERT INTO educacion.tinscrito_seccion (cedula_persona,seccion,creado_por,fecha_creacion) VALUES ('$this->cedula_persona','$this->seccion','$user',NOW())";
		    	if($this->pgsql->Ejecutar($sqlx1)!=null)
		    		$ok= true;
		    	else{
			    	$this->error(pg_last_error());
					$ok=false;
			    }
	    	}else{
		    	$this->error(pg_last_error());
				$ok=false;
		    }
	    }
		else{
			$this->error(pg_last_error());
			$ok= false;
		}

		if($ok==true){
			$this->Transaccion('finalizado');
			return true;
		}
		else{
			$this->Transaccion('cancelado');
			return false;
		}
   	}

   	public function GenerarCargaFamiliar($persona,$familiar,$parentesco,$representante,$user){
   		$sql="INSERT INTO general.tdetalle_familiar (cedula_persona,cedula_familiar,codigo_parentesco,es_representantelegal,creado_por,fecha_creacion) VALUES 
   		('$persona','$familiar','$parentesco','$representante','$user',NOW())";
   		if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else{
	    	$this->error(pg_last_error());
			return false;
	    }
   	}

   	public function Asignar_Seccion($user,$pins,$ci){
   		$sql="UPDATE educacion.tproceso_inscripcion SET seccion=(SELECT s.seccion FROM educacion.tseccion s 
   		LEFT JOIN educacion.tinscrito_seccion isec ON s.seccion = isec.seccion WHERE EXISTS (SELECT * FROM educacion.tproceso_inscripcion pi 
   		WHERE pi.indice BETWEEN s.indice_min AND s.indice_max AND pi.codigo_proceso_inscripcion='$pins') 
   		GROUP BY s.seccion,s.nombre_seccion ORDER BY s.seccion,MAX(s.capacidad_max)-COUNT(isec.seccion) ASC LIMIT 1),
		observacion='ASIGNADO POR $user SEGÚN TABULADOR',procesado='Y',modificado_por='$user',fecha_modificacion=NOW() 
		WHERE codigo_proceso_inscripcion='$pins' AND cedula_persona='$ci'";
	    if($this->pgsql->Ejecutar($sql)!=null){
	    	$sqlx="INSERT INTO educacion.tinscrito_seccion (cedula_persona,seccion,creado_por,fecha_creacion) VALUES ('$ci',(SELECT s.seccion FROM educacion.tseccion s 
	   		LEFT JOIN educacion.tinscrito_seccion isec ON s.seccion = isec.seccion WHERE 
	   		EXISTS (SELECT * FROM educacion.tproceso_inscripcion pi WHERE pi.indice BETWEEN s.indice_min AND s.indice_max AND pi.codigo_proceso_inscripcion='$pins') 
	   		GROUP BY s.seccion,s.nombre_seccion ORDER BY s.seccion,MAX(s.capacidad_max)-COUNT(isec.seccion) ASC LIMIT 1),'$user',NOW())";
	    	if($this->pgsql->Ejecutar($sqlx)!=null)
	    		return true;
	    	else{
	    		$sqlz="SELECT s.seccion FROM educacion.tseccion s 
				LEFT JOIN educacion.tinscrito_seccion isec ON s.seccion = isec.seccion 
				WHERE EXISTS (SELECT * FROM educacion.tproceso_inscripcion pi 
				WHERE pi.indice BETWEEN s.indice_min AND s.indice_max AND pi.codigo_proceso_inscripcion='$pins') 
				GROUP BY s.seccion,s.nombre_seccion 
				ORDER BY s.seccion,MAX(s.capacidad_max)-COUNT(isec.seccion) ASC";
				$query=$this->pgsql->Ejecutar($sql);
				if($this->pgsql->Total_Filas($query)==0){
					$this->error('No hay secciones disponibles');
					return false;
				}
				else{
					$this->error(pg_last_error());
					return false;
				}
	    	}
	    }
		else{
			$this->error(pg_last_error());
			return false;
		}
   	}
}
?>
