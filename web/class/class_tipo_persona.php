<?php
require_once("class_bd.php");
class tipopersona {
	private $codigo_tipopersona; 
	private $descripcion;
	private $es_usuariosistema;
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_tipopersona=null;
		$this->descripcion=null;
		$this->es_usuariosistema=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_tipopersona(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_tipopersona;

		if($Num_Parametro>0){
			$this->codigo_tipopersona=func_get_arg(0);
		}
    }

    public function descripcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->descripcion;
     
		if($Num_Parametro>0){
	   		$this->descripcion=func_get_arg(0);
	 	}
    }

	 public function es_usuariosistema(){
	$Num_Parametro=func_num_args();
	if($Num_Parametro==0) return $this->es_usuariosistema;
 
	if($Num_Parametro>0){
   		$this->es_usuariosistema=func_get_arg(0);
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
	    $sql="INSERT INTO general.ttipo_persona (descripcion,es_usuariosistema,creado_por,fecha_creacion) VALUES 
	    ('$this->descripcion','$this->es_usuariosistema','$user',NOW())";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE general.ttipo_persona SET estatus = '1',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_tipopersona=$this->codigo_tipopersona";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM general.ttipo_persona tp WHERE tp.codigo_tipopersona = $this->codigo_tipopersona AND 
    	EXISTS (SELECT 1 FROM general.tpersona p WHERE p.codigo_tipopersona = tp.codigo_tipopersona)";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE general.ttipo_persona SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_tipopersona=$this->codigo_tipopersona";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE general.ttipo_persona SET descripcion='$this->descripcion', es_usuariosistema='$this->es_usuariosistema',modificado_por='$user',fecha_modificacion=NOW() 
	    WHERE codigo_tipopersona='$this->codigo_tipopersona'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM general.ttipo_persona WHERE descripcion='$this->descripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$ttipo_persona=$this->pgsql->Respuesta($query);
			$this->codigo_tipopersona($ttipo_persona['codigo_tipopersona']);
			$this->descripcion($ttipo_persona['descripcion']);
			$this->es_usuariosistema($ttipo_persona['es_usuariosistema']);
			$this->estatus($ttipo_persona['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function BuscarCodigo($value){
   		$sql="SELECT codigo_tipopersona FROM general.ttipo_persona WHERE descripcion='$value'";
   		$query=$this->pgsql->Ejecutar($sql);
   		if($row=$this->pgsql->Respuesta($query)){
   			return $row['codigo_tipopersona'];
   		}
   		else
   			return null;
   	}
}
?>
