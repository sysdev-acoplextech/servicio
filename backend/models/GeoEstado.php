<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "geo_estado".
 *
 * @property int $id
 * @property string $nombre
 * @property int $estatus
 */
class GeoEstado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'geo_estado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['estatus'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'estatus' => 'Estatus',
        ];
    }
}
