<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoriaCliente */

$this->title = 'Registrar Categoría de Cliente';
$this->params['breadcrumbs'][] = ['label' => 'Categoria Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-cliente-create">

    <?= $this->render('_form', [
        'model' => $model,
        'model2' => $model2,
    ]) ?>

</div>
