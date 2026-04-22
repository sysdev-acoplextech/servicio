<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CondicionFlota */

$this->title = 'Modificar Condición de la Flota: ' . $model->nombre_condicion_flota;
$this->params['breadcrumbs'][] = ['label' => 'Condicion Flota', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="condicion-flota-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
