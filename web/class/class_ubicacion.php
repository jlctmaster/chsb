<?php
require_once("class_bd.php");
class ubicacion {
	private $codigo_ubicacion; 
	private $descripcion;
	private $codigo_ambiente; 
	private $ubicacionprincipal;
	private $itemsdefectuoso;
	private $estatus; 
	private $pgsql; 
	 
	public function __construct(){
		$this->codigo_ubicacion=null;
		$this->descripcion=null;
		$this->codigo_ambiente=null;
		$this->ubicacionprincipal=null;
		$this->itemsdefectuoso=null;
		$this->pgsql=new Conexion();
	}
   
 	public function __destruct(){}

	public function Transaccion($value){
		if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
		if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
		if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
	}

    public function codigo_ubicacion(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_ubicacion;

		if($Num_Parametro>0){
			$this->codigo_ubicacion=func_get_arg(0);
		}
    }

    public function descripcion(){
    	$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->descripcion;
     
		if($Num_Parametro>0){
	   		$this->descripcion=func_get_arg(0);
	 	}
    }

    public function codigo_ambiente(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->codigo_ambiente;

		if($Num_Parametro>0){
			$this->codigo_ambiente=func_get_arg(0);
		}
    }

    public function ubicacionprincipal(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->ubicacionprincipal;

		if($Num_Parametro>0){
			$this->ubicacionprincipal=func_get_arg(0);
		}
    }

    public function itemsdefectuoso(){
		$Num_Parametro=func_num_args();
		if($Num_Parametro==0) return $this->itemsdefectuoso;

		if($Num_Parametro>0){
			$this->itemsdefectuoso=func_get_arg(0);
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
	    $sql="INSERT INTO inventario.tubicacion (descripcion,codigo_ambiente,ubicacionprincipal,itemsdefectuoso,creado_por,fecha_creacion) VALUES 
	    ('$this->descripcion',$this->codigo_ambiente,'$this->ubicacionprincipal','$this->itemsdefectuoso','$user',NOW());";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}
   
    public function Activar($user){
	    $sql="UPDATE inventario.tubicacion SET estatus = '1',modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_ubicacion=$this->codigo_ubicacion";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

    public function Desactivar($user){
    	$sqlx="SELECT * FROM inventario.tubicacion u WHERE u.codigo_ubicacion = $this->codigo_ubicacion 
    	AND (EXISTS (SELECT 1 FROM inventario.tdetalle_adquisicion da WHERE u.codigo_ubicacion = da.codigo_ubicacion) OR 
    	EXISTS (SELECT 1 FROM bienes_nacionales.tdetalle_asignacion das WHERE u.codigo_ubicacion = das.codigo_ubicacion) OR 
    	EXISTS (SELECT 1 FROM bienes_nacionales.trecuperacion r WHERE u.codigo_ubicacion = r.codigo_ubicacion) OR 
    	EXISTS (SELECT 1 FROM bienes_nacionales.tdetalle_recuperacion dr WHERE u.codigo_ubicacion = dr.codigo_ubicacion) OR 
    	EXISTS (SELECT 1 FROM biblioteca.tdetalle_prestamo dp WHERE u.codigo_ubicacion = dp.codigo_ubicacion) OR 
    	EXISTS (SELECT 1 FROM biblioteca.tdetalle_prestamo de WHERE u.codigo_ubicacion = de.codigo_ubicacion) OR 
    	EXISTS (SELECT 1 FROM inventario.tdetalle_movimiento dm WHERE u.codigo_ubicacion = dm.codigo_ubicacion))";
		$query=$this->pgsql->Ejecutar($sqlx);
	    if($this->pgsql->Total_Filas($query)==0){
	    	$sql="UPDATE inventario.tubicacion SET estatus = '0',modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_ubicacion=$this->codigo_ubicacion";
		    if($this->pgsql->Ejecutar($sql)!=null)
				return true;
			else
				return false;
		}
		else
			return false;
   	}
   
    public function Actualizar($user){
	    $sql="UPDATE inventario.tubicacion SET descripcion='$this->descripcion',codigo_ambiente=$this->codigo_ambiente,
	    ubicacionprincipal='$this->ubicacionprincipal',itemsdefectuoso='$this->itemsdefectuoso',modificado_por='$user',
	    fecha_modificacion=NOW() 
	    WHERE codigo_ubicacion='$this->codigo_ubicacion'";
	    if($this->pgsql->Ejecutar($sql)!=null)
			return true;
		else
			return false;
   	}

   	public function Comprobar($comprobar){
   		if($comprobar==true){
		    $sql="SELECT * FROM inventario.tubicacion WHERE descripcion='$this->descripcion'";
			$query=$this->pgsql->Ejecutar($sql);
		    if($this->pgsql->Total_Filas($query)!=0){
				$tubicacion=$this->pgsql->Respuesta($query);
				$this->estatus($tubicacion['estatus']);
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
