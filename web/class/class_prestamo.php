<?php
require_once("class_bd.php");
class prestamo {
	private $codigo_prestamo; 
	private $cedula_responsable;
	private $cedula_persona;
	private $codigo_area;
	private $lugar_prestamo;
	private $fecha_salida;
	private $fecha_entrada;
	private $observacion;
	private $estatus; 
	private $error; 
	private $pgsql; 
	 
	public function __construct(){
		$this->cedula_responsable=null;
		$this->cedula_persona=null;
		$this->codigo_area=null;
		$this->lugar_prestamo=null;
		$this->fecha_salida=null;
		$this->fecha_entrada=null;
		$this->observacion=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_prestamo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_prestamo;

		if($Num_Parametro>0){
			$this->codigo_prestamo=func_get_arg(0);
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

        public function codigo_area(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_area;

		if($Num_Parametro>0){
			$this->codigo_area=func_get_arg(0);
		}
    }

         public function lugar_prestamo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->lugar_prestamo;

		if($Num_Parametro>0){
			$this->lugar_prestamo=func_get_arg(0);
		}
    }

    public function fecha_salida(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->fecha_salida;

		if($Num_Parametro>0){
			$this->fecha_salida=func_get_arg(0);
		}
    }

    public function fecha_entrada(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->fecha_entrada;

		if($Num_Parametro>0){
			$this->fecha_entrada=func_get_arg(0);
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

	public function EliminarPrestamos(){
		$sql="DELETE FROM biblioteca.tdetalle_prestamo WHERE codigo_prestamo='$this->codigo_prestamo'";
		if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
	}

	public function InsertarPrestamos($user,$ejemplar,$ubicacion,$cantidad){
	    $sql="INSERT INTO biblioteca.tdetalle_prestamo(codigo_prestamo,codigo_ejemplar,codigo_ubicacion,cantidad,creado_por,fecha_creacion) VALUES ";
	    for ($i=0; $i < count($ejemplar); $i++){
	    	//	Extraemos el codigo del item y la ubicacion por cada registro
	    	$item=explode('_',$ejemplar[$i]);
	    	$codigo_item=$item[0];
	    	$ubicaciones=explode('_',$ubicacion[$i]);
	    	$codigo_ubicacion=$ubicaciones[0];
	    	//	Fin
	    	$sql.="('$this->codigo_prestamo','$codigo_item','$codigo_ubicacion','".$cantidad[$i]."','$user',NOW()),";
	    }
	    $sql=substr($sql,0,-1);
	    $sql=$sql.";";
	    if($this->pgsql->Ejecutar($sql)!=null)
	      return true;
	    else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
    }
   
   	public function Registrar($user){
	    $sql="INSERT INTO biblioteca.tprestamo (cedula_responsable,cedula_persona,codigo_area,lugar_prestamo,fecha_salida,fecha_entrada,observacion,creado_por,fecha_creacion) VALUES 
	    ('$this->cedula_responsable','$this->cedula_persona','$this->codigo_area','$this->lugar_prestamo','$this->fecha_salida','$this->fecha_entrada','$this->observacion','$user',NOW());";
	    //_echo $sql; die();
	    if($this->pgsql->Ejecutar($sql)!=null){
	    	$sqlx="SELECT codigo_prestamo FROM biblioteca.tprestamo 
	    	WHERE cedula_responsable='$this->cedula_responsable' AND cedula_persona = '$this->cedula_persona' AND codigo_area='$this->codigo_area' 
	    	AND fecha_salida = '$this->fecha_salida' AND fecha_entrada = '$this->fecha_entrada' 
	    	ORDER BY creado_por DESC LIMIT 1";
	    	$query=$this->pgsql->Ejecutar($sqlx);
	    	if($this->pgsql->Total_Filas($query)!=0){
				$tprestamo=$this->pgsql->Respuesta($query);
				$this->codigo_prestamo($tprestamo['codigo_prestamo']);
	    		return true;
			}
		    else{
		    	$this->error(pg_last_error());
		    	return false;
		    }
	    }
	    else{
	    	$this->error(pg_last_error());
	    	echo $this->error()." 1 <br>";
	    	return false;
	    }
   	}
   
    public function Activar($user){
	    $sql="UPDATE biblioteca.tprestamo SET estatus = '1', modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_prestamo='$this->codigo_prestamo'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
	    else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM biblioteca.tprestamo p WHERE p.codigo_prestamo = '$this->codigo_prestamo' 
    	AND (EXISTS (SELECT 1 FROM biblioteca.tdetalle_prestamo dp WHERE p.codigo_prestamo = dp.codigo_prestamo))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE biblioteca.tprestamo SET estatus = '0', modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_prestamo='$this->codigo_prestamo'";
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
   
    public function Actualizar($user){
	    $sql="UPDATE biblioteca.tprestamo SET cedula_responsable='$this->cedula_responsable',cedula_persona='$this->cedula_persona',
	    codigo_area='$this->codigo_area',lugar_prestamo='$this->lugar_prestamo',fecha_salida='$this->fecha_salida',
	    fecha_entrada='$this->fecha_entrada',observacion='$this->observacion',modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_prestamo='$this->codigo_prestamo'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
	    else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
   	}
   	public function Consultar(){
			$sql="SELECT per.cedula_persona, INITCAP(per.primer_nombre||' '||per.primer_apellido) nombre, a.descripcion,p.lugar_prestamo, p.fecha_entrada, p.fecha_salida, p.observacion
			FROM biblioteca.tprestamo p 
			INNER JOIN general.tpersona per ON p.cedula_persona = per.cedula_persona 
			INNER JOIN general.tarea a ON p.codigo_area = a.codigo_area 
			INNER JOIN general.tdepartamento dp ON a.codigo_departamento = dp.codigo_departamento 
			WHERE p.fecha_salida BETWEEN '$this->fecha_desde' AND '$this->fecha_hasta' 
			AND dp.descripcion = 'BIBLIOTECA'";
			$query=$this->objBD->Ejecutar($sql);
			while($datos=$this->objBD->Respuesta($query)) {
				$R['hora']['dia'][$i]=$hora['dia'];
				$R['hora']['hora'][$i]=$hora['hora'];
				$R['hora']['celda'][$i]=$hora['celda'];
				$R['hora']['codigo_bloque_hora'][$i]=$hora['codigo_bloque_hora'];
				$R['hora']['codigo_ano_academico'][$i]=$hora['codigo_ano_academico'];
				$R['hora']['cedula'][$i]=$hora['cedula'];
				$R['hora']['nombre'][$i]=$hora['nombre'];
				$R['hora']['apellido'][$i]=$hora['apellido'];
				$R['hora']['codigo_ambiente'][$i]=$hora['codigo_ambiente'];
				$R['hora']['nombre_ambiente'][$i]=$hora['nombre_ambiente'];
				$R['hora']['materia'][$i]=$hora['materia'];
				$R['hora']['nombre_materia'][$i]=$hora['nombre_materia'];
				$R['hora']['seccion'][$i]=$hora['seccion'];
				$R['hora']['nombre_seccion'][$i]=$hora['nombre_seccion'];
			}
			return $R['hora'];
		}
}
?>