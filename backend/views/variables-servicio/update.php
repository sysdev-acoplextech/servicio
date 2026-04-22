<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VariablesServicio */

$this->title = 'Update Variables Servicio: ' . $model->id_variable;
$this->params['breadcrumbs'][] = ['label' => 'Variables Servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_variable, 'url' => ['view', 'id' => $model->id_variable]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="variables-servicio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
