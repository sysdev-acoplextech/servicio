<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoriaGastos */

$this->title = 'Update Categoria Gastos: ' . $model->id_categoria_gasto;
$this->params['breadcrumbs'][] = ['label' => 'Categoria Gastos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_categoria_gasto, 'url' => ['view', 'id' => $model->id_categoria_gasto]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="categoria-gastos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
