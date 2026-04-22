<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cierre_diario".
 *
 * @property int $idcierre
 * @property string $fecha_cierre
 * @property string $numero_cuenta
 * @property string $saldo_sistema
 * @property string $saldo_bancario
 * @property string $diferencia
 * @property int $id_operador
 * @property string $observaciones
 */
class CierreDiario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cierre_diario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_cierre', 'numero_cuenta', 'saldo_sistema', 'saldo_bancario', 'diferencia', 'id_operador'], 'required'],
            [['fecha_cierre'], 'safe'],
            [['saldo_sistema', 'saldo_bancario', 'diferencia'], 'number'],
            [['id_operador'], 'integer'],
            [['observaciones'], 'string'],
            [['numero_cuenta'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idcierre' => 'Idcierre',
            'fecha_cierre' => 'Fecha Cierre',
            'numero_cuenta' => 'Numero Cuenta',
            'saldo_sistema' => 'Saldo Sistema',
            'saldo_bancario' => 'Saldo Bancario',
            'diferencia' => 'Diferencia',
            'id_operador' => 'Id Operador',
            'observaciones' => 'Observaciones',
        ];
    }
}
