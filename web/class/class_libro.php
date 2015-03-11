<?php
require_once("class_bd.php");
  class libro {
  private $codigo_isbn_libro;
  private $titulo;  
  private $codigo_editorial;
  private $codigo_autor;
  private $codigo_tema;
  private $numero_paginas;
  private $fecha_edicion;
  private $estatus; 
  private $pgsql; 
   
  public function __construct(){
    $this->codigo_isbn_libro=null;
    $this->titulo=null;
    $this->codigo_editorial=null;
    $this->codigo_autor=null;
    $this->codigo_tema=null;
    $this->numero_paginas=null;
    $this->fecha_edicion=null;
    $this->pgsql=new Conexion();
  }
   
  public function __destruct(){}

  public function Transaccion($value){
    if($value=='iniciando') return $this->pgsql->Incializar_Transaccion();
    if($value=='cancelado') return $this->pgsql->Cancelar_Transaccion();
    if($value=='finalizado') return $this->pgsql->Finalizar_Transaccion();
  }

  public function codigo_isbn_libro(){
    $Num_Parametro=func_num_args();
    if($Num_Parametro==0) return $this->codigo_isbn_libro;

    if($Num_Parametro>0){
      $this->codigo_isbn_libro=func_get_arg(0);
    }
  }
  
  public function titulo(){
    $Num_Parametro=func_num_args();
    if($Num_Parametro==0) return $this->titulo;

    if($Num_Parametro>0){
      $this->titulo=func_get_arg(0);
    }
  }

  public function codigo_editorial(){
    $Num_Parametro=func_num_args();
    if($Num_Parametro==0) return $this->codigo_editorial;
     
    if($Num_Parametro>0){
        $this->codigo_editorial=func_get_arg(0);
    }
  }

  public function codigo_autor(){
    $Num_Parametro=func_num_args();
    if($Num_Parametro==0) return $this->codigo_autor;

    if($Num_Parametro>0){
      $this->codigo_autor=func_get_arg(0);
    }
  }

  public function codigo_tema(){
    $Num_Parametro=func_num_args();
    if($Num_Parametro==0) return $this->codigo_tema;

    if($Num_Parametro>0){
      $this->codigo_tema=func_get_arg(0);
    }
  }

  public function numero_paginas(){
    $Num_Parametro=func_num_args();
    if($Num_Parametro==0) return $this->numero_paginas;

    if($Num_Parametro>0){
      $this->numero_paginas=func_get_arg(0);
    }
  }

  public function fecha_edicion(){
    $Num_Parametro=func_num_args();
    if($Num_Parametro==0) return $this->fecha_edicion;

    if($Num_Parametro>0){
      $this->fecha_edicion=func_get_arg(0);
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
    $sql="INSERT INTO biblioteca.tlibro (codigo_isbn_libro,titulo,codigo_editorial,codigo_autor,codigo_tema,numero_paginas,fecha_edicion,creado_por,fecha_creacion) VALUES 
    ('$this->codigo_isbn_libro','$this->titulo','$this->codigo_editorial','$this->codigo_autor','$this->codigo_tema','$this->numero_paginas','$this->fecha_edicion','$user',NOW())";
    if($this->pgsql->Ejecutar($sql)!=null)
      return true;
    else
      return false;
  }
 
  public function Activar($user){
    $sql="UPDATE biblioteca.tlibro SET estatus = '1', modificado_por='$user', fecha_modificacion=NOW() WHERE 
    codigo_isbn_libro='$this->codigo_isbn_libro'";
    if($this->pgsql->Ejecutar($sql)!=null)
      return true;
    else
      return false;
  }

  public function Desactivar($user){
    $sqlx="SELECT * FROM biblioteca.tlibro WHERE codigo_isbn_libro='$this->codigo_isbn_libro'";
    $query=$this->pgsql->Ejecutar($sqlx);
    if($this->pgsql->Total_Filas($query)==0){
      $sql="UPDATE biblioteca.tlibro SET estatus = '0', modificado_por='$user', fecha_modificacion=NOW() WHERE codigo_isbn_libro='$this->codigo_isbn_libro'";
      if($this->pgsql->Ejecutar($sql)!=null)
        return true;
      else
        return false;
    }
    else
      return false;
  }
 
  public function Actualizar($user){
    $sql="UPDATE biblioteca.tlibro SET codigo_isbn_libro='$this->codigo_isbn_libro', titulo='$this->titulo', codigo_editorial='$this->codigo_editorial',
    codigo_autor='$this->codigo_autor', codigo_tema='$this->codigo_tema',numero_paginas='$this->numero_paginas', fecha_edicion='$this->fecha_edicion',
    modificado_por='$user',fecha_modificacion=NOW() 
      WHERE codigo_isbn_libro='$this->codigo_isbn_libro'";
    if($this->pgsql->Ejecutar($sql)!=null)
      return true;
    else
      return false;
  }

  public function Comprobar($comprobar){
    if($comprobar==true){
      $sql="SELECT * FROM biblioteca.tlibro WHERE codigo_isbn_libro='$this->codigo_isbn_libro'";
      $query=$this->pgsql->Ejecutar($sql);
      if($this->pgsql->Total_Filas($query)!=0){
        $libro=$this->pgsql->Respuesta($query);
        $this->estatus($libro['estatus']);
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
