<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TipoRuta */

$this->title = 'Registrar Tipo de Ruta';
$this->params['breadcrumbs'][] = ['label' => 'Tipo Rutas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-ruta-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
