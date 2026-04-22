<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Usuarios';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1><?php // Html::encode($this->title) ?></h1>
	    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="box box-primary">
            <div class="box-header with-border">
             <?= Html::a('Crear Usuarios', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
              <div class="box-body">
               <?= GridView::widget([
        'dataProvider' => $dataProvider,
       'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            'cedula',
            'nombres',
            'apellidos',
              'username',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            //'email:email',
            //'status',
            //'created_at',
            //'updated_at',
            //'accessToken',
            //'activate',
            //'id_role',
            //'nacionalidad',
            //'telefono_oficina',
            //'telefono_celular',
            //'id_conjunto',
            [
            'class' => 'yii\grid\ActionColumn',
            'template' => Helper::filterActionColumn(['view', 'update', 'cambiarclave','delete','estatus']),
             //'template' => '{view} {update} {delete} {cambiarclave}',
            'buttons' =>[


          'view' =>function($url, $model)
          {
            $options = [
              'title' => 'Ver',
              'data-method' => 'post', 
            ];
            // return Html::a('<span class="btn btn-success fa fa-eye"></span>', $url, $options);
            return Html::a('<span class="btn btn-success icofont-eye-alt "></span>', $url, $options);
          },


          'update' =>function($url, $model)
          {
            $options = [
              'title' => 'Actualizar',
              'data-method' => 'post', 
            ];
            return Html::a('<span class="btn btn-primary icofont-edit-alt "></span>', $url, $options);
          },



             'cambiarclave' =>function($url, $model)
                            {
                                $options = [
                                'title' => 'Cambiar Contraseña',
                                //'aria-label' => 'Cambiar Contraseña',
                                //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                                //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                                'data-method' => 'post',
                                //'data-pjax' => '0',
                                ]; 
                                return Html::a('<span class="btn btn-primary icofont-ui-password "></span>', $url, $options);
                            },
             'delete' =>function($url, $model)
                            {
                                $options = [
                                'title' => 'Borrar',
                                'aria-label' => 'Borrar Registro',
                                // 'aria-label' => Yii::t('rbac-admin', 'Activate'),
                                'data-confirm' =>   'Seguro que desea borrar este usuario?' ,
                                'data-method' => 'post',
                                //'data-pjax' => '0',
                                ];
                            return Html::a('<span class="btn btn-danger icofont-eraser-alt "></span>', $url, $options);
                            },
             'estatus' =>function($url, $model)
                            {
     if ($model->status==10) 
        { 
          $options = [
                                'title' => 'Desactivar',
                                'aria-label' => 'Desactivar',
                                // 'aria-label' => Yii::t('rbac-admin', 'Activate'),
                                'data-confirm' =>   'Seguro que desea desactivar este usuario?' ,
                                'data-method' => 'post',
                                //'data-pjax' => '0',
                                ];
                            return Html::a('<span class="btn btn-warning icofont-ui-close "></span>', $url, $options);

      }else
      { 

 
          $options = [
                                'title' => 'Avtivar',
                                'aria-label' => 'Avtivar',
                                // 'aria-label' => Yii::t('rbac-admin', 'Activate'),
                                'data-confirm' =>   'Seguro que desea Avtivar este usuario?' ,
                                'data-method' => 'post',
                                //'data-pjax' => '0',
                                ];
                            return Html::a('<span class="btn btn-success icofont-ui-check  "></span>', $url, $options);

      

      }


                      
                            },



                        ],
            ],
        ],
    ]); ?>
              </div>
          </div>


</div>
