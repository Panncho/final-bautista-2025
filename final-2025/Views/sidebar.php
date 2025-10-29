<!-- Sidebar -->
<nav id="sidebar">
    <div class="sidebar-header">
        <h3>Panel de Administración</h3>
    </div>
    
    <div class="sidebar-menu">
        <ul>
            <li>
                <a href="dashboardIndexController.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'dashboardIndexController.php') ? 'active' : ''; ?>">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard Admin</span>
                </a>
            </li>
            <li>
                <a href="titularesIndexController.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'titularesIndexController.php') ? 'active' : ''; ?>">
                    <i class="bi bi-building"></i>
                    <span>Razon Social</span>
                </a>
            </li>
            <li>
                <a href="comercioIndexController.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'comercioIndexController.php') ? 'active' : ''; ?>">
                    <i class="bi bi-shop"></i>
                    <span>Comercios</span>
                </a>
            </li>
            <li>
                <a href="rubrosIndexController.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'rubrosIndexController.php') ? 'active' : ''; ?>">
                    <i class="bi bi-tags"></i>
                    <span>Rubros</span>
                </a>
            </li>
        
            <li>
                <a href="loginController.php">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </li>
        </ul>
    </div>
</nav>