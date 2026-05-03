<?php

namespace backend\controllers;

use Yii;
use backend\models\CotizacionRapida;
use backend\models\CotizacionRapidaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CotizacionRapidaController implements the CRUD actions for CotizacionRapida model.
 */
class CotizacionRapidaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CotizacionRapida models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CotizacionRapidaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CotizacionRapida model.
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
     * Creates a new CotizacionRapida model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CotizacionRapida();

        if ($model->load(Yii::$app->request->post())) {
            
            // 1. Limpiar los formatos de moneda antes de guardar
            // Convertimos "1.250,50" -> 1250.50
            $model->monto_base = $this->cleanNumber($model->monto_base);
            $model->monto_recargo = $this->cleanNumber($model->monto_recargo);
            $model->monto_viatico = $this->cleanNumber($model->monto_viatico);
            $model->monto_total = $this->cleanNumber($model->monto_total);

            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Oportunidad guardada correctamente.");
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

   protected function cleanNumber($value)
    {
        if (empty($value)) return 0;
        $number = str_replace('.', '', $value); // Quita separador de miles
        $number = str_replace(',', '.', $number); // Cambia coma por punto decimal
        return (float)$number;
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_cotizacion]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CotizacionRapida model.
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
     * Finds the CotizacionRapida model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CotizacionRapida the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CotizacionRapida::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
