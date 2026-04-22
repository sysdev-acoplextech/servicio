<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "geo_municipio".
 *
 * @property int $id
 * @property int $id_estado
 * @property string $nombre_municipio
 * @property int $estatus
 */
class GeoMunicipio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'geo_municipio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_estado', 'nombre_municipio'], 'required'],
            [['id_estado', 'estatus'], 'integer'],
            [['nombre_municipio'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_estado' => 'Id Estado',
            'nombre_municipio' => 'Nombre Municipio',
            'estatus' => 'Estatus',
        ];
    }
}
