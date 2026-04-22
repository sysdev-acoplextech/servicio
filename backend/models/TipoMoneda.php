<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tipo_moneda".
 *
 * @property int $id_tipo_moneda
 * @property string $moneda
 * @property string $cod_moneda
 * @property int $estatus
 *
 * @property CuentasBancarias[] $cuentasBancarias
 */
class TipoMoneda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_moneda';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estatus'], 'integer'],
            [['moneda'], 'string', 'max' => 20],
            [['cod_moneda'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_moneda' => 'Id Tipo Moneda',
            'moneda' => 'Moneda',
            'cod_moneda' => 'Cod Moneda',
            'estatus' => 'Estatus',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuentasBancarias()
    {
        return $this->hasMany(CuentasBancarias::className(), ['id_tipo_moneda' => 'id_tipo_moneda']);
    }
}
