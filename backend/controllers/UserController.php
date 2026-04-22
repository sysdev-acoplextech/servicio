<?php

namespace backend\controllers;
 
use yii\data\ActiveDataProvider;   
use mdm\admin\components\Configs;
use yii\filters\AccessControl;
use backend\models\ChangePassword;

use mdm\admin\components\Helper;
use Yii;
use backend\models\Userp;
use backend\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

public function beforeAction($action)
{
    if (!parent::beforeAction($action))
    {
        return false;
    }
    $operacion = Yii::$app->controller->route;
    $permitirSiempre = ['site-captcha', 'site-signup', 'site-index', 'site-error', 'site-contact', 'site-login', 'site-logout'];
    if (in_array($operacion, $permitirSiempre)) {
        return true;
    }
    $ll=Helper::checkRoute($operacion, []);
    if (!$ll) {
        $name='404';
        $message='Página no encontrada';
        echo $this->render('/site/error', ['message'=>$message,'name'=>$name]);
        return false;
    }
    return true;
}
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     private function randKey($str='', $long=0)
     {
         $key=null;
         $str=str_split($str);
         $start=0;
         $limit= count($str)-1;
         for($x=0; $x<$long; $x++)
         {
             $key .=$str[rand($start, $limit)];
         }
         return $key;
     }
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) /*&& $model->save()*/) {
            // $variables=Yii::$app->request->post();



            $model->auth_key=$this->generateAuthKey();
           $model->password_hash=$this->setPassword($model->password);

           $model->accessToken=$this->generateAccessToken();
           $model->fecha_creacion=date('d-m-Y');
           $model->status=10;
           $model->created_at=0;
           $model->updated_at=0;



            if($model->save())
            {


            $manager = Configs::authManager();
            $item = $manager->getRole('inicio');
            $item = $item ?: $manager->getPermission('inicio');
            $manager->assign($item, $model->id);
            return $this->redirect(['view', 'id' => $model->id]);
            }else
            {

                return $this->render('create', [
                    'model' => $model,
                ]);                
            }


        



        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = Userp::find()->where(['id'=>$id])->one();
        // $model = $this->findModel($id);
        // $connection = \Yii::$app->db;
        if ($model->load(Yii::$app->request->post())) {
         // $nombres=$model->nombres;
         // $apellidos=$model->apellidos;
         // $nacionalidad=$model->nacionalidad;
         // $telefono_oficina=$model->telefono_oficina;
         // $telefono_celular=$model->telefono_celular;
         // $codigo_convenio=$model->codigo_convenio;
// echo "<pre>";
// print_r($model);die;
// $model->fecha_creacion=date('d-m-Y');
//            $model->status=10;
//            $model->created_at=0;
//            $model->updated_at=0;

if ($model->save()) {
         return $this->redirect(['view', 'id' => $id]);  
 }



         // $command = $connection->createCommand("
         //     UPDATE public.user
         //     SET
         //     nombres = '".$nombres."',
         //     apellidos = '".$apellidos."',
         //     nacionalidad = '".$nacionalidad."',
         //     telefono_oficina = '".$telefono_oficina."',
         //     codigo_convenio = '".$codigo_convenio."',
         //     telefono_celular = '".$telefono_celular."'
         //     WHERE
         //     id = $id;");
         // $model = $command->queryOne();
     }
     return $this->render('update', [
        'model' => $model,
    ]);
 }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionEstatus($id)
    {
        $model=$this->findModel($id);



        if ($model->status==10) 
        {
          $model->status=9;
      }else
      {
          $model->status=10;

      }

         User::updateAll([
            'status' => $model->status, 
        ], 
            ['id' => $id]);











        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */


    public function actionCambiarclave($id)
    {
        $model = new ChangePassword();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->change2($id)) {
            return $this->render('view', [
            'model' => $this->findModel($id),
            ]);
        }

        $modelUser= User::findOne($id);
        return $this->render('cambiarclave', [
                'model' => $model,
                'modelUser' => $modelUser,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
     public   function findIdentity($id)
    {
        return   User::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
    /**
     * @inheritdoc
     */
    public   function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public   function findByUsername($username)
    {
        return User::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public   function findByPasswordResetToken($token)
    {
        if (!User::isPasswordResetTokenValid($token)) {
            return null;
        }
        return User::findOne([
                'password_reset_token' => $token,
                'status' => self::STATUS_ACTIVE,
        ]);
    }
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public   function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {

        return $this->getAuthKey() === $authKey;
    }
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        $model = new User();
        return Yii::$app->security->validatePassword($password, $model->password_hash);
    }
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $model = new User();
        return $model->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $model = new User();
        return $model->auth_key = Yii::$app->security->generateRandomString();
    }
    public function generateAccessToken()
    {
       $model = new User();
        return $model->accessToken = Yii::$app->security->generateRandomString();
    }
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
       $model = new User();
        return $model->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $model = new User();
        return $model->password_reset_token = null;
    }
    /***********************************************/
}
