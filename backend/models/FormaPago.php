<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "forma_pago".
 *
 * @property int $id_forma_pago
 * @property string $descripcion
 * @property int $estatus
 */
class FormaPago extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forma_pago';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estatus'], 'integer'],
            [['descripcion'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_forma_pago' => 'Id Forma Pago',
            'descripcion' => 'Descripcion',
            'estatus' => 'Estatus',
        ];
    }
}
