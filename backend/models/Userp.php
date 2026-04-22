<?php
namespace backend\models; 
use Yii;
use yii\base\model;

use backend\models\Empresa;
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
 * @property int $id_conjunto
 * @property string $fecha_creacion
 * @property string $fecha_modifica
 * @property string $codigo_convenio
 */
class Userp extends \yii\db\ActiveRecord
{
 /**
  * {@inheritdoc}
  */


public $rif_empresa;

 public static function tableName()
 {
  return 'user';
}
 /**
  * {@inheritdoc}
  */
 public function rules()
 {
  return [
     [[   'nacionalidad', 'nombres', 'apellidos', 'cedula' ], 'required'],
     ['email',   'email' ],
     [['status', 'created_at', 'updated_at', 'activate', 'id_role', 'id_conjunto'], 'default', 'value' => null],
     [['status', 'created_at', 'updated_at', 'activate', 'id_role', 'id_conjunto', 'id_gerencia', 'id_fuente_financiamiento', 'id_empresa'], 'integer'],
     [['fecha_creacion', 'fecha_modifica', 'rif_empresa'], 'safe'],
     [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
     [['auth_key'], 'string', 'max' => 32],
     
     ['rif_empresa', 'match', 'pattern' => '/[VEJGvejg][0123456789]{1,15}/'],
     [['accessToken'], 'string', 'max' => 250],
     [['nombres', 'apellidos', 'codigo_convenio'], 'string', 'max' => 100],
     [['nacionalidad'], 'string', 'max' => 1],
     [['telefono_oficina', 'telefono_celular', 'cedula'], 'string', 'max' => 20],
     // [['telefono_oficina', 'telefono_celular', 'cedula'], 'number'],
 ];
} 
  /**
  * {@inheritdoc}
  */
 public function attributeLabels()
 {
  return [
     'id' => Yii::t('app', 'ID'),
     'username' => Yii::t('app', 'Acceso'),
     'auth_key' => Yii::t('app', 'llave de Usuario'),
     'password_hash' => Yii::t('app', 'Password Hash'),
     'password_reset_token' => Yii::t('app', 'Password Reset Token'),
     'email' => Yii::t('app', 'Correo'),
     'repeatPassword' => Yii::t('app', 'Confirmar  Contraseña'),
     'password' => Yii::t('app', 'Contraseña'),
     'status' => Yii::t('app', 'Estatus'),
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
     'id_conjunto' => Yii::t('app', 'Id Conjunto'),
     'fecha_creacion' => Yii::t('app', 'Fecha Creacion'),
     'fecha_modifica' => Yii::t('app', 'Fecha Modifica'),
     'codigo_convenio' => Yii::t('app', 'Código Convenio'),
     'id_gerencia' => Yii::t('app', 'Unidad Administrativa'),
     'id_empresa' => Yii::t('app', 'Empresa'),
     'rif_empresa' => Yii::t('app', 'Rif de la Empresa'),
     'id_fuente_financiamiento' => Yii::t('app', 'Fuente de Financiamiento'),
 ];
}
public function setPassword($password)
{
  return $this->password_hash = Yii::$app->security->generatePasswordHash($password);
}
public function generateAuthKey()
{ 
  return $this->auth_key = Yii::$app->security->generateRandomString();
}
}
