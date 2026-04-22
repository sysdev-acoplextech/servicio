<?php

namespace backend\controllers;

use Yii;
use backend\models\CuentasBancarias;
use backend\models\CuentasBancariasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CuentasBancariasController implements the CRUD actions for CuentasBancarias model.
 */
class CuentasBancariasController extends Controller
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
     * Lists all CuentasBancarias models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CuentasBancariasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // 1. Sumar saldos iniciales de cuentas en Bolívares (id_tipo_moneda = 1)
        $saldoInicialTotal = \backend\models\CuentasBancarias::find()
            ->where(['id_tipo_moneda' => 1, 'estatus' => 1])
            ->sum('saldo') ?: 0;

        // 2. Sumar movimientos (monto) de estado_cuenta que pertenezcan a cuentas en Bolívares
        // Usamos Query Builder para evitar cargar modelos pesados
        $movimientosTotal = (new \yii\db\Query())
            ->from('estado_cuenta ec')
            ->innerJoin('cuentas_bancarias cb', 'ec.numero_cuenta = cb.numero_cuenta')
            ->where(['cb.id_tipo_moneda' => 1])
            ->andWhere(['ec.eliminado' => 0])
            ->sum('ec.monto') ?: 0;

        // Filtramos para mostrar solo las activas en el dashboard
        $cuentasActivas = \backend\models\CuentasBancarias::find()
            ->where(['estatus' => 1])
            ->with(['banco', 'tipoMoneda'])
            ->all();

        // Cálculo final del disponible real
        $disponibleTotal = $saldoInicialTotal + $movimientosTotal;

        $pendientesCategorizar = (new \yii\db\Query())
            ->from('estado_cuenta')
            ->where(['id_categoria' => null])
            ->andWhere(['eliminado' => 0])
            ->count();

            $ultimoMovimiento = \backend\models\EstadoCuenta::find()
        ->where(['eliminado' => 0])
        ->orderBy(['idestado_cuenta' => SORT_DESC])
        ->one();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'disponibleTotal' => $disponibleTotal,
            'pendientesCategorizar' => $pendientesCategorizar,
            'cuentasActivas' => $cuentasActivas, 
            'ultimoMovimiento' => $ultimoMovimiento,// Enviamos el dato a la vista
        ]);
    }

    /**
     * Displays a single CuentasBancarias model.
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
     * Creates a new CuentasBancarias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CuentasBancarias();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_cuentas]);
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CuentasBancarias model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_cuentas]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CuentasBancarias model.
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
     * Finds the CuentasBancarias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CuentasBancarias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CuentasBancarias::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
