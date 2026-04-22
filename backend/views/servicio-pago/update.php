<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ServicioPago */

$this->title = 'Update Servicio Pago: ' . $model->id_pago;
$this->params['breadcrumbs'][] = ['label' => 'Servicio Pagos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pago, 'url' => ['view', 'id' => $model->id_pago]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="servicio-pago-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
