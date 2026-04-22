<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CuerpoBomberos */

$this->title = Yii::t('app', 'Pagar Servicio: {name}', [
    'name' => $model->id_servicio,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Servicio'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Servicio');
?>
<div class="servicio-update">

    <?= $this->render('_pagar', [
        'model' => $model,
        'model2' => $model2,
        'model3' => $model3,
        'pagos' => $pagos,
    ]) ?>

</div>
