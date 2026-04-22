<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tipo_ruta".
 *
 * @property int $id
 * @property string $nombre_ruta
 * @property int $estatus
 */
class TipoRuta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_ruta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_ruta'], 'required'],
            [['estatus'], 'integer'],
            [['nombre_ruta'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_ruta' => 'Nombre de la Ruta',
            'estatus' => '¿Activo?',
        ];
    }
}
