<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ServicioPago */

$this->title = 'Pago de Factura ';
$this->params['breadcrumbs'][] = ['label' => 'Servicio Pagos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servicio-pago-create">

    <?= $this->render('_form', [
        'model' => $model,
        'model2' => $model2,
        'model3' => $model3,
        'id_cliente' => $id_cliente,
    ]) ?>

</div>
