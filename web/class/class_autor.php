<?php
require_once("class_bd.php");
class autor {
	private $codigo_autor; 
	private $nombre;
	private $codigo_parroquia;
	private $fecha_nacimiento;
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_autor=null;
		$this->nombre=null;
		$this->codigo_parroquia=null;
		$this->fecha_nacimiento=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_autor(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_autor;

		if($Num_Parametro>0){
			$this->codigo_autor=func_get_arg(0);
		}
    }

    public function nombre(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nombre;
     
		if($Num_Parametro>0){
	   		$this->nombre=func_get_arg(0);
	 	}
    }

    public function codigo_parroquia(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_parroquia;

		if($Num_Parametro>0){
			$this->codigo_parroquia=func_get_arg(0);
		}
    }
    public function fecha_nacimiento(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->fecha_nacimiento;

		if($Num_Parametro>0){
			$this->fecha_nacimiento=func_get_arg(0);
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
	    $sql="INSERT INTO biblioteca.tautor (nombre,codigo_parroquia,fecha_nacimiento,creado_por,fecha_creacion) VALUES 
	    ('$this->nombre','$this->codigo_parroquia','$this->fecha_nacimiento','$user',NOW())";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE biblioteca.tautor SET estatus = '1',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_autor='$this->codigo_autor'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM biblioteca.tautor a WHERE codigo_autor = '$this->codigo_autor '
    	AND (EXISTS (SELECT 1 FROM biblioteca.tlibro l WHERE l.codigo_autor = a.codigo_autor))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE biblioteca.tautor SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_autor='$this->codigo_autor'";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE biblioteca.tautor SET nombre='$this->nombre',codigo_parroquia='$this->codigo_parroquia',fecha_nacimiento='$this->fecha_nacimiento',
		modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_autor='$this->codigo_autor'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM biblioteca.tautor WHERE nombre='$this->nombre'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tautor=$this->pgsql->Respuesta($query);
			$this->codigo_autor($tautor['codigo_autor']);
			$this->nombre($tautor['nombre']);
			$this->codigo_parroquia($tautor['codigo_parroquia']);
			$this->fecha_nacimiento($tautor['fecha_nacimiento']);
			$this->estatus($tautor['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
