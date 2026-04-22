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
                        'actions' => ['logout', 'index', 'index-lp', 'qr'],
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
        // Obtener datos para el dashboard

        // Conteo por Servicios

        $fuentefinan  = Servicios::find()
        ->select([
        new Expression('count(id_servicio) as id_servicio'), 
        'id_estatus'
        ])  
        ->groupBy([ 'id_estatus'])
        ->orderBy( 'id_estatus')
        ->all();

        
        $servicios  = Servicios::find()->count();
        $servicios_mes  = Servicios::find()->where(['MONTH(fecha_registro)'=> date('n')])->count();

        $connection = \Yii::$app->db;
        $cliente=$connection->createCommand("SELECT sum(monto) as monto
        FROM servicio_pago 
        where  YEAR(fecha_pago)=" . date('Y'));
        $servicios_monto= $cliente->queryOne();

        $connection = \Yii::$app->db;
        $cliente=$connection->createCommand("SELECT sum(monto) as monto
        FROM servicio_pago a 
        where  MONTH(a.fecha_pago) =". date('n') ." and YEAR(a.fecha_pago)=" . date('Y'));
        $servicios_monto_mes= $cliente->queryOne();

        //Por tipo de pago
        $tipopago  = ServicioPago::find()
        ->select([
        new Expression('count(id_servicio) as id_servicio'), 
        'tipo_pago'
        ])  
        ->where([ 'MONTH(fecha_pago)'=> date('n'), 'YEAR(fecha_pago)'=> date('Y')])
        ->groupBy([ 'tipo_pago'])
        ->orderBy( 'tipo_pago')
        ->all();

        //Por tipo de vehiculo

        $tipovehiculo  = VServicios::find()
        ->select([
        new Expression('count(id_servicio) as id_servicio'), 
        'nombre_tipo_vehiculo'
        ])  
        ->where([ 'MONTH(fecha_registro)'=> date('n'), 'YEAR(fecha_registro)'=> date('Y')])
        ->groupBy([ 'nombre_tipo_vehiculo'])
        ->orderBy( 'nombre_tipo_vehiculo')
        ->all();

        //Por conductor

        $conductor  = VServicios::find()
        ->select([
        new Expression('count(id_servicio) as id_servicio'), 
        'conductor'
        ])  
        ->where([ 'MONTH(fecha_registro)'=> date('n'), 'YEAR(fecha_registro)'=> date('Y')])
        ->andwhere([ 'is not', 'conductor', null])        
        ->groupBy([ 'conductor'])
        ->orderBy( 'conductor')
        ->all();

        return $this->render('../dashboard/index', [
            'fuentefinan' => $fuentefinan,
            'servicios' => $servicios,
            'servicios_mes' => $servicios_mes,
            'servicios_monto' => $servicios_monto,
            'servicios_monto_mes' => $servicios_monto_mes,
            'tipopago' => $tipopago,
            'tipovehiculo' => $tipovehiculo,
            'conductor' => $conductor,
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
}
