<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Flota */

$this->title = 'Modificar Flota: ' . $model->placa;
$this->params['breadcrumbs'][] = ['label' => 'Flotas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="flota-update">
    <?= $this->render('_formmod', [
        'model' => $model,
    ]) ?>

</div>
