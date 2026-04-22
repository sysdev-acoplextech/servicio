<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BaseMetodosPago */

$this->title = 'Registar métodos de pago';
$this->params['breadcrumbs'][] = ['label' => 'Base métodos de pagos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-metodos-pago-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
