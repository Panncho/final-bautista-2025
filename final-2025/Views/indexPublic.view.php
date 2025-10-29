<?php
// Iniciar sesión para mantener los datos entre pasos
session_start();

// Configuración básica
$paso_actual = isset($_GET['paso']) ? (int)$_GET['paso'] : 1;
$max_pasos = 4;

// Procesar envío de formularios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Guardar datos en sesión
    foreach ($_POST as $key => $value) {
        $_SESSION['form_data'][$key] = htmlspecialchars($value);
    }
    
    // Redirigir al siguiente paso
    $siguiente_paso = $paso_actual + 1;
    if ($siguiente_paso <= $max_pasos) {
        header("Location: ?paso=$siguiente_paso");
        exit;
    }
}

// Recuperar datos de sesión
$form_data = $_SESSION['form_data'] ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Comercio - Sistema</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .registration-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            margin: 2rem auto;
            max-width: 1000px;
        }
        
        .registration-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .registration-progress {
            background: #f8f9fa;
            padding: 1.5rem;
            border-bottom: 1px solid #dee2e6;
        }
        
        .progress-step {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        
        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #dee2e6;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
        }
        
        .step-active .step-number {
            background: var(--primary-color);
            color: white;
        }
        
        .step-completed .step-number {
            background: #28a745;
            color: white;
        }
        
        .step-text {
            font-weight: 500;
        }
        
        .form-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary-color);
        }
        
        .form-section h5 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .required-label::after {
            content: " *";
            color: #dc3545;
        }
        
        .documento-item {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            background: white;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <!-- Header -->
        <div class="registration-header">
            <h1><i class="bi bi-shop me-2"></i>Alta de Comercio</h1>
            <p class="mb-0">Complete el siguiente formulario para registrar su comercio en nuestro sistema</p>
        </div>
        
        <!-- Progreso -->
        <div class="registration-progress">
            <div class="row">
                <div class="col-md-3">
                    <div class="progress-step <?php echo $paso_actual >= 1 ? 'step-active' : ''; ?> <?php echo $paso_actual > 1 ? 'step-completed' : ''; ?>">
                        <div class="step-number">1</div>
                        <div class="step-text">Razón Social</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="progress-step <?php echo $paso_actual >= 2 ? 'step-active' : ''; ?> <?php echo $paso_actual > 2 ? 'step-completed' : ''; ?>">
                        <div class="step-number">2</div>
                        <div class="step-text">Datos del Comercio</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="progress-step <?php echo $paso_actual >= 3 ? 'step-active' : ''; ?> <?php echo $paso_actual > 3 ? 'step-completed' : ''; ?>">
                        <div class="step-number">3</div>
                        <div class="step-text">Documentación</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="progress-step <?php echo $paso_actual >= 4 ? 'step-active' : ''; ?>">
                        <div class="step-number">4</div>
                        <div class="step-text">Confirmación</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contenido del Formulario -->
        <div class="p-4">
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <h4><i class="bi bi-check-circle"></i> ¡Registro exitoso!</h4>
                    <p>Su comercio ha sido registrado correctamente. Nos pondremos en contacto a la brevedad.</p>
                    <a href="?" class="btn btn-success">Nuevo Registro</a>
                </div>
            <?php else: ?>
            
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="paso_actual" value="<?php echo $paso_actual; ?>">
                
                <?php if ($paso_actual == 1): ?>
                
                <!-- Paso 1: Razón Social -->
                <div class="form-section">
                    <h5><i class="bi bi-building me-2"></i>Datos de la Razón Social</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tipo_persona" class="form-label required-label">Tipo de Persona</label>
                            <select class="form-select" id="tipo_persona" name="tipo_persona" required>
                                <option value="">Seleccionar tipo...</option>
                                <option value="fisica" <?php echo isset($form_data['tipo_persona']) && $form_data['tipo_persona'] == 'fisica' ? 'selected' : ''; ?>>Persona Física</option>
                                <option value="juridica" <?php echo isset($form_data['tipo_persona']) && $form_data['tipo_persona'] == 'juridica' ? 'selected' : ''; ?>>Persona Jurídica</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="razon_social" class="form-label required-label">Razón Social o Nombre</label>
                            <input type="text" class="form-control" id="razon_social" name="razon_social" 
                                   value="<?php echo $form_data['razon_social'] ?? ''; ?>" 
                                   placeholder="Nombre o razón social completa" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cuit_cuil" class="form-label required-label">CUIT/CUIL</label>
                            <input type="text" class="form-control" id="cuit_cuil" name="cuit_cuil" 
                                   value="<?php echo $form_data['cuit_cuil'] ?? ''; ?>" 
                                   placeholder="XX-XXXXXXXX-X" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="condicion_iva" class="form-label required-label">Condición IVA</label>
                            <select class="form-select" id="condicion_iva" name="condicion_iva" required>
                                <option value="">Seleccionar condición...</option>
                                <option value="monotributista" <?php echo isset($form_data['condicion_iva']) && $form_data['condicion_iva'] == 'monotributista' ? 'selected' : ''; ?>>Monotributista</option>
                                <option value="responsable_inscripto" <?php echo isset($form_data['condicion_iva']) && $form_data['condicion_iva'] == 'responsable_inscripto' ? 'selected' : ''; ?>>Responsable Inscripto</option>
                                <option value="exento" <?php echo isset($form_data['condicion_iva']) && $form_data['condicion_iva'] == 'exento' ? 'selected' : ''; ?>>Exento</option>
                                <option value="consumidor_final" <?php echo isset($form_data['condicion_iva']) && $form_data['condicion_iva'] == 'consumidor_final' ? 'selected' : ''; ?>>Consumidor Final</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label required-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo $form_data['email'] ?? ''; ?>" 
                                   placeholder="email@ejemplo.com" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label required-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" 
                                   value="<?php echo $form_data['telefono'] ?? ''; ?>" 
                                   placeholder="+54 11 1234-5678" required>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <div></div> <!-- Espacio vacío para alinear a la derecha -->
                    <button type="submit" class="btn btn-primary">
                        Siguiente <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
                
                <?php elseif ($paso_actual == 2): ?>
                
                <!-- Paso 2: Datos del Comercio -->
                <div class="form-section">
                    <h5><i class="bi bi-shop me-2"></i>Datos del Comercio</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre_comercio" class="form-label required-label">Nombre del Comercio</label>
                            <input type="text" class="form-control" id="nombre_comercio" name="nombre_comercio" 
                                   value="<?php echo $form_data['nombre_comercio'] ?? ''; ?>" 
                                   placeholder="Nombre comercial" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nombre_fantasia" class="form-label">Nombre de Fantasía</label>
                            <input type="text" class="form-control" id="nombre_fantasia" name="nombre_fantasia" 
                                   value="<?php echo $form_data['nombre_fantasia'] ?? ''; ?>" 
                                   placeholder="Nombre público (opcional)">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="rubro_id" class="form-label required-label">Rubro Principal</label>
                            <select class="form-select" id="rubro_id" name="rubro_id" required onchange="actualizarDocumentacion()">
                                <option value="">Seleccionar rubro...</option>
                                <?php
                                // Simulación de rubros desde la base de datos
                                $rubros = [
                                    ['id' => 1, 'nombre' => 'Alimentos y Bebidas', 'documentacion' => ['sanitario', 'municipal']],
                                    ['id' => 2, 'nombre' => 'Electrónica', 'documentacion' => ['comercial', 'tecnico']],
                                    ['id' => 3, 'nombre' => 'Servicios', 'documentacion' => ['profesional', 'comercial']],
                                    ['id' => 4, 'nombre' => 'Indumentaria', 'documentacion' => ['comercial']],
                                    ['id' => 5, 'nombre' => 'Salud y Belleza', 'documentacion' => ['sanitario', 'profesional']],
                                    ['id' => 6, 'nombre' => 'Restaurantes', 'documentacion' => ['sanitario', 'municipal', 'seguridad']],
                                ];
                                
                                foreach ($rubros as $rubro): 
                                    $selected = (isset($form_data['rubro_id']) && $form_data['rubro_id'] == $rubro['id']) ? 'selected' : '';
                                ?>
                                <option value="<?php echo $rubro['id']; ?>" data-documentacion="<?php echo implode(',', $rubro['documentacion']); ?>" <?php echo $selected; ?>>
                                    <?php echo $rubro['nombre']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="subrubro" class="form-label">Subrubro o Especialidad</label>
                            <input type="text" class="form-control" id="subrubro" name="subrubro" 
                                   value="<?php echo $form_data['subrubro'] ?? ''; ?>" 
                                   placeholder="Especificación del rubro">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="direccion" class="form-label required-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" 
                                   value="<?php echo $form_data['direccion'] ?? ''; ?>" 
                                   placeholder="Calle y número" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="localidad" class="form-label required-label">Localidad</label>
                            <input type="text" class="form-control" id="localidad" name="localidad" 
                                   value="<?php echo $form_data['localidad'] ?? ''; ?>" 
                                   placeholder="Localidad" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="provincia" class="form-label required-label">Provincia</label>
                            <select class="form-select" id="provincia" name="provincia" required>
                                <option value="">Seleccionar provincia...</option>
                                <option value="CABA" <?php echo isset($form_data['provincia']) && $form_data['provincia'] == 'CABA' ? 'selected' : ''; ?>>CABA</option>
                                <option value="Buenos Aires" <?php echo isset($form_data['provincia']) && $form_data['provincia'] == 'Buenos Aires' ? 'selected' : ''; ?>>Buenos Aires</option>
                                <option value="Córdoba" <?php echo isset($form_data['provincia']) && $form_data['provincia'] == 'Córdoba' ? 'selected' : ''; ?>>Córdoba</option>
                                <option value="Santa Fe" <?php echo isset($form_data['provincia']) && $form_data['provincia'] == 'Santa Fe' ? 'selected' : ''; ?>>Santa Fe</option>
                                <option value="Mendoza" <?php echo isset($form_data['provincia']) && $form_data['provincia'] == 'Mendoza' ? 'selected' : ''; ?>>Mendoza</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="codigo_postal" class="form-label">Código Postal</label>
                            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" 
                                   value="<?php echo $form_data['codigo_postal'] ?? ''; ?>" 
                                   placeholder="Código postal">
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="?paso=1" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Anterior
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Siguiente <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
                
                <?php elseif ($paso_actual == 3): ?>
                
                <!-- Paso 3: Documentación -->
                <div class="form-section">
                    <h5><i class="bi bi-files me-2"></i>Documentación Requerida</h5>
                    
                    <?php
                    // Determinar qué documentación se requiere según el rubro seleccionado
                    $rubro_id = $form_data['rubro_id'] ?? 0;
                    $documentacion_requerida = [];
                    
                    foreach ($rubros as $rubro) {
                        if ($rubro['id'] == $rubro_id) {
                            $documentacion_requerida = $rubro['documentacion'];
                            break;
                        }
                    }
                    
                    // Mapeo de tipos de documentación a nombres legibles
                    $nombres_documentacion = [
                        'sanitario' => 'Certificado Sanitario',
                        'municipal' => 'Habilitación Municipal',
                        'comercial' => 'Registro Comercial',
                        'tecnico' => 'Certificado Técnico',
                        'profesional' => 'Matrícula Profesional',
                        'seguridad' => 'Certificado de Seguridad',
                        'tributaria' => 'Constancia Fiscal',
                        'legal' => 'Documentación Legal'
                    ];
                    
                    $descripciones_documentacion = [
                        'sanitario' => 'Certificado sanitario vigente emitido por autoridad competente',
                        'municipal' => 'Habilitación comercial municipal actualizada',
                        'comercial' => 'Registro comercial de la empresa o comercio',
                        'tecnico' => 'Certificado técnico de productos o instalaciones',
                        'profesional' => 'Matrícula profesional del titular o responsables',
                        'seguridad' => 'Certificado de condiciones de seguridad',
                        'tributaria' => 'Constancia de inscripción tributaria',
                        'legal' => 'Documentación legal de constitución de la empresa'
                    ];
                    ?>
                    
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> 
                        <strong>Documentación requerida para el rubro seleccionado:</strong> 
                        Debe adjuntar los siguientes documentos en formato PDF o imagen (máximo 5MB por archivo).
                    </div>
                    
                    <?php if (empty($documentacion_requerida)): ?>
                        <div class="alert alert-warning">
                            No se ha seleccionado un rubro válido. <a href="?paso=2">Volver al paso anterior</a>.
                        </div>
                    <?php else: ?>
                        <?php foreach ($documentacion_requerida as $index => $tipo_doc): ?>
                        <div class="documento-item">
                            <h6><?php echo $nombres_documentacion[$tipo_doc] ?? $tipo_doc; ?></h6>
                            <p class="text-muted"><?php echo $descripciones_documentacion[$tipo_doc] ?? ''; ?></p>
                            
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label required-label">Adjuntar Documento</label>
                                    <input type="file" class="form-control" name="documento_<?php echo $tipo_doc; ?>" 
                                           accept=".pdf,.jpg,.jpeg,.png" required>
                                    <div class="form-text">Formatos aceptados: PDF, JPG, PNG (máx. 5MB)</div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Número de Documento</label>
                                    <input type="text" class="form-control" name="numero_<?php echo $tipo_doc; ?>" 
                                           placeholder="Número de certificado o registro">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Fecha de Emisión</label>
                                    <input type="date" class="form-control" name="fecha_emision_<?php echo $tipo_doc; ?>">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Fecha de Vencimiento</label>
                                    <input type="date" class="form-control" name="fecha_vencimiento_<?php echo $tipo_doc; ?>">
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="?paso=2" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Anterior
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Siguiente <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
                
                <?php elseif ($paso_actual == 4): ?>
                
                <!-- Paso 4: Confirmación -->
                <div class="form-section">
                    <h5><i class="bi bi-check-circle me-2"></i>Confirmación de Datos</h5>
                    
                    <div class="alert alert-success">
                        <h6><i class="bi bi-shield-check"></i> Revise cuidadosamente la información antes de enviar</h6>
                        <p class="mb-0">Una vez enviado el formulario, recibirá un correo de confirmación y nos pondremos en contacto para finalizar el proceso.</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Datos de la Razón Social</h6>
                            <table class="table table-sm">
                                <tr><td><strong>Tipo:</strong></td><td><?php echo $form_data['tipo_persona'] == 'fisica' ? 'Persona Física' : 'Persona Jurídica'; ?></td></tr>
                                <tr><td><strong>Razón Social:</strong></td><td><?php echo $form_data['razon_social'] ?? ''; ?></td></tr>
                                <tr><td><strong>CUIT/CUIL:</strong></td><td><?php echo $form_data['cuit_cuil'] ?? ''; ?></td></tr>
                                <tr><td><strong>Condición IVA:</strong></td><td><?php echo ucfirst(str_replace('_', ' ', $form_data['condicion_iva'] ?? '')); ?></td></tr>
                                <tr><td><strong>Email:</strong></td><td><?php echo $form_data['email'] ?? ''; ?></td></tr>
                                <tr><td><strong>Teléfono:</strong></td><td><?php echo $form_data['telefono'] ?? ''; ?></td></tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h6>Datos del Comercio</h6>
                            <table class="table table-sm">
                                <tr><td><strong>Nombre:</strong></td><td><?php echo $form_data['nombre_comercio'] ?? ''; ?></td></tr>
                                <tr><td><strong>Nombre fantasía:</strong></td><td><?php echo $form_data['nombre_fantasia'] ?? 'No especificado'; ?></td></tr>
                                <tr><td><strong>Rubro:</strong></td><td>
                                    <?php 
                                    $rubro_nombre = 'No seleccionado';
                                    foreach ($rubros as $rubro) {
                                        if ($rubro['id'] == ($form_data['rubro_id'] ?? 0)) {
                                            $rubro_nombre = $rubro['nombre'];
                                            break;
                                        }
                                    }
                                    echo $rubro_nombre;
                                    ?>
                                </td></tr>
                                <tr><td><strong>Dirección:</strong></td><td><?php echo $form_data['direccion'] ?? ''; ?></td></tr>
                                <tr><td><strong>Localidad:</strong></td><td><?php echo $form_data['localidad'] ?? ''; ?></td></tr>
                                <tr><td><strong>Provincia:</strong></td><td><?php echo $form_data['provincia'] ?? ''; ?></td></tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <h6>Documentación a Adjuntar</h6>
                        <ul>
                            <?php 
                            $rubro_id = $form_data['rubro_id'] ?? 0;
                            $documentos_rubro = [];
                            foreach ($rubros as $rubro) {
                                if ($rubro['id'] == $rubro_id) {
                                    $documentos_rubro = $rubro['documentacion'];
                                    break;
                                }
                            }
                            
                            foreach ($documentos_rubro as $doc): 
                            ?>
                            <li><?php echo $nombres_documentacion[$doc] ?? $doc; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="acepto_terminos" name="acepto_terminos" required>
                        <label class="form-check-label" for="acepto_terminos">
                            Acepto los <a href="#" target="_blank">términos y condiciones</a> y la 
                            <a href="#" target="_blank">política de privacidad</a>
                        </label>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="?paso=3" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Anterior
                    </a>
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bi bi-check-lg"></i> Enviar Solicitud
                    </button>
                </div>
                
                <?php endif; ?>
            </form>
            
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Función simple para mostrar la documentación requerida (sin AJAX)
        function actualizarDocumentacion() {
            // Esta función se ejecuta cuando cambia el rubro, pero como no usamos AJAX,
            // la validación real se hace en el servidor al enviar el formulario
            console.log('Rubro seleccionado cambiado');
        }
        
        // Validación básica del formulario
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    let valid = true;
                    const requiredFields = form.querySelectorAll('[required]');
                    
                    requiredFields.forEach(function(field) {
                        if (!field.value.trim()) {
                            valid = false;
                            field.classList.add('is-invalid');
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });
                    
                    if (!valid) {
                        e.preventDefault();
                        alert('Por favor, complete todos los campos obligatorios.');
                    }
                });
            });
        });
    </script>
</body>
</html>