<?php
use yii\helpers\Url;
use yii\helpers\Html;
use mdm\admin\components\Helper;

/* Iconos de Bootstrap vía CDN */
$this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css');

$this->title = 'CONFIGURACIONES DEL SISTEMA';

// Definición de los módulos de transporte según tu captura de pantalla
$todosLosModulos = [
    ['label' => 'Tipo de Vehículo', 'desc' => 'Gestión de categorías: Sedán, SUV, Van, etc.', 'url' => '/base-tipo-vehiculo/index', 'icon' => 'bi-car-front', 'color' => '#5c7cfa'],
    ['label' => 'Método de Pago', 'desc' => 'Configuración de pasarelas y formas de cobro.', 'url' => '/base-metodos-pago/index', 'icon' => 'bi-credit-card', 'color' => '#20c997'],
    ['label' => 'Condiciones Flota', 'desc' => 'Reglas y estados operativos de las unidades.', 'url' => '/condicion-flota/index', 'icon' => 'bi-list-check', 'color' => '#fcc419'],
    ['label' => 'Tipo de Clientes', 'desc' => 'Segmentación: Corporativos, VIP, Regulares.', 'url' => '/base-tipo-cliente/index', 'icon' => 'bi-person-badge', 'color' => '#9775fa'],
    ['label' => '¿Cómo nos conoció?', 'desc' => 'Fuentes de marketing y referidos.', 'url' => '/base-nos-conoce/index', 'icon' => 'bi-handshake', 'color' => '#4dabf7'],
    ['label' => 'Tipo de Servicios', 'desc' => 'Traslados, Tours, Express, entre otros.', 'url' => '/tipo-servicio/index', 'icon' => 'bi-briefcase', 'color' => '#ff6b6b'],
    ['label' => 'Tipo de Ruta', 'desc' => 'Definición de trayectos: Urbano, Interurbano.', 'url' => '/tipo-ruta/index', 'icon' => 'bi-signpost-split', 'color' => '#339af0'],
    ['label' => 'Marca-Modelo', 'desc' => 'Catálogo maestro de fabricantes y modelos.', 'url' => '//base-modelo/index', 'icon' => 'bi-tags', 'color' => '#51cf66'],
    ['label' => 'Tasa del Día', 'desc' => 'Actualización de valores para conversión de moneda.', 'url' => '/tasadia/index', 'icon' => 'bi-currency-exchange', 'color' => '#f06595'],
];

// Filtro de seguridad (RBAC)
$modulosPermitidos = [];
foreach ($todosLosModulos as $mod) {
    if (Helper::checkRoute($mod['url'])) {
        $modulosPermitidos[] = $mod;
    }
}
?>

<div class="dashboard-site">
    <div class="container-fluid pt-2 px-5"> 
        <div class="row mb-4">
            <div class="col-12">
                <span class="badge-admin">MODO ADMINISTRADOR</span>
            </div>
        </div>

        <div class="row g-4">
            <?php if (empty($modulosPermitidos)): ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No tienes permisos para administrar ningún módulo en esta sección.</p>
                </div>
            <?php else: ?>
                <?php foreach ($modulosPermitidos as $mod): ?>
                    <div class="col-12 col-sm-6 col-lg-4 d-flex">
                        <div class="card-sicher-v2"> 
                            <div class="card-upper-section">
                                <div class="icon-box-wrapper" style="background-color: <?= $mod['color'] ?>;">
                                    <i class="<?= $mod['icon'] ?>"></i>
                                </div>
                                <div class="text-content">
                                    <h3 class="modulo-title"><?= Html::encode($mod['label']) ?></h3>
                                    <p class="modulo-desc"><?= Html::encode($mod['desc']) ?></p>
                                </div>
                            </div>
                            <div class="card-lower-section">
                                <span class="footer-stat-text">
                                    <i class="bi bi-gear-fill" style="color: #ea4c2d;"></i> Activo
                                </span>
                                <?= Html::a('Configurar →', [$mod['url']], ['class' => 'btn-link-administrar']) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .dashboard-site { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

    .badge-admin {
        background-color: #ea4c2d;
        color: white;
        font-size: 10px;
        font-weight: bold;
        padding: 4px 15px;
        text-transform: uppercase;
        border-radius: 50px !important;
    }

    .card-sicher-v2 {
        background-color: #ffffff;
        border-radius: 25px !important; /* */
        padding: 25px;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .card-sicher-v2:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.1);
        border-color: #ea4c2d;
    }

    .card-upper-section {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .icon-box-wrapper {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 5px;
    }

    .icon-box-wrapper i {
        color: #ffffff !important;
        font-size: 22px !important;
    }

    .modulo-title {
        color: #1b242d;
        font-size: 1.15rem;
        font-weight: 700;
        margin: 0;
    }

    .modulo-desc {
        color: #6a737d;
        font-size: 0.85rem;
        line-height: 1.4;
        margin-top: 5px;
    }

    .card-lower-section {
        border-top: 1px solid #f1f2f6;
        padding-top: 15px;
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .footer-stat-text {
        color: #8c8c8c;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .btn-link-administrar {
        text-decoration: none;
        color: #ea4c2d;
        font-size: 0.9rem;
        font-weight: 600;
        transition: color 0.2s;
    }

    .btn-link-administrar:hover {
        color: #1b242d;
    }
</style>