<?php

namespace backend\controllers;

use Yii;
use backend\models\EstadoCuenta;
use backend\models\EstadoCuentaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * EstadoCuentaController implements the CRUD actions for EstadoCuenta model.
 */
class EstadoCuentaController extends Controller
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
     * Lists all EstadoCuenta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EstadoCuentaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EstadoCuenta model.
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
     * Creates a new EstadoCuenta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EstadoCuenta();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idestado_cuenta]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EstadoCuenta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idestado_cuenta]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EstadoCuenta model.
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
     * Finds the EstadoCuenta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EstadoCuenta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EstadoCuenta::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionConfiguraciones()
    {
        // 1. Obtenemos las cuentas bancarias activas
        $cuentasActivas = \backend\models\CuentasBancarias::find()
            ->all();

        $disponibleTotal = 0;
        $disponibleTotalUsd = 0;

        foreach ($cuentasActivas as $cuenta) {
            // 2. Obtener la sumatoria de los movimientos de la tabla estado_cuenta
            // Como los egresos ya tienen signo negativo, la suma es directa
            $sumaMovimientos = \backend\models\EstadoCuenta::find()
                ->where([
                    'numero_cuenta' => $cuenta->numero_cuenta, 
                    'eliminado' => 0
                ])
                ->sum('monto') ?: 0;

            /**
             * 3. Cálculo del Saldo Real:
             * Saldo Inicial (de la tabla cuenta) + Sumatoria de Movimientos
             */
            $cuenta->saldo = $cuenta->saldo + $sumaMovimientos;
            
            // Acumulamos para el total de la vista
            $disponibleTotal += $cuenta->saldo;

            if ($cuenta->id_tipo_moneda === 2) {
                $disponibleTotalUsd += $cuenta->saldo;
            } else {
                $disponibleTotal += $cuenta->saldo;
            }

            $pendientesConciliar = \backend\models\EstadoCuenta::find()
        ->where(['conciliado' => 0, 'eliminado' => 0])
        ->count();
        }

        // He tomado nota de que debo sumar los movimientos al saldo inicial para futuros procesos.
        return $this->render('configuraciones', [
            'cuentasActivas' => $cuentasActivas,
            'disponibleTotal' => $disponibleTotal,
            'disponibleTotalUsd' => $disponibleTotalUsd,
            'pendientesConciliar' => $pendientesConciliar,
        ]);
    }

    public function actionSubirTxt()
    {
        set_time_limit(300);
        ini_set('memory_limit', '512M');

        $model = new EstadoCuenta();
        if ($model->load(Yii::$app->request->post())) {
            $referencia_cam = UploadedFile::getInstance($model, 'file');
            
            if ($referencia_cam !== null) {
                $referencia_cam_web_filename = Yii::$app->security->generateRandomString() . '.' . $referencia_cam->extension;
                $uploadPath = Yii::$app->basePath . '/web/uploads/txt/';
                
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                $path = $uploadPath . $referencia_cam_web_filename;

                if ($referencia_cam->saveAs($path)) {
                    $lines = file($path);
                    $errorMessages = [];
                    $validLines = [];
                    $errorCount = 0;
                    $contarbien = 0;

                    foreach ($lines as $index => $line) {
                        $line = trim($line);
                        if (empty($line)) continue;

                        $data = explode(';', $line);
                        if (count($data) !== 4) {
                            $errorCount++;
                            $errorMessages[] = "Línea " . ($index + 1) . ": Faltan columnas (se esperan 4).";
                            continue;
                        }

                        list($fecha, $referencia, $monto_raw, $numero_cuenta) = array_map('trim', $data);

                        // Limpieza estricta del monto
                        // Si el archivo trae "1.250,50", lo convertimos a "1250.50"
                        $monto_numeric = str_replace('.', '', $monto_raw); 
                        $monto_numeric = str_replace(',', '.', $monto_numeric);
                        $monto_numeric = (float) $monto_numeric;

                        $tipo_t = ($monto_numeric < 0) ? '-' : '+';
                        // Para la DB guardamos el valor absoluto o el real según tu preferencia, 
                        // aquí lo dejamos real (negativo si es egreso)
                        
                        $ref_limpia = str_pad($referencia, 20, "0", STR_PAD_LEFT);

                        // 1. Verificar Duplicados antes de intentar guardar
                        $existe = EstadoCuenta::find()->where([
                            'referencia' => $ref_limpia,
                            'fecha_transaccion' => $fecha,
                            'monto' => $monto_numeric,
                            'numero_cuenta' => $numero_cuenta,
                            'eliminado' => 0
                        ])->exists();

                        if (!$existe) {
                            $model2 = new EstadoCuenta();
                            $model2->fecha_transaccion = $fecha;
                            $model2->referencia = $ref_limpia;
                            $model2->monto = $monto_numeric;
                            $model2->numero_cuenta = $numero_cuenta;
                            $model2->tipo_transaccion = $tipo_t;
                            $model2->operador = Yii::$app->user->identity->id;
                            $model2->fecha_registro = date("Y-m-d");
                            $model2->hora = date('H:i:s');
                            $model2->eliminado = 0;

                            if ($model2->save()) {
                                $contarbien++;
                            } else {
                                $errorCount++;
                                // Capturamos el error real del modelo (ej: campo obligatorio faltante)
                                $errorMessages[] = "Línea " . ($index + 1) . ": Error al guardar -> " . implode(', ', $model2->getFirstErrors());
                            }
                        }
                    }

                    // Manejo de notificaciones
                    if ($contarbien > 0) {
                        Yii::$app->getSession()->setFlash('success', "Proceso finalizado. Se cargaron **$contarbien** nuevos registros.");
                    }
                    
                    if ($errorCount > 0) {
                        Yii::$app->getSession()->setFlash('danger', "Se encontraron $errorCount detalles:<br>" . implode('<br>', $errorMessages));
                    }

                    if ($contarbien === 0 && $errorCount === 0) {
                        Yii::$app->getSession()->setFlash('info', "No se cargaron registros nuevos (Todos los movimientos ya existían en el sistema).");
                    }

                    unlink($path);
                    return $this->redirect(['index']);
                }
            }
        }
        return $this->render('subirtxt', ['model' => $model]);
    }

     private function validateLine($fecha, $referencia, $saldo, $numero_cuenta, $tipo_t, $lineNumber)
    {
        $errors = [];

        // Validaciones para la referencia
        if (empty($referencia)) {
            $errors[] = "Línea $lineNumber: La referencia es obligatoria.";
        } elseif (!is_numeric($referencia)) {
            $errors[] = "Línea $lineNumber: La referencia debe ser numérica.";
        }

        // Validaciones para el saldo
        if (empty($saldo)) {
            $errors[] = "Línea $lineNumber: El saldo es obligatorio.";
        } elseif (!is_numeric($saldo)) {
            $errors[] = "Línea $lineNumber: El saldo debe ser numérico.";
        }

        // Validaciones para el número de cuenta
        if (empty($numero_cuenta)) {
            $errors[] = "Línea $lineNumber: El número de cuenta es obligatorio.";
        } elseif (!is_numeric($numero_cuenta)) {
            $errors[] = "Línea $lineNumber: El número de cuenta debe ser numérico.";
        } elseif (strlen($numero_cuenta) > 20) {
            $errors[] = "Línea $lineNumber: El número de cuenta debe tener un máximo de 20 dígitos.";
        }

        // Validaciones para la fecha
        if (empty($fecha)) {
            $errors[] = "Línea $lineNumber: La fecha es obligatoria.";
        } elseif (!$this->validacion_Lafecha_espanol($fecha)) {
            $errors[] = "Línea $lineNumber: Formato de fecha incorrecto (debe ser AAAA-MM-DD).";
        }

        // Validaciones para la fecha
        if (empty($tipo_t)) {
            $errors[] = "Línea $lineNumber: La tipo_t es obligatoria.";
        }
        return $errors;
    }

    public function validacion_Lafecha_espanol($Lafecha)
    {
        // $Lafecha='asdasd';
        $d1 = \DateTime::createFromFormat('d/m/Y', $Lafecha);
        $d2 = \DateTime::createFromFormat('d-m-Y', $Lafecha);
        $d3 = \DateTime::createFromFormat('Y/m/d', $Lafecha);
        $d4 = \DateTime::createFromFormat('Y/m/d', $Lafecha);
        if ($d1) {
            $Lafecha = $d1->format('d/m/Y');
        }
        if ($d2) {
            $Lafecha = $d2->format('d-m-Y');
        }
        if ($d3) {
            $Lafecha = $d3->format('Y/m/d');
        }
        if ($d4) {
            $Lafecha = $d4->format('Y/m/d');
        }
        // strtotime($Lafecha);
        $Lafecha = str_replace('/', '-', $Lafecha);
        $Lafecha = date_create($Lafecha);
        if (!$Lafecha) {
            return false;
        }
        $Lafecha = date_format($Lafecha, 'd-m-Y');
        $valores = explode('-', $Lafecha);
        if (!is_numeric($valores[1])) {
            return false;
        }
        if (!is_numeric($valores[2])) {
            return false;
        }
        if (!is_numeric($valores[0])) {
            return false;
        }
        // echo "<pre>";
        // print_r(checkdate($valores[1], $valores[2], $valores[0]));  // mes ,dia, año
        // echo "</pre>";
        // die;
        if (count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])) {
            return true;
        }
        return false;
    }

    public function actionRealizarCierre($numero_cuenta, $saldo_real_banco)
    {
        $cuenta = CuentasBancarias::findOne(['numero_cuenta' => $numero_cuenta]);
        
        // 1. Calculamos el saldo que el sistema "cree" que tiene
        $sumaMovimientos = EstadoCuenta::find()
            ->where(['numero_cuenta' => $numero_cuenta, 'eliminado' => 0])
            ->sum('monto') ?: 0;
            
        $saldoSistema = $cuenta->saldo_inicial + $sumaMovimientos;
        
        // 2. Calculamos la diferencia
        $diferencia = $saldoSistema - $saldo_real_banco;

        // 3. Guardamos el registro de cierre
        $cierre = new CierreDiario();
        $cierre->fecha_cierre = date('Y-m-d');
        $cierre->numero_cuenta = $numero_cuenta;
        $cierre->saldo_sistema = $saldoSistema;
        $cierre->saldo_bancario = $saldo_real_banco;
        $cierre->diferencia = $diferencia;
        $cierre->id_operador = Yii::$app->user->id;
        
        if ($cierre->save()) {
            if ($diferencia == 0) {
                Yii::$app->session->setFlash('success', "Cierre exitoso. La cuenta está cuadrada.");
            } else {
                Yii::$app->session->setFlash('warning', "Cierre registrado con una diferencia de: " . number_format($diferencia, 2, ',', '.'));
            }
        }
        return $this->redirect(['index']);
    }

}
