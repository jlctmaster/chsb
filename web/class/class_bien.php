<?php
require_once("class_bd.php");
class bien {
	private $codigo_bien; 
	private $nombre;
	private $nro_serial;
	private $codigo_tipo_bien;
	private $esconfigurable;
	private $codigo_configuracion_bien;
	private $codigo_item;
	private $cantidad;
	private $item_base;
	private $estatus; 
	private $error; 
	private $pgsql; 
	
	public function __construct(){
		$this->codigo_bien=null;
		$this->nombre=null;		
		$this->nro_serial=null;
		$this->codigo_tipo_bien=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_bien(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_bien;

		if($Num_Parametro>0){
			$this->codigo_bien=func_get_arg(0);
		}
    }

    public function nombre(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nombre;
     
		if($Num_Parametro>0){
	   		$this->nombre=func_get_arg(0);
	 	}
    }

    public function nro_serial(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->nro_serial;
     
		if($Num_Parametro>0){
	   		$this->nro_serial=func_get_arg(0);
	 	}
    }

    public function codigo_tipo_bien(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_tipo_bien;

		if($Num_Parametro>0){
			$this->codigo_tipo_bien=func_get_arg(0);
		}
    }

    public function esconfigurable(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->esconfigurable;

		if($Num_Parametro>0){
			$this->esconfigurable=func_get_arg(0);
		}
    }
    public function codigo_configuracion_bien(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_configuracion_bien;

		if($Num_Parametro>0){
			$this->codigo_configuracion_bien=func_get_arg(0);
		}
    }

     public function codigo_item(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_item;
     
		if($Num_Parametro>0){
	   		$this->codigo_item=func_get_arg(0);
	 	}
    }

    public function cantidad(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->cantidad;

		if($Num_Parametro>0){
			$this->cantidad=func_get_arg(0);
		}
    }

    public function item_base(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->item_base;

		if($Num_Parametro>0){
			$this->item_base=func_get_arg(0);
		}
    }

    public function estatus(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->estatus;

		if($Num_Parametro>0){
			$this->estatus=func_get_arg(0);
		}
	}

    public function error(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->error;

		if($Num_Parametro>0){
			$this->error=func_get_arg(0);
		}
	}
	
	function comprobarCheckBox($value){
		if($value == "on")
			$chk = "Y";
		else
			$chk = "N";
		return $chk;
	}

	public function EliminarBienes(){
		$sql="DELETE FROM bienes_nacionales.tconfiguracion_bien WHERE codigo_bien='$this->codigo_bien'";
		if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
	}

	public function InsertarBienes($user,$items,$cantidades,$item_base){
	    $sql="INSERT INTO bienes_nacionales.tconfiguracion_bien(codigo_bien,codigo_item,cantidad,item_base,creado_por,fecha_creacion) VALUES ";
	    for ($i=0; $i < count($items); $i++){
	    	//	Extraemos el codigo del item y la ubicacion por cada registro
	    	$item=explode('_',$items[$i]);
	    	$codigo_item=$item[0];
	    	//	Fin
	    	$sql.="('$this->codigo_bien','".$codigo_item."','".$cantidades[$i]."','".$this->comprobarCheckBox($item_base[$i])."','$user',NOW()),";
	    }
	    $sql=substr($sql,0,-1);
	    $sql=$sql.";";
	    if($this->pgsql->Ejecutar($sql)!=null)
	      return true;
	    else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
    }

   	public function Registrar($user){
	    $sql="INSERT INTO bienes_nacionales.tbien (nombre,nro_serial,codigo_tipo_bien,esconfigurable,creado_por,fecha_creacion) VALUES 
	    ('$this->nombre','$this->nro_serial','$this->codigo_tipo_bien','$this->esconfigurable','$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null){
	    	$sqlx="SELECT codigo_bien FROM bienes_nacionales.tbien WHERE nombre='$this->nombre'";
	    	$query=$this->pgsql->Ejecutar($sqlx);
	    	if($this->pgsql->Total_Filas($query)!=0){
				$tbien=$this->pgsql->Respuesta($query);
				$this->codigo_bien($tbien['codigo_bien']);
	    		return true;
			}
	    }
		else{
	    	$this->error(pg_last_error());
	    	return false;
	    }
   	}
   
    public function Activar($user){
	    $sql="UPDATE bienes_nacionales.tbien SET estatus = '1',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_bien='$this->codigo_bien'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM bienes_nacionales.tbien b WHERE codigo_bien = '$this->codigo_bien' 
    	AND (EXISTS (SELECT 1 FROM bienes_nacionales.ttipo_bien tb WHERE b.codigo_bien = tb.codigo_bien))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE bienes_nacionales.tbien SET estatus = '0',modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_bien='$this->codigo_bien'";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE bienes_nacionales.tbien SET nombre='$this->nombre',nro_serial='$this->nro_serial',codigo_tipo_bien='$this->codigo_tipo_bien',esconfigurable='$this->esconfigurable',
	    modificado_por='$user',fecha_modificacion=NOW() WHERE codigo_bien='$this->codigo_bien'";
		    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar($comprobar){
   		if($comprobar==true){
		    $sql="SELECT * FROM bienes_nacionales.tbien WHERE nombre='$this->nombre' AND nro_serial='$this->nro_serial'";
		   		$query=$this->pgsql->Ejecutar($sql);
		    	if($this->pgsql->Total_Filas($query)!=0){
				$tbien=$this->pgsql->Respuesta($query);
				$this->estatus($tbien['estatus']);
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
