<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BaseModelo */

$this->title = 'Registrar Marcas y Modelos';
$this->params['breadcrumbs'][] = ['label' => 'Base Modelos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-modelo-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
