<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ServicioPago */

$this->title = $model->id_pago;
$this->params['breadcrumbs'][] = ['label' => 'Servicio Pagos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="servicio-pago-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_pago], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_pago], [
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
            'id_pago',
            'id_servicio',
            'fecha_pago',
            'monto',
            'referencia',
            'tipo_pago',
            'id_metodo',
            'banco_origen',
            'procedencia',
            'observacion_pago',
        ],
    ]) ?>

</div>
