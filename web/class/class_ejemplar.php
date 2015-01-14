<?php
require_once("class_bd.php");
class ejemplars {
	private $codigo_ejemplar; 
	private $codigo_clasificacion;
	private $numero_edicion;
	private $codigo_isbn_libro;
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_ejemplar=null;
		$this->codigo_clasificacion=null;
		$this->numero_edicion=null;
		$this->codigo_isbn_libro=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_ejemplar(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_ejemplar;

		if($Num_Parametro>0){
			$this->codigo_ejemplar=func_get_arg(0);
		}
    }

    public function codigo_clasificacion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_clasificacion;
     
		if($Num_Parametro>0){
	   		$this->codigo_clasificacion=func_get_arg(0);
	 	}
    }

    public function numero_edicion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->numero_edicion;

		if($Num_Parametro>0){
			$this->numero_edicion=func_get_arg(0);
		}
    }
    public function codigo_isbn_libro(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_isbn_libro;

		if($Num_Parametro>0){
			$this->codigo_isbn_libro=func_get_arg(0);
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
	    $sql="INSERT INTO biblioteca.tejemplar (codigo_clasificacion,numero_edicion,codigo_isbn_libro,creado_por,fecha_creacion) VALUES 
	    ('$this->codigo_clasificacion','$this->numero_edicion','$this->codigo_isbn_libro','$user',NOW())";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	
   }
    public function Activar($user){
	    $sql="UPDATE biblioteca.tejemplar SET estatus = '1',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_ejemplar='$this->codigo_ejemplar'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM biblioteca.tejemplar e WHERE codigo_ejemplar = '$this->codigo_ejemplar'
    	AND (EXISTS (SELECT 1 FROM biblioteca.tlibro l WHERE l.codigo_ejemplar = e.codigo_ejemplar))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE biblioteca.tejemplar SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_ejemplar='$this->codigo_ejemplar'";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE biblioteca.tejemplar SET codigo_clasificacion='$this->codigo_clasificacion',numero_edicion='$this->numero_edicion',
	    codigo_isbn_libro='$this->codigo_isbn_libro',
		modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_ejemplar='$this->codigo_ejemplar'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM biblioteca.tejemplar";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tejemplar=$this->pgsql->Respuesta($query);
			$this->codigo_ejemplar($tejemplar['codigo_ejemplar']);
			$this->codigo_clasificacion($tejemplar['codigo_clasificacion']);
			$this->numero_edicion($tejemplar['numero_edicion']);
			$this->codigo_isbn_libro($tejemplar['codigo_isbn_libro']);
			$this->estatus($tejemplar['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}
}
?>
