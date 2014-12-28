<?php
require_once("class_bd.php");
class tema {
	private $codigo_tema; 
	private $descripcion;
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_tema=null;
		$this->descripcion=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_tema(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_tema;

		if($Num_Parametro>0){
			$this->codigo_tema=func_get_arg(0);
		}
    }

    public function descripcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->descripcion;
     
		if($Num_Parametro>0){
	   		$this->descripcion=func_get_arg(0);
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
	    $sql="INSERT INTO biblioteca.ttema (descripcion,creado_por,fecha_creacion) VALUES 
	    ('$this->descripcion','$user',NOW())";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE biblioteca.ttema SET estatus = '1',modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_tema=$this->codigo_tema";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM biblioteca.ttema p WHERE p.codigo_tema = $this->codigo_tema 
    	AND EXISTS (SELECT 1 FROM biblioteca.testado e WHERE e.codigo_tema = p.codigo_tema)";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE biblioteca.ttema SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_tema=$this->codigo_tema";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE biblioteca.ttema SET descripcion='$this->descripcion',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_tema='$this->codigo_tema'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM biblioteca.ttema WHERE descripcion='$this->descripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$ttema=$this->pgsql->Respuesta($query);
			$this->codigo_tema($ttema['codigo_tema']);
			$this->descripcion($ttema['descripcion']);
			$this->estatus($ttema['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
