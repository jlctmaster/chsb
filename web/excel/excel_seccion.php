<?php
	require_once("../class/class_bd.php");
	$mysql = new Conexion();
	$sql = "SELECT seccion,nombre_seccion,CASE turno WHEN 'M' THEN 'MAÑANA' WHEN 'T' THEN 'TARDE' ELSE 'NOCHE' END AS turno,
  capacidad_min,capacidad_max,indice_min,indice_max,
  CASE estatus when '1' then 'ACTIVO' when '0' then 'DESACTIVADO' end as estatus
  FROM educacion.tseccion";
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

	$tituloReporte = "Listado de las Secciones";
	$titulosColumnas = array('Sección', 'Nombre', 'Turno', 'Capacidad Min.', 'Capacidad Máx.', 'Índice Min.', 'Índice Máx.', 'Estatus');
	
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
	$i = 5;
	while ($row = $mysql->Respuesta($query)){
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$i, $row['seccion'])
		->setCellValue('B'.$i, $row['nombre_seccion'])
		->setCellValue('C'.$i, $row['turno'])
		->setCellValue('D'.$i, $row['capacidad_min'])
		->setCellValue('E'.$i, $row['capacidad_max'])
		->setCellValue('F'.$i, $row['indice_min'])
		->setCellValue('G'.$i, $row['indice_max'])
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
	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A5:H".($i-1));

	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
			
	for($i = 'A'; $i <= 'H'; $i++){
		$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
	}
	
	// Se asigna el nombre a la hoja
	$objPHPExcel->getActiveSheet()->setTitle('Listado de las Secciones');

	// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
	$objPHPExcel->setActiveSheetIndex(0);
	// Inmovilizar paneles 
	//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
	$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

	// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Listado Secciones.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;

?>