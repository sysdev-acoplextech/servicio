<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "horario".
 *
 * @property int $id_horario
 * @property string $descripcion
 * @property string $hora_desde
 * @property string $hora_hasta
 * @property string $recargo
 */
class Horario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'required'],
            [['hora_desde', 'hora_hasta'], 'safe'],
            [['recargo'], 'number'],
            [['descripcion'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_horario' => 'Id Horario',
            'descripcion' => 'Descripcion',
            'hora_desde' => 'Hora Desde',
            'hora_hasta' => 'Hora Hasta',
            'recargo' => 'Recargo',
        ];
    }
}
