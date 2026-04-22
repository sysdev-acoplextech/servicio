<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DetalleFactura */

$this->title = 'Update Detalle Factura: ' . $model->id_detallefactura;
$this->params['breadcrumbs'][] = ['label' => 'Detalle Facturas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_detallefactura, 'url' => ['view', 'id' => $model->id_detallefactura]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="detalle-factura-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
