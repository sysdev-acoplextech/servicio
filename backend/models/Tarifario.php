<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tarifario".
 *
 * @property int $id_tarifario
 * @property string $descripcion
 */
class Tarifario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tarifario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'required'],
            [['descripcion'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tarifario' => 'Id Tarifario',
            'descripcion' => 'Descripción',
        ];
    }
    public function getDetalles()
    {
        return $this->hasMany(DetalleTarifario::class, ['id_tarifario' => 'id_tarifario']);
    }
}
