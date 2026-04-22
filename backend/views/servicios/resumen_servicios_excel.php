<?php

use backend\models\Cliente;
use backend\models\Pasajero;
use backend\models\PasajeroServicio;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


$usuario = Yii::$app->user->identity->username;
$nombres_usuario= Yii::$app->user->identity->nombres;
$apellido_usuario= Yii::$app->user->identity->apellidos;


$helper = new Sample();
if ($helper->isCli()) {
  $helper->log('This example should only be run from a Web Browser' . PHP_EOL);
  return;
}

$drawing = new Drawing();
$drawing->setName('Logo');
$drawing->setDescription('Logo');
$drawing->setPath('../web/img/logo_reportes.png');

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();

$drawing->setWorksheet($spreadsheet->getActiveSheet());
$objDrawing = $spreadsheet->getActiveSheet();
// Set document properties
$spreadsheet->getProperties()->setCreator('Maarten Balliauw')
->setLastModifiedBy('Maarten Balliauw')
->setTitle('Office 2007 XLSX Test Document')
->setSubject('Office 2007 XLSX Test Document')
->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
->setKeywords('office 2007 openxml php')
->setCategory('Test result file');


$sharedStyle1 = new Style();
$sharedStyle1->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => '9C9C9C'],
  ],
'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,
      'rotation'   => 0,
  'wrapText' => true,
],
  // 'borders' => [
  //               // 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
  //   'allBorders' => ['borderStyle' => Border::BORDER_THIN],
  // ],
  'font' =>
  [
    'name' => 'Arial',
    'bold' => false,
    'italic' => false,
    'size' => 14  ,
            // 'underline' => Font::UNDERLINE_DOUBLE,
    'strikethrough' => false,
    'color' =>
    [ 'rgb' => '000' ]
  ],
],
);
$sharedStyle2 = new Style();
$sharedStyle2->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'DCDADA'],
  ],
'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,
      'rotation'   => 0,
  'wrapText' => true,
],
  'font' =>
   ['name' => 'Arial',
    'bold' => TRUE,
    'italic' => false,
    'size' => 12  ,
// 'underline' => Font::UNDERLINE_DOUBLE,
    'strikethrough' => false,
    'color' =>
    ['rgb' => '000000' ]
  ],
],
);
$sharedStyle3 = new Style();
$sharedStyle3->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => '9C9C9C'],
  ],
'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,
      'rotation'   => 0,
  'wrapText' => true,
],
  // 'borders' => [
  //               // 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
  //   'allBorders' => ['borderStyle' => Border::BORDER_THIN],
  // ],
  'font' =>
  [
    'name' => 'Arial',
    'bold' => true,
    'italic' => false,
    'size' => 12  ,
            // 'underline' => Font::UNDERLINE_DOUBLE,
    'strikethrough' => false,
    'color' =>
    [ 'rgb' => '000' ]
  ],
],
);
$sharedStyle4 = new Style();
$sharedStyle4->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'ffffff'],
  ],
    'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,
      'rotation'   => 0,
  'wrapText' => true,
],
  'font' =>
   [
    'name' => 'Arial',
    'bold' => TRUE,
    'italic' => false,
    'size' => 12  ,
// 'underline' => Font::UNDERLINE_DOUBLE,
    'strikethrough' => false,
    'color' =>
    [ 'rgb' => '000000' ]
  ],
],
);
$sharedStyle41 = new Style();
$sharedStyle41->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'ffffff'],
  ],
    'borders' => [
                // 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
  ],
    'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,
      'rotation'   => 0,
  'wrapText' => true,
],
  'font' =>
   [
    'name' => 'Arial',
    'bold' => TRUE,
    'italic' => false,
    'size' => 12  ,
// 'underline' => Font::UNDERLINE_DOUBLE,
    'strikethrough' => false,
    'color' =>
    [ 'rgb' => '000000' ]
  ],
],
);
$sharedStyle5 = new Style();
$sharedStyle5->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => '890b0b'],
  ],
'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,
      'rotation'   => 0,
  'wrapText' => true,
],

  'font' =>
   [
    'name' => 'Arial',
    'bold' => TRUE,
    'italic' => false,
    'size' => 14  ,
// 'underline' => Font::UNDERLINE_DOUBLE,
    'strikethrough' => false,
    'color' =>
    [ 'rgb' => 'ffffff' ]
  ],
],
);
$sharedStyle6 = new Style();
$sharedStyle6->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'DCDADA'],
  ],
  'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,
      'rotation'   => 0,
  'wrapText' => true,
],
  'font' =>
  [
    'name' => 'Arial',
    'bold' => true,
    'italic' => false,
    'size' => 12  ,
            // 'underline' => Font::UNDERLINE_DOUBLE,
    'strikethrough' => false,
    'color' =>
    [ 'rgb' => '000000' ]
  ],
],
);$sharedStyle7 = new Style();
$sharedStyle7->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => '6a6161'],
  ],
  // 'borders' => [
  //               // 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
  //   'allBorders' => ['borderStyle' => Border::BORDER_THIN],
  // ],
    'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,
      'rotation'   => 0,
  'wrapText' => true,
],
  'font' =>
  [
    'name' => 'Arial',
    'bold' => true,
    'italic' => false,
    'size' => 12  ,
            // 'underline' => Font::UNDERLINE_DOUBLE,
    'strikethrough' => false,
    'color' =>
    [ 'rgb' => 'ffffff' ]
  ],
],
);
$sharedStylepie = new Style();
$sharedStylepie->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'bbafaf'],
  ],
  // 'horizontal' => Alignment::HORIZONTAL_CENTER,
  // 'vertical' => Alignment::VERTICAL_CENTER,
  'borders' => [
                // 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
  ],
  'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,
      'rotation'   => 0,
  'wrapText' => true,
],
  'font' =>
  [
    'name' => 'Arial',
    'bold' => true,
    'italic' => false,
    'size' => 16  ,
            // 'underline' => Font::UNDERLINE_DOUBLE,
    'strikethrough' => false,
    'color' =>
    [ 'rgb' => '000000' ]
  ],
],
);
$sharedStylepies = new Style();
$sharedStylepies->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'e3d9d9'],
  ],
    'borders' => [
                // 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
  ],
  'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,
      'rotation'   => 0,
  'wrapText' => true,
],
  'font' =>
  [
    'name' => 'Arial',
    'bold' => true,
    'italic' => false,
    'size' => 13  ,
            // 'underline' => Font::UNDERLINE_DOUBLE,
    'strikethrough' => false,
    'color' =>
    [ 'rgb' => '000000' ]
  ],
],
);
$sharednumbre = new Style();
$sharednumbre->applyFromArray(

   [
  //   'fill' => [
  //   'fillType' => Fill::FILL_SOLID,
  //   'color' => ['rgb' => 'DCDADA'],
  // ],
    // 'borders' => [
    //             'allBorders' => ['borderStyle' => Border::BORDER_THIN],
    //         ],
'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_RIGHT,
],
],
);
$sharednumbrecolor = new Style();
$sharednumbrecolor->applyFromArray(

   [
    'fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'DCDADA'],
  ],
  'font' =>
  [
    'name' => 'Arial',
    'bold' => true,
    'italic' => false,
    'size' => 12  ,
            // 'underline' => Font::UNDERLINE_DOUBLE,
    'strikethrough' => false,
    'color' =>
    [ 'rgb' => '000000' ]
  ],
'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_RIGHT,
],
],
);


$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
// $spreadsheet->getActiveSheet()->duplicateStyle($sharedStyle2, "A1:O1");
// Add some data
$spreadsheet->setActiveSheetIndex(0)
// TITULOS $sharedStyle3
->mergeCells('A2:L2')
->mergeCells('A1:L1')
->setCellValue('A2', 'RELACIÓN DE SERVICIOS')
;
$spreadsheet->getActiveSheet()->duplicateStyle($sharedStyle2, "A2:L2");
$spreadsheet->getActiveSheet()->getRowDimension("2")->setRowHeight(20);

$c=0;
$cel=4;
$t_monto_depositado=0;

  // $cel+=1;
  $tca="A".$cel;
  $tcb="B".$cel;
  $tcc="C".$cel;
  $tcd="D".$cel;
  $tce="E".$cel;
  $tcf="F".$cel;
  $tcg="G".$cel;
  $tch="H".$cel;
  $tci="I".$cel;
  $tcj="J".$cel;
  $tck="K".$cel;
  $tcl="L".$cel;


  $spreadsheet->setActiveSheetIndex(0)
  ->setCellValue($tca, 'N°')
  ->setCellValue($tcb, 'Fecha de servicio')
  ->setCellValue($tcc, 'Ruta')
  ->setCellValue($tcd, 'Cliente')
  ->setCellValue($tce, 'Tipo de cliente')
  ->setCellValue($tcf, 'Estatus')
  ->setCellValue($tcg, 'Monto ($)')
  ->setCellValue($tch, 'Pasajero(s)')
  ->setCellValue($tci, 'Origen')
  ->setCellValue($tcj, 'Destino')
  ->setCellValue($tck, 'Conductor/Flota')
  ->setCellValue($tcl, 'Nro Factura')

  ;

    $spreadsheet->getActiveSheet()->duplicateStyle($sharedStyle3, "A".$cel.":l".$cel."");
    $spreadsheet->getActiveSheet()->getRowDimension($cel)->setRowHeight(35);
    $spreadsheet->getActiveSheet()->getStyle("A".$cel.":l".$cel."")->getAlignment()->setWrapText(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(40);
    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
    $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
    $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(30);
    $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(15);

foreach ($model as $key => $value) {

 $cel++;
 $c++;
  $ca="A".$cel;
  $cb="B".$cel;
  $cc="C".$cel;
  $cd="D".$cel;
  $ce="E".$cel;
  $cf="F".$cel;
  $cg="G".$cel;
  $ch="H".$cel;
  $ci="I".$cel;
  $cj="J".$cel;
  $ck="K".$cel;
  $cl="L".$cel;


  if ($value->fecha_servicio) {
    $fecha_servicio = Yii::$app->formatter->asDate($value->fecha_servicio, 'php:d-m-Y') ;
  }

  if ($value->fecha_registro) {
    $fecha_registro =  Yii::$app->formatter->asDate($value->fecha_registro, 'php:d-m-Y') ;
  }

  //Pax
  $pax = PasajeroServicio::find()->where(['id_servicio' => $value->id_servicio])->all();
  $pasajero='';
  $origen='';
  $destino='';
  foreach ($pax as $key => $value2) {
    $det_pax = Pasajero::find()->where(['id_pasajero' => $value2->id_pasajero])->one();
    $pasajero.=$det_pax['nombre_apellido']."\n";

    $origen.=$value2->origen."\n";
    $destino.=$value2->destino."\n";
  }



  
  $spreadsheet->setActiveSheetIndex(0)
  ->setCellValue($ca, $c)
  ->setCellValue($cb, Yii::$app->formatter->asDate($value->fecha_servicio, 'php:d-m-Y'))
  ->setCellValue($cc, $value->nombre_traslado_ruta)
  ->setCellValue($cd, $value->nombre_apellido)
  ->setCellValue($ce, $value->nombre_tipo_cliente)
  ->setCellValue($cf, $value->estatus)
  ->setCellValue($cg, number_format($value->monto,2,',','.'))
  ->setCellValue($ch, $pasajero)
  ->setCellValue($ci, $origen)
  ->setCellValue($cj, $destino)
  ->setCellValue($ck, $value->conductor."\n".$value->flota)
  ->setCellValue($cl, $value->nombre_apellido)
 ;

}
$cel+=3;
// totales generales
        $ttgca="A".$cel;
        $ttgcb="B".$cel;
        $ttgcc="C".$cel;
        $ttgcd="D".$cel;
        $ttgce="E".$cel;
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue($ttgca, 'Monto Total')
        ->setCellValue($ttgcb, 'Monto Aplicado')
        ->setCellValue($ttgcc, 'Monto Reversado')
        ->setCellValue($ttgcd, 'Monto Monto Pend x Aplicar')
        ->setCellValue($ttgce, 'Monto No Aplicable')
        ;
$spreadsheet->getActiveSheet()->duplicateStyle($sharedStyle3, "A".$cel.":E".$cel."");
$spreadsheet->getActiveSheet()->getRowDimension($cel)->setRowHeight(35);
$spreadsheet->getActiveSheet()->getStyle("A".$cel.":E".$cel."")->getAlignment()->setWrapText(true);
$cel+=1;

        $togca="A".$cel;
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue($togca, number_format($t_monto_depositado,2,',','.'));

$spreadsheet->getActiveSheet()->getRowDimension($cel)->setRowHeight(35);
$spreadsheet->getActiveSheet()->getStyle("A".$cel.":E".$cel."")->getAlignment()->setWrapText(true);
$spreadsheet->getActiveSheet()->duplicateStyle($sharednumbre, "A".$cel.":E".$cel."");
// Miscellaneous glyphs, UTF-8
// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Resumen de servicios');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Ods)
header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
header('Content-Disposition: attachment;filename="resumen_servicios_chgroup.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0
$writer = IOFactory::createWriter($spreadsheet, 'Xls');
$writer->save('php://output');
exit;
