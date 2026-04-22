<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CierreDiarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cierre Diarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cierre-diario-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Cierre Diario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idcierre',
            'fecha_cierre',
            'numero_cuenta',
            'saldo_sistema',
            'saldo_bancario',
            //'diferencia',
            //'id_operador',
            //'observaciones:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
