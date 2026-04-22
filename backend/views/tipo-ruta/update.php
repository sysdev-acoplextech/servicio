<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TipoRuta */

$this->title = 'Modificar Tipo de Ruta: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Rutas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="tipo-ruta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
