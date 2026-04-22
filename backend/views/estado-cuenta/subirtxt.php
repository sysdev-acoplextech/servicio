<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

$this->title = 'Importar Estado de Cuenta';

$this->registerCss("
    .import-container {
        padding: 40px;
        background-color: #F8FAFC;
        min-height: 100vh;
    }
    .ficha-importacion {
        background: #FFFFFF;
        border-radius: 25px !important;
        box-shadow: 0 15px 40px rgba(0,0,0,0.05) !important;
        border: none !important;
        padding: 0;
        overflow: hidden;
        max-width: 900px;
        margin: 0 auto;
    }
    .header-import {
        background-color: #1B242D;
        color: white;
        padding: 30px;
    }
    .body-import {
        padding: 40px;
    }
    .ayuda-sidebar {
        border-right: 1px solid #F1F5F9;
        padding-right: 30px;
    }
    .btn-redondo {
        border-radius: 20px !important;
        padding: 10px 25px;
        font-weight: bold;
        transition: 0.3s;
    }
    .form-control {
        border-radius: 0px !important; /* Manteniendo tu regla de inputs rectos */
    }
    /* Estilo para el link de descarga de formato */
    .link-formato {
        display: block;
        padding: 15px;
        background: #F8FAFC;
        border-radius: 15px;
        text-decoration: none !important;
        color: #1B242D;
        transition: 0.3s;
        border: 1px solid transparent;
    }
    .link-formato:hover {
        background: #F1F5F9;
        border-color: #E2E8F0;
        transform: translateY(-2px);
    }
");
?>

<div class="import-container">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="ficha-importacion">
        <div class="header-import">
            <div class="row" style="display: flex; align-items: center;">
                <div class="col-md-12">
                    <h4 style="margin: 0; font-weight: bold; letter-spacing: 0.5px;">
                        <i class="fa fa-upload"></i>&nbsp; CARGA MASIVA DE REFERENCIAS
                    </h4>
                </div>
            </div>
        </div>

        <div class="body-import">
            <div class="row">
                <div class="col-md-4 ayuda-sidebar">
                    <h5 style="font-weight: bold; color: #64748B; text-transform: uppercase; font-size: 9pt; letter-spacing: 1px; margin-bottom: 20px;">
                        Documentación
                    </h5>
                    
                    <?= Html::a(
                        '<div style="display: flex; align-items: center;">
                            <i class="fa fa-file-excel-o" style="font-size: 20pt; color: #10B981; margin-right: 15px;"></i>
                            <div>
                                <b style="display: block; font-size: 10pt;">Formato CSV/TXT</b>
                                <small style="color: #94A3B8;">Descargar estructura</small>
                            </div>
                        </div>',
                        ['descargar-formato', 't' => 1],
                        ['class' => 'link-formato']
                    ); ?>

                    <div style="margin-top: 25px; padding: 15px; background: #FFFBEB; border-radius: 15px; border: 1px solid #FEF3C7;">
                        <p style="font-size: 9pt; color: #92400E; margin: 0;">
                            <i class="fa fa-info-circle"></i> Asegúrese de que el archivo no contenga encabezados y use coma (,) como separador.
                        </p>
                    </div>
                </div>

                <div class="col-md-8" style="padding-left: 30px;">
                    <label style="font-weight: bold; color: #1B242D; margin-bottom: 15px;">Seleccione el archivo bancario</label>
                    
                    <?= $form->field($model, 'file')->label(false)->widget(
                        FileInput::classname(),
                        [
                            'options' => [
                                'accept' => 'text/plain, .csv',
                                'multiple' => false
                            ],
                            'pluginOptions' => [
                                'showUpload' => false, 
                                'showRemove' => true,
                                'allowedFileExtensions' => ['txt', 'csv'],
                                'removeClass' => 'btn btn-default btn-redondo',
                                'browseClass' => 'btn btn-primary btn-redondo',
                                'browseLabel' => ' Buscar Archivo',
                                'browseIcon' => '<i class="fa fa-folder-open"></i>',
                                'previewFileType' => ['txt', 'csv'],
                                'layoutTemplates' => [
                                    'main1' => '{preview}<div class="input-group" style="margin-top:15px;">{caption}<div class="input-group-btn">{remove}{browse}</div></div>'
                                ]
                            ],
                        ]
                    ); ?>
                </div>
            </div>
        </div>

        <div style="background: #F8FAFC; padding: 25px 40px; border-top: 1px solid #F1F5F9;" class="text-right">
            <?= Html::a('<i class="fa fa-chevron-left"></i> REGRESAR', ['index'], [
                'class' => 'btn btn-default btn-redondo',
                'style' => 'background: white; border: 1px solid #E2E8F0; color: #64748B; margin-right: 10px;'
            ]); ?>
            
            <?= Html::submitButton('<i class="fa fa-check"></i> PROCESAR INFORMACIÓN', [
                'class' => 'btn btn-success btn-redondo',
                'style' => 'background-color: #1B242D; border: none; box-shadow: 0 4px 12px rgba(27,36,45,0.15);'
            ]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>