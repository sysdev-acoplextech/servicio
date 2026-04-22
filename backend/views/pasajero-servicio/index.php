<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PasajeroServicioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pasajero Servicios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pasajero-servicio-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Pasajero Servicio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_pax_servicio',
            'id_servicio',
            'hora',
            'origen',
            'destino',
            //'fecha',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
