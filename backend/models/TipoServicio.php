<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tipo_servicio".
 *
 * @property int $id
 * @property string $nombre_servicio
 * @property bool $estatus
 */
class TipoServicio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_servicio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_servicio'], 'required'],
            [['estatus'], 'boolean'],
            [['nombre_servicio'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_servicio' => 'Nombre Servicio',
            'estatus' => '¿Activo?',
        ];
    }
}
