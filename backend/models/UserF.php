<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $accessToken
 * @property int $activate
 * @property int $id_role
 * @property string $nombres
 * @property string $apellidos
 * @property string $nacionalidad
 * @property string $telefono_oficina
 * @property string $telefono_celular
 * @property string $cedula
 * @property string $fecha_creado
 * @property int $id_gerencia
 */
class UserF extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db4');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email'], 'required'],
            [['status', 'created_at', 'updated_at', 'activate', 'id_role', 'id_gerencia'], 'default', 'value' => null],
            [['status', 'created_at', 'updated_at', 'activate', 'id_role', 'id_gerencia'], 'integer'],
            [['fecha_creado'], 'safe'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['accessToken'], 'string', 'max' => 250],
            [['nombres', 'apellidos'], 'string', 'max' => 100],
            [['nacionalidad'], 'string', 'max' => 1],
            [['telefono_oficina', 'telefono_celular', 'cedula'], 'string', 'max' => 20],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'accessToken' => Yii::t('app', 'Access Token'),
            'activate' => Yii::t('app', 'Activate'),
            'id_role' => Yii::t('app', 'Id Role'),
            'nombres' => Yii::t('app', 'Nombres'),
            'apellidos' => Yii::t('app', 'Apellidos'),
            'nacionalidad' => Yii::t('app', 'Nacionalidad'),
            'telefono_oficina' => Yii::t('app', 'Telefono Oficina'),
            'telefono_celular' => Yii::t('app', 'Telefono Celular'),
            'cedula' => Yii::t('app', 'Cedula'),
            'fecha_creado' => Yii::t('app', 'Fecha Creado'),
            'id_gerencia' => Yii::t('app', 'Id Gerencia'),
        ];
    }
}
