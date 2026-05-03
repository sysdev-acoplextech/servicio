<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CotizacionRapidaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cotizacion Rapidas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cotizacion-rapida-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Cotizacion Rapida', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_cotizacion',
            'cliente_nombre',
            'telefono',
            'fecha_servicio',
            'hora_servicio',
            //'id_tarifario',
            //'ruta_detalle:ntext',
            //'id_tipo_vehiculo',
            //'forma_pago',
            //'adicionales_json:ntext',
            //'monto_base',
            //'monto_recargo',
            //'monto_viatico',
            //'monto_total',
            //'creado_el',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
