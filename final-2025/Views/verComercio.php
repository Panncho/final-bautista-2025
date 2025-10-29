<?php
// ver_comercio.php
$page_title = "Información del Comercio";
$current_page = "ver_comercio";

// Simulación de conexión a la base de datos
$comercio_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Datos de ejemplo (en un caso real, estos vendrían de la base de datos)
$comercio_data = [
    'id' => $comercio_id,
    'razon_social' => 'Distribuidora de Alimentos S.A.',
    'nombre_fantasia' => 'Supermercado El Buen Precio',
    'cuit_comercio' => '30-12345678-9',
    'estado' => 'aprobado',
    'fecha_aprobacion' => '2024-01-15',
    'direccion' => 'Av. Siempre Viva 123',
    'localidad' => 'Springfield',
    'codigo_postal' => '1234',
    'telefono' => '+54 11 1234-5678',
    'email_contacto' => 'contacto@supermercadoelbuenprecio.com',
    'sitio_web' => 'www.supermercadoelbuenprecio.com',
    'rubro_nombre' => 'Alimentos y Bebidas',
    'rubro_icono' => 'bi-utensils',
    'titular_nombre' => 'Homero',
    'titular_apellido' => 'Simpson',
    'titular_dni' => '12.345.678',
    'titular_email' => 'homero@simpson.com',
    'titular_telefono' => '+54 11 9876-5432'
];

// Si no existe el comercio, mostrar error
if ($comercio_id === 0) {
    header('HTTP/1.0 404 Not Found');
    die('Comercio no encontrado');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - <?php echo $comercio_data['nombre_fantasia'] ?: $comercio_data['razon_social']; ?></title>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --success-color: #4cc9f0;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .comercio-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            margin: 2rem auto;
            max-width: 1000px;
        }
        
        .comercio-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            position: relative;
        }
        
        .estado-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 0.8rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }
        
        .comercio-body {
            padding: 2rem;
        }
        
        .info-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary-color);
        }
        
        .info-section h5 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #495057;
            min-width: 150px;
        }
        
        .info-value {
            color: #6c757d;
            text-align: right;
            flex: 1;
        }
        
        .rubro-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .qr-section {
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-top: 2rem;
        }
        
        .actions-section {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }
        
        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
        }
        
        @media (max-width: 768px) {
            .comercio-header {
                padding: 1.5rem;
            }
            
            .comercio-body {
                padding: 1.5rem;
            }
            
            .info-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }
            
            .info-value {
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="comercio-card">
            <!-- Encabezado -->
            <div class="comercio-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="mb-2">
                            <i class="<?php echo $comercio_data['rubro_icono']; ?> me-2"></i>
                            <?php echo $comercio_data['nombre_fantasia'] ?: $comercio_data['razon_social']; ?>
                        </h1>
                        <p class="mb-0 lead"><?php echo $comercio_data['razon_social']; ?></p>
                        <p class="mb-0"><?php echo $comercio_data['rubro_nombre']; ?></p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <span class="estado-badge bg-success">
                            <i class="bi bi-check-circle-fill me-1"></i>
                            <?php 
                            $estados = [
                                'aprobado' => 'Aprobado',
                                'pendiente' => 'Pendiente',
                                'en_revision' => 'En Revisión',
                                'rechazado' => 'Rechazado',
                                'suspendido' => 'Suspendido'
                            ];
                            echo $estados[$comercio_data['estado']] ?? 'Desconocido';
                            ?>
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Cuerpo -->
            <div class="comercio-body">
                <div class="row">
                    <!-- Información del Comercio -->
                    <div class="col-lg-6">
                        <div class="info-section">
                            <h5><i class="bi bi-shop"></i> Información del Comercio</h5>
                            <div class="info-item">
                                <span class="info-label">Razón Social:</span>
                                <span class="info-value"><?php echo $comercio_data['razon_social']; ?></span>
                            </div>
                            <?php if ($comercio_data['nombre_fantasia']): ?>
                            <div class="info-item">
                                <span class="info-label">Nombre de Fantasía:</span>
                                <span class="info-value"><?php echo $comercio_data['nombre_fantasia']; ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="info-item">
                                <span class="info-label">CUIT:</span>
                                <span class="info-value"><?php echo $comercio_data['cuit_comercio']; ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Rubro:</span>
                                <span class="info-value">
                                    <i class="<?php echo $comercio_data['rubro_icono']; ?> me-1"></i>
                                    <?php echo $comercio_data['rubro_nombre']; ?>
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Estado:</span>
                                <span class="info-value">
                                    <span class="badge bg-success"><?php echo $estados[$comercio_data['estado']] ?? 'Desconocido'; ?></span>
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Fecha de Aprobación:</span>
                                <span class="info-value"><?php echo date('d/m/Y', strtotime($comercio_data['fecha_aprobacion'])); ?></span>
                            </div>
                        </div>
                        
                        <!-- Datos de Contacto -->
                        <div class="info-section">
                            <h5><i class="bi bi-telephone"></i> Datos de Contacto</h5>
                            <div class="info-item">
                                <span class="info-label">Dirección:</span>
                                <span class="info-value"><?php echo $comercio_data['direccion']; ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Localidad:</span>
                                <span class="info-value"><?php echo $comercio_data['localidad']; ?></span>
                            </div>
                            <?php if ($comercio_data['codigo_postal']): ?>
                            <div class="info-item">
                                <span class="info-label">Código Postal:</span>
                                <span class="info-value"><?php echo $comercio_data['codigo_postal']; ?></span>
                            </div>
                            <?php endif; ?>
                            <?php if ($comercio_data['telefono']): ?>
                            <div class="info-item">
                                <span class="info-label">Teléfono:</span>
                                <span class="info-value">
                                    <a href="tel:<?php echo $comercio_data['telefono']; ?>" class="text-decoration-none">
                                        <?php echo $comercio_data['telefono']; ?>
                                    </a>
                                </span>
                            </div>
                            <?php endif; ?>
                            <?php if ($comercio_data['email_contacto']): ?>
                            <div class="info-item">
                                <span class="info-label">Email:</span>
                                <span class="info-value">
                                    <a href="mailto:<?php echo $comercio_data['email_contacto']; ?>" class="text-decoration-none">
                                        <?php echo $comercio_data['email_contacto']; ?>
                                    </a>
                                </span>
                            </div>
                            <?php endif; ?>
                            <?php if ($comercio_data['sitio_web']): ?>
                            <div class="info-item">
                                <span class="info-label">Sitio Web:</span>
                                <span class="info-value">
                                    <a href="http://<?php echo $comercio_data['sitio_web']; ?>" target="_blank" class="text-decoration-none">
                                        <?php echo $comercio_data['sitio_web']; ?>
                                    </a>
                                </span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Información del Titular -->
                    <div class="col-lg-6">
                        <div class="info-section">
                            <h5><i class="bi bi-person-badge"></i> Información del Titular</h5>
                            <div class="info-item">
                                <span class="info-label">Nombre:</span>
                                <span class="info-value"><?php echo $comercio_data['titular_nombre'] . ' ' . $comercio_data['titular_apellido']; ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">DNI:</span>
                                <span class="info-value"><?php echo $comercio_data['titular_dni']; ?></span>
                            </div>
                            <?php if ($comercio_data['titular_email']): ?>
                            <div class="info-item">
                                <span class="info-label">Email:</span>
                                <span class="info-value">
                                    <a href="mailto:<?php echo $comercio_data['titular_email']; ?>" class="text-decoration-none">
                                        <?php echo $comercio_data['titular_email']; ?>
                                    </a>
                                </span>
                            </div>
                            <?php endif; ?>
                            <?php if ($comercio_data['titular_telefono']): ?>
                            <div class="info-item">
                                <span class="info-label">Teléfono:</span>
                                <span class="info-value">
                                    <a href="tel:<?php echo $comercio_data['titular_telefono']; ?>" class="text-decoration-none">
                                        <?php echo $comercio_data['titular_telefono']; ?>
                                    </a>
                                </span>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Código QR -->
                        <div class="qr-section">
                            <h5><i class="bi bi-qr-code"></i> Código QR</h5>
                            <div class="mb-3">
                                <!-- En un caso real, aquí iría el QR generado -->
                                <div style="width: 150px; height: 150px; background: #f8f9fa; border: 2px dashed #dee2e6; display: inline-flex; align-items: center; justify-content: center; color: #6c757d;">
                                    <i class="bi bi-qr-code" style="font-size: 3rem;"></i>
                                </div>
                            </div>
                            <p class="small text-muted">
                                Este código QR contiene la información pública del comercio y puede ser escaneado para verificar su autenticidad.
                            </p>
                            <button class="btn btn-outline-primary btn-sm" onclick="descargarQR()">
                                <i class="bi bi-download"></i> Descargar QR
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Acciones -->
                <div class="actions-section">
                    <button class="btn btn-outline-primary" onclick="compartirComercio()">
                        <i class="bi bi-share"></i> Compartir
                    </button>
                    <button class="btn btn-outline-primary" onclick="imprimirPagina()">
                        <i class="bi bi-printer"></i> Imprimir
                    </button>
                    <a href="https://maps.google.com/?q=<?php echo urlencode($comercio_data['direccion'] . ', ' . $comercio_data['localidad']); ?>" 
                       target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-geo-alt"></i> Ver en Maps
                    </a>
                    <a href="alta_comercio.php" class="btn btn-outline-primary">
                        <i class="bi bi-plus-circle"></i> Registrar Mi Comercio
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function compartirComercio() {
            if (navigator.share) {
                navigator.share({
                    title: '<?php echo $comercio_data["nombre_fantasia"] ?: $comercio_data["razon_social"]; ?>',
                    text: 'Información del comercio <?php echo $comercio_data["nombre_fantasia"] ?: $comercio_data["razon_social"]; ?>',
                    url: window.location.href
                })
                .then(() => console.log('Compartido exitosamente'))
                .catch((error) => console.log('Error al compartir', error));
            } else {
                // Fallback para navegadores que no soportan Web Share API
                navigator.clipboard.writeText(window.location.href)
                    .then(() => {
                        alert('Enlace copiado al portapapeles');
                    })
                    .catch(err => {
                        console.error('Error al copiar: ', err);
                    });
            }
        }
        
        function imprimirPagina() {
            window.print();
        }
        
        function descargarQR() {
            // En un caso real, aquí se generaría y descargaría el QR
            alert('Funcionalidad de descarga de QR en desarrollo');
        }
        
        // Mostrar mensaje de bienvenida si viene de un QR
        if (window.location.search.includes('from=qr')) {
            setTimeout(() => {
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-info alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
                alertDiv.style.zIndex = '1050';
                alertDiv.innerHTML = `
                    <i class="bi bi-qr-code me-2"></i>
                    <strong>¡Bienvenido!</strong> Estás viendo la información pública de este comercio mediante código QR.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(alertDiv);
                
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            }, 1000);
        }
    </script>
</body>
</html>