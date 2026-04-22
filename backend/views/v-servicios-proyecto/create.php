<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VServiciosProyecto */

$this->title = 'Create V Servicios Proyecto';
$this->params['breadcrumbs'][] = ['label' => 'V Servicios Proyectos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vservicios-proyecto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
