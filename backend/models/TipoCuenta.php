<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tipo_cuenta".
 *
 * @property int $id_tipo_cuenta
 * @property string $nombre_tipo_cuenta
 * @property int $operador
 * @property string $fecha
 * @property string $hora
 * @property int $eliminado
 *
 * @property CuentasBancarias[] $cuentasBancarias
 * @property User $operador0
 */
class TipoCuenta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_cuenta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_tipo_cuenta'], 'required'],
            [['operador', 'eliminado'], 'integer'],
            [['fecha', 'hora'], 'safe'],
            [['nombre_tipo_cuenta'], 'string', 'max' => 100],
            [['operador'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['operador' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_cuenta' => 'Id Tipo Cuenta',
            'nombre_tipo_cuenta' => 'Nombre Tipo Cuenta',
            'operador' => 'Operador',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'eliminado' => 'Eliminado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuentasBancarias()
    {
        return $this->hasMany(CuentasBancarias::className(), ['id_tipo_cuenta' => 'id_tipo_cuenta']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperador0()
    {
        return $this->hasOne(User::className(), ['id' => 'operador']);
    }
}
