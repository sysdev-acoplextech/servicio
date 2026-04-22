<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EstadoCuenta */

$this->title = 'Update Estado Cuenta: ' . $model->idestado_cuenta;
$this->params['breadcrumbs'][] = ['label' => 'Estado Cuentas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idestado_cuenta, 'url' => ['view', 'id' => $model->idestado_cuenta]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="estado-cuenta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
