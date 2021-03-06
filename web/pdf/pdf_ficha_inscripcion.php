<?php
require_once("../librerias/fpdf/fpdf.php");
require_once("../class/class_bd.php");
session_start();
class clsFpdf extends FPDF {
  var $widths;
  var $aligns;
  //Cabecera de página
  public function Header(){
    $this->Image("../images/cintillo.jpg" , 25 ,15, 160 , 20, "JPG" ,$_SERVER['HTTP_HOST']."/CHSB/web/");   
    $this->Ln(25);  
  }

  //Pie de página
  public function Footer(){
    //Posición: a 2 cm del final
    $this->SetY(-20);
    //Arial italic 8
    $this->SetFont("Arial","I",8);
    //Dirección
    //Número de página
    $this->SetFont('Arial','',13);
    $this->SetFillColor(240,240,240);
    $this->SetTextColor(200, 200, 200);     
    $this->Cell(0,5,"______________________________________________________________________________________________________________",0,1,"C",false);
    $this->SetFont('Arial','',9);
    $this->SetTextColor(0,0,0);     
    $this->Cell(254);
    $this->Cell(25,8,'Página '.$this->PageNo()."/{nb}",0,1,'C',true);
    //Fecha

    //setlocale(LC_ALL,"es_VE.UTF8");
    $this->Ln(-9);
    $this->SetFont("Arial","I",6);
    $avanzar=70;
    $this->Cell($avanzar);
    $empresa="Liceo Bolivariano Bicentenario de la Independencia de Venezuela";
    $dir="Dirección: Complejo Habitacional Simon Bolivar, 3302 Acarigua";
    $tel="Teléfono: 04168110432";
    $empresa1="Todos los Derechos Reservados\"© 2014 FUNDABIT-DTIC.\"";
    $this->Cell(130,4,$empresa,0,1,"C");
    $this->Cell($avanzar);  
    $this->Cell(130,4,$dir,0,1,"C");
    $this->Cell($avanzar);  
    $this->Cell(130,4,$tel,0,1,"C");
  }

  function SetWidths($w){
    //Set the array of column widths
    $this->widths=$w;
  }

  function SetAligns($a){
    //Set the array of column alignments
    $this->aligns=$a;
  }

  function Row($data){
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
    $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++){
      $w=$this->widths[$i];
      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
      //Save the current position
      $x=$this->GetX();
      $y=$this->GetY();
      //Draw the border
      $this->Rect($x,$y,$w,$h);

      //Print the text
      if((count($data)-1)==$i && (strtolower($data[count($data)-1])=='desactivado'))        
        $this->SetTextColor(255, 0, 0);
      else 
        $this->SetTextColor(0, 0, 0);
      $this->MultiCell($w,5,$data[$i],0,$a);
      //Put the position to the right of the cell
      $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
  }

  function CheckPageBreak($h){
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
      $this->AddPage($this->CurOrientation);
  }

  function NbLines($w,$txt){
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
      $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
      $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb){
      $c=$s[$i];
      if($c=="\n"){
        $i++;
        $sep=-1;
        $j=$i;
        $l=0;
        $nl++;
        continue;
      }
      if($c==' ')
        $sep=$i;
      $l+=$cw[$c];
      if($l>$wmax){
        if($sep==-1){
          if($i==$j)
            $i++;
        }
        else
          $i=$sep+1;
        $sep=-1;
        $j=$i;
        $l=0;
        $nl++;
      }
      else
        $i++;
    }
    return $nl;
  }
}

  //generar el listado 
  setlocale(LC_ALL,"es_VE.UTF8");
  $lobjPdf=new clsFpdf();
  // 1era Página
  $lobjPdf->AddPage("P","Legal");
  $pgsql=new Conexion();
  $sql="SELECT TO_CHAR(ps.fecha_inscripcion,'DD/MM/YYYY') AS fecha_inscripcion, aa.ano AS ano_academico, 
  CASE WHEN rp.segundo_nombre IS NOT NULL AND rp.segundo_apellido  IS NOT NULL THEN rp.primer_nombre||' '||rp.segundo_nombre||' '||rp.primer_apellido||' '||rp.segundo_apellido 
  WHEN rp.segundo_nombre IS NULL AND rp.segundo_apellido  IS NOT NULL THEN rp.primer_nombre||' '||rp.primer_apellido||' '||rp.segundo_apellido 
  WHEN rp.segundo_nombre IS NOT NULL AND rp.segundo_apellido  IS NULL THEN rp.primer_nombre||' '||rp.segundo_nombre||' '||rp.primer_apellido 
  ELSE rp.primer_nombre||' '||rp.primer_apellido END AS responsable,
  CASE WHEN per.segundo_nombre IS NOT NULL AND per.segundo_apellido  IS NOT NULL THEN per.primer_nombre||' '||per.segundo_nombre||' '||per.primer_apellido||' '||per.segundo_apellido 
  WHEN per.segundo_nombre IS NULL AND per.segundo_apellido  IS NOT NULL THEN per.primer_nombre||' '||per.primer_apellido||' '||per.segundo_apellido 
  WHEN per.segundo_nombre IS NOT NULL AND per.segundo_apellido  IS NULL THEN per.primer_nombre||' '||per.segundo_nombre||' '||per.primer_apellido 
  ELSE per.primer_nombre||' '||per.primer_apellido END AS estudiante,
  per.primer_nombre,per.segundo_nombre,per.primer_apellido,per.segundo_apellido,TRIM(SUBSTR(ps.cedula_persona,2,LENGTH(rep.cedula_persona))) AS cedula_persona,SUBSTR(ps.cedula_persona,1,1) AS nacionalidad,per.sexo,
  TO_CHAR(per.fecha_nacimiento,'DD/MM/YYYY') AS fecha_nacimiento,extract(year from age(per.fecha_nacimiento)) AS edad,extract(month from age(per.fecha_nacimiento)) AS meses,pa.descripcion AS lugar_nacimiento,e.descripcion AS entidad_federal,
  per.direccion,ps.anio_a_cursar,ps.coordinacion_pedagogica,per.telefono_local,ps.estado_salud,ps.alergico,ps.impedimento_deporte,ps.especifique_deporte,ps.materia_pendiente,ps.cual_materia,ps.practica_deporte,ps.cual_deporte, 
  ps.tiene_beca,ps.organismo,ps.tiene_hermanos,ps.cuantos_varones,ps.cuantas_hembras,ps.estudian_aca,ps.que_anio,ps.peso,ps.talla,ps.indice,ps.tiene_talento,ps.cual_talento,
  CASE WHEN pad.segundo_nombre IS NOT NULL AND pad.segundo_apellido  IS NOT NULL THEN pad.primer_nombre||' '||pad.segundo_nombre||' '||pad.primer_apellido||' '||pad.segundo_apellido 
  WHEN pad.segundo_nombre IS NULL AND pad.segundo_apellido  IS NOT NULL THEN pad.primer_nombre||' '||pad.primer_apellido||' '||pad.segundo_apellido 
  WHEN pad.segundo_nombre IS NOT NULL AND pad.segundo_apellido  IS NULL THEN pad.primer_nombre||' '||pad.segundo_nombre||' '||pad.primer_apellido 
  ELSE pad.primer_nombre||' '||pad.primer_apellido END AS padre,
  TO_CHAR(pad.fecha_nacimiento,'DD/MM/YYYY') AS fecha_nacimiento_padre,TRIM(SUBSTR(pad.cedula_persona,2,LENGTH(rep.cedula_persona))) AS cedula_padre,SUBSTR(pad.cedula_persona,1,1) AS nacionalidad_padre,
  pad.profesion AS profesion_padre,pad.grado_instruccion AS grado_instruccion_padre,pad.direccion AS direccion_padre,pad.telefono_local AS telefono_local_padre,
  CASE WHEN mad.segundo_nombre IS NOT NULL AND mad.segundo_apellido  IS NOT NULL THEN mad.primer_nombre||' '||mad.segundo_nombre||' '||mad.primer_apellido||' '||mad.segundo_apellido 
  WHEN mad.segundo_nombre IS NULL AND mad.segundo_apellido  IS NOT NULL THEN mad.primer_nombre||' '||mad.primer_apellido||' '||mad.segundo_apellido 
  WHEN mad.segundo_nombre IS NOT NULL AND mad.segundo_apellido  IS NULL THEN mad.primer_nombre||' '||mad.segundo_nombre||' '||mad.primer_apellido 
  ELSE mad.primer_nombre||' '||mad.primer_apellido END AS madre,
  TO_CHAR(mad.fecha_nacimiento,'DD/MM/YYYY') AS fecha_nacimiento_madre,TRIM(SUBSTR(mad.cedula_persona,2,LENGTH(rep.cedula_persona))) AS cedula_madre,SUBSTR(mad.cedula_persona,1,1) AS nacionalidad_madre,
  mad.profesion AS profesion_madre,mad.grado_instruccion AS grado_instruccion_madre,mad.direccion AS direccion_madre,mad.telefono_local AS telefono_local_madre,
  CASE WHEN rep.segundo_nombre IS NOT NULL AND rep.segundo_apellido  IS NOT NULL THEN rep.primer_nombre||' '||rep.segundo_nombre||' '||rep.primer_apellido||' '||rep.segundo_apellido 
  WHEN rep.segundo_nombre IS NULL AND rep.segundo_apellido  IS NOT NULL THEN rep.primer_nombre||' '||rep.primer_apellido||' '||rep.segundo_apellido 
  WHEN rep.segundo_nombre IS NOT NULL AND rep.segundo_apellido  IS NULL THEN rep.primer_nombre||' '||rep.segundo_nombre||' '||rep.primer_apellido 
  ELSE rep.primer_nombre||' '||rep.primer_apellido END AS representante,
  TO_CHAR(rep.fecha_nacimiento,'DD/MM/YYYY') AS fecha_nacimiento_representante,TRIM(SUBSTR(rep.cedula_persona,2,LENGTH(rep.cedula_persona))) AS cedula_representante,SUBSTR(rep.cedula_persona,1,1) AS nacionalidad_representante,
  rep.profesion AS profesion_representante,rep.grado_instruccion AS grado_instruccion_representante,rep.direccion AS direccion_representante,rep.telefono_local AS telefono_local_representante,
  paren.descripcion AS parentesco,ps.integracion_educativa,ps.integracion_plomeria,ps.integracion_electricidad,ps.integracion_albanileria,ps.integracion_peluqueria,ps.integracion_ambientacion,ps.integracion_manualidades,
  ps.integracion_bisuteria,ps.otra_integracion,ps.especifique_integracion,sec.nombre_seccion,ps.observacion,ps.fotocopia_ci,ps.partida_nacimiento,ps.boleta_promocion,ps.certificado_calificaciones,
  ps.constancia_buenaconducta,ps.fotos_estudiante,ps.boleta_zonificacion,ps.fotocopia_ci_representante,ps.fotos_representante,ps.otro_documento,ps.cual_documento,ps.observacion_documentos, 
  ps.estudiante_regular,ps.procedencia 
  FROM educacion.tproceso_inscripcion ps 
  INNER JOIN educacion.tano_academico aa ON ps.codigo_ano_academico = aa.codigo_ano_academico 
  LEFT JOIN general.tpersona rp ON ps.cedula_responsable = rp.cedula_persona 
  LEFT JOIN general.tpersona per ON ps.cedula_persona = per.cedula_persona 
  LEFT JOIN general.tparroquia pa ON per.lugar_nacimiento = pa.codigo_parroquia 
  LEFT JOIN general.tmunicipio m ON pa.codigo_municipio = m.codigo_municipio 
  LEFT JOIN general.testado e ON m.codigo_estado = e.codigo_estado 
  LEFT JOIN general.tpersona pad ON ps.cedula_padre = pad.cedula_persona 
  LEFT JOIN general.tpersona mad ON ps.cedula_madre = mad.cedula_persona
  LEFT JOIN general.tpersona rep ON ps.cedula_representante = rep.cedula_persona
  LEFT JOIN general.tparentesco paren ON ps.codigo_parentesco = paren.codigo_parentesco 
  LEFT JOIN educacion.tseccion sec ON ps.seccion = sec.seccion 
  WHERE ps.codigo_proceso_inscripcion=".$pgsql->comillas_inteligentes($_GET['p1']);
  $i=-1;
  $ind=-1;
  $arr=array();
  $data=$pgsql->Ejecutar($sql);
  if($pgsql->Total_Filas($data)!=0){
    while ($sacar_datos=$pgsql->Respuesta($data)) {
      $ind++;
      $arr['fecha_inscripcion'][$ind]=$sacar_datos['fecha_inscripcion'];
      $arr['ano_academico'][$ind]=$sacar_datos['ano_academico'];
      $arr['responsable'][$ind]=$sacar_datos['responsable'];
      $arr['estudiante'][$ind]=$sacar_datos['estudiante'];
      $arr['primer_nombre'][$ind]=$sacar_datos['primer_nombre'];
      $arr['segundo_nombre'][$ind]=$sacar_datos['segundo_nombre'];
      $arr['primer_apellido'][$ind]=$sacar_datos['primer_apellido'];
      $arr['segundo_apellido'][$ind]=$sacar_datos['segundo_apellido'];    
      $arr['cedula_persona'][$ind]=$sacar_datos['cedula_persona'];
      $arr['nacionalidad'][$ind]=$sacar_datos['nacionalidad'];   
      $arr['sexo'][$ind]=$sacar_datos['sexo'];
      $arr['fecha_nacimiento'][$ind]=$sacar_datos['fecha_nacimiento'];
      $arr['edad'][$ind]=$sacar_datos['edad'];    
      $arr['meses'][$ind]=$sacar_datos['meses'];    
      $arr['lugar_nacimiento'][$ind]=$sacar_datos['lugar_nacimiento'];
      $arr['entidad_federal'][$ind]=$sacar_datos['entidad_federal'];   
      $arr['direccion'][$ind]=$sacar_datos['direccion'];
      $arr['anio_a_cursar'][$ind]=$sacar_datos['anio_a_cursar'];   
      $arr['coordinacion_pedagogica'][$ind]=$sacar_datos['coordinacion_pedagogica'];
      $arr['telefono_local'][$ind]=$sacar_datos['telefono_local'];
      $arr['estudiante_regular'][$ind]=$sacar_datos['estudiante_regular'];
      $arr['procedencia'][$ind]=$sacar_datos['procedencia'];
      $arr['materia_pendiente'][$ind]=$sacar_datos['materia_pendiente'];
      $arr['cual_materia'][$ind]=$sacar_datos['cual_materia'];
      $arr['estado_salud'][$ind]=$sacar_datos['estado_salud'];   
      $arr['alergico'][$ind]=$sacar_datos['alergico'];
      $arr['impedimento_deporte'][$ind]=$sacar_datos['impedimento_deporte'];
      $arr['especifique_deporte'][$ind]=$sacar_datos['especifique_deporte'];
      $arr['practica_deporte'][$ind]=$sacar_datos['practica_deporte'];
      $arr['cual_deporte'][$ind]=$sacar_datos['cual_deporte'];
      $arr['tiene_beca'][$ind]=$sacar_datos['tiene_beca'];
      $arr['organismo'][$ind]=$sacar_datos['organismo'];
      $arr['tiene_hermanos'][$ind]=$sacar_datos['tiene_hermanos'];
      $arr['cuantos_varones'][$ind]=$sacar_datos['cuantos_varones'];
      $arr['cuantas_hembras'][$ind]=$sacar_datos['cuantas_hembras'];
      $arr['estudian_aca'][$ind]=$sacar_datos['estudian_aca'];
      $arr['que_anio'][$ind]=$sacar_datos['que_anio'];  
      $arr['peso'][$ind]=$sacar_datos['peso'];
      $arr['talla'][$ind]=$sacar_datos['talla'];
      $arr['indice'][$ind]=$sacar_datos['indice'];
      $arr['tiene_talento'][$ind]=$sacar_datos['tiene_talento'];
      $arr['cual_talento'][$ind]=$sacar_datos['cual_talento'];  
      $arr['padre'][$ind]=$sacar_datos['padre'];
      $arr['fecha_nacimiento_padre'][$ind]=$sacar_datos['fecha_nacimiento_padre'];
      $arr['cedula_padre'][$ind]=$sacar_datos['cedula_padre'];  
      $arr['nacionalidad_padre'][$ind]=$sacar_datos['nacionalidad_padre'];
      $arr['profesion_padre'][$ind]=$sacar_datos['profesion_padre'];
      $arr['grado_instruccion_padre'][$ind]=$sacar_datos['grado_instruccion_padre'];
      $arr['direccion_padre'][$ind]=$sacar_datos['direccion_padre'];
      $arr['telefono_local_padre'][$ind]=$sacar_datos['telefono_local_padre'];  
      $arr['madre'][$ind]=$sacar_datos['madre'];
      $arr['fecha_nacimiento_madre'][$ind]=$sacar_datos['fecha_nacimiento_madre'];
      $arr['cedula_madre'][$ind]=$sacar_datos['cedula_madre'];  
      $arr['nacionalidad_madre'][$ind]=$sacar_datos['nacionalidad_madre'];
      $arr['profesion_madre'][$ind]=$sacar_datos['profesion_madre'];
      $arr['grado_instruccion_madre'][$ind]=$sacar_datos['grado_instruccion_madre'];
      $arr['direccion_madre'][$ind]=$sacar_datos['direccion_padre'];
      $arr['telefono_local_madre'][$ind]=$sacar_datos['telefono_local_madre'];
      $arr['representante'][$ind]=$sacar_datos['representante'];
      $arr['fecha_nacimiento_representante'][$ind]=$sacar_datos['fecha_nacimiento_representante'];
      $arr['cedula_representante'][$ind]=$sacar_datos['cedula_representante'];  
      $arr['nacionalidad_representante'][$ind]=$sacar_datos['nacionalidad_representante'];
      $arr['profesion_representante'][$ind]=$sacar_datos['profesion_representante'];
      $arr['grado_instruccion_representante'][$ind]=$sacar_datos['grado_instruccion_representante'];
      $arr['direccion_representante'][$ind]=$sacar_datos['direccion_representante'];
      $arr['telefono_local_representante'][$ind]=$sacar_datos['telefono_local_representante'];
      $arr['parentesco'][$ind]=$sacar_datos['parentesco'];
      $arr['integracion_educativa'][$ind]=$sacar_datos['integracion_educativa'];
      $arr['integracion_plomeria'][$ind]=$sacar_datos['integracion_plomeria'];
      $arr['integracion_electricidad'][$ind]=$sacar_datos['integracion_electricidad'];
      $arr['integracion_albanileria'][$ind]=$sacar_datos['integracion_albanileria'];
      $arr['integracion_peluqueria'][$ind]=$sacar_datos['integracion_peluqueria'];
      $arr['integracion_ambientacion'][$ind]=$sacar_datos['integracion_ambientacion'];
      $arr['integracion_manualidades'][$ind]=$sacar_datos['integracion_manualidades'];
      $arr['integracion_bisuteria'][$ind]=$sacar_datos['integracion_bisuteria'];
      $arr['otra_integracion'][$ind]=$sacar_datos['otra_integracion'];
      $arr['especifique_integracion'][$ind]=$sacar_datos['especifique_integracion'];
      $arr['nombre_seccion'][$ind]=$sacar_datos['nombre_seccion'];
      $arr['observacion'][$ind]=$sacar_datos['observacion'];
      $arr['fotocopia_ci'][$ind]=$sacar_datos['fotocopia_ci'];
      $arr['partida_nacimiento'][$ind]=$sacar_datos['partida_nacimiento'];  
      $arr['boleta_promocion'][$ind]=$sacar_datos['boleta_promocion'];
      $arr['certificado_calificaciones'][$ind]=$sacar_datos['certificado_calificaciones'];
      $arr['constancia_buenaconducta'][$ind]=$sacar_datos['constancia_buenaconducta'];
      $arr['fotos_estudiante'][$ind]=$sacar_datos['fotos_estudiante'];
      $arr['boleta_zonificacion'][$ind]=$sacar_datos['boleta_zonificacion'];
      $arr['fotocopia_ci_representante'][$ind]=$sacar_datos['fotocopia_ci_representante'];
      $arr['fotos_representante'][$ind]=$sacar_datos['fotos_representante'];
      $arr['otro_documento'][$ind]=$sacar_datos['otro_documento'];
      $arr['cual_documento'][$ind]=$sacar_datos['cual_documento'];
      $arr['observacion_documentos'][$ind]=$sacar_datos['observacion_documentos'];
    }

    $lobjPdf->SetFont('Arial','',8);
    $lobjPdf->SetXY(25,40);
    $lobjPdf->MultiCell(20,10,'Foto Estudiante',1,'C',false);
    $lobjPdf->SetFont('Arial','B',12);
    $lobjPdf->SetXY(5,50);
    $lobjPdf->Cell(0,6,'FICHA DE INSCRIPCIÓN',0,1,"C");
    $lobjPdf->SetFont('Arial','',8);
    $lobjPdf->SetXY(160,40);
    $lobjPdf->MultiCell(25,10,'Foto Representante',1,'C',false);
    $lobjPdf->Ln(2);
    $lobjPdf->SetFont('Arial','B',10);
    $lobjPdf->SetFont('Arial','',8);
    $lobjPdf->Cell(30,5,'FECHA '.$arr['fecha_inscripcion'][0],1,0);
    $lobjPdf->Cell(50,5,'AÑO ESCOLAR: '.$arr['ano_academico'][0],1,0);
    $lobjPdf->Cell(110,5,'Prof. Responsable: '.$arr['responsable'][0],1,1);
    $lobjPdf->SetFont('Arial','B',10);
    $lobjPdf->Cell(190,5,'I.-DATOS DEL ESTUDIANTE',1,1);
    $lobjPdf->SetFont('Arial','',8);
    $lobjPdf->Cell(35,5,'Primer Apellido',1,0);
    $lobjPdf->Cell(35,5,'Segundo Apellido',1,0);
    $lobjPdf->Cell(35,5,'Primer Nombre',1,0);
    $lobjPdf->Cell(35,5,'Segundo Nombre',1,0);
    $lobjPdf->Cell(20,5,'CI N°',1,0);
    $lobjPdf->Cell(5,5,'V',1,0);
    $lobjPdf->Cell(5,5,'E',1,0);
    $lobjPdf->Cell(20,5,'Sexo',1,1,'C');
    $lobjPdf->Cell(35,5,$arr['primer_apellido'][0],1,0);
    $lobjPdf->Cell(35,5,$arr['segundo_apellido'][0],1,0);
    $lobjPdf->Cell(35,5,$arr['primer_nombre'][0],1,0);
    $lobjPdf->Cell(35,5,$arr['segundo_nombre'][0],1,0);
    $lobjPdf->Cell(20,5,$arr['cedula_persona'][0],1,0);
    $lobjPdf->Cell(5,5,$arr['nacionalidad'][0]!="E" ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(5,5,$arr['nacionalidad'][0]=="E" ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(5,5,'M',1,0);
    $lobjPdf->Cell(5,5,$arr['sexo'][0]=="M" ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(5,5,'F',1,0);
    $lobjPdf->Cell(5,5,$arr['sexo'][0]=="F" ? 'X' : '',1,1,'C');
    $lobjPdf->Cell(35,5,'Fecha de Nacimiento',1,0);
    $lobjPdf->Cell(10,5,'Edad',1,0);
    $lobjPdf->Cell(30,5,'Lugar de Nacimiento',1,0);
    $lobjPdf->Cell(25,5,'Entidad Federal',1,0);
    $lobjPdf->Cell(90,5,'Dirección:',1,1);
    $lobjPdf->Cell(35,10,$arr['fecha_nacimiento'][0],1,0);
    $lobjPdf->Cell(10,10,$arr['edad'][0],1,0);
    $lobjPdf->Cell(30,10,$arr['lugar_nacimiento'][0],1,0);
    $lobjPdf->Cell(25,10,$arr['entidad_federal'][0],1,0);
    $lobjPdf->Cell(90,10,$arr['direccion'][0],1,1);
    $lobjPdf->Cell(25,5,'Año a Cursar: ',1,0);
    $lobjPdf->Cell(15,5,$arr['anio_a_cursar'][0]=='1' ? '1ero: X' : '1ero: ',1,0,'C');
    $lobjPdf->Cell(15,5,$arr['anio_a_cursar'][0]=='2' ? '2do: X' : '2do: ',1,0,'C');
    $lobjPdf->Cell(15,5,$arr['anio_a_cursar'][0]=='3' ? '3ero: X' : '3ero: ',1,0,'C');
    $lobjPdf->Cell(15,5,$arr['anio_a_cursar'][0]=='4' ? '4to: X' : '4to: ',1,0,'C');
    $lobjPdf->Cell(15,5,$arr['anio_a_cursar'][0]=='5' ? '5to: X' : '5to: ',1,0,'C');
    $lobjPdf->Cell(40,5,'Coordinación Pedagógica N°: ',1,0);
    $lobjPdf->Cell(5,5,'1',1,0);
    $lobjPdf->Cell(5,5,$arr['coordinacion_pedagogica'][0]=='1' ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(5,5,'2',1,0);
    $lobjPdf->Cell(5,5,$arr['coordinacion_pedagogica'][0]=='2' ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(5,5,'3',1,0);
    $lobjPdf->Cell(5,5,$arr['coordinacion_pedagogica'][0]=='3' ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(5,5,'4',1,0);
    $lobjPdf->Cell(5,5,$arr['coordinacion_pedagogica'][0]=='4' ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(5,5,'5',1,0);
    $lobjPdf->Cell(5,5,$arr['coordinacion_pedagogica'][0]=='5' ? 'X' : '',1,1,'C');
    $lobjPdf->SetFont('Arial','B',10);
    $lobjPdf->Cell(190,5,'II.-CONDICIÓN DEL ESTUDIANTE',1,1);
    $lobjPdf->SetFont('Arial','',8);
    $lobjPdf->Cell(20,5,'Reg.',1,0);
    $lobjPdf->Cell(20,5,'Rep.',1,0);
    $lobjPdf->Cell(40,5,'Mat. Pend.',1,1);
    $lobjPdf->Cell(20,5,$arr['estudiante_regular'][0]=='Y' ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(20,5,$arr['estudiante_regular'][0]=='N' ? 'X' : '',1,0);
    $lobjPdf->Cell(10,5,'SÍ',1,0);
    $lobjPdf->Cell(10,5,$arr['materia_pendiente'][0]=="Y" ? 'X' : '',1,0);
    $lobjPdf->Cell(10,5,'NO',1,0);
    $lobjPdf->Cell(10,5,$arr['materia_pendiente'][0]=="N" ? 'X' : '',1,0,'C');
    $lobjPdf->SetXY(90,107);
    $lobjPdf->Cell(110,10,'¿Cúal? '.$arr['cual_materia'][0],1,1);
    $lobjPdf->SetFont('Arial','',8);
    $lobjPdf->Cell(140,5,'Procedencia: '.$arr['procedencia'][0],1,0);
    $lobjPdf->SetFont('Arial','',8);
    $lobjPdf->Cell(50,5,'Teléfono: ('.$arr['telefono_local'][0].')',1,1);
    $lobjPdf->Cell(40,5,'Estado de Salud: Excelente',1,0);
    $lobjPdf->Cell(5,5,$arr['estado_salud'][0]=='1' ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(15,5,'Bueno',1,0);
    $lobjPdf->Cell(5,5,$arr['estado_salud'][0]=='2' ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(15,5,'Regular',1,0);
    $lobjPdf->Cell(5,5,$arr['estado_salud'][0]=='3' ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(20,5,'Alérgico(a)',1,0);
    $lobjPdf->Cell(10,5,$arr['alergico'][0]=='Y' ? 'SÍ X' : 'SÍ ',1,0);
    $lobjPdf->Cell(10,5,$arr['alergico'][0]=='N' ? 'NO X' : 'NO ',1,0);
    $lobjPdf->Cell(45,5,'Impedimentos P/Deportes',1,0);
    $lobjPdf->Cell(5,5,'SÍ',1,0);
    $lobjPdf->Cell(5,5,$arr['impedimento_deporte'][0]=='Y' ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(5,5,'NO',1,0);
    $lobjPdf->Cell(5,5,$arr['impedimento_deporte'][0]=='N' ? 'X' : '',1,1,'C');
    $lobjPdf->Cell(110,5,'Especifique: '.$arr['especifique_deporte'][0],1,0);
    $lobjPdf->Cell(80,5,$arr['practica_deporte'][0]=="Y" ? 'Practica algún Deporte: SÍ ¿Cuál?: '.$arr['cual_deporte'][0] : 'Practica algún Deporte: NO ¿Cuál?: ',1,1);
    $lobjPdf->Cell(45,5,'Tiene Beca ',1,0);
    $lobjPdf->Cell(5,5,'SÍ',1,0);
    $lobjPdf->Cell(5,5,$arr['tiene_beca'][0]=="Y" ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(5,5,'NO',1,0);
    $lobjPdf->Cell(5,5,$arr['tiene_beca'][0]=="N" ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(125,5,'Organismo: '.$arr['organismo'][0],1,1);
    $lobjPdf->Cell(45,5,$arr['tiene_hermanos'][0]=="Y" ? 'N° de Hermanos: '.($arr['cuantos_varones'][0] + $arr['cuantas_hembras'][0]) : 'N° de Hermanos: 0',1,0);
    $lobjPdf->Cell(5,5,'V',1,0);
    $lobjPdf->Cell(5,5,$arr['tiene_hermanos'][0]=="Y" ? $arr['cuantos_varones'][0] : '0',1,0,'C');
    $lobjPdf->Cell(5,5,'H',1,0);
    $lobjPdf->Cell(5,5,$arr['tiene_hermanos'][0]=="Y" ? $arr['cuantas_hembras'][0] : '0',1,0,'C');
    $lobjPdf->Cell(40,5,'Estudian Acá: ',1,0);
    $lobjPdf->Cell(5,5,'SÍ',1,0);
    $lobjPdf->Cell(5,5,$arr['estudian_aca'][0]=="Y" ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(5,5,'NO',1,0);
    $lobjPdf->Cell(5,5,$arr['estudian_aca'][0]=="N" ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(20,5,'Año: ',1,0);
    $lobjPdf->Cell(45,5,$arr['estudian_aca'][0]=="Y" ? $arr['que_anio'][0] : '',1,1);
    $lobjPdf->Cell(50,5,'Peso del Estudiante: '.$arr['peso'][0],1,0);
    $lobjPdf->Cell(30,5,'Estatura: '.$arr['talla'][0],1,0,'C');
    $lobjPdf->Cell(35,5,'Índice: '.$arr['indice'][0],1,0);
    $lobjPdf->Cell(75,5,$arr['tiene_talento'][0]=="Y" ? 'Tiene habilidades/talento: SÍ ¿Cuál? '.$arr['cual_talento'][0] : 'Tiene habilidades/talento: NO ¿Cuál? ',1,1);
    $lobjPdf->SetFont('Arial','B',10);
    $lobjPdf->Cell(190,5,'III.-ANTECEDENTES FAMILIARES',1,1);
    $lobjPdf->SetFont('Arial','',8);
    $lobjPdf->Cell(115,5,'Nombres y Apellidos del Padre: '.$arr['padre'][0],1,0);
    $lobjPdf->Cell(25,5,'F.N.: '.$arr['fecha_nacimiento_padre'][0],1,0);
    $lobjPdf->Cell(5,5,'C.I',1,0);
    $lobjPdf->Cell(5,5,'V',1,0);
    $lobjPdf->Cell(5,5,$arr['nacionalidad_padre'][0] != "E" ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(5,5,'E',1,0);
    $lobjPdf->Cell(5,5,$arr['nacionalidad_padre'][0] == "E" ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(25,5,'N°: '.$arr['cedula_padre'][0],1,1);
    $lobjPdf->Cell(90,5,'Profesión: '.$arr['profesion_padre'][0],1,0);
    $lobjPdf->Cell(100,5,'Grado de Instrucción: '.$arr['grado_instruccion_padre'][0],1,1);
    $lobjPdf->Cell(120,10,'Dirección: '.$arr['direccion_padre'][0],1,0);
    $lobjPdf->Cell(70,10,'Teléfono: ('.$arr['telefono_local_padre'][0].')',1,1);
    $lobjPdf->Cell(115,5,'Nombres y Apellidos de la Madre: '.$arr['madre'][0],1,0);
    $lobjPdf->Cell(25,5,'F.N.: '.$arr['fecha_nacimiento_madre'][0],1,0);
    $lobjPdf->Cell(5,5,'C.I',1,0);
    $lobjPdf->Cell(5,5,'V',1,0);
    $lobjPdf->Cell(5,5,$arr['nacionalidad_madre'][0] != "E" ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(5,5,'E',1,0);
    $lobjPdf->Cell(5,5,$arr['nacionalidad_madre'][0] == "E" ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(25,5,'N°: '.$arr['cedula_madre'][0],1,1);
    $lobjPdf->Cell(90,5,'Profesión: '.$arr['profesion_madre'][0],1,0);
    $lobjPdf->Cell(100,5,'Grado de Instrucción: '.$arr['grado_instruccion_madre'][0],1,1);
    $lobjPdf->Cell(120,10,'Dirección: '.$arr['direccion_madre'][0],1,0);
    $lobjPdf->Cell(70,10,'Teléfono: ('.$arr['telefono_local_madre'][0].')',1,1);
    $lobjPdf->SetFont('Arial','B',10);
    $lobjPdf->Cell(190,5,'IV.-DATOS DEL REPRESENTANTE LEGAL',1,1);
    $lobjPdf->SetFont('Arial','',8);
    $lobjPdf->Cell(115,5,'Nombres y Apellidos: '.$arr['representante'][0],1,0);
    $lobjPdf->Cell(25,5,'F.N.: '.$arr['fecha_nacimiento_representante'][0],1,0);
    $lobjPdf->Cell(5,5,'C.I',1,0);
    $lobjPdf->Cell(5,5,'V',1,0);
    $lobjPdf->Cell(5,5,$arr['nacionalidad_representante'][0] != "E" ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(5,5,'E',1,0);
    $lobjPdf->Cell(5,5,$arr['nacionalidad_representante'][0] == "E" ? 'X' : '',1,0,'C');
    $lobjPdf->Cell(25,5,'N°: '.$arr['cedula_representante'][0],1,1);
    $lobjPdf->Cell(90,5,'Profesión: '.$arr['profesion_representante'][0],1,0);
    $lobjPdf->Cell(100,5,'Grado de Instrucción: '.$arr['grado_instruccion_representante'][0],1,1);
    $lobjPdf->Cell(30,5,'Parentesco: ',1,0);
    $lobjPdf->Cell(20,5,$arr['parentesco'][0]=="MADRE" ? 'Madre: X' : 'Madre: ',1,0);
    $lobjPdf->Cell(20,5,$arr['parentesco'][0]=="PADRE" ? 'Padre: X' : 'Padre: ',1,0);
    $lobjPdf->Cell(20,5,$arr['parentesco'][0]!="MADRE" && $arr['parentesco'][0]!="PADRE" ? 'Otro: X' : 'Otro: ',1,0);
    $lobjPdf->Cell(100,5,$arr['parentesco'][0]!="MADRE" && $arr['parentesco'][0]!="PADRE" ? 'Especifique: '.$arr['parentesco'][0] : 'Especifique: ',1,1);
    $lobjPdf->Cell(120,10,'Dirección: '.$arr['direccion_representante'][0],1,0);
    $lobjPdf->Cell(70,10,'Teléfono: ('.$arr['telefono_local_representante'][0].')',1,1);
    $lobjPdf->SetFont('Arial','B',10);
    $lobjPdf->Cell(190,5,'V.-INTEGRACIÓN ESCUELA - COMUNIDAD',1,1);
    $lobjPdf->SetFont('Arial','',8);
    $lobjPdf->Cell(190,5,'En que podría usted aportar para la Integración Escuela-Comunidad, a fin de participar en bienestar de la Institución:','LTR',1);
    $lobjPdf->Cell(190,5,'Educativo ('.($arr['integracion_educativa'][0]=="Y" ? ' X ' : '   ').') Plomería ('.($arr['integracion_plomeria'][0]=="Y" ? ' X ' : '   ').') Electricidad ('.($arr['integracion_electricidad'][0]=="Y" ? ' X ' : '   ').') Albañilería ('.($arr['integracion_albanileria'][0]=="Y" ? ' X ' : '   ').') Peluquería ('.($arr['integracion_peluqueria'][0]=="Y" ? ' X ' : '   ').') Ambientación ('.($arr['integracion_ambientacion'][0]=="Y" ? ' X ' : '   ').') Manualidades ('.($arr['integracion_manualidades'][0]=="Y" ? ' X ' : '   ').') Bisutería ('.($arr['integracion_bisuteria'][0]=="Y" ? ' X ' : '   ').') Otros ('.($arr['otra_integracion'][0]=="Y" ? ' X ' : '   ').')','LR',1);
    if($arr['otra_integracion'][0]=="Y"){
      $lobjPdf->Cell(15,5,'Especifique:','LB',0);
      $lobjPdf->SetFont('Arial','U',8);
      $lobjPdf->Cell(175,5,$arr['especifique_integracion'][0],'BR',1);
    }else{
      $lobjPdf->Cell(190,5,'Especifique:______________________________________________________','LBR',1);
    }
    $lobjPdf->SetFont('Arial','B',10);
    $lobjPdf->Cell(190,5,'VI.- DOCUMENTOS CONSIGNADOS',1,1);
    $lobjPdf->SetFont('Arial','',8);
    $lobjPdf->Cell(95,5,$arr['fotocopia_ci'][0]=="Y" ? '(  X  ) Fotocopia C.I. Estudiante' :  '(     ) Fotocopia C.I. Estudiante',1,0);
    $lobjPdf->Cell(95,5,$arr['fotos_estudiante'][0]=="Y" ? '(  X  ) 4 Fotos Estudiante' : '(     ) 4 Fotos Estudiante',1,1);
    $lobjPdf->Cell(95,5,$arr['partida_nacimiento'][0]=="Y" ? '(  X  ) Partida de Nacimiento Original  y Copia' : '(     ) Partida de Nacimiento Original  y Copia',1,0);
    $lobjPdf->Cell(95,5,$arr['boleta_zonificacion'][0]=="Y" ? '(  X  ) Boleta de Zonificación' : '(     ) Boleta de Zonificación',1,1);
    $lobjPdf->Cell(95,5,$arr['boleta_promocion'][0]=="Y" ? '(  X  ) Boleta de Promoción' : '(     ) Boleta de Promoción',1,0);
    $lobjPdf->Cell(95,5,$arr['fotocopia_ci_representante'][0]=="Y" ? '(  X  ) Fotocopia C.I. Representante' : '(     ) Fotocopia C.I. Representante',1,1);
    $lobjPdf->Cell(95,5,$arr['certificado_calificaciones'][0]=="Y" ? '(  X  ) Certificado de Calificaciones' : '(     ) Certificado de Calificaciones',1,0);
    $lobjPdf->Cell(95,5,$arr['fotos_representante'][0]=="Y" ? '(  X  ) 2 Fotos Representante' : '(     ) 2 Fotos Representante',1,1);
    $lobjPdf->Cell(95,5,$arr['constancia_buenaconducta'][0]=="Y" ? '(  X  ) Constancia de Buena Conducta' : '(     ) Constancia de Buena Conducta',1,0);
    $lobjPdf->Cell(95,5,$arr['otro_documento'][0]=="Y" ? '(  X  ) Otro ¿Cuál? '.$arr['cual_documento'][0] : '(     ) Otro ¿Cuál?',1,1);
    $lobjPdf->Cell(190,5,'Observación: '.$arr['observacion_documentos'][0],1,1);
    $lobjPdf->SetFont('Arial','B',10);
    $lobjPdf->Cell(190,5,'VII.- INSCRIPICIÓN',1,1);
    $lobjPdf->SetFont('Arial','',8);
    $lobjPdf->Cell(70,5,'Fecha de Inscripción: '.$arr['fecha_inscripcion'][0],1,0);
    $lobjPdf->Cell(120,5,'Procedencia: ',1,1);
    $lobjPdf->Cell(10,5,'Año: ',1,0);
    if($arr['anio_a_cursar'][0] == "1")
      $lobjPdf->Cell(10,5,'1ero',1,0,'C');
    else if ($arr['anio_a_cursar'][0] == "2")
      $lobjPdf->Cell(10,5,'2do',1,0,'C');
    else if ($arr['anio_a_cursar'][0] == "3")
      $lobjPdf->Cell(10,5,'3ero',1,0,'C');
    else if ($arr['anio_a_cursar'][0] == "4")
      $lobjPdf->Cell(10,5,'4to',1,0,'C');
    else 
      $lobjPdf->Cell(10,5,'5to',1,0,'C');
    $lobjPdf->Cell(15,5,'Sección: ',1,0);
    $lobjPdf->Cell(25,5,$arr['nombre_seccion'][0],1,0,'C');
    $lobjPdf->Cell(30,5,'Condición: Regular: ',1,0);
    $lobjPdf->Cell(10,5,'X',1,0,'C');
    $lobjPdf->Cell(20,5,'Repitiente: ',1,0);
    $lobjPdf->Cell(10,5,'',1,0,'C');
    $lobjPdf->Cell(35,5,'Materia Pendiente: NO',1,0);
    $lobjPdf->Cell(25,5,'',1,1,'C');
    $lobjPdf->Cell(190,5,'Asignatura (s) Pendiente (s): ',1,1);
    $lobjPdf->Cell(190,5,'Asignaturas (s) que repite: ',1,1);
    $lobjPdf->Cell(10,5,'Edad',1,0);
    $lobjPdf->Cell(5,5,$arr['edad'][0],1,0,'C');
    $lobjPdf->Cell(10,5,'Años',1,0);
    $lobjPdf->Cell(10,5,'Meses',1,0);
    $lobjPdf->Cell(5,5,$arr['meses'][0],1,0,'C');
    $lobjPdf->Cell(12,5,'Estatura',1,0);
    $lobjPdf->Cell(9,5,($arr['talla'][0]),1,0,'C');
    $lobjPdf->Cell(9,5,'Peso',1,0);
    $lobjPdf->Cell(10,5,$arr['peso'][0],1,0,'C');
    $lobjPdf->Cell(15,5,'Índice',1,0);
    $lobjPdf->Cell(10,5,$arr['indice'][0],1,0,'C');
    $lobjPdf->Cell(85,5,'Documentos Consignados:',1,1);
    $lobjPdf->Cell(85,5,'',1,0);
    $lobjPdf->Cell(105,5,'Observación:'.$arr['observacion'][0],1,1);
    $lobjPdf->SetFont('Arial','B',10);
    $lobjPdf->Cell(190,5,'VIII.- EGRESO',1,1);
    $lobjPdf->SetFont('Arial','',8);
    $lobjPdf->Cell(45,5,'Fecha:',1,0);
    $lobjPdf->Cell(145,5,'Causa:',1,1);
    $lobjPdf->Cell(190,10,'Observación:',1,1);
    // Fin 1era Página
    // 2da Página
    $lobjPdf->AddPage("P","Legal");
    $lobjPdf->Ln(5);
    $lobjPdf->SetFont('Arial','',10);
    $lobjPdf->Cell(10);
    $lobjPdf->Cell(5,5,'Yo, ',0,0);
    $lobjPdf->SetFont('Arial','BU',10);
    $lobjPdf->Cell(3);
    $lobjPdf->Cell(80,5,$arr['representante'][0],0,0);
    $lobjPdf->SetFont('Arial','',10);
    $lobjPdf->Cell(15,5,'C.I.Nº ',0,0);
    $lobjPdf->SetFont('Arial','BU',10);
    $lobjPdf->Cell(20,5,$arr['cedula_representante'][0],0,0);
    $lobjPdf->SetFont('Arial','',10);
    $lobjPdf->Cell(15,5,'Representante del estudiante',0,1);
    $lobjPdf->SetFont('Arial','BU',10);
    $lobjPdf->Cell(10);
    $lobjPdf->Cell(80,5,$arr['estudiante'][0],0,0);
    $lobjPdf->SetFont('Arial','',10);
    $lobjPdf->Cell(12,5,'C.I.Nº ',0,0);
    $lobjPdf->SetFont('Arial','BU',10);
    $lobjPdf->Cell(20,5,$arr['cedula_persona'][0],0,0);
    $lobjPdf->SetFont('Arial','',10);
    $lobjPdf->Cell(3);
    $lobjPdf->Cell(15,5,'me comprometo responsablemente,',0,1);
    $lobjPdf->Cell(10);
    $lobjPdf->Cell(15,5,'al momento de la inscripción a cumplir y hacer cumplir a mi representado las normas de convivencias de la',0,1);
    $lobjPdf->Cell(10);
    $lobjPdf->Cell(15,5,'institución, así como también, aceptaré toda responsabilidad que implique el no acatamiento de las normas,',0,1);
    $lobjPdf->Cell(10);
    $lobjPdf->Cell(15,5,'de igual forma me comprometo a:',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'1. Que mi representado debe acatar todo lo referente a: al corte de cabello, el no uso de piercing, zarcillos',0,1);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'(los caballeros),gorra,durante todo el año escolar, de lo contrario en el caso de la gorra serán decomisadas',0,1);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'por los docentes de la institución la misma será entregada al final del año escolar. ',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'2. El uso reglamentario del uniforme escolar, calzado negro, uniforme de deporte y bolso transparente. ',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'3. Asistir a las citaciones enviadas por la institución para tratar asuntos relacionados con mi representado. ',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'4. Asistir a las reuniones de representantes, y al retiro de boletines. ',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'5. A que los datos colocados en la fichas de inscripción son actuales y verdaderos. ',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'6. Participar en las actividades que me solicite la institución para lograr una buena integración. ',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'7. Responder por los daños ocasionados a la institución por mi representado de forma inmediata. ',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'8. Notificar si mi representado sufre alguna enfermedad que le impida hacer Educ. Física, con informe',0,1);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'médico emitido por una institución de salud pública como evidencia para evitar problemas en adelante. ',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'9. Velar por el cumplimiento en forma oportuna de las actividades académicas de mi representado, de igual',0,1);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'manera con el cumplimiento del Artículo 13. ',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'10. Presentar  ante las autoridades correspondiente Reposo Médico dentro de los lapsos que establece la ley',0,1);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'para que sean procesadas las evaluaciones y justificada sus inasistencias. ',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'11. Lo establecido en el Articulo 109 (Asistencia). ',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'12. Hablar con mi representado para que esté pendiente de sus útiles escolares ya que la institución no se',0,1);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'hace responsable por pérdida alguna. ',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'13. Hablar con mi representado sobre el buen uso de los celulares ya que cualquier incidencia como por ',0,1);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'ejemplo filmación de videos, interrupciones de la actividad escolar serán penalizados según la ley y normativa',0,1);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'de la institución.',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'14. Hablar con mi representado para que no cometa falta alguna que pueda perjudicar el desarrollo de su',0,1);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'actividad escolar.',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'15. No permitir el consumo de cigarrillos, bebidas espirituosa o cualquier derivado del tabaco (chimó).',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'16. Aceptar que la institución se reserva  el derecho en la asignación de la sección de mi representado. ',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(15);
    $lobjPdf->Cell(15,5,'17. Cumplir con todo lo establecido por la Ley.',0,1);
    $lobjPdf->Ln(80);
    $lobjPdf->Cell(20);
    $lobjPdf->Cell(80,5,'________________________________                            ________________________________',0,1);
    $lobjPdf->Ln(2);
    $lobjPdf->Cell(35);
    $lobjPdf->Cell(80,5,'Firma de Representante                                                       Firma del Docente',0,1);
    // Fin 2da Página
  $lobjPdf->Output('documento',"I");
  }else{
  echo "ERROR AL GENERAR ESTE REPORTE!";
  }
?>
