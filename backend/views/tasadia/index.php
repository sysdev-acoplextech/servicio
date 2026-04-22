<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TasadiaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasa de cambio del día';
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="tasadia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Actualizar Tasa de Cambio', ['update', 'id' => 1], ['class' => 'btn btn-primary']) ?>

    </p>

  
</div>
    <div class="box-body">
      <div class="row">
        <div class="col-lg-5 col-xs-10">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h4>Valor de cambio</h4>
              <h3><?= $model[0]['valor'];?></h3>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-xs-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <p>Última Actualización</p>
              <h3><?= $model[0]['fecha_hora'];?></h3>
              <p>Actualizado por el Usuario</p>
              <h3><?= $model[0]['usuario'];?></h3>
            </div>
            <div class="icon">
              <i class="fa fa-archive"></i>
            </div>
          </div>
        </div>
      </div>
    </div>