<?php
require_once("class_bd.php");
class servicio {
	private $codigo_servicio; 
	private $nombre_servicio;
	private $url; 
	private $orden;
	private $codigo_modulo;
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_servicio=null;
		$this->nombre_servicio=null;
		$this->url=null;
		$this->orden=null;
		$this->codigo_modulo=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_servicio(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_servicio;

		if($Num_Parametro>0){
			$this->codigo_servicio=func_get_arg(0);
		}
    }

    public function nombre_servicio(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nombre_servicio;
     
		if($Num_Parametro>0){
	   		$this->nombre_servicio=func_get_arg(0);
	 	}
    }

    public function url(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->url;

		if($Num_Parametro>0){
			$this->url=func_get_arg(0);
		}
    }

    public function orden(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->orden;

		if($Num_Parametro>0){
			$this->orden=func_get_arg(0);
		}
    }

    public function codigo_modulo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_modulo;

		if($Num_Parametro>0){
			$this->codigo_modulo=func_get_arg(0);
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
	    $sql="INSERT INTO seguridad.tservicio (nombre_servicio,url,orden,codigo_modulo,creado_por,fecha_creacion) VALUES 
	    ('$this->nombre_servicio','$this->url',$this->orden,$this->codigo_modulo,'$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null)

			return true;
		else
			return false;
   	}

   
    public function Activar($user){
	    $sql="UPDATE seguridad.tservicio SET estatus = '1',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_servicio=$this->codigo_servicio";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM seguridad.tservicio s WHERE s.codigo_servicio = $this->codigo_servicio 
    	AND (EXISTS (SELECT 1 FROM seguridad.tdetalle_servicio_perfil_opcion dspo WHERE dspo.codigo_servicio = s.codigo_servicio))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE seguridad.tservicio SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_servicio=$this->codigo_servicio";
		    if($this->pgsql->Ejecutar($sql)!=null)

				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE seguridad.tservicio SET nombre_servicio='$this->nombre_servicio',url='$this->url',orden=$this->orden
	    ,codigo_modulo=$this->codigo_modulo,modificado_por='$user',fecha_modificacion=NOW() 
	    WHERE codigo_servicio='$this->codigo_servicio'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM seguridad.tservicio WHERE nombre_servicio='$this->nombre_servicio'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tservicio=$this->pgsql->Respuesta($query);
			$this->codigo_servicio($tservicio['codigo_servicio']);
			$this->nombre_servicio($tservicio['nombre_servicio']);
			$this->url($tservicio['url']);
			$this->orden($tservicio['orden']);
			$this->codigo_modulo($tservicio['codigo_modulo']);
			$this->estatus($tservicio['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
