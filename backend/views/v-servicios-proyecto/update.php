<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VServiciosProyecto */

$this->title = 'Update V Servicios Proyecto: ' . $model->id_servicio;
$this->params['breadcrumbs'][] = ['label' => 'V Servicios Proyectos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_servicio, 'url' => ['view', 'id' => $model->id_servicio]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vservicios-proyecto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
