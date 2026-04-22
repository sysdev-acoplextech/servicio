<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "detalle_tarifario".
 *
 * @property int $id_detalle_tarifario
 * @property int $id_tarifario
 * @property string $rutas
 * @property string $sedan
 * @property string $camioneta
 */
class DetalleTarifario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalle_tarifario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tarifario', 'rutas'], 'required'],
            [['id_tarifario'], 'integer'],
            [['sedan', 'camioneta'], 'number'],
            [['rutas'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_detalle_tarifario' => 'Id Detalle Tarifario',
            'id_tarifario' => 'Id Tarifario',
            'rutas' => 'Rutas',
            'sedan' => 'Sedan',
            'camioneta' => 'Camioneta',
        ];
    }
}
