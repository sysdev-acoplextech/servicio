<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "servicio_variables".
 *
 * @property int $id_servicio_variable
 * @property int $id_variable_servicio
 * @property int $monto
 * @property int $cantidad
 */
class ServicioVariables extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servicio_variables';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_servicio_variable', 'id_variable_servicio', 'monto', 'cantidad'], 'safe'],
            [['id_servicio_variable', 'id_variable_servicio', 'monto', 'cantidad'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_servicio_variable' => 'Id Servicio Variable',
            'id_variable_servicio' => 'Id Variable Servicio',
            'monto' => 'Monto',
            'cantidad' => 'Cantidad',
        ];
    }
}
