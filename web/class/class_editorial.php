<?php
require_once("class_bd.php");
	class editorial {
	private $codigo_editorial;
	private $nombre;  
	private $direccion;
	private $telefono;
	private $codigo_parroquia;
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_editorial=null;
		$this->nombre=null;
		$this->direccion=null;
		$this->telefono=null;
		$this->codigo_parroquia=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_editorial(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_editorial;

		if($Num_Parametro>0){
			$this->codigo_editorial=func_get_arg(0);
		}
    }
        public function nombre(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nombre;

		if($Num_Parametro>0){
			$this->nombre=func_get_arg(0);
		}
    }

    public function direccion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->direccion;
     
		if($Num_Parametro>0){
	   		$this->direccion=func_get_arg(0);
	 	}
    }

    public function telefono(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->telefono;

		if($Num_Parametro>0){
			$this->telefono=func_get_arg(0);
		}
    }

    public function codigo_parroquia(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_parroquia;

		if($Num_Parametro>0){
			$this->codigo_parroquia=func_get_arg(0);
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
	    $sql="INSERT INTO biblioteca.teditorial (nombre,direccion,telefono,codigo_parroquia,creado_por,fecha_creacion) VALUES 
	    ('$this->nombre','$this->direccion','$this->telefono','$this->codigo_parroquia','$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE biblioteca.teditorial SET estatus = '1', modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_editorial='$this->codigo_editorial'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM biblioteca.teditorial cb WHERE cb.codigo_editorial WHERE codigo_editorial='$this->codigo_editorial'";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE biblioteca.teditorial SET estatus = '0', modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_editorial='$this->codigo_editorial'";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE biblioteca.teditorial SET nombre='$this->nombre', direccion='$this->direccion',telefono='$this->telefono', codigo_parroquia='$this->codigo_parroquia',
	    modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_editorial='$this->codigo_editorial'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM biblioteca.teditorial WHERE nombre='$this->nombre'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$editorial=$this->pgsql->Respuesta($query);
			$this->codigo_editorial($editorial['codigo_editorial']);
			$this->nombre($editorial['nombre']);
			$this->direccion($editorial['direccion']);
			$this->telefono($editorial['telefono']);
			$this->codigo_parroquia($editorial['codigo_parroquia']);
			$this->estatus($editorial['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
