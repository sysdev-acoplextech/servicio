<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BaseTipoCliente */

$this->title = 'Registrar Tipo de Cliente';
$this->params['breadcrumbs'][] = ['label' => 'Tipo Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-tipo-cliente-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
