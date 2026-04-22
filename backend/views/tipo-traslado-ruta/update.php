<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TipoTrasladoRuta */

$this->title = 'Modificar Tipo de traslado de ruta: ' . $model->nombre_traslado_ruta;
$this->params['breadcrumbs'][] = ['label' => 'Tipo Traslado Rutas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="tipo-traslado-ruta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
