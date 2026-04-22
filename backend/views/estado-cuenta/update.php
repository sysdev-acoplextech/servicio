<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\FinancieroEstadoCuenta $model */

$this->title = 'Update Financiero Estado Cuenta: ' . $model->idestado_cuenta;
$this->params['breadcrumbs'][] = ['label' => 'Financiero Estado Cuentas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idestado_cuenta, 'url' => ['view', 'idestado_cuenta' => $model->idestado_cuenta]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="financiero-estado-cuenta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
