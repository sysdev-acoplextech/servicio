<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CondicionFlota */

$this->title = 'Registrar Condición de la Flota';
$this->params['breadcrumbs'][] = ['label' => 'Condicion Flotas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="condicion-flota-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
