<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Detalle de Usuario';
//$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?PHP //Html::encode($this->title) ?></h1>

  


  <div class="col-md-12">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green">
              <div class="widget-user-image"> 
                <img class="img-circle" src="../../vendor/almasaeed2010/adminlte/dist/img/avatar04.png" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><?= $model->username; ?></h3>
              <h5 class="widget-user-desc"><?= $model->nombres.' '.$model->apellidos; ?></h5>
            </div>
            <div class="box-footer no-padding">
              <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
             [
            'attribute' => 'nacionalidad',
            'value' => function ($model) {
              if ($model->nacionalidad==1) {
                $na='V';
              }else
              {
                $na='E';
              }
                return $na;
              }
            
        ],
            'cedula',
            // 'nacionalidad',
            'email:email',
            'telefono_oficina',
            'telefono_celular',
            'codigo_convenio',
            // 'id_conjunto',
        ],
    ]) ?>
	
	
	 <div class="box-footer">
          	<?= Html::a('Regresar', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta Seguro que desea Eliminar este registro?',
                'method' => 'post',
            ],
        ]) ?>
            </div>
	

            </div>
			 
        
   
          </div>
          <!-- /.widget-user -->
        </div>




    

</div>
