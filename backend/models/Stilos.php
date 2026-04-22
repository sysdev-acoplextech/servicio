<?php

namespace backend\models;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Yii;

class Stilos extends \yii\base\Model
{ 
public static function sharedtitulo()
{
  $sharedStyle3 = new Style();
return $sharedStyle3->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'FFFFFF'],
  ],
  'horizontal' => Alignment::HORIZONTAL_CENTER,
  'vertical' => Alignment::VERTICAL_CENTER,
  'borders' => [
  'allBorders' => ['borderStyle' => Border:: BORDER_NONE],
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
      'size' => 14  ,
            // 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false, 
      'color' => 
      [ 'rgb' => '000000' ] 
    ],
  ],  
);
}
public static function sharedStylesi()
{
  $sharedStylesi = new Style();
return $sharedStylesi->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'f2f2f2'],
  ],
  'horizontal' => Alignment::HORIZONTAL_CENTER,
  'vertical' => Alignment::VERTICAL_CENTER,
  'borders' => [
  'allBorders' => ['borderStyle' => Border:: BORDER_NONE],
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
      'size' => 14  ,
            // 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false, 
      'color' => 
      [ 'rgb' => 'b92414' ] 
    ],
  ],  
);
}
public static function sharedStylefp()
{
  $sharedStylefp = new Style();
return $sharedStylefp->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'efffdb'],
  ],
  'horizontal' => Alignment::HORIZONTAL_CENTER,
  'vertical' => Alignment::VERTICAL_CENTER,
  'borders' => [
  'allBorders' => ['borderStyle' => Border:: BORDER_THIN],
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
      'bold' => false, 
      'italic' => false,
      'size' => 10  ,
            // 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false, 
      'color' => 
      [ 'rgb' => '000000' ] 
    ],
  ],  
);
}
public static function sharedStylefp1()
{
  $sharedStylefp1 = new Style();
return $sharedStylefp1->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'fbffc7'],
  ],
  'horizontal' => Alignment::HORIZONTAL_CENTER,
  'vertical' => Alignment::VERTICAL_CENTER,
  'borders' => [
  'allBorders' => ['borderStyle' => Border:: BORDER_THIN],
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
      'bold' => false, 
      'italic' => false,
      'size' => 10  ,
            // 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false, 
      'color' => 
      [ 'rgb' => '000000' ] 
    ],
  ],  
);
}
public static function sharedsubtitulo()
{
  $sharedStyle3 = new Style();
return $sharedStyle3->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'FFFFFF'],
  ],
  'horizontal' => Alignment::HORIZONTAL_CENTER,
  'vertical' => Alignment::VERTICAL_CENTER,
  'borders' => [
  'allBorders' => ['borderStyle' => Border::BORDER_NONE],
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
);
}

public static function sharedStyle8()
{

$sharedStyle8 = new Style();
return $sharedStyle8->applyFromArray(
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
      [ 'rgb' => 'ffffff' ] 
    ],
  ],  
);
}

public static function sharedsubtitulo2()
{
  $sharedStyle3 = new Style();
return $sharedStyle3->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'FFFFFF'],
  ],
  'horizontal' => Alignment::HORIZONTAL_CENTER,
  'vertical' => Alignment::VERTICAL_CENTER,
  'borders' => [
  'allBorders' => ['borderStyle' => Border::BORDER_NONE],
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
      'font_underline' => true  ,
      'strikethrough' => false, 
      'underline' => Font::UNDERLINE_DOUBLE, 
      'color' => 
      [ 'rgb' => '000000' ] 
    ],
  ],  
);
}


public static function sharedStyle3()
{
  $sharedStyle3 = new Style();
return $sharedStyle3->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'FFFFFF'],
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
      'size' => 14  ,
            // 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false, 
      'color' => 
      [ 'rgb' => '000000' ] 
    ],
  ],  
);
}

public static function sharedStyle4()
{

$sharedStyle4 = new Style();
return $sharedStyle4->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => '88DEFF'],
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
    'size' => 14  ,
            // 'underline' => Font::UNDERLINE_DOUBLE, 
    'strikethrough' => false, 
    'color' => 
    [ 'rgb' => '000000' ] 
  ],
],  
);
}
public static function sharedStyle1()
{

$sharedStyle1 = new Style();
return $sharedStyle1->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'FFFFFF'],
  ],
  'borders' => [
                // 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
    'allBorders' => ['borderStyle' => Border::BORDER_MEDIUM],
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
}
public static function sharedStyle11()
{

$sharedStyle11 = new Style();
return $sharedStyle11->applyFromArray(
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
    'horizontal' => Alignment::HORIZONTAL_LEFT,],
    'font' => 
    [ 
      'name' => 'Arial', 
      'bold' => false, 
      'italic' => false,
      'size' => 10  ,

// 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false, 
      'color' => 
      [ 'rgb' => '000000' ] 
    ],
  ],  
);
}
public static function sharedStyle5()
{

$sharedStyle5 = new Style();
return $sharedStyle5->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'f2f2f2'],
  ],
  'horizontal' => Alignment::HORIZONTAL_CENTER,
  'vertical' => Alignment::VERTICAL_CENTER,
  'borders' => [
// 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
    'left' => ['borderStyle' => Border::BORDER_THIN],
    'right' => ['borderStyle' => Border::BORDER_THIN],
  ],

  'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,],
    'rotation'   => 0,
    'wrapText' => true,
    'font' => 
    [ 
      'name' => 'Arial', 
      'bold' => true, 
      'italic' => false,
      'size' => 10  ,
// 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false, 
      'color' => 
      [ 'rgb' => '000000' ] 
    ],
  ],  
);
}
public static function sharedStyle5a()
{

$sharedStyle5a = new Style();
return $sharedStyle5a->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'f2f2f2'],
  ],
  'horizontal' => Alignment::HORIZONTAL_CENTER,
  'vertical' => Alignment::VERTICAL_CENTER,
//   'borders' => [

//     // 'left' => array(
//     //         'borderStyle' =>Border::BORDER_THICK,
//     //         'color' => array('rgb' => 'f2f2f2'),
//     //     ),
// // 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
//     // 'allBorders' => ['borderStyle' => Border::BORDER_THIN],
//   ],

  'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,],
    'rotation'   => 0,
    'wrapText' => true,
    'font' => 
    [ 
      'name' => 'Arial', 
      'bold' => true, 
      'italic' => false,
      'size' => 10  ,
// 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false, 
      'color' => 
      [ 'rgb' => '000000' ] 
    ],
  ],  
);
}
public static function sharedStyle6()
{

$sharedStyle6 = new Style();
return $sharedStyle6->applyFromArray(
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
      [ 'rgb' => 'ffffff' ] 
    ],
  ],  
);
}
public static function sharedStyle7()
{

$sharedStyle7 = new Style();
return $sharedStyle7->applyFromArray(
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
}
public static function sharedStylev()
{

$sharedStyle8 = new Style();
return $sharedStyle8->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => '8ad290'],
  ],
  'borders' => [
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
      'size' => 10  ,
// 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false, 
      'color' => 
      [ 'rgb' => '000000' ] 
    ],
  ],  
);
}
public static function sharedStylea()
{

$sharedStyle8 = new Style();
return $sharedStyle8->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'FFFACD'],
  ],
  'borders' => [
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
      'size' => 10  ,
// 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false, 
      'color' => 
      [ 'rgb' => '000000' ] 
    ],
  ],  
);
}
public static function sharedStyler()
{

$sharedStyle8 = new Style();
return $sharedStyle8->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
    'color' => ['rgb' => 'f34336'],
  ],
  'borders' => [
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
      'size' => 10  ,
// 'underline' => Font::UNDERLINE_DOUBLE, 
      'strikethrough' => false, 
      'color' => 
      [ 'rgb' => '000000' ] 
    ],
  ],  
);
}
public static function sharednumbre()
{

$sharednumbre = new Style();
return $sharednumbre->applyFromArray([
  'borders' => [
    'allBorders' => ['borderStyle' => Border::BORDER_THIN], 
  ],
  'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_RIGHT,],
    'rotation'   => 0,
    'wrapText' => true,
  ],  );
}
public static function sharedStyle2()
{

$sharedStyle2 = new Style();
return $sharedStyle2->applyFromArray(
  ['fill' => [
    'fillType' => Fill::FILL_SOLID,
  ], 
  'font' => 
  [ 
    'name' => 'Arial', 
    'bold' => false, 
    'italic' => false,
    'size' => 12  ,
    'strikethrough' => false, 
    'color' => 
    [ 'rgb' => '000000' ] 
  ],
],  
);
}

public static function sharedStylew2()
{
$sharedStyle2 = new Style();
return $sharedStyle2->applyFromArray(

  ['borders' => [
  'allBorders' => ['borderStyle' => Border::BORDER_THIN],
  ],
    'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_CENTER,],
    'rotation'   => 0,
    'wrapText' => true,
  'font' => [ 
  'name' => 'Arial', 
  'bold' => false, 
  'italic' => false,
  'size' => 10,
  'strikethrough' => false, 
  'color' => 
  [ 'rgb' => '000000' ] 
  ],
],  
);
}


public static function sharednumbrerojo()
{
$sharednumbrerojo = new Style();
return $sharednumbrerojo->applyFromArray([
  'borders' => [
    'allBorders' => ['borderStyle' => Border::BORDER_THIN], 
  ],
  'font' => [
    'name' => 'Arial',
    'bold' => true,
    'italic' => false,
    'size' => 9  ,
    'strikethrough' => false,
    'color' =>
    [ 'rgb' => 'e70000' ]
  ],
  'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_RIGHT,
    'rotation'   => 0,
    'wrapText' => true,
  ],
],  );

}

public static function sharednumbrevino()
{
$sharednumbrevino = new Style();
return $sharednumbrevino->applyFromArray([
  'borders' => [
    'allBorders' => ['borderStyle' => Border::BORDER_THIN], 
  ],
  'font' => [
    'name' => 'Arial',
    'bold' => false,
    'italic' => false,
    'size' => 9  ,
    'strikethrough' => false,
    'color' =>
    [ 'rgb' => 'e70000' ]
  ],
  'alignment' => [
    'vertical' => Alignment::VERTICAL_CENTER,
    'horizontal' => Alignment::HORIZONTAL_RIGHT,
    'rotation'   => 0,
    'wrapText' => true,
  ],
],  );

}
public static function sharedStyle51()
{
  $sharedStyle51 = new Style();
  return $sharedStyle51->applyFromArray(
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
  ],  );

}

}
