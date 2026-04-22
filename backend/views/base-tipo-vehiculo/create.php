<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BaseTipoVehiculo */

$this->title = 'Registrar Tipo de Vehículo';
$this->params['breadcrumbs'][] = ['label' => 'Base Tipo Vehiculos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-tipo-vehiculo-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
