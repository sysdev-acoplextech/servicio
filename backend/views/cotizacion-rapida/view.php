<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CotizacionRapida */

$this->title = $model->id_cotizacion;
$this->params['breadcrumbs'][] = ['label' => 'Cotizacion Rapidas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cotizacion-rapida-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_cotizacion], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_cotizacion], [
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
            'id_cotizacion',
            'cliente_nombre',
            'telefono',
            'fecha_servicio',
            'hora_servicio',
            'id_tarifario',
            'ruta_detalle:ntext',
            'id_tipo_vehiculo',
            'forma_pago',
            'adicionales_json:ntext',
            'monto_base',
            'monto_recargo',
            'monto_viatico',
            'monto_total',
            'creado_el',
        ],
    ]) ?>

</div>
