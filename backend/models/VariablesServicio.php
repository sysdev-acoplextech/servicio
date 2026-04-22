<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "variables_servicio".
 *
 * @property int $id_variable
 * @property string $nombre_variable
 * @property string $descripcion
 * @property int $estatus
 */
class VariablesServicio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'variables_servicio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_variable', 'descripcion', 'estatus'], 'required'],
            [['descripcion'], 'string'],
            [['estatus'], 'integer'],
            [['nombre_variable'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_variable' => 'Id Variable',
            'nombre_variable' => 'Nombre de la Variable de Servicio',
            'descripcion' => 'Descripción',
            'estatus' => '¿Activo?',
        ];
    }
}
