<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BaseMetodosPago */

$this->title = 'Modificar Métodos de Pago: ' . $model->nombre_metodo;
$this->params['breadcrumbs'][] = ['label' => 'Métodos de Pagos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_metodo, 'url' => ['view', 'id' => $model->id_metodo]];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="base-metodos-pago-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
