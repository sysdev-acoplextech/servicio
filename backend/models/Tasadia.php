<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tasadia".
 *
 * @property integer $id
 * @property double $valor
 * @property string $fecha_hora
 * @property string $usuario
 */
class Tasadia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tasadia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['valor'], 'number'],
            [['fecha_hora'], 'safe'],
            [['usuario'], 'required'],
            [['usuario'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'valor' => 'Valor',
            'fecha_hora' => 'Fecha Hora',
            'usuario' => 'Usuario',
        ];
    }
}
