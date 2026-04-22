<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Conductor */

$this->title = 'Modificar Conductor: ' . $model->nombres. ' '. $model->apellidos;
$this->params['breadcrumbs'][] = ['label' => 'Conductores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="conductor-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
