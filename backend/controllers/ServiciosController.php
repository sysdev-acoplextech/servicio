<?php

namespace backend\controllers;

use backend\models\Cliente;
use backend\models\ClienteProyecto;
use backend\models\DetalleFactura;
use backend\models\MovServicio;
use backend\models\Pasajero;
use backend\models\PasajeroServicio;
use backend\models\ServicioPago;
use Yii;
use backend\models\Servicios;
use backend\models\ServiciosSearch;
use backend\models\ServicioVariables;
use backend\models\Tarifario;
use backend\models\Tasadia;
use backend\models\VariablesServicio;
use backend\models\VFlota;
use backend\models\VServicios;
use backend\models\Conductor;
use backend\models\Flota;
use backend\models\VServiciosProyecto;
use backend\models\ServicioVariable;
use backend\models\DetalleTarifario;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/**
 * ServiciosController implements the CRUD actions for Servicios model.
 */
class ServiciosController extends Controller
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
     * Lists all Servicios models.
     * @return mixed
     */
    public function actionIndex_res()
    {
        $searchModel = new ServiciosSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, [1,2]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex()
    {
        $hoy = date('Y-m-d');

        // 1. Mantener tus métricas actuales
        $agendados = \backend\models\Servicios::find()->where(['id_estatus' => 1, 'fecha_servicio' => $hoy])->count();
        $confirmados = \backend\models\Servicios::find()->where(['id_estatus' => 2])->count();
        $sinConductor = \backend\models\Servicios::find()->where(['id_conductor' => null, 'id_estatus' => 2])->count();
        $porPagar = \backend\models\Servicios::find()->where(['id_estatus' => 4])->count();
        
        // Lista de servicios del día (para la vista de "Lista" o "Tarjetas")
        // Nota: He usado el ActiveDataProvider para que sea compatible con la paginación si la necesitas
        $searchModel = new \backend\models\ServiciosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, null);
        $dataProvider->query->orderBy(['id_servicio' => SORT_DESC]);

        // 2. Lógica para el Calendario
        // Traemos todos los servicios para que se vean en el calendario mensual
        $todosLosServicios = \backend\models\Servicios::find()->all();
        $eventosCalendario = [];

        foreach ($todosLosServicios as $s) {
            $eventosCalendario[] = [
                'id'    => $s->id_servicio,
                'title' => '#' . $s->id_servicio . ' - ' . ($s->id_cliente ? $s->cliente->nombre_apellido : 'S/N'),
                'start' => $s->fecha_servicio, // Formato YYYY-MM-DD
                // Color dinámico según estatus (puedes ajustar los IDs de estatus según tu base de datos)
                'color' => ($s->id_estatus == 2) ? '#10B981' : '#F59E0B', 
                'textColor' => '#ffffff',
            ];
        }

        // 3. Conductores activos
        $totalConductores = \backend\models\Conductor::find()->count();

        // 4. Retornar todo a la vista
        return $this->render('index', [
            'dataProvider' => $dataProvider, // Para la tabla y tarjetas
            'eventosCalendario' => $eventosCalendario, // Para el calendario
            'agendados' => $agendados,
            'confirmados' => $confirmados,
            'sinConductor' => $sinConductor,
            'porPagar' => $porPagar,
            'totalConductores' => $totalConductores,
        ]);
    }

    public function actionIndexproyecto()
    {
        $searchModel = new ServiciosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 2);

        return $this->render('indexproyecto', [
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

    public function actionCreateSeleccion()
    {

        $model = new Servicios();
        $model2 = new Tarifario();
        $model3 = new Cliente();
        $model4 = new ClienteProyecto();
        $model5 = new PasajeroServicio();
        $model6 = new Pasajero();

        return $this->render('create_seleccion', [
            'model' => $model,
            'model2' => $model2,
            'model3' => $model3,
            'model4' => $model4,
            'model5' => $model5,
            'model6' => $model6,
        ]);
    }

    public function actionCreate_res()
    {

        $model = new Servicios();
        $model2 = new Tarifario();
        $model3 = new Cliente();
        $model4 = new ClienteProyecto();
        $model5 = new PasajeroServicio();
        $model6 = new Pasajero();
        $model7 = new VariablesServicio();

        if ($model->load(Yii::$app->request->post())) {

            if ($_POST['Servicios']['km_servicio'] == '') {
                \Yii::$app->getSession()->setFlash('success', '<center><h2><b>Debe llenar el servicio</b></h2></center> ');
            }

            // var_dump($_POST); die();

            //Tipo de Vehiculo
            switch ($_POST['Servicios']['item_tipo_vehiculo']) {
                case 'Sedán':
                    $tipo_vehiculo = 1;
                    break;
                case 'Camioneta':
                    $tipo_vehiculo = 2;
                    break;
                case 'Autobus':
                    $tipo_vehiculo = 3;
                    break;
                case 'Van':
                    $tipo_vehiculo = 5;
                    break;
            }

            //Tipo de Ruta
            if ($_POST['Servicios']['item_ruta'] == 'Gran Caracas')
                $ruta = 2;
            else
                $ruta = 1;

            //Guardamos el servicio

            //*** SERVICIOS *****

            $model->fecha_registro = date("Y-m-d");
            $model->id_tipo_vehiculo = $_POST['Servicios']['item_tipo_vehiculo'];
            $model->id_tipo_traslado_ruta = $ruta;
            $model->km_servicio = $_POST['Servicios']['km_servicio'];
            $model->monto = $_POST['Servicios']['monto'];
            $model->id_estatus = 5;
            if ($_POST['Servicios']['item_horario'] == 'Diurno')
                $ruta = 1;
            else
                $ruta = 2;
            $model->id_tipo_ruta = $ruta;
            $model->id_usuario = Yii::$app->user->identity->id;
            if ($_POST['Servicios']['observacion_inicial'])
                $model->observacion_inicial = $_POST['Servicios']['observacion_inicial'];
            else
                $model->observacion_inicial = 'Registro Inicial del servicio';
            $model->save(false);

            $id_servicio = $model->id_servicio;

            //**** VARIABLE DEL SERVICIO */
            if (($_POST['Servicios']['subtotal_v1'] != '') or
                ($_POST['Servicios']['subtotal_v2'] != '') or ($_POST['Servicios']['subtotal_v3'] != '')
                or ($_POST['Servicios']['subtotal_v4'] != '') or ($_POST['Servicios']['subtotal_v5'] != '')
                or ($_POST['Servicios']['subtotal_v6'] != '')
            ) {

                if ($_POST['Servicios']['subtotal_v1'] != '') {
                    $model_ser_var = new ServicioVariables();
                    $model_ser_var->id_servicio = $id_servicio;
                    $model_ser_var->id_variable_servicio = $_POST['Servicios']['variable1'];
                    $model_ser_var->monto = $_POST['Servicios']['monto_v1'];
                    $model_ser_var->cantidad = $_POST['Servicios']['cant_v1'];
                    $model_ser_var->save(false);
                }
                if ($_POST['Servicios']['subtotal_v2'] != '') {
                    $model_ser_var = new ServicioVariables();
                    $model_ser_var->id_servicio = $id_servicio;
                    $model_ser_var->id_variable_servicio = $_POST['Servicios']['variable2'];
                    $model_ser_var->monto = $_POST['Servicios']['monto_v2'];
                    $model_ser_var->cantidad = $_POST['Servicios']['cant_v2'];
                    $model_ser_var->save(false);
                }
                if ($_POST['Servicios']['subtotal_v3'] != '') {
                    $model_ser_var = new ServicioVariables();
                    $model_ser_var->id_servicio = $id_servicio;
                    $model_ser_var->id_variable_servicio = $_POST['Servicios']['variable3'];
                    $model_ser_var->monto = $_POST['Servicios']['monto_v3'];
                    $model_ser_var->cantidad = $_POST['Servicios']['cant_v3'];
                    $model_ser_var->save(false);
                }
                if ($_POST['Servicios']['subtotal_v4'] != '') {
                    $model_ser_var = new ServicioVariables();
                    $model_ser_var->id_servicio = $id_servicio;
                    $model_ser_var->id_variable_servicio = $_POST['Servicios']['variable4'];
                    $model_ser_var->monto = $_POST['Servicios']['monto_v4'];
                    $model_ser_var->cantidad = $_POST['Servicios']['cant_v4'];
                    $model_ser_var->save(false);
                }
                if ($_POST['Servicios']['subtotal_v5'] != '') {
                    $model_ser_var = new ServicioVariables();
                    $model_ser_var->id_servicio = $id_servicio;
                    $model_ser_var->id_variable_servicio = $_POST['Servicios']['variable5'];
                    $model_ser_var->monto = $_POST['Servicios']['monto_v5'];
                    $model_ser_var->cantidad = $_POST['Servicios']['cant_v5'];
                    $model_ser_var->save(false);
                }
                if ($_POST['Servicios']['subtotal_v6'] != '') {
                    $model_ser_var = new ServicioVariables();
                    $model_ser_var->id_servicio = $id_servicio;
                    $model_ser_var->id_variable_servicio = $_POST['Servicios']['variable6'];
                    $model_ser_var->monto = $_POST['Servicios']['monto_v6'];
                    $model_ser_var->cantidad = $_POST['Servicios']['cant_v6'];
                    $model_ser_var->save(false);
                }
            }


            //****PASAJERO** */

            if ($_POST['Pasajero']['nombre_apellido'] != '') {
                //Buscamos si el pasajero existe
                $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre_apellido']])
                    ->andWhere(['telefono' => $_POST['Pasajero']['telefono']])
                    ->one();

                if ($pax) {
                    $model5->id_pasajero = $pax['id_pasajero'];
                } else {
                    $model6 = new Pasajero();
                    $model6->nombre_apellido = $_POST['Pasajero']['nombre_apellido'];
                    $model6->telefono = $_POST['Pasajero']['telefono'];
                    $model6->save(false);

                    $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre_apellido']])
                        ->andWhere(['telefono' => $_POST['Pasajero']['telefono']])
                        ->one();
                }


                $model5 = new PasajeroServicio();
                $model5->id_servicio = $id_servicio;
                $model5->id_pasajero = $pax['id_pasajero'];
                $model5->hora = $_POST['hora'];
                $fecha = explode("/", $_POST['PasajeroServicio']['fecha']);
                $model5->fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $model5->origen = $_POST['PasajeroServicio']['origen'];
                $model5->destino = $_POST['PasajeroServicio']['destino'];
                $model5->save(false);
                Servicios::updateAll(
                    [
                        'fecha_servicio' => $model5->fecha,
                    ],
                    'id_servicio= ' . $id_servicio
                );
            }


            if ($_POST['Pasajero']['nombre1'] != '') {
                //Buscamos si el pasajero existe
                $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre1']])
                    ->andWhere(['telefono' => $_POST['Pasajero']['telefono1']])
                    ->one();



                $fecha = explode("/", $_POST['PasajeroServicio']['fecha1']);
                $model5->fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                Servicios::updateAll(
                    [
                        'fecha_servicio' => $model5->fecha,
                    ],
                    'id_servicio= ' . $id_servicio
                );


                //Pasajero Servicio
                $model5 = new PasajeroServicio();
                $model5->id_servicio = $id_servicio;
                $model5->hora = $_POST['PasajeroServicio']['hora1'];
                $fecha = explode("/", $_POST['PasajeroServicio']['fecha1']);
                $model5->fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $model5->origen = $_POST['PasajeroServicio']['origen1'];
                $model5->destino = $_POST['PasajeroServicio']['destino1'];

                if ($pax) {
                    $model5->id_pasajero = $pax['id_pasajero'];
                } else {
                    $model6 = new Pasajero();
                    $model6->nombre_apellido = $_POST['Pasajero']['nombre1'];
                    $model6->telefono = $_POST['Pasajero']['telefono1'];
                    $model6->save(false);
                    $model5->id_pasajero = $model6->id_pasajero;
                }
                $model5->save(false);
            }

            if ($_POST['Pasajero']['nombre2'] != '') {
                //Buscamos si el pasajero existe
                $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre2']])
                    ->andWhere(['telefono' => $_POST['Pasajero']['telefono2']])
                    ->one();

                //Pasajero Servicio
                $model5 = new PasajeroServicio();
                $model5->id_servicio = $id_servicio;
                $model5->hora = $_POST['PasajeroServicio']['hora2'];
                $fecha = explode("/", $_POST['PasajeroServicio']['fecha2']);
                $model5->fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $model5->origen = $_POST['PasajeroServicio']['origen2'];
                $model5->destino = $_POST['PasajeroServicio']['destino2'];

                if ($pax) {
                    $model5->id_pasajero = $pax->id_pasajero;
                } else {
                    $model6 = new Pasajero();
                    $model6->nombre_apellido = $_POST['Pasajero']['nombre2'];
                    $model6->telefono = $_POST['Pasajero']['telefono2'];
                    $model6->save(false);
                    $model5->id_pasajero = $model6->id_pasajero;
                }
                $model5->save(false);
            }

            if ($_POST['Pasajero']['nombre3'] != '') {
                //Buscamos si el pasajero existe
                $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre3']])
                    ->andWhere(['telefono' => $_POST['Pasajero']['telefono3']])
                    ->one();

                //Pasajero Servicio
                $model5 = new PasajeroServicio();
                $model5->id_servicio = $id_servicio;
                $model5->hora = $_POST['PasajeroServicio']['hora3'];
                $fecha = explode("/", $_POST['PasajeroServicio']['fecha3']);
                $model5->fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $model5->origen = $_POST['PasajeroServicio']['origen3'];
                $model5->destino = $_POST['PasajeroServicio']['destino3'];

                if ($pax) {
                    $model5->id_pasajero = $pax->id_pasajero;
                } else {
                    $model6 = new Pasajero();
                    $model6->nombre_apellido = $_POST['Pasajero']['nombre3'];
                    $model6->telefono = $_POST['Pasajero']['telefono3'];
                    $model6->save(false);
                    $model5->id_pasajero = $model6->id_pasajero;
                }
                $model5->save(false);
            }

            if ($_POST['Pasajero']['nombre4'] != '') {
                //Buscamos si el pasajero existe
                $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre4']])
                    ->andWhere(['telefono' => $_POST['Pasajero']['telefono4']])
                    ->one();

                //Pasajero Servicio
                $model5 = new PasajeroServicio();
                $model5->id_servicio = $id_servicio;
                $model5->hora = $_POST['PasajeroServicio']['hora4'];
                $fecha = explode("/", $_POST['PasajeroServicio']['fecha4']);
                $model5->fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $model5->origen = $_POST['PasajeroServicio']['origen4'];
                $model5->destino = $_POST['PasajeroServicio']['destino4'];

                if ($pax) {
                    $model5->id_pasajero = $pax->id_pasajero;
                } else {
                    $model6 = new Pasajero();
                    $model6->nombre_apellido = $_POST['Pasajero']['nombre4'];
                    $model6->telefono = $_POST['Pasajero']['telefono4'];
                    $model6->save(false);
                    $model5->id_pasajero = $model6->id_pasajero;
                }
                $model5->save(false);
            }
            //****CLIENTE** */
            $cliente = Cliente::find()->where(['cedula' => $_POST['Cliente']['cedula_rif_serv']])->one();

            //var_dump($cliente); die();
            if ($cliente) {
                Servicios::updateAll(
                    [
                        'id_cliente' => $cliente->id_cliente,
                    ],
                    'id_servicio= ' . $id_servicio
                );
            } else {
                $model3 = new Cliente();
                $model3->cedula = $_POST['Cliente']['cedula_rif_serv'];
                $model3->nombre_apellido = $_POST['Cliente']['nombre_apellido'];
                $model3->telefono_principal = $_POST['Cliente']['telefono_principal'];
                $model3->telefono_alterno = $_POST['Cliente']['telefono_alterno'];
                $model3->correo = $_POST['Cliente']['correo'];
                $model3->direccion = $_POST['Cliente']['direccion'];

                $model3->save(false);

                Servicios::updateAll(
                    [
                        'id_cliente' => $model3->id_cliente,
                        'observacion_inicial' =>  $_POST['Servicios']['observacion_inicial'],
                    ],
                    'id_servicio= ' . $id_servicio
                );
            }

            //Registro del movimiento
            $model10 = new MovServicio();
            $model10->id_servicio = $id_servicio;
            $model10->id_estatus = 4;
            $model10->id_usuario = Yii::$app->user->identity->id;
            $model10->observacion = $_POST['Servicios']['observacion_inicial'];
            $model10->save(false);


            \Yii::$app->getSession()->setFlash('success', '<center><h2><b>Servicio registrado con éxito</b></h2></center> ');

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'model2' => $model2,
            'model3' => $model3,
            'model4' => $model4,
            'model5' => $model5,
            'model6' => $model6,
            'model7' => $model7,
        ]);
    }

    public function actionInfoCliente($id)
    {
        // Esto es vital para que JavaScript entienda la respuesta
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        try {
            $cliente = Cliente::findOne($id);
            if ($cliente) {
                return [
                    'success' => true,
                    'telefono' => $cliente->telefono_principal,
                    'grato' => (int)$cliente->cliente_grato, // Captura 1 o 0
                    'tipo' => $cliente->id_tipo_cliente
                ];
            }
            return ['success' => false, 'message' => 'Cliente no encontrado'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function actionGetRutasPasajero($id)
    {
        // Configuramos la respuesta como JSON explícitamente para Yii2
        Yii::$app->response->format = Response::FORMAT_JSON;

        $rutas = PasajeroServicio::find()
            ->select(['origen', 'destino'])
            ->where(['id_pasajero' => $id])
            ->distinct()
            ->asArray()
            ->all();

        return $rutas; 
        // Al usar Response::FORMAT_JSON, Yii se encarga del Json::encode automáticamente
    }

    public function actionCalcularTarifa($ruta, $vehiculo, $hora)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        // 1. Buscar Monto Base en detalle_tarifario
        // Asumimos que $vehiculo es el ID del tipo (1 para sedan, 2 para camioneta por ej.)
        $tarifario = \backend\models\DetalleTarifario::find()
            ->where(['id_detalle_tarifario' => $ruta])
            ->one();

        $montoBase = 0;
        $incViatico = 0;

        if ($tarifario) {
            $incViatico = $tarifario->inc_viatico;
            // Lógica simple: si id_vehiculo es 1 es sedan, si es 2 es camioneta
            $montoBase = ($vehiculo == 1) ? $tarifario->sedan : $tarifario->camioneta;
        }

        // 2. Buscar Recargo en tabla Horario
        $recargo = 0;
        $horaServicio = date('H:i:s', strtotime($hora));
        
        $horarioEspecial = \backend\models\Horario::find()
            ->where(['<=', 'hora_desde', $horaServicio])
            ->andWhere(['>=', 'hora_hasta', $horaServicio])
            ->one();

        if ($horarioEspecial) {
            $recargo = $horarioEspecial->recargo;
        }

        return [
            'success' => true,
            'monto_base' => $montoBase,
            'recargo' => $recargo,
            'inc_viatico' => $incViatico
        ];
    }

    public function actionBuscarRuta($q = null, $id_tarifario = null) 
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => []];
        
        $query = \backend\models\DetalleTarifario::find()
            ->select(['id_detalle_tarifario as id', 'rutas as text', 'sedan', 'camioneta', 'inc_viatico']);

        // Filtro por tarifario (Obligatorio si queremos dependencia)
        if (!empty($id_tarifario)) {
            $query->andWhere(['id_tarifario' => $id_tarifario]);
        }

        // Si el usuario escribió algo, filtramos. Si no, traerá las primeras 20 del tarifario.
        if (!empty($q)) {
            $query->andWhere(['like', 'rutas', $q]);
        }

        $out['results'] = $query->limit(20)->asArray()->all();
        return $out;
    }

    public function actionObtenerRecargo($hora)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        // 1. Limpieza absoluta de la hora
        // Si llega "14:30" o "14:30:00" o incluso con fecha, esto lo estandariza
        $timestamp = strtotime($hora);
        if (!$timestamp) {
            return ['success' => true, 'recargo' => 0, 'descripcion' => 'Hora no válida'];
        }
        
        $time = date('H:i:s', $timestamp);

        // 2. Consulta con soporte para cruce de medianoche (ej: 22:00 a 06:00)
        // Usamos SQL puro para evitar errores de interpretación del modelo
        $horario = \backend\models\Horario::find()
            ->where("
                (hora_desde <= hora_hasta AND :time1 BETWEEN hora_desde AND hora_hasta)
                OR 
                (hora_desde > hora_hasta AND (:time2 >= hora_desde OR :time3 <= hora_hasta))
            ", [
                ':time1' => $time,
                ':time2' => $time,
                ':time3' => $time
            ])->one();

        if ($horario) {
            return [
                'success' => true,
                'recargo' => (float)$horario->recargo,
                'descripcion' => $horario->descripcion,
                'debug' => [
                    'hora_recibida' => $hora,
                    'hora_procesada' => $time,
                    'id_encontrado' => $horario->id_horario // Ajusta según tu PK
                ]
            ];
        }

        return [
            'success' => true,
            'recargo' => 0,
            'descripcion' => 'Tarifa Normal',
            'debug' => ['hora_procesada' => $time, 'status' => 'No se encontró rango']
        ];
    }

    public function actionGetProyectos($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        // Consulta directa para evitar fallos de relaciones en el modelo
        $proyectos = (new \yii\db\Query())
            ->select(['cp.id_cliente_proyecto as id', 'c.nombre_apellido as text', 'cp.cargo'])
            ->from('cliente_proyecto cp')
            ->innerJoin('cliente c', 'c.id_cliente = cp.id_empresa')
            ->where(['cp.id_cliente' => $id])
            ->all();

        return $proyectos;
    }
    
    public function actionGetDatosPasajero($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        // Si es un tag nuevo (texto), no buscamos en DB
        if (!is_numeric($id)) {
            return ['success' => false];
        }

        $pasajero = \backend\models\Pasajero::findOne($id);
        if ($pasajero) {
            return [
                'success' => true,
                'telefono' => $pasajero->telefono,
            ];
        }
        return ['success' => false];
    }

    public function actionCreate()
    {
        $model = new Servicios();

        if ($this->request->isPost) {
            $postData = $this->request->post();
            
            if ($model->load($postData)) {
                $transaction = Yii::$app->db->beginTransaction();
                
                try {
                    // 1. GESTIÓN DE NUEVO CLIENTE (Step 1)
                    if (!empty($model->id_cliente) && !is_numeric($model->id_cliente)) {
                        $nuevoCliente = new \backend\models\Cliente();
                        $nuevoCliente->nombre_apellido = $model->id_cliente;
                        
                        // Ajustado al nombre exacto de tu columna en la base de datos
                        $nuevoCliente->telefono_principal = !empty($postData['ClienteNuevo']['telefono']) 
                            ? $postData['ClienteNuevo']['telefono'] 
                            : '0000';
                        
                        $nuevoCliente->id_tipo_cliente = 0; // Activo por defecto

                        if (!$nuevoCliente->save()) {
                            throw new \Exception("Error al crear el cliente: " . implode(', ', $nuevoCliente->getFirstErrors()));
                        }

                        // Asignamos el ID del cliente recién creado al modelo de servicios
                        $model->id_cliente = $nuevoCliente->id_cliente;
                    }

                    // CORRECCIÓN ID_CLIENTE: Si viene un proyecto del Step 1
                    if (!empty($postData['cliente_proyecto_id'])) {
                        $model->id_cliente = $postData['cliente_proyecto_id'];
                    }

                    // LIMPIEZA DE MONTOS
                    if (!empty($model->monto)) {
                        $model->monto = str_replace(',', '.', str_replace('.', '', $model->monto));
                    }
                    
                    // Mapeo manual de viáticos a la columna de la base de datos
                    $viaticosRaw = $postData['Servicios']['viaticos'] ?? '0';
                    $model->total_viatico = str_replace(',', '.', str_replace('.', '', $viaticosRaw));

                    // Datos obligatorios automáticos
                    $model->id_usuario = Yii::$app->user->identity->id;
                    $model->fecha_registro = date('Y-m-d');
                    $model->id_estatus = $model->id_estatus ?: 5; // Por defecto Agendado

                    if (!$model->save()) {
                        $error = current($model->getFirstErrors());
                        throw new \Exception("Error en Servicio: " . $error);
                    }

                    // 3. GUARDAR PASAJEROS (Step 2)
                    if (!empty($postData['Pasajeros'])) {
                        foreach ($postData['Pasajeros'] as $index => $data) {
                            if (empty($data['id_pasajero'])) continue;

                            $ps = new \backend\models\PasajeroServicio();
                            $ps->id_servicio = $model->id_servicio;
                            $ps->fecha = $model->fecha_servicio;

                            // Si es nuevo pasajero (el usuario escribió texto en el Select2)
                            if (!is_numeric($data['id_pasajero'])) {
                                $nuevoP = new \backend\models\Pasajero();
                                $nuevoP->nombre_apellido = $data['id_pasajero'];
                                
                                // Capturamos el teléfono del pasajero que viaja en el array del Step 2
                                $nuevoP->telefono = !empty($data['telefono']) ? $data['telefono'] : '0000'; 
                                
                                if (!$nuevoP->save()) {
                                    throw new \Exception("Error creando pasajero: " . current($nuevoP->getFirstErrors()));
                                }
                                $ps->id_pasajero = $nuevoP->id_pasajero;
                            } else {
                                // Si el pasajero ya existe, guardamos su ID
                                $ps->id_pasajero = $data['id_pasajero'];
                                
                                // OPCIONAL: Si quieres actualizar el teléfono del pasajero existente si viene uno nuevo
                                if (!empty($data['telefono'])) {
                                    $pExistente = \backend\models\Pasajero::findOne($data['id_pasajero']);
                                    if ($pExistente && $pExistente->telefono !== $data['telefono']) {
                                        $pExistente->telefono = $data['telefono'];
                                        $pExistente->save(false); // Guardar sin validar para agilizar
                                    }
                                }
                            }

                            $ps->origen = $data['origen'] ?? 'N/A';
                            $ps->destino = $data['destino'] ?? 'N/A';
                            $ps->hora = $data['hora'] ?? date('H:i');
                            $ps->google_map = $data['google_map'] ?? null;
                            
                            if (!$ps->save()) {
                                $msg = "Error en Pasajero " . ($index + 1) . ": " . implode(', ', $ps->getFirstErrors());
                                throw new \Exception($msg);
                            }
                        }
                    }

                    // 4. GUARDAR ADICIONALES
                    if (isset($postData['Servicios']['adicionales'])) {
                        foreach ($postData['Servicios']['adicionales'] as $id_var) {
                            $montoV = (new \yii\db\Query())->select(['monto'])->from('lista_precio')
                                        ->where(['id_variable' => $id_var])->scalar() ?: 0;

                            $sa = new \backend\models\ServicioVariables();
                            $sa->id_servicio = $model->id_servicio;
                            $sa->id_variable_servicio = $id_var;
                            $sa->monto = $montoV;
                            $sa->cantidad = 1;
                            if (!$sa->save()) {
                                throw new \Exception("Error en Adicional");
                            }
                        }
                    }

                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id_servicio]);

                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        return $this->render('create', ['model' => $model]);
    }

    /////// REVISAR FUNCION/////////////////////////////
    public function actionGetPrecioRuta($id_detalle, $tipo_vehiculo)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        // Buscamos en tu tabla de tarifario (ajusta el nombre del modelo según tu proyecto)
        $detalle = \backend\models\TarifarioDetalle::findOne($id_detalle);
        
        if ($detalle) {
            // Suponiendo 1 = Sedan, 2 = Camioneta
            $monto = ($tipo_vehiculo == 1) ? $detalle->monto_sedan : $detalle->monto_camioneta;
            return [
                'success' => true,
                'monto' => $monto,
                'viatico' => $detalle->viatico ?? 0,
            ];
        }
        
        return ['success' => false, 'monto' => 0, 'viatico' => 0];
    }

    public function actionCreateproyecto()
    {

        $model = new Servicios();
        $model2 = new Tarifario();
        $model3 = new Cliente();
        $model4 = new ClienteProyecto();
        $model5 = new PasajeroServicio();
        $model6 = new Pasajero();

        if ($model->load(Yii::$app->request->post())) {



            //Tipo de Vehiculo
            switch ($_POST['Servicios']['item_tipo_vehiculo']) {
                case 'Sedán':
                    $tipo_vehiculo = 1;
                    break;
                case 'Camioneta':
                    $tipo_vehiculo = 2;
                    break;
                case 'Autobus':
                    $tipo_vehiculo = 3;
                    break;
                case 'Van':
                    $tipo_vehiculo = 5;
                    break;
            }

            //Tipo de Ruta
            if ($_POST['Servicios']['item_ruta'] == 'Gran Caracas')
                $ruta = 2;
            else
                $ruta = 1;

            //Guardamos el servicio

            //*** SERVICIOS *****

            $model->fecha_registro = date("Y-m-d");
            $model->id_tipo_vehiculo = $tipo_vehiculo;
            $model->id_tipo_traslado_ruta = $ruta;
            $model->km_servicio = $_POST['Servicios']['km_servicio'];
            $model->monto = $_POST['Servicios']['monto'];
            $model->id_estatus = 4;
            $model->tipo_servicio = 2;
            if ($_POST['Servicios']['item_horario'] == 'Diurno')
                $ruta = 1;
            else
                $ruta = 2;
            $model->id_tipo_ruta = $ruta;
            $model->id_usuario = Yii::$app->user->identity->id;
            if ($_POST['Servicios']['observacion_inicial'])
                $model->observacion_inicial = $_POST['Servicios']['observacion_inicial'];
            else
                $model->observacion_inicial = 'Registro Inicial del servicio';


            $model->save(false);

            $id_servicio = $model->id_servicio;

            //**** VARIABLE DEL SERVICIO */
            if (($_POST['Servicios']['subtotal_v1'] != '') or
                ($_POST['Servicios']['subtotal_v2'] != '') or ($_POST['Servicios']['subtotal_v3'] != '')
                or ($_POST['Servicios']['subtotal_v4'] != '') or ($_POST['Servicios']['subtotal_v5'] != '')
                or ($_POST['Servicios']['subtotal_v6'] != '')
            ) {

                if ($_POST['Servicios']['subtotal_v1'] != '') {
                    $model_ser_var = new ServicioVariables();
                    $model_ser_var->id_servicio = $id_servicio;
                    $model_ser_var->id_variable_servicio = $_POST['Servicios']['variable1'];
                    $model_ser_var->monto = $_POST['Servicios']['monto_v1'];
                    $model_ser_var->cantidad = $_POST['Servicios']['cant_v1'];
                    $model_ser_var->save(false);
                }
                if ($_POST['Servicios']['subtotal_v2'] != '') {
                    $model_ser_var = new ServicioVariables();
                    $model_ser_var->id_servicio = $id_servicio;
                    $model_ser_var->id_variable_servicio = $_POST['Servicios']['variable2'];
                    $model_ser_var->monto = $_POST['Servicios']['monto_v2'];
                    $model_ser_var->cantidad = $_POST['Servicios']['cant_v2'];
                    $model_ser_var->save(false);
                }
                if ($_POST['Servicios']['subtotal_v3'] != '') {
                    $model_ser_var = new ServicioVariables();
                    $model_ser_var->id_servicio = $id_servicio;
                    $model_ser_var->id_variable_servicio = $_POST['Servicios']['variable3'];
                    $model_ser_var->monto = $_POST['Servicios']['monto_v3'];
                    $model_ser_var->cantidad = $_POST['Servicios']['cant_v3'];
                    $model_ser_var->save(false);
                }
                if ($_POST['Servicios']['subtotal_v4'] != '') {
                    $model_ser_var = new ServicioVariables();
                    $model_ser_var->id_servicio = $id_servicio;
                    $model_ser_var->id_variable_servicio = $_POST['Servicios']['variable4'];
                    $model_ser_var->monto = $_POST['Servicios']['monto_v4'];
                    $model_ser_var->cantidad = $_POST['Servicios']['cant_v4'];
                    $model_ser_var->save(false);
                }
                if ($_POST['Servicios']['subtotal_v5'] != '') {
                    $model_ser_var = new ServicioVariables();
                    $model_ser_var->id_servicio = $id_servicio;
                    $model_ser_var->id_variable_servicio = $_POST['Servicios']['variable5'];
                    $model_ser_var->monto = $_POST['Servicios']['monto_v5'];
                    $model_ser_var->cantidad = $_POST['Servicios']['cant_v5'];
                    $model_ser_var->save(false);
                }
                if ($_POST['Servicios']['subtotal_v6'] != '') {
                    $model_ser_var = new ServicioVariables();
                    $model_ser_var->id_servicio = $id_servicio;
                    $model_ser_var->id_variable_servicio = $_POST['Servicios']['variable6'];
                    $model_ser_var->monto = $_POST['Servicios']['monto_v6'];
                    $model_ser_var->cantidad = $_POST['Servicios']['cant_v6'];
                    $model_ser_var->save(false);
                }
            }


            //****PASAJERO** */

            if ($_POST['Pasajero']['nombre_apellido'] != '') {
                //Buscamos si el pasajero existe
                $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre_apellido']])
                    ->andWhere(['telefono' => $_POST['Pasajero']['telefono']])
                    ->one();

                if ($pax) {
                    $model5->id_pasajero = $pax['id_pasajero'];
                } else {
                    $model6 = new Pasajero();
                    $model6->nombre_apellido = $_POST['Pasajero']['nombre_apellido'];
                    $model6->telefono = $_POST['Pasajero']['telefono'];
                    $model6->save(false);

                    $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre_apellido']])
                        ->andWhere(['telefono' => $_POST['Pasajero']['telefono']])
                        ->one();
                }


                $model5 = new PasajeroServicio();
                $model5->id_servicio = $id_servicio;
                $model5->id_pasajero = $pax['id_pasajero'];
                $model5->hora = $_POST['hora'];
                $fecha = explode("/", $_POST['PasajeroServicio']['fecha']);
                $model5->fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $model5->origen = $_POST['PasajeroServicio']['origen'];
                $model5->destino = $_POST['PasajeroServicio']['destino'];
                $model5->save(false);


                Servicios::updateAll(
                    [
                        'fecha_servicio' => $model5->fecha,
                    ],
                    'id_servicio= ' . $id_servicio
                );
            }


            if ($_POST['Pasajero']['nombre1'] != '') {
                //Buscamos si el pasajero existe
                $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre1']])
                    ->andWhere(['telefono' => $_POST['Pasajero']['telefono1']])
                    ->one();



                $fecha = explode("/", $_POST['PasajeroServicio']['fecha1']);
                $model5->fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                Servicios::updateAll(
                    [
                        'fecha_servicio' => $model5->fecha,
                    ],
                    'id_servicio= ' . $id_servicio
                );


                //Pasajero Servicio
                $model5 = new PasajeroServicio();
                $model5->id_servicio = $id_servicio;
                $model5->hora = $_POST['PasajeroServicio']['hora1'];
                $fecha = explode("/", $_POST['PasajeroServicio']['fecha1']);
                $model5->fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $model5->origen = $_POST['PasajeroServicio']['origen1'];
                $model5->destino = $_POST['PasajeroServicio']['destino1'];

                if ($pax) {
                    $model5->id_pasajero = $pax['id_pasajero'];
                } else {
                    $model6 = new Pasajero();
                    $model6->nombre_apellido = $_POST['Pasajero']['nombre1'];
                    $model6->telefono = $_POST['Pasajero']['telefono1'];
                    $model6->save(false);
                    $model5->id_pasajero = $model6->id_pasajero;
                }
                $model5->save(false);
            }

            if ($_POST['Pasajero']['nombre2'] != '') {
                //Buscamos si el pasajero existe
                $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre2']])
                    ->andWhere(['telefono' => $_POST['Pasajero']['telefono2']])
                    ->one();

                //Pasajero Servicio
                $model5 = new PasajeroServicio();
                $model5->id_servicio = $id_servicio;
                $model5->hora = $_POST['PasajeroServicio']['hora2'];
                $fecha = explode("/", $_POST['PasajeroServicio']['fecha2']);
                $model5->fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $model5->origen = $_POST['PasajeroServicio']['origen2'];
                $model5->destino = $_POST['PasajeroServicio']['destino2'];

                if ($pax) {
                    $model5->id_pasajero = $pax->id_pasajero;
                } else {
                    $model6 = new Pasajero();
                    $model6->nombre_apellido = $_POST['Pasajero']['nombre2'];
                    $model6->telefono = $_POST['Pasajero']['telefono2'];
                    $model6->save(false);
                    $model5->id_pasajero = $model6->id_pasajero;
                }
                $model5->save(false);
            }

            if ($_POST['Pasajero']['nombre3'] != '') {
                //Buscamos si el pasajero existe
                $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre3']])
                    ->andWhere(['telefono' => $_POST['Pasajero']['telefono3']])
                    ->one();

                //Pasajero Servicio
                $model5 = new PasajeroServicio();
                $model5->id_servicio = $id_servicio;
                $model5->hora = $_POST['PasajeroServicio']['hora3'];
                $fecha = explode("/", $_POST['PasajeroServicio']['fecha3']);
                $model5->fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $model5->origen = $_POST['PasajeroServicio']['origen3'];
                $model5->destino = $_POST['PasajeroServicio']['destino3'];

                if ($pax) {
                    $model5->id_pasajero = $pax->id_pasajero;
                } else {
                    $model6 = new Pasajero();
                    $model6->nombre_apellido = $_POST['Pasajero']['nombre3'];
                    $model6->telefono = $_POST['Pasajero']['telefono3'];
                    $model6->save(false);
                    $model5->id_pasajero = $model6->id_pasajero;
                }
                $model5->save(false);
            }

            if ($_POST['Pasajero']['nombre4'] != '') {
                //Buscamos si el pasajero existe
                $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre4']])
                    ->andWhere(['telefono' => $_POST['Pasajero']['telefono4']])
                    ->one();

                //Pasajero Servicio
                $model5 = new PasajeroServicio();
                $model5->id_servicio = $id_servicio;
                $model5->hora = $_POST['PasajeroServicio']['hora4'];
                $fecha = explode("/", $_POST['PasajeroServicio']['fecha4']);
                $model5->fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $model5->origen = $_POST['PasajeroServicio']['origen4'];
                $model5->destino = $_POST['PasajeroServicio']['destino4'];

                if ($pax) {
                    $model5->id_pasajero = $pax->id_pasajero;
                } else {
                    $model6 = new Pasajero();
                    $model6->nombre_apellido = $_POST['Pasajero']['nombre4'];
                    $model6->telefono = $_POST['Pasajero']['telefono4'];
                    $model6->save(false);
                    $model5->id_pasajero = $model6->id_pasajero;
                }
                $model5->save(false);
            }
            //****CLIENTE** */
            $cliente = Cliente::find()->where(['cedula' => $_POST['Cliente']['cedula_rif_serv']])->one();
            if ($cliente) {
                Servicios::updateAll(
                    [
                        'id_cliente' => $cliente->id_cliente,
                    ],
                    'id_servicio= ' . $id_servicio
                );
            } else {
                $model3 = new Cliente();
                $model3->cedula = $_POST['Cliente']['cedula_rif_serv'];
                $model3->nombre_apellido = $_POST['Cliente']['nombre_apellido'];
                $model3->telefono_principal = $_POST['Cliente']['telefono_principal'];
                $model3->telefono_alterno = $_POST['Cliente']['telefono_alterno'];
                $model3->correo = $_POST['Cliente']['correo'];
                $model3->direccion = $_POST['Cliente']['direccion'];

                $model3->save(false);

                Servicios::updateAll(
                    [
                        'id_cliente' => $model3->id_cliente,
                        'observacion_inicial' => $_POST['Servicios']['observacion_inicial'],
                    ],
                    'id_servicio= ' . $id_servicio
                );
            }

            //Registro del movimiento
            $model10 = new MovServicio();
            $model10->id_servicio = $id_servicio;
            $model10->id_estatus = 4;
            $model10->id_usuario = Yii::$app->user->identity->id;
            $model10->observacion = $_POST['Servicios']['observacion_inicial'];
            $model10->save(false);

            Servicios::updateAll(
                [
                    'fecha_servicio' => $model5->fecha,
                ],
                'id_servicio= ' . $id_servicio
            );


            \Yii::$app->getSession()->setFlash('success', '<center><h2><b>Servicio registrado con éxito</b></h2></center> ');

            return $this->redirect(['indexproyecto']);
        }

        return $this->render('createproyecto', [
            'model' => $model,
            'model2' => $model2,
            'model3' => $model3,
            'model4' => $model4,
            'model5' => $model5,
            'model6' => $model6,
        ]);
    }

    public function actionImagen($id)
    {
        $model = $this->findModel($id);

        return $this->render('imageninfo', [
            'model' => $model,
        ]);
    }

    public function actionAgendar_old($id)
    {
        $model = $this->findModel($id);

        $model3=  new ServicioPago();

        $direccion = '';
        if ($model->tipo_servicio == 1)
            $direccion = 'index';
        else
            $direccion = 'indexproyecto';
        $model2 = new MovServicio();

        if ($model->load(Yii::$app->request->post())) {

            //var_dump($_POST); die();
            if ($_POST['Servicios']['flota_conductor'] != '') {
                $flota = VFlota::find()->where(['id_conductor' => $_POST['Servicios']['flota_conductor']])->one();

                Servicios::updateAll(
                    [
                        'id_conductor' =>  $flota->id_conductor,
                        'id_flota' => $flota->id_flota,
                        'id_estatus' => 5,
                    ],
                    'id_servicio= ' . $_POST['Servicios']['id_servicio']
                );
                if ($_POST['ServicioPago']['id_metodo']== 1){
                    $model3->id_metodo = 4;
                    $model3->fecha_pago = $model->fecha_servicio;
                    $model3->id_tipo_moneda = '$';
                    $model3->tipo_pago = 'Efectivo (Divisas)';
                    $model3->monto =  $model->monto;
                    $model3->faltante =  0;
                    $model3->observacion_pago =  $_POST['MovServicio']['observacion'];
                    $model3->procedencia =  'Pago Total: Al generarse el servicio cancelará en efectivo en divisa.';
                    $model3->id_servicio =$_POST['Servicios']['id_servicio'] ;
                    $model3->save(false);
                }
               
            }


            //Registro del movimiento

            $model2->id_servicio = $_POST['Servicios']['id_servicio'];
            $model2->id_estatus = 5;
            $model2->id_usuario = Yii::$app->user->identity->id;
            $model2->observacion = $_POST['MovServicio']['observacion'];
            $model2->save(false);

            \Yii::$app->getSession()->setFlash('success', '<center><h2><b>Servicio Agendado</b></h2></center> ');

            return $this->redirect([$direccion]);
        }

        return $this->render('agendar', [
            'model' => $model,
            'model2' => $model2,
            'model3' => $model3,
        ]);
    }

    public function actionBorrarpago($id,$id_servicio)
    { 
        //Cuentos pagos tenemos para cambiar el estatus del servicio
        $pagos = ServicioPago::find()->where(['id_servicio' => $id_servicio])->all();
               
        $model = ServicioPago::find()->where(['id_pago' => $id])
        ->one();


        $cadena_pago_servicio= "Pago Eliminado Referencia: " . $model->referencia . " - Monto: " . $model->monto . " - Tipo de moneda: " . $model-> id_tipo_moneda. " - Fecha: " . $model->fecha_pago . " - Tipo de Pago: " . $model->tipo_pago ;

        if ($model) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Registro borrado correctamente.');
            
            if (count($pagos) == 1) {
                Servicios::updateAll(
                    [
                        'id_estatus' => 5,
                        'faltante' => NULL,
                    ],
                    'id_servicio= ' . $id_servicio
                );

                //Registro del movimiento
                $model2 = new MovServicio();
                $model2->id_servicio = $id_servicio;
                $model2->id_estatus = 5;
                $model2->id_usuario = Yii::$app->user->identity->id;
                $model2->observacion = $cadena_pago_servicio;
                $model2->save(false);

            } else { // Revisar si el servicio tiene pagos parciales
                Servicios::updateAll(
                    [
                        'faltante' => $model->monto,
                    ],
                    'id_servicio= ' . $id_servicio
                );
            }

        } else {
            Yii::$app->session->setFlash('error', 'Error al borrar el registro.');
        }

        return $this->redirect(['index']); // Redirigir a la lista o a donde desees
    }

    public function actionPagar($id)
    {
        $model = $this->findModel($id);
        $model2 = new MovServicio();
        $model3 = new ServicioPago();

        // Historial de pagos para calcular el faltante real anterior
        $pagos = ServicioPago::find()
            ->where(['id_servicio' => $id])
            ->orderBy(['id_pago' => SORT_DESC])
            ->all();
        
        // Si no hay pagos previos, el faltante inicial es el monto original del servicio
        $faltante_anterior_divisas = (empty($pagos)) ? (float)$model->monto : (float)$pagos[0]->faltante;

        if ($model3->load(Yii::$app->request->post())) {
            $tasa = Tasadia::find()->where(['id_estatus' => TRUE])->one();
            $postData = Yii::$app->request->post('ServicioPago');

            // Normalización de fecha
            $fecha_pago = $postData['fecha_pago'];
            $fecha_db = (strpos($fecha_pago, '/') !== false) 
                ? implode("-", array_reverse(explode("/", $fecha_pago))) 
                : $fecha_pago;

            // Validación: No permitir fechas futuras
            if (strtotime($fecha_db) > strtotime(date('Y-m-d'))) {
                Yii::$app->session->setFlash('error', 'La fecha no puede ser una fecha futura.');
                return $this->render('pagar', [
                    'model' => $model, 'model2' => $model2, 'model3' => $model3, 'pagos' => $pagos,
                ]);
            }

            // Conversión de montos a divisas (base de cálculo)
            $monto_ingresado = (float)$postData['monto'];
            $pago_actual_divisas = ($postData['id_tipo_moneda'] === '$') 
                ? $monto_ingresado 
                : ($monto_ingresado / $tasa->valor);

            // --- LÓGICA DE PRECISIÓN PARA ESTATUS ---
            $nuevo_faltante = $faltante_anterior_divisas - $pago_actual_divisas;

            // Si el remanente es menor o igual a 0.1, se marca como TOTAL
            if ($nuevo_faltante <= 0.1) {
                $estatus = 7; // Pagado Total
                $desc_pago = "Total";
                $faltante_final = 0; 
            } else {
                $estatus = 6; // Pago Parcial
                $desc_pago = "Parcial";
                $faltante_final = round($nuevo_faltante, 2);
            }

            // Configuración de origen y método
            $banco_origen = ($postData['tipo_pago'] == 'Efectivo (Divisas)') ? 0 : ($postData['banco_origen'] ?? 0);
            $id_metodo = ($postData['tipo_pago'] == 'Efectivo (Divisas)') ? 4 : $postData['id_metodo'];

            // Guardar en servicio_pago
            $model3->attributes = $postData;
            $model3->id_servicio = $id;
            $model3->fecha_pago = $fecha_db;
            $model3->id_metodo = $id_metodo;
            $model3->banco_origen = $banco_origen;
            $model3->faltante = $faltante_final;
            $model3->tasa = $tasa->valor;
            $model3->ref_divisas = round($pago_actual_divisas, 2);
            $model3->id_usuario = Yii::$app->user->identity->id;
            $model3->procedencia = "Pago $desc_pago relacionado al Servicio Nro. $id";
            
            if ($model3->save(false)) {
                // 1. Registro de Movimiento
                $model2->id_servicio = $id;
                $model2->id_estatus = $estatus;
                $model2->id_usuario = Yii::$app->user->identity->id;
                $model2->observacion = "Pago $desc_pago del servicio nro $id";
                $model2->save(false);

                // 2. Actualización de Servicio
                \backend\models\Servicios::updateAll([
                    'id_estatus' => $estatus,
                    'faltante' => $faltante_final,
                ], ['id_servicio' => $id]);

                Yii::$app->session->setFlash('success', "Pago $desc_pago registrado correctamente.");
                return $this->redirect(['index']);
            }
        }

        return $this->render('pagar', [
            'model' => $model,
            'model2' => $model2,
            'model3' => $model3,
            'pagos' => $pagos,
        ]);
    }
 
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Servicios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionIndexReporte()
    {
        $model = new VServicios();
        return $this->render('index_reporte', [
            'model' => $model,
        ]);
    }

    public function actionResumenServicios()
    {
        $model =  VServicios::find();
        $variables = Yii::$app->request->post();
        $tip_rep = Yii::$app->request->post('bt');

        if ($variables['VServicios']['fecha_servicio_desde'] and $variables['VServicios']['fecha_servicio_hasta']) {
            $fecha = explode("-", $variables['VServicios']['fecha_servicio_desde']);
            $fecha_servicio = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
            $fecha = explode("-", $variables['VServicios']['fecha_servicio_hasta']);
            $fecha_servicio_fin = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
            $model->andFilterWhere(['between', 'fecha_servicio', $fecha_servicio, $fecha_servicio_fin]);
        }

        $model = $model->all();

        if ($tip_rep == '0') {
            $content = $this->renderPartial('resumen_servicios_excel', ['model' => $model]);
        }
    }

    public function actionGestionPago()
    {
        $model =  VServicios::find();
        $model2 =  VServiciosProyecto::find();

        $variables = Yii::$app->request->post();
        $tip_rep = Yii::$app->request->post('bt');

        //var_dump($variables);   die();

        if ($variables['VServicios']['fecha_gestion_pago_desde'] and $variables['VServicios']['fecha_gestion_pago_hasta']) {
            $fecha = explode("-", $variables['VServicios']['fecha_gestion_pago_desde']);
            $fecha_servicio = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
            $fecha = explode("-", $variables['VServicios']['fecha_gestion_pago_hasta']);
            $fecha_servicio_fin = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
            
            //Formas de pago por Servicio
            $connection = \Yii::$app->db;

            $tipo_pago=$connection->createCommand("select count(a.id_servicio) as id_servicio, b.tipo_pago,
            ROUND(b.monto, 2) as monto
            from v_servicios a
            inner join servicio_pago b on a.id_servicio =b.id_servicio
            where fecha_servicio between '".$fecha_servicio."' and '".$fecha_servicio_fin."'
            and tipo_servicio = 1
            GROUP BY id_estatus ORDER BY id_estatus");

            $rowproducto= $tipo_pago->queryall();  

            $tipo_pago=$connection->createCommand("select count(a.id_servicio) as id_servicio, b.tipo_pago,
            ROUND(b.monto, 2) as monto
            from v_servicios a
            inner join servicio_pago b on a.id_servicio =b.id_servicio
            where fecha_servicio between '".$fecha_servicio."' and '".$fecha_servicio_fin."'
            and tipo_servicio = 2
            GROUP BY id_estatus ORDER BY id_estatus");

            $rowpr2= $tipo_pago->queryall();           
                        
        }
       // var_dump($rowproducto); die();

        $content = $this->renderPartial('resumen_gestion_pago_excel', ['model' => $rowproducto,
        'model2' => $rowpr2]);
    }

    public function actionConcretar($id)
    {
        $model = $this->findModel($id);
        $model2 = new MovServicio();        //Registro del movimiento

        $model2->id_servicio =  $id;
        $model2->id_estatus = 8;
        $model2->id_usuario = Yii::$app->user->identity->id;
        $model2->observacion = "Servicio Concretado";
        $model2->save(false);

        //Actualizar campo de nuevo del cliente
        $model3 = Cliente::find()->where(['id_cliente' => $model->id_cliente])->one();
        $model3->updateAll(
            [
                'nuevo' => 0,
            ],
            'id_cliente= ' . $model3->id_cliente
        );

        Servicios::updateAll(
            [
                'id_estatus' => 8,
            ],
            'id_servicio= ' . $id
        );
        return $this->redirect(['index']);
    }

    public function actionModificarCliente($id)
    {  
        $model = $this->findModel($id);
        $model2 = VServicios::find()->where(['id_servicio' => $id])
        ->one();
        $model3 = Cliente::find()->where(['id_cliente' => $model2->id_cliente])
        ->one();

        $cliente_anterior= $model3->cedula. " - ".$model3->nombre_apellido;

        if ($model3->load(Yii::$app->request->post())) {
           
            //****CLIENTE** */
            $cliente = Cliente::find()->where(['cedula' => $_POST['Cliente']['cedula']])->one();

            if ($cliente) {
               
                Cliente::updateAll(
                    [
                        'cedula' => $_POST['Cliente']['cedula'],
                        'nombre_apellido' => $_POST['Cliente']['nombre_apellido'],
                        'telefono_principal' => $_POST['Cliente']['telefono_principal'],
                        'telefono_alterno' => $_POST['Cliente']['telefono_alterno'],
                        'correo' => $_POST['Cliente']['correo'],
                        'direccion' => $_POST['Cliente']['direccion'],
                    ],
                    'id_cliente= ' . $cliente->id_cliente
                );

                Servicios::updateAll(
                    [
                        'id_cliente' => $cliente->id_cliente,
                    ],
                    'id_servicio= ' . $id
                );

            } else {
                $model3 = new Cliente();
                $model3->cedula = $_POST['Cliente']['cedula'];
                $model3->nombre_apellido = $_POST['Cliente']['nombre_apellido'];
                $model3->telefono_principal = $_POST['Cliente']['telefono_principal'];
                $model3->telefono_alterno = $_POST['Cliente']['telefono_alterno'];
                $model3->correo = $_POST['Cliente']['correo'];
                $model3->direccion = $_POST['Cliente']['direccion'];

                $model3->save(false);

                Servicios::updateAll(
                    [
                        'id_cliente' => $model3->id_cliente,
                    ],
                    'id_servicio= ' . $id
                );
            }

            $model = $this->findModel($id);
            $model2 = VServicios::find()->where(['id_servicio' => $id])
            ->one();

            //Registro del movimiento
            $model10 = new MovServicio();
            $model10->id_servicio = $id;
            $model10->id_estatus = $model2->id_estatus;
            $model10->id_usuario = Yii::$app->user->identity->id;
            $model10->observacion = "Modificación de datos del cliente - ".$cliente_anterior." a ". $_POST['Cliente']['cedula']. " - ".$_POST['Cliente']['nombre_apellido'];
            $model10->save(false);

            \Yii::$app->getSession()->setFlash('success', '<center><h2><b>Cliente modificado con éxito</b></h2></center> ');

            return $this->render('_form_update', [
                'model' => $model,
                'model2' => $model2,
                'model3' => $model3,
            ]);
        }

        return $this->render('_form_update_cliente', [
            'model' => $model,
            'model2' => $model2,
            'model3' => $model3,
        ]);

        
    }

    public function actionModificarPasajeros($id)
    {  
        $model = $this->findModel($id);
        $model2 = VServicios::find()->where(['id_servicio' => $id])
        ->one();
        $model3 = Cliente::find()->where(['id_cliente' => $model2->id_cliente])
        ->one();

        $model5 = PasajeroServicio::find()->where(['id_servicio' => $id]);
        $model6 = new Pasajero();  
        $model7 = new PasajeroServicio();  
        
        if (empty($model5)) {
            $registros = 0;
        }else{
            $registros = $model5;
        }
       
        if ($model6->load(Yii::$app->request->post())) {
           
            //****PASAJERO** */

            if ($_POST['Pasajero']['nombre_apellido'] != '') {
                //Buscamos si el pasajero existe
                $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre_apellido']])
                    ->andWhere(['telefono' => $_POST['Pasajero']['telefono']])
                    ->one();

                if ($pax) {
                    $model5->id_pasajero = $pax['id_pasajero'];
                } else {
                    $model6 = new Pasajero();
                    $model6->nombre_apellido = $_POST['Pasajero']['nombre_apellido'];
                    $model6->telefono = $_POST['Pasajero']['telefono'];
                    $model6->save(false);

                    $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre_apellido']])
                        ->andWhere(['telefono' => $_POST['Pasajero']['telefono']])
                        ->one();
                }


                $model5 = new PasajeroServicio();
                $model5->id_servicio = $id;
                $model5->id_pasajero = $pax['id_pasajero'];
                $model5->hora = $_POST['hora'];
                $fecha = explode("/", $_POST['PasajeroServicio']['fecha']);
                $model5->fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $model5->origen = $_POST['PasajeroServicio']['origen'];
                $model5->destino = $_POST['PasajeroServicio']['destino'];
                $model5->save(false);

            }


            if ($_POST['Pasajero']['nombre1'] != '') {
                //Buscamos si el pasajero existe
                $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre1']])
                    ->andWhere(['telefono' => $_POST['Pasajero']['telefono1']])
                    ->one();

              


                //Pasajero Servicio
                $model5 = new PasajeroServicio();
                $model5->id_servicio = $id;
                $model5->hora = $_POST['PasajeroServicio']['hora1'];
                $fecha = explode("/", $_POST['PasajeroServicio']['fecha1']);
                $model5->fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $model5->origen = $_POST['PasajeroServicio']['origen1'];
                $model5->destino = $_POST['PasajeroServicio']['destino1'];

                if ($pax) {
                    $model5->id_pasajero = $pax['id_pasajero'];
                } else {
                    $model6 = new Pasajero();
                    $model6->nombre_apellido = $_POST['Pasajero']['nombre1'];
                    $model6->telefono = $_POST['Pasajero']['telefono1'];
                    $model6->save(false);
                    $model5->id_pasajero = $model6->id_pasajero;
                }
                $model5->save(false);
            }

            if ($_POST['Pasajero']['nombre2'] != '') {
                //Buscamos si el pasajero existe
                $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre2']])
                    ->andWhere(['telefono' => $_POST['Pasajero']['telefono2']])
                    ->one();

                //Pasajero Servicio
                $model5 = new PasajeroServicio();
                $model5->id_servicio = $id;
                $model5->hora = $_POST['PasajeroServicio']['hora2'];
                $fecha = explode("/", $_POST['PasajeroServicio']['fecha2']);
                $model5->fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $model5->origen = $_POST['PasajeroServicio']['origen2'];
                $model5->destino = $_POST['PasajeroServicio']['destino2'];

                if ($pax) {
                    $model5->id_pasajero = $pax->id_pasajero;
                } else {
                    $model6 = new Pasajero();
                    $model6->nombre_apellido = $_POST['Pasajero']['nombre2'];
                    $model6->telefono = $_POST['Pasajero']['telefono2'];
                    $model6->save(false);
                    $model5->id_pasajero = $model6->id_pasajero;
                }
                $model5->save(false);
            }

            if ($_POST['Pasajero']['nombre3'] != '') {
                //Buscamos si el pasajero existe
                $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre3']])
                    ->andWhere(['telefono' => $_POST['Pasajero']['telefono3']])
                    ->one();

                //Pasajero Servicio
                $model5 = new PasajeroServicio();
                $model5->id_servicio = $id;
                $model5->hora = $_POST['PasajeroServicio']['hora3'];
                $fecha = explode("/", $_POST['PasajeroServicio']['fecha3']);
                $model5->fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $model5->origen = $_POST['PasajeroServicio']['origen3'];
                $model5->destino = $_POST['PasajeroServicio']['destino3'];

                if ($pax) {
                    $model5->id_pasajero = $pax->id_pasajero;
                } else {
                    $model6 = new Pasajero();
                    $model6->nombre_apellido = $_POST['Pasajero']['nombre3'];
                    $model6->telefono = $_POST['Pasajero']['telefono3'];
                    $model6->save(false);
                    $model5->id_pasajero = $model6->id_pasajero;
                }
                $model5->save(false);
            }

            if ($_POST['Pasajero']['nombre4'] != '') {
                //Buscamos si el pasajero existe
                $pax = Pasajero::find()->where(['nombre_apellido' => $_POST['Pasajero']['nombre4']])
                    ->andWhere(['telefono' => $_POST['Pasajero']['telefono4']])
                    ->one();

                //Pasajero Servicio
                $model5 = new PasajeroServicio();
                $model5->id_servicio = $id;
                $model5->hora = $_POST['PasajeroServicio']['hora4'];
                $fecha = explode("/", $_POST['PasajeroServicio']['fecha4']);
                $model5->fecha = $fecha[2] . "-" . $fecha[1] . "-" . $fecha[0];
                $model5->origen = $_POST['PasajeroServicio']['origen4'];
                $model5->destino = $_POST['PasajeroServicio']['destino4'];

                if ($pax) {
                    $model5->id_pasajero = $pax->id_pasajero;
                } else {
                    $model6 = new Pasajero();
                    $model6->nombre_apellido = $_POST['Pasajero']['nombre4'];
                    $model6->telefono = $_POST['Pasajero']['telefono4'];
                    $model6->save(false);
                    $model5->id_pasajero = $model6->id_pasajero;
                }
                $model5->save(false);
            }

            $model = $this->findModel($id);
            $model2 = VServicios::find()->where(['id_servicio' => $id])
            ->one();

            //Registro del movimiento
            $model10 = new MovServicio();
            $model10->id_servicio = $id;
            $model10->id_estatus = $model2->id_estatus;
            $model10->id_usuario = Yii::$app->user->identity->id;
            $model10->observacion = "Modificación de pasajero(s)";
            $model10->save(false);

            \Yii::$app->getSession()->setFlash('success', '<center><h2><b>Pasajero(s) modificado con éxito</b></h2></center> ');

            return $this->render('_form_update', [
                'model' => $model,
                'model2' => $model2,
                'model3' => $model3,
            ]);
        }

        return $this->render('_form_update_pasajeros', [
            'model' => $model,
            'model2' => $model2,
            'model3' => $model3,
            'model5' => $model5,
            'model6' => $model6,
            'model7' => $model7,
            'registros' => $registros,
        ]);
    }

    public function actionDeletePax($id, $id_servicio)
    {  
        //$this->findModel($id)->delete();
        $model = PasajeroServicio::find()->where(['id_servicio' => $id_servicio, 'id_pasajero' => $id])->one();
        $model->delete();

        \Yii::$app->getSession()->setFlash('success', '<center><h2><b>Registro borrado con exito</b></h2></center> ');

        $model = $this->findModel($id_servicio);
        $model2 = VServicios::find()->where(['id_servicio' => $id_servicio])
        ->one();
        $model3 = Cliente::find()->where(['id_cliente' => $model2->id_cliente])
        ->one();

        return $this->render('_form_update', [
            'model' => $model,
            'model2' => $model2,
            'model3' => $model3,
        ]);
    }

    public function actionCotizacionRapida()
    {
        $model = new Servicios();
        $model->id_estatus = 12; // Estatus fijo: Cotización/Por confirmar

        if ($this->request->isPost) {
            $postData = $this->request->post();
            if ($model->load($postData)) {
                // Limpieza de montos como ya sabemos hacer
                $model->monto = str_replace(',', '.', str_replace('.', '', $model->monto));
                $model->total_viatico = str_replace(',', '.', str_replace('.', '', $postData['Servicios']['viaticos'] ?? '0'));
                
                $model->id_usuario = Yii::$app->user->identity->id;
                $model->fecha_registro = date('Y-m-d');
                
                if ($model->save()) {
                    // Guardar las variables seleccionadas en servicio_variables
                    if (isset($postData['variables_cotizacion'])) {
                        foreach ($postData['variables_cotizacion'] as $id_var) {
                            $sv = new ServicioVariables();
                            $sv->id_servicio = $model->id_servicio;
                            $sv->id_variable_servicio = $id_var;
                            $sv->monto = $this->obtenerMontoVariable($id_var); // Función auxiliar
                            $sv->cantidad = 1;
                            $sv->save();
                        }
                    }
                    Yii::$app->session->setFlash('success', "Cotización #{$model->id_servicio} generada.");
                    return $this->redirect(['index-cotizaciones']);
                }
            }
        }

        return $this->render('cotizacion_rapida', ['model' => $model]);
    }

   public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        // 1. Obtener los adicionales guardados para calcular la base real
        $adicionalesModelos = \backend\models\ServicioVariables::find()
            ->where(['id_servicio' => $id])
            ->all();

        $sumaAdicionales = 0;
        $adicionalesGuardados = [];
        foreach ($adicionalesModelos as $relacion) {
            $sumaAdicionales += (float)$relacion->monto;
            $adicionalesGuardados[] = $relacion->id_variable_servicio;
        }

        // 2. Calcular la Base Real: Total - Recargo - Viáticos - Adicionales
        $baseCalculada = (float)$model->monto - (float)$model->monto_recargo - (float)$model->total_viatico - $sumaAdicionales;

        // 3. Asignar formatos para la vista (Separadores de miles punto, decimal coma)
        $model->monto_base = number_format($baseCalculada, 2, ',', '.');
        $model->monto_recargo = number_format($model->monto_recargo, 2, ',', '.');
        $model->viaticos = number_format($model->total_viatico, 2, ',', '.');

        // --- NUEVO: Obtener los pasajeros ya guardados para este servicio ---
        $pasajerosGuardados = \backend\models\PasajeroServicio::find()
            ->where(['id_servicio' => $id])
            ->all();

        if ($this->request->isPost && $model->load($this->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $postData = $this->request->post();

                if (!empty($postData['cliente_proyecto_id'])) {
                    $model->id_cliente = $postData['cliente_proyecto_id'];
                }

                // Limpieza de formatos antes de guardar
                $model->monto = str_replace(',', '.', str_replace('.', '', $model->monto));
                $model->monto_recargo = str_replace(',', '.', str_replace('.', '', $model->monto_recargo));
                
                $viaticosRaw = $postData['Servicios']['viaticos'] ?? '0';
                $model->total_viatico = str_replace(',', '.', str_replace('.', '', $viaticosRaw));

                if (!$model->save()) {
                    $error = current($model->getFirstErrors());
                    throw new \Exception("Error en Servicio: " . $error);
                }

                // Actualizar pasajeros (Borrar anteriores y guardar nuevos)
                \backend\models\PasajeroServicio::deleteAll(['id_servicio' => $model->id_servicio]);

                if (!empty($postData['Pasajeros'])) {
                    foreach ($postData['Pasajeros'] as $index => $data) {
                        if (empty($data['id_pasajero'])) continue;

                        $ps = new \backend\models\PasajeroServicio();
                        $ps->id_servicio = $model->id_servicio;
                        $ps->fecha = $model->fecha_servicio;

                        if (!is_numeric($data['id_pasajero'])) {
                            $nuevoP = new \backend\models\Pasajero();
                            $nuevoP->nombre_apellido = $data['id_pasajero'];
                            $nuevoP->telefono = '0000'; 
                            if(!$nuevoP->save()) {
                                throw new \Exception("Error creando pasajero: " . current($nuevoP->getFirstErrors()));
                            }
                            $ps->id_pasajero = $nuevoP->id_pasajero;
                        } else {
                            $ps->id_pasajero = $data['id_pasajero'];
                        }

                        $ps->origen = $data['origen'] ?? 'N/A';
                        $ps->destino = $data['destino'] ?? 'N/A';
                        $ps->hora = $data['hora'] ?? date('H:i');
                        
                        if (!$ps->save()) {
                            $msg = "Error en Pasajero ".($index+1).": " . implode(', ', $ps->getFirstErrors());
                            throw new \Exception($msg);
                        }
                    }
                }

                // Actualizar adicionales (Borrar anteriores y guardar nuevos)
                \backend\models\ServicioVariables::deleteAll(['id_servicio' => $model->id_servicio]);

                if (isset($postData['Servicios']['adicionales'])) {
                    foreach ($postData['Servicios']['adicionales'] as $id_var) {
                        $montoV = (new \yii\db\Query())->select(['monto'])->from('lista_precio')
                            ->where(['id_variable' => $id_var])->scalar() ?: 0;

                        $sa = new \backend\models\ServicioVariables();
                        $sa->id_servicio = $model->id_servicio;
                        $sa->id_variable_servicio = $id_var;
                        $sa->monto = $montoV;
                        $sa->cantidad = 1;
                        
                        if (!$sa->save()) {
                            throw new \Exception("Error en Adicional");
                        }
                    }
                }

                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id_servicio]);

            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $model,
            'variablesAdicionales' => \backend\models\VariablesServicio::find()->all(),
            'adicionalesGuardados' => $adicionalesGuardados,
            'adicionalesModelos' => $adicionalesModelos,
            'pasajerosGuardados' => $pasajerosGuardados, // Pasamos los pasajeros actuales a la vista
        ]);
    }

    public function actionConfirmar($id)
    {
        // Buscamos el modelo por su ID
        $model = $this->findModel($id);

        // Asignamos el ID de estatus correspondiente a 'Confirmado'
        $model->id_estatus = 11;

        // Intentamos guardar el cambio
        if ($model->save(false)) { // Usamos false para saltar validaciones de campos no relacionados si es necesario
            Yii::$app->session->setFlash('success', "El servicio #{$id} ha sido confirmado con éxito.");
        } else {
            Yii::$app->session->setFlash('error', "No se pudo confirmar el servicio.");
        }

        // Redireccionamos siempre al index para que permanezca en la misma vista
        return $this->redirect(['index']);
    }

    public function actionAgendar($id)
    {
        $model = $this->findModel($id);
        
        // 1. LISTA COMBO: Solo flotas que TIENEN un conductor asignado (v_flota hace LEFT JOIN, filtramos los que tengan ID conductor)
        $dataCombo = VFlota::find()->where(['not', ['id_conductor' => null]])->all();
        $listaFlotaAsignada = ArrayHelper::map($dataCombo, 'id_flota', 'flota_asignada_nombre');

        // 2. LISTA MANUAL - CONDUCTORES: Extraemos los conductores únicos de la tabla conductor
        $listaConductores = ArrayHelper::map(Conductor::find()->all(), 'id', function($c) {
            return $c->nombres . ' ' . $c->apellidos;
        });

        // 3. LISTA MANUAL - FLOTAS: Todas las flotas disponibles en la vista usando 'nombre_flota'
        // nombre_flota según tu SQL: placa + tipo + marca + color
        $dataTodasFlotas = VFlota::find()->all();
        $listaTodasFlotas = ArrayHelper::map($dataTodasFlotas, 'id_flota', 'nombre_flota');

        if ($model->load(Yii::$app->request->post())) {
            // Si la selección fue manual, el id_conductor ya viene en el POST
            // Si fue por combo, debemos asegurar que el id_conductor se guarde basado en la flota
            if (empty($model->id_conductor) && !empty($model->id_flota)) {
                $vf = VFlota::findOne(['id_flota' => $model->id_flota]);
                if ($vf) { $model->id_conductor = $vf->id_conductor; }
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id_servicio]);
            }
        }

        return $this->render('agendar', [
            'model' => $model,
            'listaFlota' => $listaFlotaAsignada,
            'listaConductores' => $listaConductores,
            'listaTodasFlotas' => $listaTodasFlotas,
        ]);
    }

    public function actionGetServiciosConductor($id, $tipo, $fecha)
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    $id_conductor = $id;
    
    // Si el ID viene de la flota, buscamos quién es el conductor de esa flota en la vista
    if ($tipo == 'flota') {
        $flota = VFlota::findOne(['id_flota' => $id]);
        $id_conductor = $flota ? $flota->id_conductor : null;
    }

    $servicios = \backend\models\Servicios::find()
        ->where(['id_conductor' => $id_conductor, 'fecha_servicio' => $fecha])
        ->all();
        
    $html = "";
    if ($servicios) {
        $html .= "<p style='color:#EA4C2D; font-size:10px; margin-bottom:5px;'>⚠️ Ocupado en estos horarios:</p>";
        foreach ($servicios as $s) {
            $html .= "<div class='info-mini-ticket'>#{$s->id_servicio} - Conf: " . ($s->id_estatus == 11 ? 'SI' : 'NO') . "</div>";
        }
    } else {
        $html = "<div class='text-success'><i class='fa fa-check-circle'></i> Disponible para esta fecha</div>";
    }
    
    return ['html' => $html];
}
}
