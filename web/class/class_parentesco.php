<?php
require_once("class_bd.php");
class parentesco {
	private $codigo_parentesco; 
	private $descripcion;
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_parentesco=null;
		$this->descripcion=null;
		$this->codigo_parentesco=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_parentesco(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_parentesco;

		if($Num_Parametro>0){
			$this->codigo_parentesco=func_get_arg(0);
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
	    $sql="INSERT INTO general.tparentesco (descripcion,creado_por,fecha_creacion) VALUES 
	    ('$this->descripcion','$user',NOW())";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE general.tparentesco SET estatus = '1',modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_parentesco=$this->codigo_parentesco";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM general.tparentesco p WHERE p.codigo_parentesco = $this->codigo_parentesco";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE general.tparentesco SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_parentesco=$this->codigo_parentesco";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE general.tparentesco SET descripcion='$this->descripcion',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_parentesco='$this->codigo_parentesco'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar(){
	    $sql="SELECT * FROM general.tparentesco WHERE descripcion='$this->descripcion'";
		$query=$this->pgsql->Ejecutar($sql);
	    if($this->pgsql->Total_Filas($query)!=0){
			$tparentesco=$this->pgsql->Respuesta($query);
			$this->codigo_parentesco($tparentesco['codigo_parentesco']);
			$this->descripcion($tparentesco['descripcion']);
			$this->estatus($tparentesco['estatus']);
			return true;
		}
		else{
			return false;
		}
   	}

   	public function BuscarCodigo($value){
   		$sql="SELECT codigo_parentesco FROM general.tparentesco WHERE descripcion='$value'";
   		$query=$this->pgsql->Ejecutar($sql);
   		if($row=$this->pgsql->Respuesta($query)){
   			return $row['codigo_parentesco'];
   		}
   		else
   			return null;
   	}
}
?>
