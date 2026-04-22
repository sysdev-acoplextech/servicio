<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TipoTrasladoRuta */

$this->title = 'Registro de Tipo de traslado de ruta';
$this->params['breadcrumbs'][] = ['label' => 'Tipo Traslado Rutas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-traslado-ruta-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
