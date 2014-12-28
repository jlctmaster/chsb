<?php
require_once("class_bd.php");
class modulo {
	private $codigo_modulo; 
	private $nombre_modulo;
	private $icono; 
	private $orden;
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_modulo=null;
		$this->nombre_modulo=null;
		$this->icono=null;
		$this->orden=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_modulo(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_modulo;

		if($Num_Parametro>0){
			$this->codigo_modulo=func_get_arg(0);
		}
    }

    public function nombre_modulo(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nombre_modulo;
     
		if($Num_Parametro>0){
	   		$this->nombre_modulo=func_get_arg(0);
	 	}
    }

    public function icono(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->icono;

		if($Num_Parametro>0){
			$this->icono=func_get_arg(0);
		}
    }

    public function orden(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->orden;

		if($Num_Parametro>0){
			$this->orden=func_get_arg(0);
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
	    $sql="INSERT INTO seguridad.tmodulo (nombre_modulo,icono,orden,creado_por,fecha_creacion) VALUES 
	    ('$this->nombre_modulo','$this->icono',$this->orden,'$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE seguridad.tmodulo SET estatus = '1',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_modulo=$this->codigo_modulo";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM seguridad.tmodulo m WHERE m.codigo_modulo = $this->codigo_modulo 
    	AND (EXISTS (SELECT 1 FROM seguridad.tservicio s WHERE m.codigo_modulo = s.codigo_modulo))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE seguridad.tmodulo SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_modulo=$this->codigo_modulo";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE seguridad.tmodulo SET nombre_modulo='$this->nombre_modulo',icono='$this->icono',orden=$this->orden
	    ,modificado_por='$user',fecha_modificacion=NOW() 
	    WHERE codigo_modulo='$this->codigo_modulo'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM seguridad.tmodulo WHERE nombre_modulo='$this->nombre_modulo'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tmodulo=$this->pgsql->Respuesta($query);
			$this->codigo_modulo($tmodulo['codigo_modulo']);
			$this->nombre_modulo($tmodulo['nombre_modulo']);
			$this->icono($tmodulo['icono']);
			$this->orden($tmodulo['orden']);
			$this->estatus($tmodulo['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
