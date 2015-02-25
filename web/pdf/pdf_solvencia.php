<?php
require_once("../librerias/fpdf/fpdf.php");
require_once("../class/class_bd.php");
session_start();
class clsFpdf extends FPDF {
  var $widths;
  var $aligns;
  //Cabecera de página
  public function Header(){
    $this->Image("../images/cintillo.jpg" , 25 ,10, 170 , 25, "JPG" ,$_SERVER['HTTP_HOST']."/CHSB/web/");
    $this->Image("../images/logo.jpg" ,45,85,115,105, "JPG");
    $this->Ln(30);
    $this->SetFont('Arial','',12);
    $this->Cell(75);
    $this->Cell(69,5,'ACARIGUA,',0,0,'R');
    $this->SetFont('Arial','',12);  
    $this->Cell(23,5,date("d/m/Y"),0,1,'R',false); 
    $this->Ln(13); 
    //setlocale(LC_ALL,"es_VE.UTF8");
    $this->SetFont("Arial","B",12);
    $avanzar=25;
    $this->Cell($avanzar);
    $empresa="Centro de Recursos para el Aprendizaje (C.R.A)";
    $dir="Liceo Bolivariano Bicentenario de la Independencia de Venezuela.";
    $this->Cell(130,4,$empresa,0,1,"C");
    $this->Cell($avanzar); 
    $this->Cell(130,4,$dir,0,1,"C");
    $this->Ln(30);
    $this->SetFont('Arial','BU',16);
    $this->Cell(65);
    $this->Cell(69,5,'SOLVENCIA DE BIBLIOTECA',0,0,'R');
   
  }

  //Pie de página
  public function Footer(){
      $pgsql=new Conexion();
    $sql="SELECT e.primer_nombre||' '||e.primer_apellido AS responsable
    FROM general.tpersona e
    INNER JOIN general.tpersona r ON e.cedula_persona = r.cedula_persona 
   INNER JOIN general.ttipo_persona tp ON e.codigo_tipopersona=tp.codigo_tipopersona WHERE tp.descripcion LIKE '%BIBLIOTECARIO%'";
    $data=$pgsql->Ejecutar($sql);
    $fila=array();
    while($rows=$pgsql->Respuesta($data)){
    $filas['responsable'][]=$rows['responsable'];
        }
    $this->SetFont('Arial','B',12);
    $this->Cell(75);
    $this->Cell(65,5,$filas['responsable'][0],0,1);
     $this->SetFont('Arial','B',12);
    $this->Cell(73);
    $this->Cell(69,5,'COORDINACIÓN C.R.A.',0,0);
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

    $this->Ln(-9);
    $this->SetFont("Arial","I",8);
    $avanzar=30;
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

  function Row($data,$color){
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
      $this->MultiCell($w,5,$data[$i],0,$a,$color);
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

  public function RoundedRect($x, $y, $w, $h, $r, $style = ''){
    $k = $this->k;
    $hp = $this->h;
    if($style=='F')
      $op='f';
    elseif($style=='FD' || $style=='DF')
      $op='B';
    else
      $op='S';
    $MyArc = 4/3 * (sqrt(2) - 1);
    $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
    $xc = $x+$w-$r ;
    $yc = $y+$r;
    $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));
    $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
    $xc = $x+$w-$r ;
    $yc = $y+$h-$r;
    $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
    $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
    $xc = $x+$r ;
    $yc = $y+$h-$r;
    $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
    $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
    $xc = $x+$r ;
    $yc = $y+$r;
    $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
    $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
    $this->_out($op);
  }

  public function _Arc($x1, $y1, $x2, $y2, $x3, $y3){
    $h = $this->h;
    $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
    $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
  }
}

//generar el listado 
setlocale(LC_ALL,"es_VE.UTF8");
$lobjPdf=new clsFpdf();
$lobjPdf->AddPage("P,Letter");
$lobjPdf->AliasNbPages();
$lobjPdf->Ln(15);
$pgsql=new Conexion();
$sql="SELECT p.cedula_persona,p.primer_nombre||' '||p.segundo_nombre||' '||p.primer_apellido||' '||p.segundo_apellido AS persona,
    CASE pins.anio_a_cursar WHEN '1' THEN '1ER AÑO' WHEN '2' THEN '2DO AÑO' WHEN '3' THEN '3ER AÑO' WHEN '4' THEN '4TO AÑO' ELSE '5TO AÑO' END AS anio_a_cursar,
    pe.descripcion AS periodo,tp.descripcion
    from general.tpersona p
    INNER JOIN educacion.tproceso_inscripcion pins ON p.cedula_persona = pins.cedula_persona 
    INNER JOIN educacion.tinscripcion i ON pins.codigo_inscripcion = i.codigo_inscripcion 
    INNER JOIN educacion.tperiodo pe ON i.codigo_periodo = pe.codigo_periodo
    INNER JOIN general.ttipo_persona tp ON p.codigo_tipopersona=tp.codigo_tipopersona WHERE tp.descripcion LIKE '%ESTUDIANTE%'";  
$i=-1;
$data=$pgsql->Ejecutar($sql);
if($pgsql->Total_Filas($data)!=0){
  $filas=array();
  while($rows=$pgsql->Respuesta($data)){
    $filas['cedula_persona'][]=$rows['cedula_persona'];
    $filas['persona'][]=$rows['persona'];
    $filas['anio_a_cursar'][]=$rows['anio_a_cursar'];
    $filas['periodo'][]=$rows['periodo'];
  }
 setlocale(LC_ALL,"es_VE.UTF8");
  $lobjPdf=new clsFpdf();
    // 2da Página
    $lobjPdf->AddPage("P,Letter");
    $lobjPdf->Ln(40);
    $lobjPdf->SetFont('Arial','',12);
    $lobjPdf->Cell(25);
    $lobjPdf->Cell(32,5,'Se hace constar que: ',0,0,'L');
    $lobjPdf->SetFont('Arial','BU',12);
    $lobjPdf->Cell(12);
    $lobjPdf->Cell(75,5,$filas['persona'][0],0,1,'L');
    $lobjPdf->SetFont('Arial','',12);
    $lobjPdf->Cell(12);
    $lobjPdf->Cell(60,5,'titular de la Cédula de Identidad Nº:',0,0,'L');
    $lobjPdf->SetFont('Arial','BU',12);
    $lobjPdf->Cell(12);
    $lobjPdf->Cell(14,5,$filas['cedula_persona'][0],0,0);
    $lobjPdf->SetFont('Arial','',12);
    $lobjPdf->Cell(12);
    $lobjPdf->Cell(15,5,'cursante del ',0,0,'L');
    $lobjPdf->SetFont('Arial','BU',12);
    $lobjPdf->Cell(12);
    $lobjPdf->Cell(10,5,$filas['anio_a_cursar'][0],0,0);
    $lobjPdf->SetFont('Arial','',12);
    $lobjPdf->Cell(12);
    $lobjPdf->Cell(75,5,'de',0,1,'');
    $lobjPdf->SetFont('Arial','',12);
    $lobjPdf->Cell(12);
    $lobjPdf->Cell(82,5,'Educación media General en nuestra institución,',0,0,'L');
    $lobjPdf->SetFont('Arial','',12);
    $lobjPdf->Cell(12);
    $lobjPdf->Cell(22,5,'Período Escolar',0,0,'L');
    $lobjPdf->SetFont('Arial','BU',12);
    $lobjPdf->Cell(12);
    $lobjPdf->Cell(19,5,$filas['periodo'][0],0,1);
    $lobjPdf->SetFont('Arial','',12);
    $lobjPdf->Cell(12);
    $lobjPdf->Cell(21,5,'se encuentra en ',0,0);
    $lobjPdf->SetFont('Arial','B',12);
    $lobjPdf->Cell(12);
    $lobjPdf->Cell(33,5,'ESTADO SOLVENTE,',0,0);
    $lobjPdf->SetFont('Arial','',12);
    $lobjPdf->Cell(12);
    $lobjPdf->Cell(18,5,'en relación a los préstamos de material',0,1);
    $lobjPdf->SetFont('Arial','',12);
    $lobjPdf->Cell(12);
    $lobjPdf->Cell(15,5,'bibliográfico y demás recursos de este centro.',0,1);
    $lobjPdf->Ln(26);
    $lobjPdf->SetFont('Arial','',12);
    $lobjPdf->Cell(45);
    $lobjPdf->Cell(14,5,'Solvencia que se expide a petición de la parte interesada,',0,1);
    $lobjPdf->Cell(15);
    $lobjPdf->Ln(50);
    $lobjPdf->Cell(55);
    $lobjPdf->Cell(80,5,'__________________________________',0,1);
    $lobjPdf->Ln(1);
  $lobjPdf->ln(5);
  $lobjPdf->Output('documento',"I");
}else{
  echo "ERROR AL GENERAR ESTE REPORTE!";          
}
?>