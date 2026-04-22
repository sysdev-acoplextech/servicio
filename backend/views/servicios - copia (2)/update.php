<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Servicios */

$this->title = 'Modificar Servicio: ' . $model->id_servicio;
$this->params['breadcrumbs'][] = ['label' => 'Servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_servicio, 'url' => ['view', 'id' => $model->id_servicio]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="servicios-update">

    <?= $this->render('_form_update', [
        'model' => $model,
        'model2' => $model2,
        'model3' => $model3,
    ]) ?>

</div>
