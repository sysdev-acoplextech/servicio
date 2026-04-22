<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ListaPrecio */

$this->title = 'Modificar Lista Precio: ' . $model->id_lista;
$this->params['breadcrumbs'][] = ['label' => 'Lista Precios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_lista, 'url' => ['view', 'id' => $model->id_lista]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lista-precio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
