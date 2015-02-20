<?php
require_once("class_bd.php");
class opcion {
	private $codigo_opcion; 
	private $nombre_opcion;
	private $accion;
	private $orden;
	private $icono; 
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_opcion=null;
		$this->nombre_opcion=null;
		$this->accion=null;
		$this->orden=null;
		$this->icono=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_opcion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_opcion;

		if($Num_Parametro>0){
			$this->codigo_opcion=func_get_arg(0);
		}
    }

    public function nombre_opcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nombre_opcion;
     
		if($Num_Parametro>0){
	   		$this->nombre_opcion=func_get_arg(0);
	 	}
    }

    public function icono(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->icono;

		if($Num_Parametro>0){
			$this->icono=func_get_arg(0);
		}
    }

    public function accion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->accion;

		if($Num_Parametro>0){
			$this->accion=func_get_arg(0);
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
	    $sql="INSERT INTO seguridad.topcion (nombre_opcion,icono,orden,accion,creado_por,fecha_creacion) VALUES 
	    ('$this->nombre_opcion','$this->icono',$this->orden,$this->accion,'$user',NOW())";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE seguridad.topcion SET estatus = '1',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_opcion=$this->codigo_opcion";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM seguridad.topcion o WHERE o.codigo_opcion = $this->codigo_opcion 
    	AND (EXISTS (SELECT 1 FROM seguridad.tdellate_servicio_perfil_opcion dspo WHERE dspo.codigo_opcion = o.codigo_opcion))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE seguridad.topcion SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_opcion=$this->codigo_opcion";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE seguridad.topcion SET nombre_opcion='$this->nombre_opcion',icono='$this->icono',orden=$this->orden
	    ,accion=$this->accion,modificado_por='$user',fecha_modificacion=NOW() 
	    WHERE codigo_opcion='$this->codigo_opcion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

	public function Comprobar($comprobar){
	    if($comprobar==true){
		    $sql="SELECT * FROM seguridad.topcion WHERE nombre_opcion='$this->nombre_opcion'";
			$query=$this->pgsql->Ejecutar($sql);
		    if($this->pgsql->Total_Filas($query)!=0){
				$topcion=$this->pgsql->Respuesta($query);
				$this->estatus($topcion['estatus']);
				return true;
			}
			else{
				return false;
			}
	    }else
	      return false;
   	}
}
?>
