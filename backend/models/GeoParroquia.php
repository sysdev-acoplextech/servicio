<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "geo_parroquia".
 *
 * @property int $id
 * @property int $id_municipio
 * @property string $nombre_parroquia
 * @property int $estatus
 */
class GeoParroquia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'geo_parroquia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_municipio', 'nombre_parroquia'], 'required'],
            [['id_municipio', 'estatus'], 'integer'],
            [['nombre_parroquia'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_municipio' => 'Id Municipio',
            'nombre_parroquia' => 'Nombre Parroquia',
            'estatus' => 'Estatus',
        ];
    }
}
