<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategoriaGastosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categoria Gastos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-gastos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Categoria Gastos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_categoria_gasto',
            'nombre_categoria',
            'estatus',
            'id_fondo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
