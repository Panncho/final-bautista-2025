<?php 
$page_title = "Comercio - Alta";
$current_page = "comercios";
?>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<style>
    .form-section {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid var(--primary-color);
    }
    .form-section h6 {
        color: var(--primary-color);
        margin-bottom: 1rem;
    }
    .required-label::after {
        content: " *";
        color: #dc3545;
    }
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
            <h4><i class="bi bi-shop me-2"></i>Gestión de Comercios</h4>
            <div>
                <a href="comercioIndexController.php" class="btn btn-sm btn-outline-primary me-2">
                    <i class="bi bi-list-ul"></i> Ver Lista
                </a>
                <button class="btn btn-sm btn-primary" onclick="resetForm()">
                    <i class="bi bi-plus-circle"></i> Nuevo Comercio
                </button>
            </div>
        </div>

        <!-- Alertas -->
        <div id="alertContainer"></div>

        <!-- Formulario de Comercio -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Alta de Comercio</h5>
            </div>
            <div class="card-body">
                <form id="comercioForm" novalidate>
                    <!-- Asociación con Razón Social -->
                    <div class="form-section">
                        <h6><i class="bi bi-building me-1"></i>Asociación con Razón Social</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="razonSocialId" class="form-label required-label">Razón Social</label>
                                <select class="form-select" id="razonSocialId" required>
                                    <option value="">Seleccionar razón social...</option>
                                    <?php
                                    // Simulación de datos de razones sociales (en la práctica vendrían de la BD)
                                    $razonesSociales = [
                                        ['id' => 1, 'nombre' => 'Empresa Tech Solutions S.A.', 'cuit' => '30-12345678-9'],
                                        ['id' => 2, 'nombre' => 'Distribuidora Norte S.R.L.', 'cuit' => '27-87654321-0'],
                                        ['id' => 3, 'nombre' => 'Consultora Estratégica Integral', 'cuit' => '20-11223344-5'],
                                        ['id' => 4, 'nombre' => 'Almacén Don José', 'cuit' => '23-44332211-6'],
                                        ['id' => 5, 'nombre' => 'Constructora Edifica S.A.', 'cuit' => '30-55667788-1']
                                    ];
                                    
                                    foreach ($razonesSociales as $razon): 
                                    ?>
                                    <option value="<?php echo $razon['id']; ?>">
                                        <?php echo htmlspecialchars($razon['nombre']); ?> (<?php echo $razon['cuit']; ?>)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Por favor selecciona una razón social.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Información de la Razón Social</label>
                                <div id="razonSocialInfo" class="p-2 bg-light rounded">
                                    <small class="text-muted">Selecciona una razón social para ver su información</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Datos del Comercio -->
                    <div class="form-section">
                        <h6><i class="bi bi-shop me-1"></i>Datos del Comercio</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombreComercio" class="form-label required-label">Nombre del Comercio</label>
                                <input type="text" class="form-control" id="nombreComercio" placeholder="Ej: Sucursal Centro" required>
                                <div class="invalid-feedback">Por favor ingresa el nombre del comercio.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="nombreFantasia" class="form-label">Nombre de Fantasía</label>
                                <input type="text" class="form-control" id="nombreFantasia" placeholder="Ej: Mi Tienda Online">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="rubroId" class="form-label required-label">Rubro</label>
                                <select class="form-select" id="rubroId" required>
                                    <option value="">Seleccionar rubro...</option>
                                    <?php
                                    $rubros = [
                                        ['id' => 1, 'nombre' => 'Alimentos y Bebidas'],
                                        ['id' => 2, 'nombre' => 'Indumentaria'],
                                        ['id' => 3, 'nombre' => 'Electrónica'],
                                        ['id' => 4, 'nombre' => 'Hogar y Muebles'],
                                        ['id' => 5, 'nombre' => 'Salud y Belleza'],
                                        ['id' => 6, 'nombre' => 'Deportes'],
                                        ['id' => 7, 'nombre' => 'Juguetes'],
                                        ['id' => 8, 'nombre' => 'Servicios'],
                                        ['id' => 9, 'nombre' => 'Restaurante'],
                                        ['id' => 10, 'nombre' => 'Otros']
                                    ];
                                    
                                    foreach ($rubros as $rubro): 
                                    ?>
                                    <option value="<?php echo $rubro['id']; ?>"><?php echo $rubro['nombre']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Por favor selecciona un rubro.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="subrubro" class="form-label">Subrubro</label>
                                <input type="text" class="form-control" id="subrubro" placeholder="Especificación del rubro">
                            </div>
                        </div>
                    </div>

                    <!-- Contacto del Comercio -->
                    <div class="form-section">
                        <h6><i class="bi bi-telephone me-1"></i>Contacto del Comercio</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telefonoComercio" class="form-label required-label">Teléfono del Comercio</label>
                                <input type="tel" class="form-control" id="telefonoComercio" placeholder="+54 11 1234-5678" required>
                                <div class="invalid-feedback">Por favor ingresa un teléfono válido.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="emailComercio" class="form-label">Email del Comercio</label>
                                <input type="email" class="form-control" id="emailComercio" placeholder="comercio@ejemplo.com">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="sitioWeb" class="form-label">Sitio Web</label>
                                <input type="url" class="form-control" id="sitioWeb" placeholder="https://www.mitienda.com">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="redesSociales" class="form-label">Redes Sociales</label>
                                <input type="text" class="form-control" id="redesSociales" placeholder="@mitienda">
                            </div>
                        </div>
                    </div>

                    <!-- Dirección del Comercio -->
                    <div class="form-section">
                        <h6><i class="bi bi-geo-alt me-1"></i>Dirección del Comercio</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="direccion" class="form-label required-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" placeholder="Calle y número" required>
                                <div class="invalid-feedback">Por favor ingresa la dirección.</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="localidadComercio" class="form-label required-label">Localidad</label>
                                <input type="text" class="form-control" id="localidadComercio" placeholder="Localidad" required>
                                <div class="invalid-feedback">Por favor ingresa la localidad.</div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="provinciaComercio" class="form-label required-label">Provincia</label>
                                <select class="form-select" id="provinciaComercio" required>
                                    <option value="">Seleccionar provincia...</option>
                                    <option value="CABA">Ciudad Autónoma de Buenos Aires</option>
                                    <option value="BA">Buenos Aires</option>
                                    <option value="CAT">Catamarca</option>
                                    <option value="COR">Córdoba</option>
                                    <option value="ERI">Corrientes</option>
                                    <option value="SFE">Santa Fe</option>
                                    <option value="MEN">Mendoza</option>
                                    <option value="TUC">Tucumán</option>
                                    <option value="SAL">Salta</option>
                                    <option value="JUJ">Jujuy</option>
                                </select>
                                <div class="invalid-feedback">Por favor selecciona una provincia.</div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="codigoPostalComercio" class="form-label">Código Postal</label>
                                <input type="text" class="form-control" id="codigoPostalComercio" placeholder="Código postal">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="zona" class="form-label">Zona/Barrio</label>
                                <input type="text" class="form-control" id="zona" placeholder="Barrio o zona">
                            </div>
                        </div>
                    </div>

                    <!-- Información Adicional -->
                    <div class="form-section">
                        <h6><i class="bi bi-info-circle me-1"></i>Información Adicional</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="fechaApertura" class="form-label">Fecha de Apertura</label>
                                <input type="date" class="form-control" id="fechaApertura">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="horarioAtencion" class="form-label">Horario de Atención</label>
                                <input type="text" class="form-control" id="horarioAtencion" placeholder="Ej: 09:00-18:00">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="empleados" class="form-label">Cantidad de Empleados</label>
                                <input type="number" class="form-control" id="empleados" min="0" placeholder="0">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="metodosPago" class="form-label">Métodos de Pago Aceptados</label>
                                <select class="form-select" id="metodosPago" multiple>
                                    <option value="efectivo">Efectivo</option>
                                    <option value="tarjeta_debito">Tarjeta de Débito</option>
                                    <option value="tarjeta_credito">Tarjeta de Crédito</option>
                                    <option value="transferencia">Transferencia</option>
                                    <option value="mercado_pago">Mercado Pago</option>
                                    <option value="cheque">Cheque</option>
                                </select>
                                <div class="form-text">Mantén presionado Ctrl para seleccionar múltiples opciones</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="observaciones" class="form-label">Observaciones</label>
                                <textarea class="form-control" id="observaciones" rows="3" placeholder="Información adicional sobre el comercio..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="form-section">
                        <h6><i class="bi bi-circle-fill me-1"></i>Estado del Comercio</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="estadoComercio" class="form-label required-label">Estado</label>
                                <select class="form-select" id="estadoComercio" required>
                                    <option value="activo" selected>Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                    <option value="suspendido">Suspendido</option>
                                    <option value="en_construccion">En Construcción</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" id="tieneEcommerce" checked>
                                    <label class="form-check-label" for="tieneEcommerce">
                                        ¿Tiene E-commerce?
                                    </label>
                                </div>
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="aceptaPedidos" checked>
                                    <label class="form-check-label" for="aceptaPedidos">
                                        ¿Acepta pedidos online?
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                    <i class="bi bi-arrow-clockwise"></i> Limpiar Formulario
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg"></i> Guardar Comercio
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Información de razones sociales (simulada)
    const razonesSocialesInfo = {
        1: { cuit: "30-12345678-9", condicionIva: "Responsable Inscripto", estado: "Activo" },
        2: { cuit: "27-87654321-0", condicionIva: "Monotributista", estado: "Activo" },
        3: { cuit: "20-11223344-5", condicionIva: "Responsable Inscripto", estado: "Inactivo" },
        4: { cuit: "23-44332211-6", condicionIva: "Monotributista", estado: "Activo" },
        5: { cuit: "30-55667788-1", condicionIva: "Responsable Inscripto", estado: "Suspendido" }
    };

    // Mostrar información de la razón social seleccionada
    document.getElementById('razonSocialId').addEventListener('change', function() {
        const razonSocialInfo = document.getElementById('razonSocialInfo');
        const selectedId = this.value;
        
        if (selectedId && razonesSocialesInfo[selectedId]) {
            const info = razonesSocialesInfo[selectedId];
            razonSocialInfo.innerHTML = `
                <div class="small">
                    <strong>CUIT:</strong> ${info.cuit}<br>
                    <strong>Condición IVA:</strong> ${info.condicionIva}<br>
                    <strong>Estado:</strong> <span class="badge ${info.estado === 'Activo' ? 'bg-success' : 'bg-warning'}">${info.estado}</span>
                </div>
            `;
        } else {
            razonSocialInfo.innerHTML = '<small class="text-muted">Selecciona una razón social para ver su información</small>';
        }
    });

    // Validación del formulario
    document.getElementById('comercioForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!this.checkValidity()) {
            e.stopPropagation();
            this.classList.add('was-validated');
            showAlert('Por favor, completa todos los campos obligatorios.', 'warning');
            return;
        }
        
        // Simular envío exitoso
        const formData = new FormData(this);
        const comercioData = {
            razonSocialId: document.getElementById('razonSocialId').value,
            nombreComercio: document.getElementById('nombreComercio').value,
            // ... otros campos
        };
        
        console.log('Datos del comercio:', comercioData);
        showAlert('Comercio guardado correctamente.', 'success');
        this.classList.remove('was-validated');
        
        // Redirigir a la lista después de 2 segundos
        setTimeout(() => {
            window.location.href = 'comercio_lista.php?success=created';
        }, 2000);
    });

    // Función para mostrar alertas
    function showAlert(message, type) {
        const alertContainer = document.getElementById('alertContainer');
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        alertContainer.appendChild(alert);
        
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    // Función para resetear el formulario
    function resetForm() {
        document.getElementById('comercioForm').reset();
        document.getElementById('comercioForm').classList.remove('was-validated');
        document.getElementById('razonSocialInfo').innerHTML = '<small class="text-muted">Selecciona una razón social para ver su información</small>';
        document.getElementById('alertContainer').innerHTML = '';
    }

    // Validación en tiempo real
    const inputs = document.querySelectorAll('#comercioForm input, #comercioForm select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });
    });
</script>

<?php include 'footer.php'; ?>