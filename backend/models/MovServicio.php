<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "mov_servicio".
 *
 * @property int $id_mov_servicio
 * @property int $id_servicio
 * @property int $id_estatus
 * @property int $id_usuario
 * @property string $fecha
 * @property string $observacion
 */
class MovServicio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mov_servicio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_servicio', 'id_estatus', 'id_usuario', 'fecha', 'observacion'], 'required'],
            [['id_servicio', 'id_estatus', 'id_usuario'], 'integer'],
            [['fecha'], 'safe'],
            [['observacion'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_mov_servicio' => 'Id Mov Servicio',
            'id_servicio' => 'Id Servicio',
            'id_estatus' => 'Id Estatus',
            'id_usuario' => 'Id Usuario',
            'fecha' => 'Fecha',
            'observacion' => 'Observación',
        ];
    }
}
