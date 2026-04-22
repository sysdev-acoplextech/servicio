<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Actualizar Usuario: ' . $model->nombres.' '.$model->apellidos;
// $this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="user-update">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form_2', [
        'model' => $model,
    ]) ?>

</div>
