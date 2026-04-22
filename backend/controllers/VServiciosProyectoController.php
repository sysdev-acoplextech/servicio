<?php

namespace backend\controllers;

use backend\models\DetalleFactura;
use backend\models\ServicioPago;
use backend\models\Servicios;
use Yii;
use backend\models\VServiciosProyecto;
use backend\models\VServiciosProyectoSearch;
use backend\models\DetalleFacturaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\IntegrityException;

/**
 * VServiciosProyectoController implements the CRUD actions for VServiciosProyecto model.
 */
class VServiciosProyectoController extends Controller
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
     * Lists all VServiciosProyecto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VServiciosProyectoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 0);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VServiciosProyecto model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model2 = new DetalleFactura();

        if ($model2->load(Yii::$app->request->post())) {

            $item = substr($model2->item_seleccionados, 0, -1);

            $fecha = explode("-", $model2->fecha_factura);
            $model2->fecha_factura = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
            $model2->id_servicios = $item;
            $model2->subtotal = $model2->monto_bs - $model2->iva;
            $model2->fecha_emision = date('Y-m-d');
            $model2->save(false);

            $item = explode(",", $item);
            for ($i = 0; $i < count($item); $i++) {

                Servicios::updateAll(
                    [
                        'facturado' =>  1,
                    ],
                    'id_servicio= ' . $item[$i]
                );
            }

            \Yii::$app->getSession()->setFlash('success', '<center><h2><b>Factura registrada con éxito</b></h2></center> ');

            return $this->redirect(['index']);
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
                'model2' => $model2,
            ]);
        }
    }

    public function actionFacturas2($id_cliente)
    {
        $model2 = new DetalleFactura();
        $model3 = new ServicioPago();
        $model = VServiciosProyecto::find()->where(['id_cliddddente' => $id_cliente])->one();

        if ($model2->load(Yii::$app->request->post())) {
        } else {
            return $this->render('facturas', [
                'model' => $model,
                'model2' => $model2,
                'model3' => $model3,
            ]);
        }
    }

    public function actionFacturas($id_cliente)
    {
        $searchModel = new DetalleFacturaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id_cliente);
        $model = VServiciosProyecto::find()->where(['id_cliente' => $id_cliente])->one();
        $model3 = new ServicioPago();

        return $this->render('facturas', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'model3' => $model3,
        ]);
    }

    public function actionPagar($id, $id_cliente)
    {
        $model2 = DetalleFactura::find()->where(['id_detallefactura' => $id])->one();
        $model = new ServicioPago();

        $model3 = ServicioPago::find()->where(['id_factura' => $id])->all();


        if ($model->load(Yii::$app->request->post())) {

            try {
                $fecha = explode("/", $model->fecha_pago);
                $model->fecha_pago = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];

                $model->monto = $model->monto;
                $model->referencia = $model->referencia;
                $model->tipo_pago = $model->tipo_pago;
                $model->id_metodo = $model->id_metodo;
                $model->banco_origen = $model->banco_origen;
                $model->observacion_pago = $model->observacion_pago;
                $model->id_tipo_moneda = $model->id_tipo_moneda;
                $model->id_factura = $model->id_factura;
                $model->procedencia = 'Pago registrado para la factura por proyecto';
                $model->pagada_factura = TRUE;
                $model->save(false);

                if ($model->tipo_pago == 'Total') {
                    $model2->pagada = 1;
                    $model2->save(false);
                }

                \Yii::$app->getSession()->setFlash('success', '<center><h2><b>Registro exitoso.</b></h2></center> ');
                return $this->redirect(['facturas', 'id_cliente' => $_POST['ServicioPago']['id_cliente']]);
            } catch (IntegrityException $e) {
                // Manejo de la excepción
                Yii::$app->session->setFlash('error', 'Debe llenar todos los campos relacionados al pago de la factura..');
            }
        }


        return $this->render('../servicio-pago/create', [
            'model' => $model,
            'model2' => $model2,
            'model3' => $model3,
            'id_cliente' => $id_cliente,
        ]);
    }

    /**
     * Creates a new VServiciosProyecto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VServiciosProyecto();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_servicio]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing VServiciosProyecto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_servicio]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing VServiciosProyecto model.
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
     * Finds the VServiciosProyecto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VServiciosProyecto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VServiciosProyecto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
