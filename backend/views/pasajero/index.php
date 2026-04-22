<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PasajeroSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pasajeros';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pasajero-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Pasajero', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_pasajero',
            'nombre_apellido',
            'telefono',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
