<?php

use backend\models\BaseMarca;
use backend\models\BaseModelo;
use backend\models\BaseTipoVehiculo;
use backend\models\CondicionFlota;
use backend\models\GeoEstado;
use backend\models\GeoMunicipio;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Flota */
/* @var $form yii\widgets\ActiveForm */


$municipioss = [];
if ($model->id_marca) {

    $municipioss = ArrayHelper::map(BaseModelo::find()->where(['id_marca' => $model->id_marca])->all(), 'id', 'nombre_modelo');
}

$municipio = [];
$parroquia = [];
if ($model->id_estado) {

    $municipio = ArrayHelper::map(GeoMunicipio::find()->where(['id_estado' => $model->id_estado])->all(), 'id_municipio', 'nombre');
}
/*if ($model5->id_municipio) {
    $parroquia = ArrayHelper::map(GeoParroquia::find()->where(['id_municipio' => $model5->id_municipio])->all(), 'id_parroquia', 'nombre');
}
*/


?>

<div class="flota-form">
    <div class="box box-widget widget-user-2">
        <div class="box box-primary">
            <div class="box-body">

                <?php $form = ActiveForm::begin([
                    'options' => ['enctype' => 'multipart/form-data']
                ]); ?>
                <div class="row">
                    <div class="col-md-6">
                        <?php
                        $tipo = BaseTipoVehiculo::find()->all();
                        $listipo = ArrayHelper::map($tipo, 'id', 'nombre_tipo_vehiculo');
                        echo $form->field($model, 'id_tipo_vehiculo')->widget(Select2::classname(), [
                            'data' => $listipo,
                            'pluginLoading' => false,
                            'value' => null,
                            'options' => ['placeholder' => 'Seleccione...'],
                            'pluginOptions' => [
                                'multiple' => false,
                                'allowClear' => true,
                            ],
                        ]);
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?php
                        $tipo = CondicionFlota::find()->all();
                        $listipo = ArrayHelper::map($tipo, 'id', 'nombre_condicion_flota');
                        echo $form->field($model, 'id_condicion')->widget(Select2::classname(), [
                            'data' => $listipo,
                            'pluginLoading' => false,
                            'value' => null,
                            'options' => ['placeholder' => 'Seleccione...'],
                            'pluginOptions' => [
                                'multiple' => false,
                                'allowClear' => true,
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?php
                       /* $tipo = BaseMarca::find()->all();
                        $listipo = ArrayHelper::map($tipo, 'id', 'nombre_marca');
                        echo $form->field($model, 'id_marca')->widget(Select2::classname(), [
                            'data' => $listipo,
                            'pluginLoading' => false,
                            'value' => null,
                            'options' => ['placeholder' => 'Seleccione...'],
                            'pluginOptions' => [
                                'multiple' => false,
                                'allowClear' => true,
                            ],
                        ]);*/


                        ?>


                        <?=
                        $form->field($model, 'id_marca')->dropDownList(ArrayHelper::map(\backend\models\BaseMarca::find()->
                            where("estatus=1")->all(), 'id', 'nombre_marca'), ['prompt' => 'Seleccione..',
                            'id' => 'id-categoria',
                        ]);
                    ?>
                    </div>
                    <div class="col-md-6">
                        <?php
                       /* echo $form->field($model, 'id_modelo')->widget(DepDrop::classname(), [
                            'type' => DepDrop::TYPE_SELECT2,
                            'options' => [
                                'placeholder' => 'Seleccione...',
                                'multiple' => false,
                                'theme' => Select2::THEME_BOOTSTRAP,
                            ],
                            'data' => [$municipioss], // ensure at least the preselected value is available
                            'pluginOptions' => [
                                'depends' => [Html::getInputId($model, 'id_marca')], // the id for cat attribute
                                'url' => Url::to(['/base-modelo/categoria'])
                            ]
                        ]);*/


                        ?>

<?=
                    $form->field($model, 'id_modelo')->widget(DepDrop::classname(), [
                        'options' => ['id' => 'id'],
                        'data' => [$model->id => $model->id], // ensure at least the preselected value is available
                        'pluginOptions' => [
                            'depends' => ['id-categoria'], // the id for cat attribute
                            'placeholder' => 'Seleccione...',
                            'url' => Url::to(['/base-modelo/listarsubcategoria'])
                        ]
                    ]);
                    ?>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field($model, 'placa')->textInput(['maxlength' => true, 'style' => 'text-transform:uppercase;']) ?>

                    </div>
                    
                    <div class="col-md-3">
                        <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

                    </div>
                    
                   
                    <div class="col-md-3">
                    <?php echo $form->field($model, 'fecha_vencimiento_rcv')->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Seleccione...'],
                                'pluginOptions' => [
                                    'id' => 'fecha_vencimiento_rcv',
                                    'autoclose' => true,
                                    'format' => 'dd-mm-yyyy',
                                    // 'startView' => 'year',
                                ]
                            ]);
                            ?>
                    </div>
                    <div class="col-md-3">
                        <?php
                        echo $form->field($model, 'tercerizado')->widget(SwitchInput::classname(), [
                            'type' => SwitchInput::CHECKBOX,
                            'pluginOptions' => [
                                'handleWidth' => 60,
                                'offColor' => 'danger',
                                'onColor' => 'success',
                                'onText' => 'SI',
                                'offText' => 'NO'
                            ]
                        ]);
                        ?>
                    </div>


                </div>

                <fieldset>
                    <legend>Ubicación</legend>
                    <div class="row">
                        <div class="col-md-4">
                            <?php
                            $tipo = GeoEstado::find()->where(['not in', 'id', [24]])->orderBy(['nombre' => SORT_ASC])->all();
                            $listipo = ArrayHelper::map($tipo, 'id', 'nombre');
                            echo $form->field($model, 'id_estado')->widget(Select2::classname(), [
                                'data' => $listipo,
                                'pluginLoading' => false,
                                'value' => null,
                                'options' => ['placeholder' => 'Seleccione...'],
                                'pluginOptions' => [
                                    'multiple' => false,
                                    'allowClear' => true,
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php
                            echo $form->field($model, 'id_municipio')->widget(DepDrop::classname(), [
                                'type' => DepDrop::TYPE_SELECT2,
                                'options' => [
                                    'placeholder' => 'Seleccione...',
                                    'multiple' => false,
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                ],
                                'data' => [$municipio], // ensure at least the preselected value is available
                                'pluginOptions' => [
                                    'depends' => [Html::getInputId($model, 'id_estado')], // the id for cat attribute
                                    'url' => Url::to(['dep-municipio'])
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php
                            echo $form->field($model, 'id_parroquia')->widget(DepDrop::classname(), [
                                'type' => DepDrop::TYPE_SELECT2,
                                'options' => [
                                    'placeholder' => 'Seleccione...',
                                    'multiple' => false,
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                ],
                                'data' => [],
                                'pluginOptions' => [
                                    'depends' => [Html::getInputId($model, 'id_municipio')],
                                    'url' => Url::to(['dep-parroquia'])
                                ]
                            ]);
                            ?>
                        </div>
                    </div>

                </fieldset>

                <div class="form-group">
                    <div class="box-tools pull-right">
                        <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span> <b>Regresar</b>', ['index'], ['class' => 'btn btn-warning btn']) ?>
                        <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span> <b>Guardar</b>', ['class' => 'btn btn-primary btn']) ?>
                    </div>
                </div>


                <?php ActiveForm::end(); ?>

            </div>