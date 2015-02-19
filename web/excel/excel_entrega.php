<?php
	require_once("../class/class_bd.php");
	$mysql = new Conexion();
	$sql = "SELECT a.codigo_entrega,b.fecha_entrada||' - '||a.cedula_persona||' - '||INITCAP(p.primer_nombre||' '||p.primer_apellido) AS prestamo,
	a.cedula_responsable||' '||r.primer_nombre||' '||r.primer_apellido AS responsable,
    a.cedula_persona||' '||p.primer_nombre||' '||p.primer_apellido AS persona,
    TO_CHAR(a.fecha_entrada,'DD/MM/YYYY') AS fecha_entrada,
    b.codigo_cra||' - '||b.numero_edicion||' '||l.titulo AS ejemplar,da.cantidad,
   CASE a.estatus when '1' then 'ACTIVO' when '0' then 'DESACTIVADO' end as estatus
  FROM biblioteca.tentrega a 
  INNER JOIN general.tpersona r ON a.cedula_responsable = r.cedula_persona 
  INNER JOIN general.tpersona p ON a.cedula_persona = p.cedula_persona
  INNER JOIN biblioteca.tdetalle_entrega da ON a.codigo_entrega = da.codigo_entrega
  LEFT JOIN biblioteca.tprestamo b ON a.codigo_prestamo = b.codigo_prestamo 
  LEFT JOIN biblioteca.tejemplar e ON da.codigo_ejemplar = e.codigo_ejemplar 
  INNER JOIN biblioteca.tlibro l on e.codigo_isbn_libro=l.codigo_isbn_libro";
	$query = $mysql->Ejecutar($sql);

	date_default_timezone_set('America/Caracas');

	/** Se agrega la libreria PHPExcel */
	require_once '../librerias/PHPExcel/PHPExcel.php';

	// Se crea el objeto PHPExcel
	$objPHPExcel = new PHPExcel();

	// Se asignan las propiedades del libro
	/*$objPHPExcel->getProperties()->setCreator("Codedrinks") //Autor
						 ->setLastModifiedBy("Codedrinks") //Ultimo usuario que lo modificó
						 ->setTitle("Reporte Excel con PHP y MySQL")
						 ->setSubject("Reporte Excel con PHP y MySQL")
						 ->setDescription("Reporte de alumnos")
						 ->setKeywords("reporte alumnos carreras")
						 ->setCategory("Reporte excel");*/

	$tituloReporte = "Listado de las Entregas";
	$titulosColumnas = array('Código', 'Préstamo','Responsable', 'Estudiante', 'Fecha Entrada', 'Ejemplar', 'Cantidad', 'Estatus');
	
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1')->mergeCells('A2:H2');
	// Se agregan los titulos del reporte
	$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A1', $tituloReporte)
				->setCellValue('A3', $titulosColumnas[0])
				->setCellValue('B3', $titulosColumnas[1])
				->setCellValue('C3', $titulosColumnas[2])
				->setCellValue('D3', $titulosColumnas[3])
				->setCellValue('E3', $titulosColumnas[4])
				->setCellValue('F3', $titulosColumnas[5])
				->setCellValue('G3', $titulosColumnas[6])
				->setCellValue('H3', $titulosColumnas[7]);
	
	//Se agregan los datos de los alumnos
	$i = 4;
	while ($row = $mysql->Respuesta($query)){
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $row['codigo_entrega'])
		->setCellValue('B'.$i, $row['prestamo'])
		->setCellValue('C'.$i, $row['responsable'])
		->setCellValue('D'.$i, $row['persona'])
		->setCellValue('E'.$i, $row['fecha_entrada'])
		->setCellValue('F'.$i, $row['ejemplar'])
		->setCellValue('G'.$i, $row['cantidad'])
		->setCellValue('H'.$i, $row['estatus']);
		$i++;
	}
	
	$estiloTituloReporte = array(
    	'font' => array(
        	'name'      => 'Verdana',
	        'bold'      => true,
    	    'italic'    => false,
            'strike'    => false,
           	'size' =>16,
            'color'     => array('rgb' => '000000')
        ),

        'fill' => array(
			'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
			'color'	=> array('argb' => '969696')
		),

        'borders' => array(
           	'allborders' => array(
            	'style' => PHPExcel_Style_Border::BORDER_NONE                    
           	)
        ), 

        'alignment' =>  array(
    			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    			'rotation'   => 0,
    			'wrap'       => TRUE
		)
    );

	$estiloTituloColumnas = array(
        'font' => array(
            'name'      => 'Arial',
            'bold'      => true,                          
            'color'     => array(
                'rgb' => 'FF0000'
            )
        ),

        'fill' 	=> array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'rotation' => 90,
    		'startcolor' => array(
        		'rgb' => 'FAFAFA'
    		)
		),

        'borders' => array(
           	'allborders' => array(
            	'style' => PHPExcel_Style_Border::BORDER_NONE                   
           	)
        ), 

		'alignment' =>  array(
    			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    			'wrap'          => TRUE
		)
	);
		
	$estiloInformacion = new PHPExcel_Style();
	$estiloInformacion->applyFromArray(
		array(

       		'font' => array(
	           	'name'      => 'Arial',
	           	'bold'      => true,         
	           	'color'     => array('rgb' => '000000')
       		),

       		'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'		=> array('argb' => 'FFFFFF')
			),

	       	'borders' => array(
           		'allborders' => array(
            		'style' => PHPExcel_Style_Border::BORDER_THIN                   
           		)
        	),

        	'alignment' =>  array(
    			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    			'wrap'          => TRUE
		)
    	)
	);
	 
	$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle('A3:H3')->applyFromArray($estiloTituloColumnas);		
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:H".($i-1));
			
	for($i = 'A'; $i <= 'E'; $i++){
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
	}
	
	// Se asigna el nombre a la hoja
	$objPHPExcel->getActiveSheet()->setTitle('Listado Entregas');

	// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
	$objPHPExcel->setActiveSheetIndex(0);
	// Inmovilizar paneles 
	//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
	$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

	// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Listado entrega.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;

?>