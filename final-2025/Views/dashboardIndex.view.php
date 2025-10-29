<?php 
$page_title = "Dashboard Principal";
$current_page = "index";
?>
<?php include 'header.php'; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Content -->
<div id="content">
    <!-- Header -->
    <header id="header">
        <button class="toggle-sidebar">
            <i class="bi bi-list"></i>
        </button>
        <div class="user-info">
            <span class="me-2">Admin User</span>
            <img src="https://via.placeholder.com/40" class="rounded-circle" alt="User">
        </div>
    </header>
    
    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Dashboard Principal</h4>
            <div>
                <button class="btn btn-sm btn-outline-secondary me-2">
                    <i class="bi bi-download"></i> Exportar
                </button>
                <button class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle"></i> Nuevo
                </button>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="card stat-card">
                    <i class="bi bi-people"></i>
                    <h2>1,254</h2>
                    <p>Usuarios Activos</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <i class="bi bi-shop"></i>
                    <h2>568</h2>
                    <p>Comercios</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <i class="bi bi-currency-dollar"></i>
                    <h2>$24.7k</h2>
                    <p>Ingresos Mensuales</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <i class="bi bi-cart-check"></i>
                    <h2>12,487</h2>
                    <p>Transacciones</p>
                </div>
            </div>
        </div>
        
        <!-- Charts and Tables -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Actividad Reciente</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Acción</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>María González</td>
                                        <td>Actualización de perfil</td>
                                        <td>10 Jun 2023</td>
                                        <td><span class="badge bg-success">Completado</span></td>
                                    </tr>
                                    <tr>
                                        <td>Carlos López</td>
                                        <td>Nuevo comercio registrado</td>
                                        <td>09 Jun 2023</td>
                                        <td><span class="badge bg-warning">Pendiente</span></td>
                                    </tr>
                                    <tr>
                                        <td>Ana Martínez</td>
                                        <td>Pago procesado</td>
                                        <td>08 Jun 2023</td>
                                        <td><span class="badge bg-success">Completado</span></td>
                                    </tr>
                                    <tr>
                                        <td>Pedro Rodríguez</td>
                                        <td>Solicitud de verificación</td>
                                        <td>07 Jun 2023</td>
                                        <td><span class="badge bg-info">En revisión</span></td>
                                    </tr>
                                    <tr>
                                        <td>Laura Sánchez</td>
                                        <td>Cambio de rubro</td>
                                        <td>06 Jun 2023</td>
                                        <td><span class="badge bg-success">Completado</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Distribución por Rubros</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Restaurantes</span>
                            <span class="fw-bold">35%</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Tiendas</span>
                            <span class="fw-bold">25%</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Servicios</span>
                            <span class="fw-bold">20%</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Entretenimiento</span>
                            <span class="fw-bold">15%</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Otros</span>
                            <span class="fw-bold">5%</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar" role="progressbar" style="width: 5%;" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>