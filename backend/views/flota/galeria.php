<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CuerpoBomberos */

$this->title = Yii::t('app', 'Galería de la Flota: {name}', [
    'name' => $model->placa,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Flota'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Galería');
?>
<div class="flota-update">

    <?= $this->render('_galeria', [
        'model' => $model,
    ]) ?>

</div>
