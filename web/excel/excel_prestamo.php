<?php
	require_once("../class/class_bd.php");
	$mysql = new Conexion();
	$sql = "SELECT a.codigo_prestamo,a.cedula_responsable||' '||r.primer_nombre||' '||r.primer_apellido AS responsable,
  a.cedula_persona||' '||p.primer_nombre||' '||p.primer_apellido AS persona,ar.descripcion AS area,a.cota,
  TO_CHAR(a.fecha_salida,'DD/MM/YYYY') AS fecha_salida, TO_CHAR(a.fecha_entrada,'DD/MM/YYYY') AS fecha_entrada,
   da.codigo_ejemplar||' - '||l.codigo_isbn_libro||' '||l.titulo AS ejemplar,da.cantidad,
   CASE a.estatus when '1' then 'ACTIVO' when '0' then 'DESACTIVADO' end as estatus
  FROM biblioteca.tprestamo a 
  INNER JOIN general.tpersona r ON a.cedula_responsable = r.cedula_persona 
  INNER JOIN general.tpersona p ON a.cedula_persona = p.cedula_persona
  INNER JOIN general.tarea ar ON a.codigo_area = ar.codigo_area  
  INNER JOIN biblioteca.tdetalle_prestamo da ON a.codigo_prestamo = da.codigo_prestamo 
  LEFT JOIN biblioteca.tejemplar b ON da.codigo_ejemplar = b.codigo_ejemplar 
  INNER JOIN biblioteca.tlibro l on b.codigo_isbn_libro=l.codigo_isbn_libro";
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

	$tituloReporte = "Listado de las Prestaciones";
	$titulosColumnas = array('Código', 'Responsable', 'Estudiante', 'Área', 'Cota.', 'Fecha Salida', 'Fecha Entrada', 'Ejemplar', 'Cantidad', 'Estatus');
	
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1')->mergeCells('A2:J2');
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
				->setCellValue('H3', $titulosColumnas[7])
				->setCellValue('I3', $titulosColumnas[8])
				->setCellValue('J3', $titulosColumnas[9]);
	
	//Se agregan los datos de los alumnos
	$i = 4;
	while ($row = $mysql->Respuesta($query)){
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $row['codigo_prestamo'])
		->setCellValue('B'.$i, $row['responsable'])
		->setCellValue('C'.$i, $row['persona'])
		->setCellValue('D'.$i, $row['area'])
		->setCellValue('E'.$i, $row['cota'])
		->setCellValue('F'.$i, $row['fecha_salida'])
		->setCellValue('G'.$i, $row['fecha_entrada'])
		->setCellValue('H'.$i, $row['ejemplar'])
		->setCellValue('I'.$i, $row['cantidad'])
		->setCellValue('J'.$i, $row['estatus']);
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
	 
	$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->applyFromArray($estiloTituloColumnas);		
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:F".($i-1));
			
	for($i = 'A'; $i <= 'E'; $i++){
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
	}
	
	// Se asigna el nombre a la hoja
	$objPHPExcel->getActiveSheet()->setTitle('Listado Prestaciones');

	// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
	$objPHPExcel->setActiveSheetIndex(0);
	// Inmovilizar paneles 
	//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
	$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

	// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Listado Prestamos.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	exit;

?>