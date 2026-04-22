<?php

namespace backend\controllers;

use Yii;
use backend\models\Conductor;
use backend\models\ConductorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use kartik\mpdf\Pdf;


/**
 * ConductorController implements the CRUD actions for Conductor model.
 */
class ConductorController extends Controller
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
     * Lists all Conductor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConductorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Conductor model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Conductor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Conductor();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if ($_POST['Conductor']['fecha_ingreso']){
                $fecha=explode("-",$_POST['Conductor']['fecha_ingreso']);
                $model->fecha_ingreso=$fecha[2]."-".$fecha[1]."-".$fecha[0];
            }

            if ($_POST['Conductor']['fecha_egreso']){
                $fecha=explode("-",$_POST['Conductor']['fecha_egreso']);
                $model->fecha_egreso=$fecha[2]."-".$fecha[1]."-".$fecha[0];
            }

            //Guardado de las fotos
            $rut_logo = $model->foto;

            if (Yii::$app->request->baseUrl) {
                $we = '/web';
            } else {
                $we = '';
            }

            $logo = UploadedFile::getInstance($model, 'foto');
            if (!is_null($logo)) {
                $logo_src_filename = $logo->name;
                $dd = explode(".", $logo->name);
                $ext = end($dd);
                $logo_web_filename = Yii::$app->security->generateRandomString() . ".{$ext}";
                Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/uploads/conductores/';
                $path = Yii::$app->params['uploadPath'] . $logo_web_filename;
                $model->foto = $we . '/uploads/conductores/' . $logo_web_filename;     
                $model->save(false);         
                $logo->saveAs($path);
            } else {
                $model->foto = $rut_logo;
            }


            Conductor::updateAll(
                [
                    'id_usuario' => Yii::$app->user->identity->id,
                    'fecha_ingreso' => $model->fecha_ingreso,
                    'fecha_egreso' => $model->fecha_egreso,
                    'fecha_registro' => date('Y-m-d'),
                  
                ], 'id = '.$model->id);
    
            \Yii::$app->getSession()->setFlash('success', '<center><h2><b>Registrado con éxito</b></h2></center> ');
            return $this->redirect(['index']);
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $rut_foto = $model->foto; // Guardamos la foto actual por si no se sube una nueva

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // --- Lógica de Procesamiento de Fechas ---
            if (!empty($_POST['Conductor']['fecha_ingreso'])) {
                $fecha = explode("-", $_POST['Conductor']['fecha_ingreso']);
                // Aseguramos formato Y-m-d para la DB (asumiendo que viene d-m-Y)
                $model->fecha_ingreso = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
            }

            if (!empty($_POST['Conductor']['fecha_egreso'])) {
                $fecha = explode("-", $_POST['Conductor']['fecha_egreso']);
                $model->fecha_egreso = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
            }

           $rut_foto = $model->foto;

            if (Yii::$app->request->baseUrl) {
                $we = '';
            } else {
                $we = '';
            }

            $logo = UploadedFile::getInstance($model, 'foto');
            if (!is_null($logo)) {
                $logo_src_filename = $logo->name;
                $dd = explode(".", $logo->name);
                $ext = end($dd);
                $logo_web_filename = Yii::$app->security->generateRandomString() . ".{$ext}";
                Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/conductores/';
                $path = Yii::$app->params['uploadPath'] . $logo_web_filename;
                $model->foto = $we . '/uploads/conductores/' . $logo_web_filename;     
                $model->save(false);         
                $logo->saveAs($path);
            } else {
                $model->foto = $rut_foto;
            }

            Conductor::updateAll(
                [
                    'foto' => $model->foto,
                    'fecha_ingreso' => $model->fecha_ingreso,
                    'fecha_egreso' => $model->fecha_egreso,
                    
                  
                ], 'id = '.$model->id);


            \Yii::$app->getSession()->setFlash('success', '<center><h2><b>Actualizado con éxito</b></h2></center>');
            return $this->redirect(['index']);
        }

        // --- ESTA ES LA CLAVE PARA EL MODAL ---
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdate_res($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if ($_POST['Conductor']['fecha_ingreso']){
                $fecha=explode("-",$_POST['Conductor']['fecha_ingreso']);
                $model->fecha_ingreso=$fecha[2]."-".$fecha[1]."-".$fecha[0];
            }

            if ($_POST['Conductor']['fecha_egreso']){
                $fecha=explode("-",$_POST['Conductor']['fecha_egreso']);
                $model->fecha_egreso=$fecha[2]."-".$fecha[1]."-".$fecha[0];
            }

            $rut_foto = $model->foto;

            if (Yii::$app->request->baseUrl) {
                $we = '/web';
            } else {
                $we = '';
            }

            $logo = UploadedFile::getInstance($model, 'foto');
            if (!is_null($logo)) {
                $logo_src_filename = $logo->name;
                $dd = explode(".", $logo->name);
                $ext = end($dd);
                $logo_web_filename = Yii::$app->security->generateRandomString() . ".{$ext}";
                Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/conductores/';
                $path = Yii::$app->params['uploadPath'] . $logo_web_filename;
                $model->foto = $we . '/uploads/conductores/' . $logo_web_filename;     
                $model->save(false);         
                $logo->saveAs($path);
            } else {
                $model->foto = $rut_foto;
            }


            Conductor::updateAll(
                [
                    'foto' => $model->foto,
                    'fecha_ingreso' => $model->fecha_ingreso,
                    'fecha_egreso' => $model->fecha_egreso,
                    
                  
                ], 'id = '.$model->id);


            \Yii::$app->getSession()->setFlash('success', '<center><h2><b>Registrado con éxito</b></h2></center> ');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        Conductor::updateAll(
            [
                'estatus' => 0,              
            ], 'id = '.$id);

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Conductor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //Ajuste nuevos asociados

    public function actionReporte()
    {
        $conductores = Conductor::find()->orderBy(['apellidos' => SORT_ASC])->all();
        
        // Renderizamos la vista del reporte
        $content = $this->renderPartial('reporte-maestro', [
            'conductores' => $conductores,
        ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, 
            'format' => Pdf::FORMAT_LETTER, 
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            'destination' => Pdf::DEST_BROWSER, 
            'content' => $content,  
            'cssInline' => '.capsula { border-radius: 15px; border: 1px solid #eee; margin-bottom: 8px; }', 
            'options' => ['title' => 'Reporte de conductores'],
            'methods' => [ 
                'SetHeader' => ['Conductores||Generado: ' . date('d/m/Y')], 
                'SetFooter' => ['Página {PAGENO}'],
            ]
        ]);
        
        return $pdf->render();
    }

    public function actionPdf($id) {
    $model = $this->findModel($id);
    $content = $this->renderPartial('_pdf_ficha', ['model' => $model]);

    $pdf = new Pdf([
        'mode' => Pdf::MODE_UTF8,
        'format' => Pdf::FORMAT_A4,
        'orientation' => Pdf::ORIENT_PORTRAIT,
        'destination' => Pdf::DEST_BROWSER,
        'content' => $content,
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
        'cssInline' => '.kv-heading-1{font-size:18px}',
        'options' => ['title' => 'Ficha del Conductor'],
        'methods' => [
            'SetHeader' => ['FICHA DE CONDUCTOR'],
            'SetFooter' => ['Generado el: {DATE j-m-Y}|Página {PAGENO}|Sistema de Gestión'],
        ]
    ]);
    return $pdf->render();
}
    
    public function actionExportar()
    {  

       $model = Conductor::find()->all();

        if(isset($_GET['id'])){

        $content = $this->renderPartial('_listadoconductores');
        $pdf = new Pdf(['cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css','orientation' => 'L']); // or new Pdf();
        
        $mpdf = $pdf->api; // fetches mpdf api
        $mpdf->WriteHtml($content); // call mpdf write html
        echo $mpdf->Output('Listado de Conductores CHgroup.pdf', 'I');
        //return $pdf->render();        
        }else {
            return $this->render('listadoconductores', [
                'model' => $model,
            ]);
        }
    }

    public function actionExcel(){
        $model = Conductor::find()->all();
        $content = $this->renderPartial('excel_conductores',['model' => $model]);   
    
    }
}
