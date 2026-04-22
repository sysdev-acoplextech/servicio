<?php

namespace backend\controllers;

use Yii;
use backend\models\Tarifario;
use backend\models\TarifarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\DetalleTarifario;

/**
 * TarifarioController implements the CRUD actions for Tarifario model.
 */
class TarifarioController extends Controller
{

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

    public function actionIndex()
    {
        $searchModel = new TarifarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Tarifario();

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save()) {
                    $detalles = Yii::$app->request->post('Detalle');
                    if ($detalles) {
                        foreach ($detalles as $item) {
                            // Omitir si la ruta está vacía
                            if (empty($item['rutas'])) continue;

                            $detalle = new DetalleTarifario();
                            $detalle->id_tarifario = $model->id_tarifario;
                            $detalle->rutas = $item['rutas'];

                            // --- AJUSTE AQUÍ: Captura del Viático ---
                            // Si el checkbox no se marca, no llega en el post, por eso usamos isset o el operador null coalescing
                            $detalle->inc_viatico = isset($item['inc_viatico']) ? $item['inc_viatico'] : 0;

                            // Formateo de moneda de '1.500,50' a '1500.50' para DB
                            $detalle->sedan = str_replace(['.', ','], ['', '.'], $item['sedan']);
                            $detalle->camioneta = str_replace(['.', ','], ['', '.'], $item['camioneta']);

                            if (!$detalle->save()) {
                                // Si quieres ver el error específico de validación del detalle:
                                $errors = implode("<br>", \yii\helpers\ArrayHelper::getColumn($detalle->getErrors(), 0));
                                throw new \Exception("Error en detalle: " . $errors);
                            }
                        }
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id_tarifario]);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Obtenemos los detalles actuales para la carga inicial de la vista
        $detalles = $model->detalles;

        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save()) {
                    // 1. Limpiamos los detalles anteriores para evitar duplicados
                    \backend\models\DetalleTarifario::deleteAll(['id_tarifario' => $model->id_tarifario]);

                    $post = Yii::$app->request->post('Detalle', []);
                    foreach ($post as $data) {
                        if (!empty($data['rutas'])) {
                            $d = new \backend\models\DetalleTarifario();
                            $d->id_tarifario = $model->id_tarifario;
                            $d->rutas = $data['rutas'];

                            // --- AJUSTE AQUÍ: Captura del Viático ---
                            $d->inc_viatico = isset($data['inc_viatico']) ? $data['inc_viatico'] : 0;

                            // Formateo de moneda de '1.500,50' a '1500.50' para DB
                            $d->sedan = str_replace(['.', ','], ['', '.'], $data['sedan']);
                            $d->camioneta = str_replace(['.', ','], ['', '.'], $data['camioneta']);

                            if (!$d->save()) {
                                $errors = implode("<br>", \yii\helpers\ArrayHelper::getColumn($d->getErrors(), 0));
                                throw new \Exception("Error al actualizar ruta: " . $errors);
                            }
                        }
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id_tarifario]);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $model,
            'detalles' => $detalles,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Tarifario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionExportPdf()
{
    $tarifarios = Tarifario::find()->all();
    
    $pdf = new \kartik\mpdf\Pdf([
        'mode' => \kartik\mpdf\Pdf::MODE_UTF8,
        'format' => \kartik\mpdf\Pdf::FORMAT_A4,
        'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
        'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
        'content' => $this->renderPartial('_pdf_report', ['tarifarios' => $tarifarios]),
        'cssInline' => '
            body { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; color: #334155; }
            .header-pdf { border-bottom: 2px solid #F1F5F9; padding-bottom: 20px; margin-bottom: 30px; }
            .title { font-size: 24pt; font-weight: bold; color: #1E293B; }
            .card { border: 1px solid #E2E8F0; border-radius: 15px; padding: 20px; margin-bottom: 30px; }
            .tarifario-title { font-size: 14pt; color: #6366F1; font-weight: bold; margin-bottom: 15px; text-transform: uppercase; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            th { background: #F8FAFC; color: #64748B; font-size: 8pt; text-transform: uppercase; padding: 12px; text-align: left; border-bottom: 1px solid #E2E8F0; }
            td { padding: 12px; font-size: 9.5pt; border-bottom: 1px solid #F1F5F9; }
            .text-right { text-align: right; }
            .badge { background: #DCFCE7; color: #166534; padding: 3px 8px; border-radius: 8px; font-size: 7pt; }
            .footer { font-size: 8pt; color: #94A3B8; text-align: center; }
        ',
        'options' => ['title' => 'Reporte de Tarifarios'],
        'methods' => [
            'SetFooter' => ['Generado el: {DATE j-m-Y} | Página {PAGENO} | Tarifario App'],
        ]
    ]);
    
    return $pdf->render();
}
}
