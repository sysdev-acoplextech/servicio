<?php

namespace backend\controllers;

use backend\models\AsignacionFlota;
use backend\models\CondicionFlota;
use backend\models\Conductor;
use Yii;
use backend\models\Flota;
use backend\models\FlotaSearch;
use backend\models\GeoMunicipio;
use backend\models\GeoParroquia;
use backend\models\MovAsignacion;
use backend\models\MovFlota;
use backend\models\VFlota;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\UploadedFile;
use kartik\mpdf\Pdf;

/**
 * FlotaController implements the CRUD actions for Flota model.
 */
class FlotaController extends Controller
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
     * Lists all Flota models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FlotaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Flota model.
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
     * Creates a new Flota model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Flota();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if ($_POST['Flota']['fecha_vencimiento_rcv']){
                $fecha=explode("-",$_POST['Flota']['fecha_vencimiento_rcv']);
                $model->fecha_vencimiento_rcv=$fecha[2]."-".$fecha[1]."-".$fecha[0];
            }

            Flota::updateAll(
                [
                    'id_usuario' => Yii::$app->user->identity->id,
                    'fecha_vencimiento_rcv' => $model->fecha_vencimiento_rcv,
                    'fecha_registro' => date('Y-m-d'),
                    'placa' => strtoupper($model->placa)
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

    /**
     * Updates an existing Flota model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {          

            if ($_POST['Flota']['fecha_vencimiento_rcv']){
                $fecha=explode("-",$_POST['Flota']['fecha_vencimiento_rcv']);
                $model->fecha_vencimiento_rcv=$fecha[2]."-".$fecha[1]."-".$fecha[0];
            }

            Flota::updateAll(
                [
                    'id_usuario' => Yii::$app->user->identity->id,
                    'fecha_vencimiento_rcv' => $model->fecha_vencimiento_rcv,
                    'fecha_registro' => date('Y-m-d'),
                    'placa' => strtoupper($model->placa)
                ], 'id = '.$model->id);




                if($model->id_condicion != $model->condicion_anterior){
                    //Agrego los movimientos de la flota

                    
                    //Condicion anterior
                    $condicion = CondicionFlota::find()->where(['id' => $model->condicion_anterior])->one();
                    echo $anterior=$condicion->nombre_condicion_flota;

                    $model3 = new MovFlota();
                    $model3->id_flota=$model->id;
                    $model3->id_estatus=3;
                    $model3->fecha_registro=date("Y-m-d");
                    $model3->id_accion=$model->id;
                    $model3->ultimo=true;
                    $model3->observacion='Cambio de Condición de la flota la condición anterior es: '. $anterior;
                    $model3->save(false);
        
                }

                  Yii::$app->session->setFlash('success', "
                    <strong>¡Operación Exitosa!</strong><br>
                    La unidad ha sido modificada correctamente.
                ");
        
                \Yii::$app->getSession()->setFlash('success', '<center><h2><b>Registrado con éxito</b></h2></center> ');
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

    /**
     * Deletes an existing Flota model.
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
     * Finds the Flota model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Flota the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Flota::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGaleria($id)
    {
        $model = $this->findModel($id);
        $rut_logo = $model->foto1;
        $rut_logod = $model->foto2;
        $rut_logorcv = $model->foto_rcv;

        if ($model->load(Yii::$app->request->post())  ) {
                    
             if (Yii::$app->request->baseUrl) {
                $we = '/web';
            } else {
                $we = '';
            }

            $logo = UploadedFile::getInstance($model, 'foto1');
            if (!is_null($logo)) {
                $logo_src_filename = $logo->name;
                $dd = explode(".", $logo->name);
                $ext = end($dd);
                $logo_web_filename = Yii::$app->security->generateRandomString() . ".{$ext}";
                Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/flota/';
                $path = Yii::$app->params['uploadPath'] . $logo_web_filename;
                $model->foto1 = $we . '/uploads/flota/' . $logo_web_filename;     
                $model->save(false);         
                $logo->saveAs($path);
            } else {
                $model->foto1 = $rut_logo;
            }
            $logod = UploadedFile::getInstance($model, 'foto2');
            if (!is_null($logod)) {
                $logo_src_filename = $logod->name;
                $dd = explode(".", $logod->name);
                $ext = end($dd);
                $logo_web_filename = Yii::$app->security->generateRandomString() . ".{$ext}";
                Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/flota/';
                $path = Yii::$app->params['uploadPath'] . $logo_web_filename;
                $model->foto2 = $we . '/uploads/flota/' . $logo_web_filename;     
                $model->save(false);         
                $logod->saveAs($path);
            } else {
                $model->foto1 = $rut_logo;
                $model->foto2 = $rut_logod;
            }
            $logod = UploadedFile::getInstance($model, 'foto_rcv');
            if (!is_null($logod)) {
                $logo_src_filename = $logod->name;
                $dd = explode(".", $logod->name);
                $ext = end($dd);
                $logo_web_filename = Yii::$app->security->generateRandomString() . ".{$ext}";
                Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/rcv/';
                $path = Yii::$app->params['uploadPath'] . $logo_web_filename;
                $model->foto_rcv = $we . '/uploads/rcv/' . $logo_web_filename;     
                $model->save(false);         
                $logod->saveAs($path);
            } else {
                $model->foto1 = $rut_logo;
                $model->foto_rcv = $rut_logorcv;
            }

             Yii::$app->session->setFlash('success', "
                    <strong>¡Operación Exitosa!</strong><br>
                    La galeria ha sido actualizada correctamente a la flota.
                ");

            return $this->redirect(['index']);
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('galeria', [
                'model' => $model,
            ]);
        }

        return $this->render('galeria', [
            'model' => $model,
        ]);
    }
    public function actionAsignacion($id)
    {
            $model = $this->findModel($id);
            $model2 = new AsignacionFlota();
            $model3 = new MovFlota();
            $registros = AsignacionFlota::find()->where(['id_flota' => $id])->orderBy(['id_asignacion' => SORT_DESC])->all();
    
            if ($model->load(Yii::$app->request->post())) {
                        
                // Actualizamos estatus de asignación en la unidad
                Flota::updateAll(['asignado' => 1], ['id' => $model->id]);

                // Formateo de fecha de asignación
                if (isset($_POST['AsignacionFlota']['fecha_asignacion']) && !empty($_POST['AsignacionFlota']['fecha_asignacion'])){
                    $fecha = explode("-", $_POST['AsignacionFlota']['fecha_asignacion']);
                    $model2->fecha_asignacion = $fecha[2]."-".$fecha[1]."-".$fecha[0];
                }

                // Marcamos asignaciones anteriores como no vigentes
                AsignacionFlota::updateAll(['ultimo' => false], ['id_flota' => $model->id]);

                // Guardamos la nueva asignación
                $model2->id_flota = $id;
                $model2->id_conductor = $_POST['AsignacionFlota']['id_conductor'];
                $model2->ultimo = true;
                $model2->save(false);

                // Actualizamos historial de movimientos
                MovFlota::updateAll(['ultimo' => false], ['id_flota' => $id]);

                $model3->id_flota = $model->id;
                $model3->id_estatus = 2; // Asignado
                $model3->fecha_registro = date("Y-m-d");
                $model3->id_accion = $model2->id_asignacion;
                $model3->ultimo = true;
                    // Usamos el operador de fusión nula para evitar errores si viene vacío
                $model3->observacion = $_POST['MovFlota']['observacion'] ?? 'Asignación de unidad';
                $model3->save(false);

                // --- SET FLASH REFORMADO (SIN HTML SUCIO) ---
                Yii::$app->session->setFlash('success', "
                    <strong>¡Operación Exitosa!</strong><br>
                    La unidad ha sido asignada correctamente al conductor seleccionado.
                ");

                return $this->redirect(['index']);
            }

            // Renderizado según el tipo de petición
            $params = [
                'model' => $model,
                'model2' => $model2,
                    'model3' => $model3,
                    'registros' => $registros,
            ];

            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('asignacion', $params);
            }

            return $this->render('asignacion', $params);
    }

    public function actionDepMunicipio()
    { 
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $id_estado = $parents[0];
                if ($id_estado) {
                    $tra = GeoMunicipio::find()->where(['id_estado' => $id_estado])->all();
                    $out = [];
                    if (count($tra) > 0) {
                        foreach ($tra as $key => $value) {
                            $out[$key] = ['id' => $value->id, 'name' => $value->nombre_municipio];
                        }
                    } else {
                        $out = ['id' => '', 'name' => ''];
                    }
                    echo Json::encode(['output' => $out, 'selected' => '']);
                    return;
                } else {
                    echo Json::encode(['output' => '', 'selected' => '']);
                }
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionDepParroquia()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            // print_r($parents);die;
            if ($parents != null) {
                $id_municipio = $parents[0];
                if ($id_municipio) {
                    $tra = GeoParroquia::find()->where(['id_municipio' => $id_municipio])->all();
                    $out = [];
                    if (count($tra) > 0) {
                        foreach ($tra as $key => $value) {
                            $out[$key] = ['id' => $value->id, 'name' => $value->nombre_parroquia];
                        }
                    } else {
                        $out[] = ['id' => '', 'name' => ''];
                    }
                    echo Json::encode(['output' => $out, 'selected' => '']);
                    return;
                } else {
                    echo Json::encode(['output' => '', 'selected' => '']);
                }
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionExportar()
    {  

       $model = Flota::find()->all();

        if(isset($_GET['id'])){

        $content = $this->renderPartial('_listadoflota');
        $pdf = new Pdf(['cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css','orientation' => 'L']); // or new Pdf();
        
        $mpdf = $pdf->api; // fetches mpdf api
        $mpdf->WriteHtml($content); // call mpdf write html
        echo $mpdf->Output('listado de flota.pdf', 'I');
        //return $pdf->render();        
        }else {
            return $this->render('listadoflota', [
                'model' => $model,
            ]);
        }
    }

    public function actionExcel(){
        $model = Flota::find()->all();
        $content = $this->renderPartial('excel_flota',['model' => $model]);   
    
    }

    public function actionConductorFlota()
    { 
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $id_estado = $parents[0];
                if ($id_estado) {
                    $tra = Vflota::find()->where(['id_estado' => $id_estado])->all();
                    $out = [];
                    if (count($tra) > 0) {
                        foreach ($tra as $key => $value) {
                            $out[$key] = ['id' => $value->id, 'name' => $value->nombre_municipio];
                        }
                    } else {
                        $out = ['id' => '', 'name' => ''];
                    }
                    echo Json::encode(['output' => $out, 'selected' => '']);
                    return;
                } else {
                    echo Json::encode(['output' => '', 'selected' => '']);
                }
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionCambiarEstatus($id)
    {
        $modelFlota = $this->findModel($id);
        // IMPORTANTE: Asegúrate de que la ruta del modelo sea correcta
        $modelMov = new \backend\models\MovFlota(); 

        if ($modelMov->load(Yii::$app->request->post())) {
            $modelFlota->id_condicion = $modelMov->id_estatus;
            $modelFlota->save(false);

            \backend\models\MovFlota::updateAll(['ultimo' => false], ['id_flota' => $id]);

            $modelMov->id_flota = $id;
            $modelMov->fecha_registro = date("Y-m-d");
            
            // Verifica que el usuario esté logueado para evitar error 500 aquí
            $modelMov->id_usuario = Yii::$app->user->isGuest ? 1 : Yii::$app->user->identity->id;
            
            $modelMov->ultimo = true;
            $modelMov->save(false);

            return $this->redirect(['index']);
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('cambiar-estatus', [
                'modelFlota' => $modelFlota,
                'modelMov' => $modelMov,
            ]);
        }
    }
    
}
