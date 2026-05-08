<?php

namespace backend\controllers;

use Yii;
use backend\models\Empresa;
use backend\models\CarteraCrediCplazo;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\FirmasGerentes;
use backend\models\Finiquito;
use backend\models\GeoEstado;
use yii\db\Expression;
use common\models\LoginForm;
use kartik\mpdf\Pdf;
use backend\models\ServicioPago;
use backend\models\Servicios;
use backend\models\VServicios;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'qr'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'index-lp', 'qr','configuraciones'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    /*public function beforeAction($action)
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
}*/
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    /**
     * Displays homepage.
     *
     * @return string
     */

public function actionIndex()
{
    $connection = \Yii::$app->db;
    $hoy = date('Y-m-d');
    $mes = date('n');
    $anio = date('Y');

    // 1. Tasa del Día
    $tasaDia = \backend\models\Tasadia::find()
        ->where(['id_estatus' => 1])
        ->orderBy(['fecha_hora' => SORT_DESC])
        ->one();

    // 2. Contadores de Servicios (Por Estatus)
    // Asumiendo que: 1 = Agendado/Pendiente, 2 = Confirmado, 3 = Concretado/Finalizado
    $serviciosAgendados = \backend\models\Servicios::find()->where(['id_estatus' => 5])->count();
    $serviciosConfirmados = \backend\models\Servicios::find()->where(['confirmado' => TRUE])->count();
    $serviciosHoy = \backend\models\Servicios::find()->where(['fecha_servicio' => $hoy])->count();

    // 3. Finanzas del Día
    $pagosHoyCount = \backend\models\ServicioPago::find()
        ->where(['date(fecha_pago)' => $hoy])
        ->count();

    $montoMes = $connection->createCommand("SELECT SUM(monto) FROM servicio_pago WHERE MONTH(fecha_pago) = $mes AND YEAR(fecha_pago) = $anio")->queryScalar() ?: 0;

    // 4. Tipos de Pago Recibidos HOY
    $tiposPagoHoy = \backend\models\ServicioPago::find()
        ->select([new \yii\db\Expression('count(id_pago) as id_servicio'), 'tipo_pago'])
        ->where(['date(fecha_pago)' => $hoy])
        ->groupBy(['tipo_pago'])
        ->all();

    // 5. Gráfico: Histórico 6 meses
    $salesData = [];
    for ($i = 5; $i >= 0; $i--) {
        $m = date('n', strtotime("-$i months"));
        $y = date('Y', strtotime("-$i months"));
        $monto = $connection->createCommand("SELECT SUM(monto) FROM servicio_pago WHERE MONTH(fecha_pago) = $m AND YEAR(fecha_pago) = $y")->queryScalar() ?: 0;
        $salesData[] = ['month' => date('M', strtotime("-$i months")), 'total_sales' => $monto];
    }

    // 6. Ranking de Conductores (Mes)
   $conductoresActivos = \backend\models\VServicios::find()
    ->select([
        new \yii\db\Expression('count(id_servicio) as total'), 
        'conductor',
        'foto' // Asegúrate de incluir el campo de la imagen aquí
    ])
    ->where(['MONTH(fecha_registro)' => date('n'), 'YEAR(fecha_registro)' => date('Y')])
    ->andWhere(['is not', 'conductor', null])
    ->groupBy(['conductor', 'foto']) // Añade foto al groupBy
    ->orderBy(['total' => SORT_DESC])
    ->limit(6)
    ->all();

    return $this->render('../dashboard/index', [
        'tasaDia' => $tasaDia,
        'serviciosAgendados' => $serviciosAgendados,
        'serviciosConfirmados' => $serviciosConfirmados,
        'serviciosHoy' => $serviciosHoy,
        'pagosHoyCount' => $pagosHoyCount,
        'montoMes' => $montoMes,
        'tiposPagoHoy' => $tiposPagoHoy,
        'salesData' => $salesData,
        'conductoresActivos' => $conductoresActivos,
    ]);
}
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    //qr finiquito
    public function actionQr($ce, $cod)
    {
        $codigo = Yii::$app->getSecurity()->decryptByPassword($cod, $ce);
        $model = Finiquito::find()->where(['idfiniquito' => $ce, 'token_validar' => $codigo])->one();
        // echo "<pre>";
        // print_r($codigo);
        //   die;
        $datos_bana = CarteraCrediCplazo::consultaBanavih();
        $result = CarteraCrediCplazo::find()->where(['id_credito' => $model->idcredito])->one();
        $modelempr = Empresa::find()->where(['id_empresa' => $result->id_empresa])->one();
        $modelestado = GeoEstado::find()->where(['id_estado' => $modelempr->id_estado])->one();
        // $modelf=Finiquito::find()->where(['idcredito'=>$id])->one();
        $modelfirmas = FirmasGerentes::find()->where(['idfirmas_gerentes' => $model->idfirma_gerente])->one();

        $header = $this->renderPartial('/cartera-credi-cplazo/header');
        $footer = $this->renderPartial('/cartera-credi-cplazo/footer', ['model' => $result, 'datos_bana' => $datos_bana, 'modelf' => $model, 'modelfirmas' => $modelfirmas]);
        $content = $this->renderPartial('/cartera-credi-cplazo/finiquito', ['model' => $result, 'datos_bana' => $datos_bana, 'modelfirmas' => $modelfirmas, 'modelf' => $model, 'modelempr' => $modelempr, 'modelestado' => $modelestado]);
        // $content = $this->renderPartial('finiquito',['model' => $result]);
        // echo "<pre>";
        // print_r($content);die;
        $pdf = new Pdf(
            [
                //'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
                'orientation' => 'P',
                // 'defaultFontSize' => '30'  ,
                'marginHeader' => '8',
                'marginFooter' => '8',
                'marginBottom' => '35',
                'marginLeft' => '20',
                'marginRight' => '20',
                'marginTop' => '25',
            ]
        );
        $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
        $mpdf = $pdf->api;
        //    if ($result->generado==false) 
        //    {
        //     $mpdf->SetWatermarkText('Vista Previa');
        //     $mpdf->showWatermarkText = true;
        //     $mpdf->watermark_font = 'DejaVuSansCondensed';
        //     $mpdf->watermarkTextAlpha = 0.2;
        // }
        $mpdf->SetHTMLHeader($header);
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHtml($content); // call mpdf write html
        echo $mpdf->Output($modelempr->nombre . '-' . $model->correlativo_finiquito . '.pdf', 'I');
    }

    public function actionConfiguraciones()
    {
        // 1. Recopilamos estadísticas para que las cards no muestren "0"
        // Nota: Asegúrate de que estos modelos existan en tu proyecto
        
        $stats = [
            'totalVehiculos' => \backend\models\BaseTipoVehiculo::find()->count(),
            'totalMetodos'   => \backend\models\BaseMetodosPago::find()->count(),
            'totalClientes'  => \backend\models\BaseTipoCliente::find()->count(),
            'totalServicios' => \backend\models\TipoServicio::find()->count(),
            'totalRutas'     => \backend\models\TipoRuta::find()->count(),
        ];

        // 2. Renderizamos la vista ubicada en site/configuraciones
        return $this->render('configuraciones', [
            'totalVehiculos' => $stats['totalVehiculos'],
            'totalMetodos'   => $stats['totalMetodos'],
            'totalClientes'  => $stats['totalClientes'],
            'totalServicios' => $stats['totalServicios'],
            'totalRutas'     => $stats['totalRutas'],
        ]);
    }
}
