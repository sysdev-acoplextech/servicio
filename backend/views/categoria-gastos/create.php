<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoriaGastos */

$this->title = 'Create Categoria Gastos';
$this->params['breadcrumbs'][] = ['label' => 'Categoria Gastos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-gastos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
