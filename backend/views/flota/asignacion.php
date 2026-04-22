<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CuerpoBomberos */

$this->title = Yii::t('app', 'Asignación: {name}', [
    'name' => $model->placa,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Flota'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Asignación');
?>
<div class="flota-update">

    <?= $this->render('_asignacion', [
        'model' => $model,
        'model2' => $model2,
        'model3' => $model3,
        'registros' => $registros,
    ]) ?>

</div>
