<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Cliente */

$this->title = 'Registro de Servicio';
$this->params['breadcrumbs'][] = ['label' => 'Servicio', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cliente-create">


    <?= $this->render('_form_serv', [
        'model' => $model,
        'model2' => $model2,
    ]) ?>

</div>
