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
  [
    'fill' => [
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
      'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
    'font' =>
    [
      'name' => 'Arial',
      'bold' => true,
      'italic' => false,
      'size' => 14,
      // 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false,
      'color' =>
      ['rgb' => '000000']
    ],
  ],
);
$sharedStyle4 = new Style();
$sharedStyle4->applyFromArray(
  [
    'fill' => [
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
      'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
    'font' =>
    [
      'name' => 'Arial',
      'bold' => true,
      'italic' => false,
      'size' => 16,
      // 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false,
      'color' =>
      ['rgb' => '932d18']
    ],
  ],
);
$sharedStyle11 = new Style();
$sharedStyle11->applyFromArray(
  [
    'fill' => [
      'fillType' => Fill::FILL_SOLID,
      'color' => ['rgb' => 'FFFFFF'],
    ],
    'borders' => [
      // 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
      'allBorders' => ['borderStyle' => Border::BORDER_THIN],
    ],

    'alignment' => [
      'vertical' => Alignment::VERTICAL_CENTER,
      'horizontal' => Alignment::HORIZONTAL_RIGHT,
    ],
    'font' =>
    [
      'name' => 'Arial',
      'bold' => false,
      'italic' => false,
      'size' => 12,
      // 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false,
      'color' =>
      ['rgb' => '000000']
    ],
  ],
);
$sharedStyle1 = new Style();
$sharedStyle1->applyFromArray(
  [
    'fill' => [
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
      'size' => 12,
      // 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false,
      'color' =>
      ['rgb' => '000000']
    ],
  ],
);
$sharedStyle7 = new Style();
$sharedStyle7->applyFromArray(
  [
    'fill' => [
      'fillType' => Fill::FILL_SOLID,
      'color' => ['rgb' => 'FFFFFF'],
    ],
    'borders' => [
      // 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
      'allBorders' => ['borderStyle' => Border::BORDER_THIN],
    ],

    'alignment' => [
      'vertical' => Alignment::VERTICAL_CENTER,
      'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
    'font' =>
    [
      'name' => 'Arial',
      'bold' => false,
      'italic' => false,
      'size' => 12,
      // 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false,
      'color' =>
      ['rgb' => '000000']
    ],
  ],
);
$sharedStyle2 = new Style();
$sharedStyle2->applyFromArray(
  [
    'fill' => [
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
      'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
    'font' =>
    [
      'name' => 'Arial',
      'bold' => true,
      'italic' => false,
      'size' => 14,
      // 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false,
      'color' =>
      ['rgb' => 'A11C00']
    ],
  ],
);
$sharedStyle5 = new Style();
$sharedStyle5->applyFromArray(
  [
    'fill' => [
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
      'size' => 14,
      // 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false,
      'color' =>
      ['rgb' => '000000']
    ],
  ],
);
$sharedStyle6 = new Style();
$sharedStyle6->applyFromArray(
  [
    'fill' => [
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
      'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
    'font' =>
    [
      'name' => 'Arial',
      'bold' => true,
      'italic' => false,
      'size' => 12,
      // 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false,
      'color' =>
      ['rgb' => '000000']
    ],
  ],
);
// Add some data

$fecha_inicio = date_create(date("Y-m-d"));
$fecha_fin = date_create(date("Y-m-d"));
$spreadsheet->setActiveSheetIndex(0)
  ->mergeCells('A1:I1')
  ->setCellValue('A1', 'Listado de Conductores')
  ->mergeCells('A2:A3')
  ->mergeCells('B2:B3')
  ->mergeCells('C2:C3')
  ->mergeCells('D2:D3')
  ->mergeCells('E2:E3')
  ->mergeCells('F2:F3')
  ->mergeCells('G2:G3')
  ->mergeCells('H2:H3')
  ->mergeCells('I2:I3')

  ->setCellValue('A2', 'Cédula')
  ->setCellValue('B2', 'Nombres')
  ->setCellValue('C2', 'Apellidos')
  ->setCellValue('D2', 'Teléfono Principal')
  ->setCellValue('E2', 'Teléfono Alterno')
  ->setCellValue('F2', 'Correo')
  ->setCellValue('G2', 'Fecha de Ingreso')
  ->setCellValue('H2', 'Fecha de Egreso')
  ->setCellValue('I2', 'Activo');

$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$spreadsheet->getActiveSheet()->duplicateStyle($sharedStyle2, "A1:I2");
$spreadsheet->getActiveSheet()->duplicateStyle($sharedStyle6, "A1:I2");
$spreadsheet->getActiveSheet()->getStyle("A2:I3")->getFill()->getStartColor()->setRGB('f0f0f0');

$spreadsheet->getActiveSheet()->getRowDimension('14')->setRowHeight(25);
$spreadsheet->getActiveSheet()->getRowDimension('15')->setRowHeight(30);
// 
$spreadsheet->getActiveSheet()->setAutoFilter('A3:I3');
$spreadsheet->getActiveSheet()->freezePane('A4');

$cel = 3;
$conta = 0;

for ($i = 0; $i < count($model); $i++) {

  $conta++;
  $cel += 1;
  $ca = "A" . $cel;
  $cb = "B" . $cel;
  $cc = "C" . $cel;
  $cd = "D" . $cel;
  $ce = "E" . $cel;
  $cf = "F" . $cel;
  $cg = "G" . $cel;
  $ch = "H" . $cel;
  $ci = "I" . $cel;


  $fecha = explode("-", $model[$i]['fecha_ingreso']);
  $fechai = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];


  if ($model[$i]['fecha_egreso']) {
    $fecha = explode("-", $model[$i]['fecha_egreso']);
    $fechae = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
  }
  else
    $fechae = '-';

  if ($model[$i]['estatus'] == 0)
    $estatus = 'NO';
  else
    $estatus = 'SI';



  $spreadsheet->setActiveSheetIndex(0)
    ->setCellValue($ca, $model[$i]['cedula'])
    ->setCellValue($cb, $model[$i]['nombres'])
    ->setCellValue($cc, $model[$i]['apellidos'])
    ->setCellValue($cd, $model[$i]['telefono_principal'])
    ->setCellValue($ce, $model[$i]['telefono_alterno'])
    ->setCellValue($cf, $model[$i]['correo'])
    ->setCellValue($cg, $fechai)
    ->setCellValue($ch, $fechae)
    ->setCellValue($ci, $estatus)

  ;
}


// die; 
// Miscellaneous glyphs, UTF-8
// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Lista_conductores');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
// $spreadsheet->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Xls)
$nombreDelDocumento = "Listado de conductores.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
header('Cache-Control: max-age=0');
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
exit;
