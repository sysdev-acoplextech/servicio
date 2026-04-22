<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Servicios */

$this->title = 'Registrar Servicio';
$this->params['breadcrumbs'][] = ['label' => 'Servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servicios-create">

    <?= $this->render('_form_seleccion', [
        'model' => $model,
        'model2' => $model2,
        'model3' => $model3,
        'model4' => $model4,
        'model5' => $model5,
        'model6' => $model6,
    ]) ?>

</div>
