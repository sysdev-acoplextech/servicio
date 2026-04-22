<?php

namespace backend\controllers;

use Yii;
use backend\models\BaseModelo;
use backend\models\BaseModeloSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * BaseModeloController implements the CRUD actions for BaseModelo model.
 */
class BaseModeloController extends Controller
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

    /**
     * Lists all BaseModelo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BaseModeloSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BaseModelo model.
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
     * Creates a new BaseModelo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BaseModelo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BaseModelo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BaseModelo model.
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

    /**
     * Finds the BaseModelo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BaseModelo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BaseModelo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionCategoria()
    {     
       $out = [];
       if (isset($_POST['depdrop_parents'])) {
          $parents = $_POST['depdrop_parents'];
          if ($parents != null) 
          { 
              $id_marca = $parents[0];
             if ($id_marca) {
                $categoria=BaseModelo::find()->where(['id_marca'=>$id_marca])->orderBy(['nombre_modelo'=>SORT_ASC])->all(); 
                $out=[];
                if (count($categoria)>0) {
                   foreach ($categoria as $key => $value) 
                   {
                      $out[$key]=['id'=>$value->id,'name'=>$value->nombre_modelo];
                  }
              }else
              {
                $out=['id'=>'','name'=>''];      
            }
            echo Json::encode(['output'=>$out, 'selected'=>'']);
            return;
        }else
        {
            echo Json::encode(['output'=>'', 'selected'=>'']);
        }
    }
}
echo Json::encode(['output'=>'', 'selected'=>'']);
}

public function actionListarsubcategoria() {
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $dep_id = $parents[0];
            //$hoy = date('Y-m-d');
            //$out = self::getSubCatList($cat_id);
            $out = yii\helpers\ArrayHelper::toArray(BaseModelo::find()->where([ 'id_marca'=>$dep_id])
                ->andFilterWhere(['estatus'=>1])
                ->orderBy('nombre_modelo')->all(), 'id', 'nombre_modelo');
            $response = array();
            foreach ($out as $row) {
              $arr['id'] = trim($row['id']);
              $arr['name'] = trim($row['nombre_modelo']);
              array_push($response, $arr);
            }
            echo \yii\helpers\Json::encode(['output'=>$response, 'selected'=>'']);
            return;
        }
    }
    echo Json::encode(['output'=>'', 'selected'=>'']);
}

}
