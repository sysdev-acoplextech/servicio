<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ListaPrecio */

$this->title = 'Registrar ítem lista precio';
$this->params['breadcrumbs'][] = ['label' => 'Lista Precios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lista-precio-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
