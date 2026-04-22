<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tipo_traslado_ruta".
 *
 * @property int $id
 * @property string $nombre_traslado_ruta
 * @property int $estatus
 */
class TipoTrasladoRuta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_traslado_ruta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_traslado_ruta'], 'required'],
            [['estatus'], 'integer'],
            [['nombre_traslado_ruta'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_traslado_ruta' => 'Nombre de traslado de ruta',
            'estatus' => '¿Activo?',
        ];
    }
}
