<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "banco".
 *
 * @property int $idbanco
 * @property string $nom_banco
 * @property int $operador
 * @property string $fecha
 * @property string $hora
 * @property int $eliminado
 * @property string $cod_sudeban
 * @property string $nom_corto
 *
 * @property User $operador0
 * @property CuentasBancarias[] $cuentasBancarias
 */
class Banco extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banco';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nom_banco'], 'required'],
            [['operador', 'eliminado'], 'integer'],
            [['fecha', 'hora'], 'safe'],
            [['nom_banco'], 'string', 'max' => 100],
            [['cod_sudeban'], 'string', 'max' => 20],
            [['nom_corto'], 'string', 'max' => 50],
            [['operador'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['operador' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idbanco' => 'Idbanco',
            'nom_banco' => 'Nom Banco',
            'operador' => 'Operador',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'eliminado' => 'Eliminado',
            'cod_sudeban' => 'Cod Sudeban',
            'nom_corto' => 'Nom Corto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperador0()
    {
        return $this->hasOne(User::className(), ['id' => 'operador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuentasBancarias()
    {
        return $this->hasMany(CuentasBancarias::className(), ['id_banco' => 'idbanco']);
    }
}
