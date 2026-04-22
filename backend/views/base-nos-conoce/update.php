<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BaseNosConoce */

$this->title = 'Modificar ¿Cómo nos conoció?: ' . $model->nombre_nos_conoce;
$this->params['breadcrumbs'][] = ['label' => '¿Cómo nos conoció?', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="base-nos-conoce-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
