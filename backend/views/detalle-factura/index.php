<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DetalleFacturaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Detalle Facturas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="detalle-factura-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Detalle Factura', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_detallefactura',
            'num_factura',
            'fecha_factura',
            'observacion',
            'monto_facturado',
            //'id_servicios',
            //'subtotal',
            //'iva',
            //'tasa_dia',
            //'fecha_emision',
            //'monto_bs',
            //'id_cliente',
            //'pagada',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
