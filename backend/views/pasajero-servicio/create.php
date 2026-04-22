<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PasajeroServicio */

$this->title = 'Create Pasajero Servicio';
$this->params['breadcrumbs'][] = ['label' => 'Pasajero Servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pasajero-servicio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
