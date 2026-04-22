<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Cliente */

$this->title = 'Registrar Cliente';
$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cliente-create">


    <?= $this->render('_form', [
        'model' => $model,
        'model2' => $model2,
    ]) ?>

</div>
