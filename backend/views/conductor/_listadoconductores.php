<?php

use backend\models\BaseMarca;
use backend\models\BaseModelo;
use backend\models\BaseTipoVehiculo;
use backend\models\CondicionFlota;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Documento */
?>


<style type="text/css">
  @media all {
    .page-break {
      display: none;
    }
  }

  @media print {
    .page-break {
      display: block;
      page-break-before: always;
    }
  }

  .table_planilla {
    border-collapse: collapse;
    border-spacing: 0;
    border: 1;
  }

  .th_planilla {
    font-family: Arial, Verdana, sans-serif;
    font-weight: bold;
    font-size: 12pt;
  }

  .td_planilla {
    font-family: Arial, Verdana, sans-serif;
    font-size: 11pt;
    border: 1px solid #000000;
  }

  .td_planillafondo {
    font-family: Arial, Verdana, sans-serif;
    font-size: 11pt;
    background-color: #ecf0f1;
    border: 1px solid #000000;
  }

  .titulo3 {
    font-family: Verdana, Geneva, sans-serif;
    font-size: 12px;
    font-weight: bold;
    text-align: center;
    border-top-width: 1px;
    border-top-style: solid;
    border-top-color: #000;
  }

  .titulo1 {
    font-family: "New Century", Schoolbook, serif;
    font-size: 26px;
    font-style: italic;
    font-weight: bold;
    margin: 0 auto;
    text-align: center;
    text-decoration: underline;
    width: 80%;
    line-height: 0.1;
  }

  .datos {
    font-family: Verdana, Geneva, sans-serif;
    font-size: 12px;
    border: 0.5px solid #000;
  }

  .titulo {
    font-family: Verdana, Geneva, sans-serif;
    font-size: 12px;
    font-style: normal;
    font-weight: bold;
  }

  .titulotabla {
    font-family: Verdana, Geneva, sans-serif;
    font-size: 12px;
    font-style: normal;
    font-weight: bold;
    background-color: #C2EFFE;
    border: 1px solid #666;
  }

  .titulotabla2 {
    font-family: Verdana, Geneva, sans-serif;
    font-size: 12px;
    vertical-align: top;
    background-color: #ecf0f1;
    color: #FFF;
    border: 0.5;
  }

  table {
    border-collapse: collapse;
    cellspacing: 0;
    cellpadding: 1;
    border: 0.5;
  }

  .titulotabla3 {
    font-size: 8px;
    vertical-align: top;
    background-color: #ecf0f1;
    color: #FFF;
  }

  th {
    text-align: left;
  }

  .titulo2 {
    font-family: Verdana, Geneva, sans-serif;
    font-size: 12px;
    font-style: normal;
    font-weight: bold;
  }

  .espacio-encabezado {
    padding-bottom: 10px;
  }
</style>
<div style="background-color: white">
  <?php


  if (Yii::$app->user->identity == null)
    $usuario_logeado = '';
  else
    $usuario_logeado = Yii::$app->user->identity->username;

  $this->params['breadcrumbs'][] = "Conductores";

  ?>
  <?php if (isset($_GET['id'])) {
    $valor = "15%";
    $valor2 = "";
  } else {
    $valor = "40%";
    $valor2 = "20%";
  }
  ?>

  <table width="100%">
    <tr>
      <td width=<?php echo $valor2; ?>>
        <img src="../web/img/CH_LOGO.png" width="<?php echo $valor ?>">
      <td>
      <td align="center">
        <p class="titulo2">
        <h1>Listado de Conductores</h1>
        <h3><?php echo count($model); ?> Conductores registrado(s)</h3>
        <hr>
        </p>
      </td>
      <td align="right">
        <b>Fecha:</b> <?php echo date('d-m-Y H:s'); ?><br>
        <b>Generado por:</b> <?php echo $usuario_logeado; ?>
      </td>
    </tr>
  </table>


  <table class="table_planilla" style="width: 100%">
    <tr>
      <th>Foto</th>
      <th>Cédula</th>
      <th>Nombres</th>
      <th>Apellidos</th>
      <th>Teléfono Principal</th>
      <th>Teléfono Alterno</th>
      <th>Correo</th>
      <th>Fecha de Ingreso</th>
      <th>Fecha de Egreso</th>
      <th>Activo</th>
    </tr>
    <?php for ($i = 0; $i < count($model); $i++) {
      if ($model[$i]['foto'] == NULL)
        $imagen_conductor = '../web/img/imagen_vacio.png';
      else
        $imagen_conductor = "../" . $model[$i]['foto'];

    ?>
      <tr>
        <td class="td_planilla" width="10%"><img src="<?php echo $imagen_conductor; ?>" width="100%"></td>
        <td class="td_planilla"><?php echo $model[$i]['cedula'] ?></td>
        <td class="td_planilla"><?php echo $model[$i]['nombres'] ?></td>
        <td class="td_planilla"><?php echo $model[$i]['apellidos'] ?></td>
        <td class="td_planilla"><?php echo $model[$i]['telefono_principal'] ?></td>
        <td class="td_planilla"><?php echo $model[$i]['telefono_alterno'] ?></td>
        <td class="td_planilla"><?php echo $model[$i]['correo'] ?></td>
        <td class="td_planilla">
          <?php
          $fecha = explode("-", $model[$i]['fecha_ingreso']);
          $fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];

          echo $fecha; ?>
        </td>
        <td class="td_planilla">
          <?php

          if ($model[$i]['fecha_egreso']){
          $fecha = explode("-", $model[$i]['fecha_egreso']);
          $fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
          } else{
            $fecha ='-';
          }

          echo $fecha; 
          ?>
        </td>
     
        <td class="td_planilla">
          <?php
          if ($model[$i]['estatus'] == 0)
            $tecerizado = 'NO';
          else
            $tecerizado = 'SI';
          echo $tecerizado;
          ?>
        </td>
      </tr>
    <?php } ?>
  </table>
  <br>
  <?php if (!isset($_GET['id'])) { ?>

    <?php //echo Html::a('Generar PDF', ['pdf', 'id' => 1], ['class' => 'btn btn-primary', 'target' => '_blank']) ?>
    <?php echo  Html::a('<button class="btn btn-success"><i class="glyphicon glyphicon-print""></i>  Exportar Excel</button>', ['excel'], ['class' => '', 'title' => 'Generar Excel', 'target' => '_black']); ?>
    <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> <b>Regresar</b>', ['index'], ['class' => 'btn btn-warning btn']) ?>

  <?php } ?>

  <br>
  <div align="right">Reporte generado desde el sistemas de gestión de <b>CHGroup C.A</b> </div>
</div>
</body>