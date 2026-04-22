<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cuentas_bancarias".
 *
 * @property int $id_cuentas
 * @property string $numero_cuenta
 * @property string $descripcion
 * @property int $estatus
 * @property int $id_usuario
 * @property string $fecha_registro
 * @property string $hora
 * @property int $id_banco
 * @property int $id_tipo_moneda
 * @property int $id_tipo_cuenta
 * @property string $saldo
 * @property string $fecha_saldo_inicial
 *
 * @property Banco $banco
 * @property TipoCuenta $tipoCuenta
 * @property TipoMoneda $tipoMoneda
 */
class CuentasBancarias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cuentas_bancarias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estatus', 'id_usuario', 'id_banco', 'id_tipo_moneda', 'id_tipo_cuenta'], 'integer'],
            [['fecha_registro', 'hora', 'fecha_saldo_inicial'], 'safe'],
            [['saldo'], 'number'],
            [['numero_cuenta'], 'string', 'max' => 20],
            [['descripcion'], 'string', 'max' => 255],
            [['id_banco'], 'exist', 'skipOnError' => true, 'targetClass' => Banco::className(), 'targetAttribute' => ['id_banco' => 'idbanco']],
            [['id_tipo_cuenta'], 'exist', 'skipOnError' => true, 'targetClass' => TipoCuenta::className(), 'targetAttribute' => ['id_tipo_cuenta' => 'id_tipo_cuenta']],
            [['id_tipo_moneda'], 'exist', 'skipOnError' => true, 'targetClass' => TipoMoneda::className(), 'targetAttribute' => ['id_tipo_moneda' => 'id_tipo_moneda']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cuentas' => 'Id Cuentas',
            'numero_cuenta' => 'Número Cuenta',
            'descripcion' => 'Descripción',
            'estatus' => 'Estatus',
            'id_usuario' => 'Usuario',
            'fecha_registro' => 'Fecha Registro',
            'hora' => 'Hora',
            'id_banco' => 'Banco',
            'id_tipo_moneda' => 'Tipo de Moneda',
            'id_tipo_cuenta' => 'Tipo de Cuenta',
            'saldo' => 'Saldo',
            'fecha_saldo_inicial' => 'Fecha de corte Saldo Inicial',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanco()
    {
        return $this->hasOne(Banco::className(), ['idbanco' => 'id_banco']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoCuenta()
    {
        return $this->hasOne(TipoCuenta::className(), ['id_tipo_cuenta' => 'id_tipo_cuenta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoMoneda()
    {
        return $this->hasOne(TipoMoneda::className(), ['id_tipo_moneda' => 'id_tipo_moneda']);
    }

    
}
