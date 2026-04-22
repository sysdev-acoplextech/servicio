<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CuentasBancarias */

$this->title = 'Editar Cuenta Bancaria: ' . $model->descripcion;
$this->params['breadcrumbs'][] = ['label' => 'Cuentas Bancarias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->descripcion, 'url' => ['view', 'id' => $model->id_cuentas]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="cuentas-bancarias-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
