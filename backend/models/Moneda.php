<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "moneda".
 *
 * @property int $id_moneda
 * @property string $nombre_moneda
 * @property string $simbolo
 * @property int $idestatus
 */
class Moneda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'moneda';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_moneda', 'simbolo'], 'required'],
            [['idestatus'], 'integer'],
            [['nombre_moneda'], 'string', 'max' => 15],
            [['simbolo'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_moneda' => 'Id Moneda',
            'nombre_moneda' => 'Nombre Moneda',
            'simbolo' => 'Simbolo',
            'idestatus' => 'Idestatus',
        ];
    }
}
