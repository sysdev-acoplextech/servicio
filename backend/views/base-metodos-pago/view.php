<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\BaseMetodosPago */

$this->title = $model->id_metodo;
$this->params['breadcrumbs'][] = ['label' => 'Base Metodos Pagos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="base-metodos-pago-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_metodo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_metodo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_metodo',
            'nombre_metodo',
            'num_cuenta',
            'banco',
            'telefono',
            'identificacion',
            'estatus:boolean',
        ],
    ]) ?>

</div>
