<?php

namespace backend\controllers;

use Yii;
use backend\models\Cliente;
use backend\models\Servicios;
use backend\models\ClienteProyecto;
use backend\models\ClienteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\Response;
use app\models\YourModel;

/**
 * ClienteController implements the CRUD actions for Cliente model.
 */
class ClienteController extends Controller
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
     * Lists all Cliente models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClienteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cliente model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model2 = ClienteProyecto::find($id)->all();

        $model3= Servicios::find()->where(['id_cliente' => $id])->all();
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'model2' => $model2,
            'model3' => $model3,
            
        ]);
    }

    /**
     * Creates a new Cliente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cliente();
        $model2 = new ClienteProyecto();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            if ($_POST['Cliente']['fecha_cumpleanos']){
                $fecha=explode("-",$_POST['Cliente']['fecha_cumpleanos']);
                $model->fecha_cumpleanos=$fecha[2]."-".$fecha[1]."-".$fecha[0];
            }

            //Verificamos si es una empresa
            switch ($_POST['Cliente']['id_tipo_cliente']) {
                case '1':
                    $es_empresa=0;
                    $nombre_cliente=$_POST['Cliente']['nombre_apellido'];
                    $identificacion=$_POST['Cliente']['cedula'];
                    break;
                case '2':
                    $es_empresa=1;
                    $nombre_cliente=$_POST['Cliente']['razon_social'];
                    $identificacion=$_POST['Cliente']['rif'];
                    break;
                case '3':
                    $es_empresa=1;
                    $nombre_cliente=$_POST['Cliente']['razon_social'];
                    $identificacion=$_POST['Cliente']['rif'];
                    break;
            }
         
            Cliente::updateAll(
                [
                    'nombre_apellido' => $nombre_cliente,
                    'cedula' => $identificacion,
                    'id_usuario' => Yii::$app->user->identity->id,
                    'fecha_cumpleanos' => $model->fecha_cumpleanos,
                    'fecha_registro' => date('Y-m-d'),
                    'fecha_registro' => date('Y-m-d'),
                    'empresa' => $es_empresa,
                    'id_categoria' => 1,
                    'nuevo' => 1,
                ], 'id_cliente = '.$model->id_cliente);

                if ($_POST['Cliente']['id_tipo_cliente']==2){
                    $model2->id_cliente=$model->id_cliente;
                    $model2->nombre_autorizada_servicio=$_POST['ClienteProyecto']['nombre_autorizada_servicio'];
                    $model2->telefono_p_autorizada_servicio=$_POST['ClienteProyecto']['telefono_p_autorizada_servicio'];
                    $model2->telefono_a_autorizada_servicio=$_POST['ClienteProyecto']['telefono_a_autorizada_servicio'];
                    $model2->correo_persona_autorizada=$_POST['ClienteProyecto']['correo_persona_autorizada'];
                    $model2->cargo=$_POST['ClienteProyecto']['cargo'];
                    $model2->nombre_contacto_paga=$_POST['ClienteProyecto']['nombre_contacto_paga'];
                    $model2->telefono_p_paga=$_POST['ClienteProyecto']['telefono_p_paga'];
                    $model2->telefono_a_paga=$_POST['ClienteProyecto']['telefono_a_paga'];
                    $model2->correo_paga=$_POST['ClienteProyecto']['correo_paga'];
                    $model2->cargo_paga=$_POST['ClienteProyecto']['cargo_paga'];
                    $model2->correo_envio_retenciones=$_POST['ClienteProyecto']['correo_envio_retenciones'];
                    $model2->save(false);
                }

            \Yii::$app->getSession()->setFlash('success', '<center><h2><b>Registrado con éxito</b></h2></center> ');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'model2' => $model2,
        ]);
    }
    public function actionCreateServ()
    {  
        $model = new Cliente();
        $model2 = new ClienteProyecto();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            if ($_POST['Cliente']['fecha_cumpleanos']){
                $fecha=explode("-",$_POST['Cliente']['fecha_cumpleanos']);
                $model->fecha_cumpleanos=$fecha[2]."-".$fecha[1]."-".$fecha[0];
            }

            //Verificamos si es una empresa
            switch ($_POST['Cliente']['id_tipo_cliente']) {
                case '1':
                    $es_empresa=0;
                    $nombre_cliente=$_POST['Cliente']['nombre_apellido'];
                    $identificacion=$_POST['Cliente']['cedula'];
                    break;
                case '2':
                    $es_empresa=1;
                    $nombre_cliente=$_POST['Cliente']['razon_social'];
                    $identificacion=$_POST['Cliente']['rif'];
                    break;
                case '3':
                    $es_empresa=1;
                    $nombre_cliente=$_POST['Cliente']['razon_social'];
                    $identificacion=$_POST['Cliente']['rif'];
                    break;
            }
         
            Cliente::updateAll(
                [
                    'nombre_apellido' => $nombre_cliente,
                    'cedula' => $identificacion,
                    'id_usuario' => Yii::$app->user->identity->id,
                    'fecha_cumpleanos' => $model->fecha_cumpleanos,
                    'fecha_registro' => date('Y-m-d'),
                    'fecha_registro' => date('Y-m-d'),
                    'empresa' => $es_empresa,
                    'id_categoria' => 1,
                    'nuevo' => 1,
                ], 'id_cliente = '.$model->id_cliente);

                if ($_POST['Cliente']['id_tipo_cliente']==2){
                    $model2->id_cliente=$model->id_cliente;
                    $model2->nombre_autorizada_servicio=$_POST['ClienteProyecto']['nombre_autorizada_servicio'];
                    $model2->telefono_p_autorizada_servicio=$_POST['ClienteProyecto']['telefono_p_autorizada_servicio'];
                    $model2->telefono_a_autorizada_servicio=$_POST['ClienteProyecto']['telefono_a_autorizada_servicio'];
                    $model2->correo_persona_autorizada=$_POST['ClienteProyecto']['correo_persona_autorizada'];
                    $model2->cargo=$_POST['ClienteProyecto']['cargo'];
                    $model2->nombre_contacto_paga=$_POST['ClienteProyecto']['nombre_contacto_paga'];
                    $model2->telefono_p_paga=$_POST['ClienteProyecto']['telefono_p_paga'];
                    $model2->telefono_a_paga=$_POST['ClienteProyecto']['telefono_a_paga'];
                    $model2->correo_paga=$_POST['ClienteProyecto']['correo_paga'];
                    $model2->cargo_paga=$_POST['ClienteProyecto']['cargo_paga'];
                    $model2->correo_envio_retenciones=$_POST['ClienteProyecto']['correo_envio_retenciones'];
                    $model2->save(false);
                }

            \Yii::$app->getSession()->setFlash('success', '<center><h2><b>Registrado con éxito</b></h2></center> ');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'model2' => $model2,
        ]);
    }

    /**
     * Updates an existing Cliente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model2 = ClienteProyecto::find()->where(['id_cliente' => $id])->one();

        //var_dump($model2); die();

        if ($model->load(Yii::$app->request->post()) ) {
            //Verificamos si es una empresa
            switch ($_POST['Cliente']['id_tipo_cliente']) {
                case '1':
                    $es_empresa=0;
                    $nombre_cliente=$_POST['Cliente']['nombre_apellido'];
                    $identificacion=$_POST['Cliente']['cedula'];
                    break;
                case '2':
                    $es_empresa=1;
                    $nombre_cliente=$_POST['Cliente']['razon_social'];
                    $identificacion=$_POST['Cliente']['rif'];
                    break;
                case '3':
                    $es_empresa=1;
                    $nombre_cliente=$_POST['Cliente']['razon_social'];
                    $identificacion=$_POST['Cliente']['rif'];
                    break;
            }

          /* Cliente::updateAll(
                [
                    'nombre_apellido' => $nombre_cliente,
                    'cedula' => $identificacion,
                    'id_tipo_cliente' => $_POST['Cliente']['id_tipo_cliente'],
                    'telefono_principal' => $_POST['Cliente']['telefono_principal'],
                    'telefono_alterno' => $_POST['Cliente']['telefono_alterno'],
                    'correo' => $_POST['Cliente']['correo'],
                    'id_estado' => $_POST['Cliente']['id_estado'],
                    'id_municipio' => $_POST['Cliente']['id_municipio'],
                    'id_parroquia' => $_POST['Cliente']['id_parroquia'],
                    'direccion' => $_POST['Cliente']['direccion'],
                    'id_referido' => $_POST['Cliente']['id_referido'],
                    'lugar_contacto' => $_POST['Cliente']['lugar_contacto'],
                    'id_nos_conoce' => $_POST['Cliente']['id_nos_conoce'],
                    'fecha_cumpleanos' => $_POST['Cliente']['fecha_cumpleanos'],
                    'viaja_frecuente' => $_POST['Cliente']['viaja_frecuente'],
                    'recibir_correo' => $_POST['Cliente']['recibir_correo'],
                    'cliente_grato' => $_POST['Cliente']['cliente_grato'],
                    'id_categoria' => $_POST['Cliente']['id_categoria'],
                ], 'id_cliente = '.$model->id_cliente);*/

                $model->save();

            if ($_POST['Cliente']['id_tipo_cliente']==2){

                ClienteProyecto::updateAll(
                    [
                        'nombre_autorizada_servicio' =>$_POST['ClienteProyecto']['nombre_autorizada_servicio'],
                        'telefono_p_autorizada_servicio'=>$_POST['ClienteProyecto']['telefono_p_autorizada_servicio'],
                        'telefono_a_autorizada_servicio'=>$_POST['ClienteProyecto']['telefono_a_autorizada_servicio'],
                        'correo_persona_autorizada'=>$_POST['ClienteProyecto']['correo_persona_autorizada'],
                        'cargo'=>$_POST['ClienteProyecto']['cargo'],
                        'nombre_contacto_paga'=>$_POST['ClienteProyecto']['nombre_contacto_paga'],
                        'telefono_p_paga'=>$_POST['ClienteProyecto']['telefono_p_paga'],
                        'telefono_a_paga'=>$_POST['ClienteProyecto']['telefono_a_paga'],
                        'correo_paga'=>$_POST['ClienteProyecto']['correo_paga'],
                        'cargo_paga'=>$_POST['ClienteProyecto']['cargo_paga'],
                        'correo_envio_retenciones'=>$_POST['ClienteProyecto']['correo_envio_retenciones'],
                    ], 'id_cliente = '.$model->id_cliente);

            }

            \Yii::$app->getSession()->setFlash('success', '<center><h2><b>Modificado con éxito</b></h2></center> ');
            return $this->redirect(['index']);

        }

        return $this->render('update', [
            'model' => $model,
            'model2' => $model2,
        ]);
    }

    /**
     * Deletes an existing Cliente model.
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
     * Finds the Cliente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cliente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cliente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAutocomplete($term)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Busca registros que coincidan con el término
        $results = Cliente::find()
            ->select('nombre_apellido') // Cambia 'name' por el campo que deseas mostrar
            ->where(['like', 'nombre_apellido', $term]) // Cambia 'name' por el campo que deseas buscar
            ->limit(10) // Limita los resultados
            ->asArray()
            ->all();

        return array_map(function($result) {
            return ['label' => $result['nombre_apellido'], 'value' => $result['nombre_apellido']];
        }, $results);
    }


}
