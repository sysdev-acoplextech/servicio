<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "estado_cuenta".
 *
 * @property int $idestado_cuenta
 * @property string $fecha_transaccion
 * @property string $referencia
 * @property string $monto
 * @property int $operador
 * @property string $fecha_registro
 * @property string $hora
 * @property int $conciliado
 * @property int $eliminado
 * @property string $numero_cuenta
 * @property string $tipo_transaccion
 * @property int $id_categoria
 *
 * @property User $operador0
 */
class EstadoCuenta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $file;
    public static function tableName()
    {
        return 'estado_cuenta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_transaccion', 'fecha_registro', 'hora'], 'safe'],
            [['monto'], 'number'],
            [['operador', 'conciliado', 'eliminado', 'id_categoria'], 'integer'],
            [['referencia'], 'string', 'max' => 255],
            [['numero_cuenta'], 'string', 'max' => 20],
            [['tipo_transaccion'], 'string', 'max' => 1],
              [['file'], 'file', 'extensions'=>'txt, csv'],
            [['file'], 'file', 'maxSize'=>'100000000'],
            [['operador'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['operador' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idestado_cuenta' => 'Idestado Cuenta',
            'fecha_transaccion' => 'Fecha Transaccion',
            'referencia' => 'Referencia',
            'monto' => 'Monto',
            'operador' => 'Operador',
            'fecha_registro' => 'Fecha Registro',
            'hora' => 'Hora',
            'conciliado' => 'Conciliado',
            'eliminado' => 'Eliminado',
            'numero_cuenta' => 'Numero Cuenta',
            'tipo_transaccion' => 'Tipo Transaccion',
            'id_categoria' => 'Id Categoria',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperador0()
    {
        return $this->hasOne(User::className(), ['id' => 'operador']);
    }

      public function getCuentaBancaria()
    {
        return $this->hasOne(CuentasBancarias::class, ['numero_cuenta' => 'numero_cuenta']);
    }

        public function getCategoriaGasto()
    {
        // id_categoria es la FK en estado_cuenta, id_categoria_gasto es la PK en categoria_gastos
        return $this->hasOne(CategoriaGastos::class, ['id_categoria_gasto' => 'id_categoria']);
    }
}
