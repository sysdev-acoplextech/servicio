<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BaseTipoVehiculo */

$this->title = 'Modificar Tipo de Vehículo: ' . $model->nombre_tipo_vehiculo;
$this->params['breadcrumbs'][] = ['label' => 'Tipo de Vehículos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="base-tipo-vehiculo-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
