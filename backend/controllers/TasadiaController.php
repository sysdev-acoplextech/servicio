<?php

namespace backend\controllers;

use Yii;
use backend\models\Tasadia;
use backend\models\TasadiaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TasadiaController implements the CRUD actions for Tasadia model.
 */
class TasadiaController extends Controller
{
    /**
     * @inheritdoc
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

    /**
     * Lists all Tasadia models.
     * @return mixed
     */
    /*public function actionIndex()
    {
        $searchModel = new TasadiaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }*/

    public function actionIndex()
    {
        $connection = \Yii::$app->db;

        $command = $connection->createCommand("SELECT FORMAT(valor,2,'de_DE') as valor,
                 valor as valor_s,
                DATE_FORMAT(fecha_hora,'%d/%m/%Y %H:%i:%s') as fecha_hora, usuario
            FROM tasadia WHERE id_estatus = 1");
        $model = $command->queryall();


        return $this->render('index', [
            'model' => $model,
        ]);

    }

    /**
     * Displays a single Tasadia model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tasadia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {  
        $model = new Tasadia();

        $model->updateAll(
        [
            'id_estutus' => 0,
        ],
        'id_estatus= 1' 
         );

                

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

          
            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tasadia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        
        $usuario = Yii::$app->user->identity->username;

        $model = Tasadia::find()->where(['id_estatus' => 1])->one();
       

        if ($model->load(Yii::$app->request->post())) {


            $model->updateAll(
                [
                    'id_estatus' => 0,
                ],
                'id_estatus= 1' 
                 );
            $model = new Tasadia();
            $model->valor=$_POST['Tasadia']['valor'];
            $model->usuario=$usuario;
            $model->fecha_hora=date('Y-m-d H:i:s');
            $model->id_estatus=1;
            $model->save(false);

        \Yii::$app->getSession()->setFlash('success', 'Actualizado Exitosamente');

            return $this->redirect(['index']);

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tasadia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tasadia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tasadia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
        protected function findModel($id)
    {
        if (($model = Tasadia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
