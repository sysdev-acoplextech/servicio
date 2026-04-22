<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TipoServicio */

$this->title = 'Modificar Tipo de servicio: ' . $model->nombre_servicio;
$this->params['breadcrumbs'][] = ['label' => 'Tipo de servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="tipo-servicio-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
