<?php

require_once("../librerias/fpdf/fpdf.php");
require_once("../class/class_bd.php");
   session_start();
  class clsFpdf extends FPDF {
     var $widths;
      var $aligns;
   //Cabecera de página
    public function Header()
    {
  
   $this->Image("../images/banner.jpg" , 25 ,15, 250 , 40, "JPG" ,$_SERVER['HTTP_HOST']."/project/web/");   $this->Ln(55);  
   $this->SetFont('Arial','B',12);
   $this->Cell(0,6,'LISTADO DE LOS PROCESOS DE INSCIPCIONES',0,1,"C");
   $this->Ln(8);
    
    
     $this->SetFillColor(0,0,140); 
         $avnzar=30;
         $altura=7;
         $anchura=10;
         $color_fondo=false;
         $this->SetFont('Arial','B',10);
         $this->SetTextColor(0,0,0);
         $this->Cell($avnzar);
      $this->Cell($anchura*2,$altura,'CÓDIGO',1,0,'C',$color_fondo); 
      $this->Cell($anchura*4,$altura,'FECHA DE INSCIPCIÓN',1,0,'C',$color_fondo);
      $this->Cell($anchura*5,$altura,'RESPONSABLE',1,0,'C',$color_fondo);
      $this->Cell($anchura*5,$altura,'ESTUDIANTE',1,0,'C',$color_fondo);
      $this->Cell($anchura*3,$altura,'AÑO A CURSAR',1,0,'C',$color_fondo);
      $this->Cell($anchura*2+6,$altura,'ESTATUS',1,1,'C',$color_fondo); 
      
                  $this->Cell($avnzar); 
                  }

    //Pie de página
  public function Footer()
    {
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
    
    function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}
 
function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
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

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
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
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
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
        if($l>$wmax)
        {
            if($sep==-1)
            {
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

   $lobjPdf->SetFont("arial","B",8);
   
    $lobjPdf->SetFont('Arial','',12);
   //Table with 20 rows and 5 columns
      $lobjPdf->SetWidths(array(20,40,50,50,30,26));
  $pgsql=new Conexion();
    $sql="SELECT pins.codigo_proceso_inscripcion,TO_CHAR(pins.fecha_inscripcion,'DD/MM/YYYY') as fecha_inscripcion,
    pins.cedula_responsable||' '||r.primer_nombre||' '||r.primer_apellido AS responsable,
    pins.cedula_persona||' '||p.primer_nombre||' '||p.primer_apellido AS estudiante,
    CASE pins.anio_a_cursar WHEN '1' THEN '1er Año' WHEN '2' THEN '2do Año' WHEN '3' THEN '3er Año' WHEN '4' THEN '4to Año'
    ELSE '5to Año' END AS anio_a_cursar,(CASE pins.estatus WHEN '1' THEN 'ACTIVO' ELSE 'DESACTIVADO' END) AS estatus
    FROM educacion.tproceso_inscripcion pins 
    INNER JOIN general.tpersona r ON pins.cedula_responsable = r.cedula_persona 
    INNER JOIN general.tpersona p ON pins.cedula_persona = p.cedula_persona";

   $i=-1;
  $data=$pgsql->Ejecutar($sql);
    if($pgsql->Total_Filas($data)!=0){
         $lobjPdf->SetFillColor(0,0,140); 
         $avnzar=30;
         $altura=7;
         $anchura=10;
         $color_fondo=false;
         $lobjPdf->SetFont('Arial','B',10);
         //$lobjPdf->Row(array("N°","Codigo","Perfil","Estatus"));
         $lobjPdf->SetTextColor(0,0,0);
         $lobjPdf->SetFont('Arial','',8);
         $lobjPdf->SetTextColor(0,0,0); 
         $xxxx=0;
         while($tperfil=$pgsql->Respuesta($data)){
         $lobjPdf->Row(array(
         ucwords($tperfil['codigo_proceso_inscripcion']),
         ucwords($tperfil['fecha_inscripcion']),
         ucwords($tperfil['responsable']),
         ucwords($tperfil['estudiante']),
         ucwords($tperfil['anio_a_cursar']),
         ucwords($tperfil['estatus'])));
          $lobjPdf->Cell($avnzar);         
         }
         
         $lobjPdf->Output('documento',"I");
         }else{
            echo "ERROR AL GENERAR ESTE REPORTE!";          
          }
?>