<?php
require_once("../librerias/fpdf/fpdf.php");
require_once("../class/class_bd.php");
session_start();

class clsFpdf extends FPDF {
  var $widths;
  var $aligns;
  //Cabecera de página
  public function Header(){
    $this->Image("../images/cintillo.jpg" , 25 ,15, 250 , 40, "JPG" ,$_SERVER['HTTP_HOST']."/project/web/");   
    $this->Ln(55);  
    $this->SetFont('Arial','B',12);
    $this->Cell(0,6,'REPORTE DE PRÉSTAMO DE LIBROS',0,1,"C");
    $this->Ln(8);
    $this->SetFillColor(0,0,140); 
    $avnzar=15;
    $altura=7;
    $anchura=10;
    $color_fondo=false;
    $this->SetFont('Arial','BIU',12);
    $this->Cell($avnzar-5);
    $this->Cell($anchura*4,$altura-2,'PARÁMETROS:',0,1,'C',$color_fondo);
    $this->SetFont('Arial','B',10);
    $this->Cell($avnzar-8);
    $this->Cell($anchura*4,$altura-2,'FECHA DESDE:',0,0,'C',$color_fondo); 
    $this->SetFont('Arial','',10);
    $this->Cell($anchura*2,$altura-2,$_POST['fecha_inicio'],0,1,'C',$color_fondo); 
    $this->SetFont('Arial','B',10);
    $this->Cell($avnzar-8);
    $this->Cell($anchura*4,$altura-2,'FECHA HASTA:',0,0,'C',$color_fondo);
    $this->SetFont('Arial','',10);
    $this->Cell($anchura*2,$altura-2,$_POST['fecha_fin'],0,1,'C',$color_fondo);
    $this->Ln(4);    
    $this->SetFont('Arial','B',10);
    $this->Cell($avnzar);
    $this->Cell($anchura*5,$altura,'RESPONSABLE',1,0,'C',$color_fondo); 
    $this->Cell($anchura*5,$altura,'ESTUDIANTE',1,0,'C',$color_fondo);
    $this->Cell($anchura*3,$altura,'AREA',1,0,'C',$color_fondo);
    $this->Cell($anchura*2,$altura,'COTA',1,0,'C',$color_fondo); 
    $this->Cell($anchura*2,$altura,'FECHA',1,0,'C',$color_fondo); 
    $this->Cell($anchura*6,$altura,'EJEMPLAR',1,0,'C',$color_fondo); 
    $this->Cell($anchura*2,$altura,'CANTIDAD',1,1,'C',$color_fondo); 
    $this->Cell($avnzar); 
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
$lobjPdf->AddPage("L");
$lobjPdf->AliasNbPages();
$avnzar=15;
$altura=7;
$anchura=10;
$color_fondo=false;
$lobjPdf->SetWidths(array($anchura*5,$anchura*5,$anchura*3,$anchura*2,$anchura*2,$anchura*6,$anchura*2));
$pgsql=new Conexion();
$sql="SELECT p.cedula_responsable||' '||resp.primer_nombre||' '||resp.primer_apellido AS responsable,
      p.cedula_persona||' '||est.primer_nombre||' '||est.primer_apellido AS estudiante,a.descripcion AS area,
      p.cota,TO_CHAR(p.fecha_salida,'DD/MM/YYYY') AS fecha_salida,
      e.codigo_isbn_libro||' '||l.titulo AS libro,dp.cantidad 
      FROM biblioteca.tprestamo p 
      INNER JOIN biblioteca.tdetalle_prestamo dp ON p.codigo_prestamo = dp.codigo_prestamo 
      INNER JOIN general.tpersona resp ON p.cedula_responsable = resp.cedula_persona 
      INNER JOIN general.tpersona est ON p.cedula_persona = est.cedula_persona 
      INNER JOIN general.tarea a ON p.codigo_area = a.codigo_area 
      INNER JOIN biblioteca.tejemplar e ON dp.codigo_ejemplar = e.codigo_ejemplar 
      INNER JOIN biblioteca.tlibro l ON e.codigo_isbn_libro = l.codigo_isbn_libro 
      WHERE fecha_salida BETWEEN ".$pgsql->comillas_inteligentes($_POST['fecha_inicio'])." AND ".$pgsql->comillas_inteligentes($_POST['fecha_fin'])." 
      ORDER BY fecha_salida ASC";
$data=$pgsql->Ejecutar($sql);
if($pgsql->Total_Filas($data)!=0){
  $lobjPdf->SetFont('Arial','',9);
  $total=0;
 while($prestamo=$pgsql->Respuesta($data)){
    $lobjPdf->Row(array($prestamo['responsable'],
    $prestamo['estudiante'],
    $prestamo['area'],
    $prestamo['cota'],
    $prestamo['fecha_salida'],
    $prestamo['libro'],
    $prestamo['cantidad']));
    $total+=$prestamo['cantidad'];
    $lobjPdf->Cell($avnzar);         
  }
  $lobjPdf->SetFont('Arial','B',9);
  $lobjPdf->Cell($anchura*23,$altura,"TOTAL PRESTAMOS:",1,0,"R",$color_fondo);
  $lobjPdf->Cell($anchura*2,$altura,$total,1,1,"R",$color_fondo);
  $lobjPdf->Output('documento',"I");
}else{
  echo "ERROR AL GENERAR ESTE REPORTE!";          
}
?>