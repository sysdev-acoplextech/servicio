<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TipoServicioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipo de servicios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-servicio-index">

<div class="row">
        <div class="col-md-11">
        <?= Html::a('<span class="fa fa-list"></span><b> Todos los Registros</b>', ['index'], ['class' => 'btn btn-primary']); ?>
           <!-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default2"><span class="fa fa-search-plus"></span>&nbsp; <b>Buscar</b>
            </button>-->
        </div>
        <div class="col-md-1">
            <p>
                <?= Html::a('Nuevo', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="box box-purple">

        <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'nombre_servicio',
            'estatus:boolean',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' =>  '{update} {delete} ',
                'buttons' =>[

                    'update' => function ($url, $model) {
                        $options = [
                            'title' => 'Modificar',
                            'data-method' => 'post',
                        ];

                        return Html::a('<span class="btn btn-warning glyphicon glyphicon-pencil"></span>', [
                            'update',
                            'id' => $model['id'],
                        ], $options);
                    },
                  
                    'delete' =>function($url, $model)
                    {
                      $options = [
                        'title' => 'Eliminar',
                        'data-confirm' =>   '¿Está seguro que desea eliminar este registro?',
                        'data-method' => 'post',
                      ];
                      return Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', $url.'&pro=0', $options);
                    },
                   
                ],
            ],
        ],
    ]); ?>


</div>
</div>
</div>
