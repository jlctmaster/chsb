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
   $this->Image("../images/cintillo.jpg" , 25 ,15, 250 , 40, "JPG" ,$_SERVER['HTTP_HOST']."/project/web/");   
   $this->Ln(55);  
   $this->SetFont('Arial','B',12);
   $this->Cell(0,6,'LISTADO DE LOS BIENES RECONSTRUIDOS',0,1,"C");
   $this->Ln(8);
    
    
     $this->SetFillColor(0,0,140); 
         $avnzar=0.5;
         $altura=7;
         $anchura=10;
         $color_fondo=false;
         $this->SetFont('Arial','B',10);
         $this->SetTextColor(0,0,0);
                $this->Cell($avnzar); 
      $this->Cell($anchura*2,$altura,'CÓDIGO',1,0,'L',$color_fondo); 
      $this->Cell($anchura*2,$altura,'FECHA',1,0,'L',$color_fondo);  
      $this->Cell($anchura*3+5,$altura,'RESPONSABLE',1,0,'L',$color_fondo);
      $this->Cell($anchura*4,$altura,'UBICACIÓN ORIGEN.',1,0,'L',$color_fondo);
      $this->Cell($anchura*3,$altura,'BIEN A REC.',1,0,'L',$color_fondo);
      $this->Cell($anchura*3+3,$altura,'CANTIDAD A REC.',1,0,'L',$color_fondo);
      $this->Cell($anchura*3,$altura,'ITEM',1,0,'L',$color_fondo);
      $this->Cell($anchura*2,$altura,'CANTIDAD',1,0,'L',$color_fondo);
      $this->Cell($anchura*3,$altura,'UBICACIÓN',1,0,'L',$color_fondo);
      $this->Cell($anchura*2,$altura,'ESTATUS',1,1,'L',$color_fondo); 
      
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
      $lobjPdf->SetWidths(array(20,20,35,40,30,33,30,20,30,20));
  $pgsql=new Conexion();
    $sql="SELECT r.codigo_recuperacion,TO_CHAR(r.fecha,'DD/MM/YYYY') AS fecha,
  p.cedula_persona||' - '||p.primer_nombre||' '||p.primer_apellido AS responsable,
  uo.descripcion as ubicacion_origen, u.descripcion as ubicacion, r.cantidad AS cantidad_a_recuperar, 
  br.nro_serial||' '||br.nombre AS bien,b.nro_serial||' '||b.nombre AS item,dr.cantidad,
  CASE p.estatus when '1' then 'ACTIVO' when '0' then 'DESACTIVADO' end as estatus 
  FROM bienes_nacionales.trecuperacion r 
  INNER JOIN general.tpersona p ON r.cedula_persona = p.cedula_persona 
  INNER JOIN bienes_nacionales.tdetalle_recuperacion dr ON r.codigo_recuperacion = dr.codigo_recuperacion 
  INNER JOIN inventario.tubicacion uo ON r.codigo_ubicacion = uo.codigo_ubicacion 
  INNER JOIN inventario.tubicacion u ON dr.codigo_ubicacion = u.codigo_ubicacion 
  INNER JOIN bienes_nacionales.tbien br ON r.codigo_bien = br.codigo_bien 
  INNER JOIN bienes_nacionales.tbien b ON dr.codigo_item = b.codigo_bien 
  WHERE r.esrecuperacion='N'";
   $i=-1;
   //echo $sql; die();
  $data=$pgsql->Ejecutar($sql);
    if($pgsql->Total_Filas($data)!=0){
         $lobjPdf->SetFillColor(0,0,140); 
         $avnzar=0.5;
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
         ucwords($tperfil['codigo_recuperacion']),
         ucwords($tperfil['fecha']),
         ucwords($tperfil['responsable']),
         ucwords($tperfil['ubicacion_origen']),
         ucwords($tperfil['bien']),
         ucwords($tperfil['cantidad_a_recuperar']),
         ucwords($tperfil['item']),
         ucwords($tperfil['cantidad']),
         ucwords($tperfil['ubicacion']),
         ucwords($tperfil['estatus'])));
          $lobjPdf->Cell($avnzar);         
         }
         
         $lobjPdf->Output('documento',"I");
         }else{
            echo "ERROR AL GENERAR ESTE REPORTE!";          
          }
?>
