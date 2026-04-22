<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Inventario */

$this->title = 'Flota';
$this->params['breadcrumbs'][] = ['label' => 'Flota', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventario-precio">

    <?= $this->render('_listadoflota', [
        'model' => $model,
    ]) ?>

</div>
