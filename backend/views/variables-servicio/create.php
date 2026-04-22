<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VariablesServicio */

$this->title = 'Registrar Variables Servicio';
$this->params['breadcrumbs'][] = ['label' => 'Variables de Servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="variables-servicio-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
