<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\ConveEmpresa;
use backend\models\SoliCortoPlazo;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\models\Gerencia;
use backend\models\FuenteFinanciamiento;
use backend\models\GeoEstado;
/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="user-form">
    <?php $form = ActiveForm::begin(); ?> 
    <div class="box box-primary">
      <div class="box-body">
        <div class="col-md-6 col-sm-12 col-lg-6">
            <?php
        //Opciones del select de plazos
            $var = [1 => 'V', 2 => 'E'];
            echo $form->field($model, 'nacionalidad')->
            dropDownList($var, ['prompt' => 'Seleccione']) ;
            ?>
            <?php // $form->field($model, 'nacionalidad')->textInput(['maxlength' => true]) ?>
        </div>  
        <div class="col-md-6 col-sm-12 col-lg-6">
            <?= $form->field($model, 'cedula')->textInput(['maxlength' => true]) ?>
        </div> 
        <div class="col-md-6 col-sm-12 col-lg-6">
            <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>
        </div> 
        <div class="col-md-6 col-sm-12 col-lg-6">
            <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>
        </div>   
    <!--<div class="col-md-6 col-sm-12 col-lg-4">
    <?php //$form->field($model, 'username')->textInput(['maxlength' => true]) ?>
</div> -->
<div class="col-md-6 col-sm-12 col-lg-4">
   <?=
   $form->field($model, 'email')->textInput(['maxlength' => true]);
   ?>
   <?php // $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
</div>  
<div class="col-md-6 col-sm-12 col-lg-4">
    <?=
    $form->field($model, 'telefono_oficina')->textInput(['maxlength' => true]);
    ?>
    <?php //$form->field($model, 'telefono_oficina')->textInput(['maxlength' => true]) ?>
</div> 
<div class="col-md-6 col-sm-12 col-lg-4">
    <?=
    $form->field($model, 'telefono_celular')->textInput(['maxlength' => true]);
    ?>
    <?php //$form->field($model, 'telefono_celular')->textInput(['maxlength' => true]) ?>
</div>  
<div class="col-md-4">
    <?= $form->field($model, 'username')->label('Usuario(*)') ?>
</div>
<div class="col-md-4">
    <?= $form->field($model, 'password')->passwordInput()->label('Contraseña(*)') ?>
</div>
<div class="col-md-4">
    <?= $form->field($model, 'repeatPassword')->passwordInput()->label('Confirmar Contraseña(*)') ?>
</div>
<div class="col-md-4 ml-auto">
    <?php
    $geer=Gerencia::find()->where(['eliminado'=>0])->all();
    $listData2=ArrayHelper::map($geer, 'id_gerencia', 'nom_gerencia');
    echo $form->field($model, 'id_gerencia')->widget(Select2::classname(), [
        'data' => $listData2,
        'pluginLoading' => false,
        'value'=> null,
                //'theme' => Select2::THEME_MATERIAL,
        'options' => ['placeholder' => 'Seleccione...'],
        'pluginOptions' => [
            'multiple' => false,
            'allowClear' => true,
        ],
    ]);
    ?>
</div>
<div class="col-md-4 ml-auto">
    <!-- numero  documento -->
    <?php /*$num_doc=ConveEmpresa::find()->select(['codigo_convenio'])->groupBy(['codigo_convenio'])->all();
    $listData=ArrayHelper::map($num_doc, 'codigo_convenio', 'codigo_convenio');
                    //echo '<label class="control-label">N° de Documento</label>';
    echo $form->field($model, 'codigo_convenio')->widget(Select2::classname(), [
        'data' => $listData,
        'pluginLoading' => false,
                        //'theme' => Select2::THEME_MATERIAL,
        'options' => ['placeholder' => 'Seleccione...'],
        'pluginOptions' => [
            'multiple' => false,
            'allowClear' => true,
        ],
    ]);*/
    ?>
</div>

<div class="col-md-4 col-sm-12 col-lg-4">
    <?php /*$fuentef=FuenteFinanciamiento::find()->all();
    $listData=ArrayHelper::map($fuentef, 'id_fuente', 'descrip_fuente'); 
    echo $form->field($model, 'id_fuente_financiamiento')->widget(Select2::classname(), [
        'data' => $listData,
        'pluginLoading' => false,
                            //'theme' => Select2::THEME_MATERIAL,
        'options' => ['placeholder' => 'Seleccione...'],
        'pluginOptions' => [
            'multiple' => false,
            'allowClear' => true,
        ],
    ]);*/
    ?>
</div>
<div class="col-md-4 col-sm-12 col-lg-4">
    <?php 
    /*$empre = SoliCortoPlazo::find()
    ->select([
        new Expression("'('||rif||') '||nombre as rif"), 
        'id_empresa',
        'nombre' 
    ])   
    ->groupBy(['rif','id_empresa','nombre'])
    ->all();
    $data_em=ArrayHelper::map($empre, 'id_empresa', 'rif'); 
    echo $form->field($model, 'id_empresa')->widget(Select2::classname(), [
        'data' => $data_em,
        'pluginLoading' => false,
                            //'theme' => Select2::THEME_MATERIAL,
        'options' => ['placeholder' => 'Seleccione...'],
        'pluginOptions' => [
            'multiple' => false,
            'allowClear' => true,
        ],
    ]);*/
    $estado = ArrayHelper::map(GeoEstado::find()->where('id_estado > 0')->all(), 'id_estado', 'nombre');
    ?>

     <?= $form->field($model, 'estado_id')->dropDownList(
        $estado,
        [
            'prompt'=>'Seleccione...',
            'allowClear' => true,
        ])->label('Estado al que pertenece');
        ?>
</div> 
</div> 
<div class="box-footer">
    <?= Html::a('Regresar', ['index'], ['class' => 'btn btn-warning']) ?>
    <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
</div> 
</div>
<?php ActiveForm::end(); ?>
</div>