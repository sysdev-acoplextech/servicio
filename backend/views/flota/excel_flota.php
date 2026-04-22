<?php

use backend\models\BaseMarca;
use backend\models\BaseModelo;
use backend\models\BaseTipoVehiculo;
use backend\models\CondicionFlota;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use backend\models\EvaluacionPersonaDiplo;
use backend\models\ModuloDiplo;
use backend\models\VEvaluEstudiantes;
use backend\models\VProductoEstudiantes; 
use backend\models\EvaluacionProductoFinal; 
use backend\models\VPorDiplo; 
use backend\models\VPorFinal; 
use backend\models\VPorEva; 
use backend\models\VDiploConNota; 
use backend\models\TipoEvaluacion; 
use backend\models\VProductoDiplo;  
use backend\models\VEvaDiplo;  
use backend\models\PorcenEvaluacionDiplo;  
use backend\models\VProfesoresDiplo;  
use backend\models\Diplomado;  
$helper = new Sample();
if ($helper->isCli()) {
  $helper->log('This example should only be run from a Web Browser' . PHP_EOL);
  return;
}
// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Set document properties
$spreadsheet->getProperties()->setCreator('Maarten Balliauw')
->setLastModifiedBy('Maarten Balliauw')
->setTitle('Office 2007 XLSX Test Document')
->setSubject('Office 2007 XLSX Test Document')
->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
->setKeywords('office 2007 openxml php')
->setCategory('Test result file'); 
$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(80);
$sharedStyle3 = new Style();
$sharedStyle3->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'FFFFFF'],
  ],
  'horizontal' => Alignment::HORIZONTAL_CENTER,
  'vertical' => Alignment::VERTICAL_CENTER,
  'borders' => [
// 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
  ],

  'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,],
    'font' => 
    [ 
      'name' => 'Arial', 
      'bold' => true, 
      'italic' => false,
      'size' => 14  ,
// 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false, 
      'color' => 
      [ 'rgb' => '000000' ] 
    ],
  ],  
);
$sharedStyle4 = new Style();
$sharedStyle4->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'f0f0f0'],
  ],
  'horizontal' => Alignment::HORIZONTAL_CENTER,
  'vertical' => Alignment::VERTICAL_CENTER,
  'borders' => [
// 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
    'allBorders' => ['borderStyle' => Border::BORDER_MEDIUM],
  ],
  'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,],
  'font' => 
  [ 
    'name' => 'Arial', 
    'bold' => true, 
    'italic' => false,
    'size' => 16  ,
// 'underline' => Font::UNDERLINE_DOUBLE, 
    'strikethrough' => false, 
    'color' => 
    [ 'rgb' => '932d18' ] 
  ],
],  
);
$sharedStyle11 = new Style();
$sharedStyle11->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'FFFFFF'],
  ],
  'borders' => [
// 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
  ],
  
  'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_RIGHT,],
    'font' => 
    [ 
      'name' => 'Arial', 
      'bold' => false, 
      'italic' => false,
      'size' => 12  ,
// 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false, 
      'color' => 
      [ 'rgb' => '000000' ] 
    ],
  ],  
);
$sharedStyle1 = new Style();
$sharedStyle1->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'FFFFFF'],
  ],
  'borders' => [
// 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
  ],
  'font' => 
  [ 
    'name' => 'Arial', 
    'bold' => false, 
    'italic' => false,
    'size' => 12  ,
// 'underline' => Font::UNDERLINE_DOUBLE, 
    'strikethrough' => false, 
    'color' => 
    [ 'rgb' => '000000' ] 
  ],
],  
);
$sharedStyle7 = new Style();
$sharedStyle7->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'FFFFFF'],
  ],
  'borders' => [
// 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
  ],

  'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,],
  'font' => 
  [ 
    'name' => 'Arial', 
    'bold' => false, 
    'italic' => false,
    'size' => 12  ,
// 'underline' => Font::UNDERLINE_DOUBLE, 
    'strikethrough' => false, 
    'color' => 
    [ 'rgb' => '000000' ] 
  ],
],  
);
$sharedStyle2 = new Style();
$sharedStyle2->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'FFFFFF'],
  ],
  'horizontal' => Alignment::HORIZONTAL_CENTER,
  'vertical' => Alignment::VERTICAL_CENTER,
  'borders' => [
// 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
  ],
  'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,],
    'font' => 
    [ 
      'name' => 'Arial', 
      'bold' => true, 
      'italic' => false,
      'size' => 14  ,
// 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false, 
      'color' => 
      [ 'rgb' => 'A11C00' ] 
    ],
  ],  
);
$sharedStyle5 = new Style();
$sharedStyle5->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'f2f2f2'],
  ],
  'horizontal' => Alignment::HORIZONTAL_CENTER,
  'vertical' => Alignment::VERTICAL_CENTER,
  'borders' => [
// 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
  ],
  'font' => 
  [ 
    'name' => 'Arial', 
    'bold' => true, 
    'italic' => false,
    'size' => 14  ,
// 'underline' => Font::UNDERLINE_DOUBLE, 
    'strikethrough' => false, 
    'color' => 
    [ 'rgb' => '000000' ] 
  ],
],  
);
$sharedStyle6 = new Style();
$sharedStyle6->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'ffffff'],
  ],
  'horizontal' => Alignment::HORIZONTAL_CENTER,
  'vertical' => Alignment::VERTICAL_CENTER,
  'borders' => [
// 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
  ],
  'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,],
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
);
// Add some data

$fecha_inicio = date_create(date("Y-m-d"));
$fecha_fin = date_create(date("Y-m-d"));
$spreadsheet->setActiveSheetIndex(0)
->mergeCells('A1:I1')
->setCellValue('A1', 'Listado de Flota')
->mergeCells('A2:A3')
->mergeCells('B2:B3')
->mergeCells('C2:C3')
->mergeCells('D2:D3')
->mergeCells('E2:E3')
->mergeCells('F2:F3')
->mergeCells('G2:G3')
->mergeCells('H2:H3')
->mergeCells('I2:I3')


->setCellValue('A2', 'Tipo de Vehículo') 
->setCellValue('B2', 'Marca') 
->setCellValue('C2', 'Modelo')   
->setCellValue('D2', 'Color') 
->setCellValue('E2', 'Placa') 
->setCellValue('F2', 'Condición') 
->setCellValue('G2', 'Tercerizado') 
->setCellValue('H2', 'Asignado') 
->setCellValue('I2', 'Fecha Vencimiento RCV');




$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15); 
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15); 
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);  
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);  
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(15);  
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);  
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(15);  
$spreadsheet->getActiveSheet()->duplicateStyle($sharedStyle2, "A1:I2");
$spreadsheet->getActiveSheet()->duplicateStyle($sharedStyle6, "A1:I2");
$spreadsheet->getActiveSheet()->getStyle("A2:I3")->getFill()->getStartColor()->setRGB('f0f0f0');

$spreadsheet->getActiveSheet()->getRowDimension('14')->setRowHeight(25);
$spreadsheet->getActiveSheet()->getRowDimension('15')->setRowHeight(30);
// 
$spreadsheet->getActiveSheet()->setAutoFilter('A3:I3');
$spreadsheet->getActiveSheet()->freezePane('A4');

$cel=3;
$conta=0;

for ($i=0; $i < count($model); $i++) { 

  $conta++;
  $cel+=1;
  $ca="A".$cel;
  $cb="B".$cel;
  $cc="C".$cel;
  $cd="D".$cel;
  $ce="E".$cel;
  $cf="F".$cel;
  $cg="G".$cel;
  $ch="H".$cel;
  $ci="I".$cel;


  /*$cedu=number_format($value->cedula,0,'.','.');
  $apellido=mb_strtolower($value->apellidos) ;
  $apellido=ucwords($apellido) ;
  $nombre=mb_strtolower($value->nombres) ;
  $nombre=ucwords($nombre) ;
  $nom_gene=substr($value->nom_gene, 0, 1);  
*/


  $tipov = BaseTipoVehiculo::find()->where(['id' => $model[$i]['id_tipo_vehiculo']])->one();
  $tipo= $tipov->nombre_tipo_vehiculo;

  $marca = BaseMarca::find()->where(['id' => $model[$i]['id_marca']])->one();
  $marca= $marca->nombre_marca;

  $modelo = BaseModelo::find()->where(['id' => $model[$i]['id_modelo']])->one();
  $modelo= $modelo->nombre_modelo;

  $color= $model[$i]['color'];
  $placa= $model[$i]['placa'];

  $condicion = CondicionFlota::find()->where(['id' => $model[$i]['id_condicion']])->one();
  $condicion= $condicion->nombre_condicion_flota;

  if ($model[$i]['tercerizado'] == 0)
    $tecerizado = 'NO';
  else
    $tecerizado = 'SI';

  if ($model[$i]['asignado'] == 0)
    $asignado = 'NO';
  else
    $asignado = 'SI';

    $fecha = explode("-", $model[$i]['fecha_vencimiento_rcv']);
    $fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];


  $spreadsheet->setActiveSheetIndex(0)
  ->setCellValue($ca, $tipo)  
  ->setCellValue($cb, $marca)  
  ->setCellValue($cc, $modelo)  
  ->setCellValue($cd, $color)  
  ->setCellValue($ce, $placa)  
  ->setCellValue($cf, $condicion) 
  ->setCellValue($cg, $tecerizado) 
  ->setCellValue($ch, $asignado) 
  ->setCellValue($ci, $fecha) 

  ;

}


// die; 
// Miscellaneous glyphs, UTF-8
// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Lista de Flota');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
// $spreadsheet->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Xls)
$nombreDelDocumento = "Listado de flota.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
header('Cache-Control: max-age=0');
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
exit;