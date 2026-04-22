<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "operador_financiero".
 *
 * @property int $id_operador
 * @property string $nombre_operador
 * @property int $id_estatus
 */
class OperadorFinanciero extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operador_financiero';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_operador'], 'required'],
            [['id_estatus'], 'integer'],
            [['nombre_operador'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_operador' => 'Id Operador',
            'nombre_operador' => 'Nombre Operador',
            'id_estatus' => 'Id Estatus',
        ];
    }
}
