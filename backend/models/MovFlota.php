<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "mov_flota".
 *
 * @property int $id
 * @property int $id_flota
 * @property int $id_estatus
 * @property string $observacion
 * @property int $ultimo
 */
class MovFlota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mov_flota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_flota', 'id_estatus', 'observacion'], 'required'],
            [['id_flota', 'id_estatus', 'ultimo'], 'integer'],
            [['observacion'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_flota' => 'Id Flota',
            'id_estatus' => 'Id Estatus',
            'observacion' => 'Observacion',
            'ultimo' => 'Ultimo',
        ];
    }
}
