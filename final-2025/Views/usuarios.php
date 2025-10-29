<?php 
$page_title = "Dashboard de Usuarios";
$current_page = "usuarios";
?>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

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
            <h4>Gestión de Usuarios</h4>
            <div>
                <button class="btn btn-sm btn-outline-secondary me-2">
                    <i class="bi bi-download"></i> Exportar
                </button>
                <button class="btn btn-sm btn-primary">
                    <i class="bi bi-person-plus"></i> Nuevo Usuario
                </button>
            </div>
        </div>
        
        <!-- Contenido específico de la página de usuarios -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Lista de Usuarios</h5>
            </div>
            <div class="card-body">
                <p>Aquí iría el contenido específico para la gestión de usuarios.</p>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>