<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EstadoCuentaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Estado Cuentas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estado-cuenta-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Estado Cuenta', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idestado_cuenta',
            'fecha_transaccion',
            'referencia',
            'monto',
            'operador',
            //'fecha_registro',
            //'hora',
            //'conciliado',
            //'eliminado',
            //'numero_cuenta',
            //'tipo_transaccion',
            //'id_categoria',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
