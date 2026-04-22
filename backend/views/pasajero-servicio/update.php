<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PasajeroServicio */

$this->title = 'Update Pasajero Servicio: ' . $model->id_pax_servicio;
$this->params['breadcrumbs'][] = ['label' => 'Pasajero Servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pax_servicio, 'url' => ['view', 'id' => $model->id_pax_servicio]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pasajero-servicio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
