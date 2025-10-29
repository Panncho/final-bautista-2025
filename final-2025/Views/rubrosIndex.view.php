<?php 
$page_title = "Rubro - Lista";
$current_page = "rubros";
?>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<style>
    .badge-activo { background-color: #28a745; }
    .badge-inactivo { background-color: #6c757d; }
    .color-badge {
        width: 20px;
        height: 20px;
        border-radius: 4px;
        display: inline-block;
        margin-right: 8px;
        border: 1px solid #dee2e6;
    }
    .table-responsive { border-radius: 8px; overflow: hidden; }
    .rubro-icon { font-size: 1.2rem; margin-right: 8px; }
</style>

<div id="content">
    <header id="header">
        <button class="toggle-sidebar">
            <i class="bi bi-list"></i>
        </button>
        <div class="user-info">
            <span class="me-2">Admin User</span>
            <img src="https://via.placeholder.com/40" class="rounded-circle" alt="User">
        </div>
    </header>
    
    <div class="dashboard-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4><i class="bi bi-tags me-2"></i>Lista de Rubros</h4>
            <a href="rubrosAltaController.php" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Rubro
            </a>
        </div>

        <!-- Alertas -->
        <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php 
            $messages = [
                'created' => 'Rubro creado correctamente.',
                'updated' => 'Rubro actualizado correctamente.',
                'deleted' => 'Rubro eliminado correctamente.'
            ];
            echo $messages[$_GET['success']] ?? 'Operación realizada correctamente.';
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Estadísticas Rápidas -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0"><?php echo 15; ?></h4>
                                <small>Total Rubros</small>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-tags fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0"><?php echo 12; ?></h4>
                                <small>Rubros Activos</small>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-check-circle fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0"><?php echo 3; ?></h4>
                                <small>Rubros Inactivos</small>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-pause-circle fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="mb-0"><?php echo 8; ?></h4>
                                <small>Con E-commerce</small>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-cart fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Rubros -->
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Rubros Registrados</h5>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="toggleInactivos">
                    <label class="form-check-label" for="toggleInactivos">Mostrar inactivos</label>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tablaRubros" class="table table-hover table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Rubro</th>
                                <th>Código</th>
                                <th>Categoría</th>
                                <th>Nivel</th>
                                <th>Comercios</th>
                                <th>Comisión</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Datos de ejemplo (en la práctica vendrían de la BD)
                            $rubros = [
                                [
                                    'id' => 1,
                                    'nombre' => 'Alimentos y Bebidas',
                                    'codigo' => 'ALI',
                                    'color' => '#28a745',
                                    'icono' => 'bi-utensils',
                                    'rubro_padre' => null,
                                    'nivel' => 1,
                                    'comercios' => 45,
                                    'comision' => 5.0,
                                    'activo' => true,
                                    'ecommerce' => true,
                                    'orden' => 1
                                ],
                                [
                                    'id' => 2,
                                    'nombre' => 'Electrónica',
                                    'codigo' => 'ELE',
                                    'color' => '#007bff',
                                    'icono' => 'bi-laptop',
                                    'rubro_padre' => null,
                                    'nivel' => 1,
                                    'comercios' => 23,
                                    'comision' => 7.5,
                                    'activo' => true,
                                    'ecommerce' => true,
                                    'orden' => 2
                                ],
                                [
                                    'id' => 3,
                                    'nombre' => 'Restaurantes',
                                    'codigo' => 'RES',
                                    'color' => '#dc3545',
                                    'icono' => 'bi-utensils',
                                    'rubro_padre' => 1,
                                    'nivel' => 2,
                                    'comercios' => 15,
                                    'comision' => 8.0,
                                    'activo' => true,
                                    'ecommerce' => true,
                                    'orden' => 3
                                ],
                                [
                                    'id' => 4,
                                    'nombre' => 'Supermercados',
                                    'codigo' => 'SUP',
                                    'color' => '#20c997',
                                    'icono' => 'bi-cart',
                                    'rubro_padre' => 1,
                                    'nivel' => 2,
                                    'comercios' => 8,
                                    'comision' => 4.5,
                                    'activo' => true,
                                    'ecommerce' => true,
                                    'orden' => 4
                                ],
                                [
                                    'id' => 5,
                                    'nombre' => 'Servicios Técnicos',
                                    'codigo' => 'SER',
                                    'color' => '#6f42c1',
                                    'icono' => 'bi-tools',
                                    'rubro_padre' => null,
                                    'nivel' => 1,
                                    'comercios' => 12,
                                    'comision' => 10.0,
                                    'activo' => true,
                                    'ecommerce' => false,
                                    'orden' => 5
                                ],
                                [
                                    'id' => 6,
                                    'nombre' => 'Indumentaria',
                                    'codigo' => 'IND',
                                    'color' => '#fd7e14',
                                    'icono' => 'bi-bag',
                                    'rubro_padre' => null,
                                    'nivel' => 1,
                                    'comercios' => 34,
                                    'comision' => 6.0,
                                    'activo' => true,
                                    'ecommerce' => true,
                                    'orden' => 6
                                ],
                                [
                                    'id' => 7,
                                    'nombre' => 'Ropa Deportiva',
                                    'codigo' => 'DEP',
                                    'color' => '#e83e8c',
                                    'icono' => 'bi-heart',
                                    'rubro_padre' => 6,
                                    'nivel' => 2,
                                    'comercios' => 9,
                                    'comision' => 7.0,
                                    'activo' => true,
                                    'ecommerce' => true,
                                    'orden' => 7
                                ],
                                [
                                    'id' => 8,
                                    'nombre' => 'Farmacias',
                                    'codigo' => 'FAR',
                                    'color' => '#17a2b8',
                                    'icono' => 'bi-heart',
                                    'rubro_padre' => null,
                                    'nivel' => 1,
                                    'comercios' => 7,
                                    'comision' => 3.5,
                                    'activo' => false,
                                    'ecommerce' => false,
                                    'orden' => 8
                                ]
                            ];

                            foreach ($rubros as $rubro): 
                                $estado = $rubro['activo'] ? 'activo' : 'inactivo';
                                $nivel_label = 'Nivel ' . $rubro['nivel'];
                                $rubro_padre_nombre = '';
                                
                                if ($rubro['rubro_padre']) {
                                    foreach ($rubros as $padre) {
                                        if ($padre['id'] == $rubro['rubro_padre']) {
                                            $rubro_padre_nombre = $padre['nombre'];
                                            break;
                                        }
                                    }
                                }
                            ?>
                            <tr class="<?php echo !$rubro['activo'] ? 'table-secondary' : ''; ?>">
                                <td><?php echo $rubro['id']; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="color-badge" style="background-color: <?php echo $rubro['color']; ?>"></span>
                                        <i class="rubro-icon <?php echo $rubro['icono']; ?>"></i>
                                        <div>
                                            <div class="fw-bold"><?php echo htmlspecialchars($rubro['nombre']); ?></div>
                                            <?php if($rubro_padre_nombre): ?>
                                            <small class="text-muted">Subcategoría de: <?php echo htmlspecialchars($rubro_padre_nombre); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-dark"><?php echo $rubro['codigo']; ?></span>
                                </td>
                                <td>
                                    <?php if($rubro['nivel'] == 1): ?>
                                        <span class="badge bg-primary">Principal</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Subcategoría</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $nivel_label; ?></td>
                                <td>
                                    <span class="badge bg-info"><?php echo $rubro['comercios']; ?> comercios</span>
                                </td>
                                <td>
                                    <span class="fw-bold"><?php echo number_format($rubro['comision'], 1); ?>%</span>
                                </td>
                                <td>
                                    <span class="badge <?php echo 'badge-' . $estado; ?>">
                                        <?php echo ucfirst($estado); ?>
                                    </span>
                                    <?php if($rubro['ecommerce']): ?>
                                    <span class="badge bg-success ms-1" title="Permite E-commerce">E</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="rubro_ver.php?id=<?php echo $rubro['id']; ?>" 
                                           class="btn btn-outline-primary" title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="rubro.php?editar=<?php echo $rubro['id']; ?>" 
                                           class="btn btn-outline-secondary" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-outline-danger" 
                                                title="Eliminar"
                                                onclick="confirmarEliminar(<?php echo $rubro['id']; ?>, '<?php echo htmlspecialchars($rubro['nombre']); ?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación Eliminar -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar el rubro <strong id="rubroDeleteName"></strong>?</p>
                <p class="text-danger"><small>Esta acción eliminará también todas las subcategorías asociadas.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<!-- DataTables JavaScript -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
    // Inicializar DataTable
    $(document).ready(function() {
        var table = $('#tablaRubros').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-AR.json'
            },
            responsive: true,
            dom: '<"row"<"col-md-6"B><"col-md-6"f>>rt<"row"<"col-md-6"l><"col-md-6"p>>',
            buttons: [
                {
                    extend: 'copy',
                    text: '<i class="bi bi-clipboard"></i> Copiar',
                    className: 'btn btn-sm btn-outline-secondary'
                },
                {
                    extend: 'excel',
                    text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                    className: 'btn btn-sm btn-outline-success'
                },
                {
                    extend: 'pdf',
                    text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                    className: 'btn btn-sm btn-outline-danger'
                },
                {
                    extend: 'print',
                    text: '<i class="bi bi-printer"></i> Imprimir',
                    className: 'btn btn-sm btn-outline-dark'
                }
            ],
            columnDefs: [
                { responsivePriority: 1, targets: 1 }, // Rubro
                { responsivePriority: 2, targets: 8 }, // Acciones
                { responsivePriority: 3, targets: 5 }, // Comercios
                { 
                    targets: [0], // Columna ID
                    visible: false,
                    searchable: false
                }
            ],
            order: [[0, 'asc']], // Ordenar por ID
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]]
        });

        // Toggle para mostrar/ocultar inactivos
        $('#toggleInactivos').on('change', function() {
            if (this.checked) {
                table.search('').draw(); // Mostrar todos
            } else {
                table.search('activo').draw(); // Filtrar solo activos
            }
        });
    });

    // Función para confirmar eliminación
    function confirmarEliminar(id, nombre) {
        document.getElementById('rubroDeleteName').textContent = nombre;
        document.getElementById('confirmDeleteBtn').href = `rubro_eliminar.php?id=${id}`;
        $('#confirmDeleteModal').modal('show');
    }
</script>

<?php include 'footer.php'; ?>