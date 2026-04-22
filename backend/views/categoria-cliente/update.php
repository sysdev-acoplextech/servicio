<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoriaCliente */

$this->title = 'Modificar Categoría Cliente: ' . $model->nombre_categoria;
$this->params['breadcrumbs'][] = ['label' => 'Categoría Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_categoria, 'url' => ['view', 'id' => $model->id_categoria]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="categoria-cliente-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
