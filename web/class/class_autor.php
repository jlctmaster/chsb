<?php
require_once("class_bd.php");
class autor {
	private $codigo_autor; 
	private $nombre;
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_autor=null;
		$this->nombre=null;
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

    public function estatus(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus;

		if($Num_Parametro>0){
			$this->estatus=func_get_arg(0);
		}
    }
   
   	public function Registrar($user){
	    $sql="INSERT INTO biblioteca.tautor (nombre,creado_por,fecha_creacion) VALUES 
	    ('$this->nombre','$user',NOW())";
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
	    $sql="UPDATE biblioteca.tautor SET nombre='$this->nombre',modificado_por='$user',fecha_modificacion=NOW() 
	    WHERE codigo_autor='$this->codigo_autor'";
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
			$this->estatus($tautor['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
