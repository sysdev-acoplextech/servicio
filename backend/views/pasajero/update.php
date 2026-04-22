<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Pasajero */

$this->title = 'Update Pasajero: ' . $model->id_pasajero;
$this->params['breadcrumbs'][] = ['label' => 'Pasajeros', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pasajero, 'url' => ['view', 'id' => $model->id_pasajero]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pasajero-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
