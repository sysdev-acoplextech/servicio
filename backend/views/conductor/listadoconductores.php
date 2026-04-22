<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Inventario */

$this->title = 'Conductores';
$this->params['breadcrumbs'][] = ['label' => 'Conductores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conductores-listado">

    <?= $this->render('_listadoconductores', [
        'model' => $model,
    ]) ?>

</div>
