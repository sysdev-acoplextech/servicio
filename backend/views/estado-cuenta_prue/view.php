<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\EstadoCuenta */

$this->title = $model->idestado_cuenta;
$this->params['breadcrumbs'][] = ['label' => 'Estado Cuentas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="estado-cuenta-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idestado_cuenta], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idestado_cuenta], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idestado_cuenta',
            'fecha_transaccion',
            'referencia',
            'monto',
            'operador',
            'fecha_registro',
            'hora',
            'conciliado',
            'eliminado',
            'numero_cuenta',
            'tipo_transaccion',
            'id_categoria',
        ],
    ]) ?>

</div>
