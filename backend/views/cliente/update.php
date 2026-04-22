<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Cliente */

$this->title = 'Modificar Cliente: ' . $model->nombre_apellido;
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_cliente, 'url' => ['view', 'id' => $model->id_cliente]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cliente-update">

    <?= $this->render('_form2', [
        'model' => $model,
        'model2' => $model2,
    ]) ?>

</div>
