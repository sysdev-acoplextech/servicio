<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Order; // Suponiendo que tienes un modelo Order
use backend\models\Servicios;

class DashboardController extends Controller
{
    public function actionIndex()
    {
        // 1. Instancia del modelo para el formulario (Evita el error Undefined variable: model)
        $model = new \backend\models\Servicios();

        // 2. Cálculo de totales para los cuadros superiores (Info-Boxes)
        $totalOrders = \backend\models\Servicios::find()->count();
        $totalSales = \backend\models\Servicios::find()->sum('monto') ?: 0; // Si es null, pone 0

        // 3. Datos para el gráfico de Ventas Mensuales
        $salesData = \backend\models\Servicios::find()
            ->select(["DATE_FORMAT(fecha_registro, '%Y-%m') AS month", "SUM(monto) AS total_sales"])
            ->groupBy(["DATE_FORMAT(fecha_registro, '%Y-%m')"])
            ->orderBy(["month" => SORT_ASC])
            ->asArray()
            ->all();

        // 4. Datos para el gráfico de Tipo de Pago (Ajusta el modelo según tu proyecto)
        $tipopago = \backend\models\VPosicionDeudora::find()->all();

        // 5. Datos para el gráfico de Tipo de Vehículo
        $tipovehiculo = \backend\models\BaseTipoVehiculo::find()->all();

        // 6. Datos para los estatus financieros (Suma de Agendados, etc.)
        $fuentefinan = \backend\models\Servicios::find()
            ->select(['id_estatus', 'COUNT(id) AS id_servicio'])
            ->groupBy(['id_estatus'])
            ->all();

        // ENVIAR TODAS LAS VARIABLES A LA VISTA
        return $this->render('index', [
            'model' => $model,
            'totalOrders' => $totalOrders,
            'totalSales' => $totalSales,
            'salesData' => $salesData,
            'tipopago' => $tipopago,
            'tipovehiculo' => $tipovehiculo,
            'fuentefinan' => $fuentefinan,
            'servicios_mes' => \backend\models\Servicios::find()->where(['month(fecha_registro)' => date('m')])->count(),
            'servicios_monto_mes' => ['monto' => \backend\models\Servicios::find()->where(['month(fecha_registro)' => date('m')])->sum('monto') ?: 0],
        ]);
    }
}

?>