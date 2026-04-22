<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BaseTipoCliente */

$this->title = 'Modificar Tipo de Cliente: ' . $model->nombre_tipo_cliente;
$this->params['breadcrumbs'][] = ['label' => 'Tipo de Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="base-tipo-cliente-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
