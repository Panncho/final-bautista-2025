<?php
$page_title = "Razón Social - Alta";
$current_page = "razon_social";
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
            <h4><i class="bi bi-building me-2"></i><?= isset($modo) && $modo === 'editar' ? 'Editar Razón Social' : 'Gestión de Razones Sociales' ?></h4>
            <div>
                <button class="btn btn-sm btn-outline-secondary me-2">
                    <i class="bi bi-download"></i> Exportar
                </button>
                <a href="titularesIndexController.php" class="btn btn-sm btn-outline-primary me-2">
                    <i class="bi bi-list-ul"></i> Ver Lista
                </a>
                <button class="btn btn-sm btn-primary" onclick="resetForm()">
                    <i class="bi bi-plus-circle"></i> Nueva Razón Social
                </button>
            </div>
        </div>

        <!-- Alertas -->
        <div id="alertContainer">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i><?= $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i><?= $success ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        </div>

        <!-- Formulario de Razón Social -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0"><?= isset($modo) && $modo === 'editar' ? 'Editar Razón Social' : 'Alta de Razón Social' ?></h5>
            </div>
            <div class="card-body">
                <form id="razonSocialForm" method="POST" action="<?= isset($modo) && $modo === 'editar' ? 'editarTitular.php?id=' . $titular['id'] : '' ?>" novalidate>
                    <?php if (isset($modo) && $modo === 'editar'): ?>
                        <input type="hidden" name="id" value="<?= $titular['id'] ?>">
                    <?php endif; ?>
                    <!-- Datos Básicos -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3">Datos Básicos</h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tipoPersona" class="form-label">Tipo de Persona <span class="text-danger">*</span></label>
                            <select class="form-select" id="tipoPersona" name="tipo" required>
                                <option value="">Seleccionar tipo</option>
                                <option value="fisica" <?= isset($datos_formulario['tipo']) && $datos_formulario['tipo'] === 'fisica' ? 'selected' : '' ?>>Persona Física</option>
                                <option value="juridica" <?= isset($datos_formulario['tipo']) && $datos_formulario['tipo'] === 'juridica' ? 'selected' : '' ?>>Persona Jurídica</option>
                            </select>
                            <div class="invalid-feedback">Por favor selecciona el tipo de persona.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="razonSocial" class="form-label">Razón Social / Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="razonSocial" name="nombre" value="<?= $datos_formulario['nombre'] ?? '' ?>" placeholder="Ej: Empresa S.A. o Juan Pérez" required>
                            <div class="invalid-feedback">Por favor ingresa la razón social o nombre.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="cuitCuil" class="form-label">CUIT/CUIL <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="cuitCuil" name="cuit" value="<?= $datos_formulario['cuit'] ?? '' ?>" placeholder="XX-XXXXXXXX-X" maxlength="13" required>
                            <div class="invalid-feedback">Por favor ingresa un CUIT/CUIL válido.</div>
                            <div class="form-text">Formato: XX-XXXXXXXX-X</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fechaInicioActividades" class="form-label">Fecha Inicio de Actividades</label>
                            <input type="date" class="form-control" id="fechaInicioActividades" name="fecha_inicio" value="<?= $datos_formulario['fecha_inicio'] ?? '' ?>">
                        </div>
                    </div>

                    <!-- Datos de Contacto -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3">Datos de Contacto</h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $datos_formulario['email'] ?? '' ?>" placeholder="contacto@empresa.com" required>
                            <div class="invalid-feedback">Por favor ingresa un email válido.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" value="<?= $datos_formulario['telefono'] ?? '' ?>" placeholder="+54 11 1234-5678" required>
                            <div class="invalid-feedback">Por favor ingresa un teléfono válido.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="tel" class="form-control" id="celular" name="celular" value="<?= $datos_formulario['celular'] ?? '' ?>" placeholder="+54 9 11 1234-5678">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="paginaWeb" class="form-label">Página Web</label>
                            <input type="url" class="form-control" id="paginaWeb" name="web" value="<?= $datos_formulario['web'] ?? '' ?>" placeholder="https://www.empresa.com">
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3">Dirección</h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="calle" class="form-label">Calle <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="calle" name="calle" value="<?= $datos_formulario['calle'] ?? '' ?>" placeholder="Av. Corrientes" required>
                            <div class="invalid-feedback">Por favor ingresa la calle.</div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="numero" class="form-label">Número <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="numero" name="numero" value="<?= $datos_formulario['numero'] ?? '' ?>" placeholder="1234" required>
                            <div class="invalid-feedback">Por favor ingresa el número.</div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="piso" class="form-label">Piso/Depto</label>
                            <input type="text" class="form-control" id="piso" name="piso" value="<?= $datos_formulario['piso'] ?? '' ?>" placeholder="1° A">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="localidad" class="form-label">Localidad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="localidad" name="localidad" value="<?= $datos_formulario['localidad'] ?? '' ?>" placeholder="Ciudad Autónoma de Buenos Aires" required>
                            <div class="invalid-feedback">Por favor ingresa la localidad.</div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="provincia" class="form-label">Provincia <span class="text-danger">*</span></label>
                            <select class="form-select" id="provincia" name="provincia" required>
                                <option value="">Seleccionar provincia</option>
                                <option value="CABA">Ciudad Autónoma de Buenos Aires</option>
                                <option value="BA">Buenos Aires</option>
                                <option value="CAT">Catamarca</option>
                                <option value="CHA">Chaco</option>
                                <option value="CHU">Chubut</option>
                                <option value="COR">Córdoba</option>
                                <option value="ERI">Corrientes</option>
                                <option value="ENT">Entre Ríos</option>
                                <option value="FOR">Formosa</option>
                                <option value="JUJ">Jujuy</option>
                                <option value="LPA">La Pampa</option>
                                <option value="LRI">La Rioja</option>
                                <option value="MEN">Mendoza</option>
                                <option value="MIS">Misiones</option>
                                <option value="NEU">Neuquén</option>
                                <option value="RNE">Río Negro</option>
                                <option value="SAL">Salta</option>
                                <option value="SJU">San Juan</option>
                                <option value="SLU">San Luis</option>
                                <option value="SCR">Santa Cruz</option>
                                <option value="SFE">Santa Fe</option>
                                <option value="SDE">Santiago del Estero</option>
                                <option value="TDF">Tierra del Fuego</option>
                                <option value="TUC">Tucumán</option>
                            </select>
                            <div class="invalid-feedback">Por favor selecciona una provincia.</div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="codigoPostal" class="form-label">Código Postal</label>
                            <input type="text" class="form-control" id="codigoPostal" name="cod_postal" value="<?= $datos_formulario['cod_postal'] ?? '' ?>" placeholder="C1000ABC">
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3">Observaciones</h6>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Notas adicionales..."><?= $datos_formulario['observaciones'] ?? '' ?></textarea>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3">Estado</h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                            <select class="form-select" id="estado" required>
                                <option value="activo" selected>Activo</option>
                                <option value="inactivo">Inactivo</option>
                                <option value="suspendido">Suspendido</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                    <i class="bi bi-arrow-clockwise"></i> Limpiar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg"></i>
                                    <?php if (isset($modo) && $modo === 'editar'): ?>
                                        Actualizar Razón Social
                                    <?php else: ?>
                                        Guardar Razón Social
                                    <?php endif; ?>
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
    // Formato automático para CUIT/CUIL
    document.getElementById('cuitCuil').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 11) {
            if (value.length > 2) {
                value = value.substring(0, 2) + '-' + value.substring(2);
            }
            if (value.length > 11) {
                value = value.substring(0, 11) + '-' + value.substring(11);
            }
            e.target.value = value;
        }
    });

    // Formato automático para teléfono
    document.getElementById('telefono').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0) {
            value = '+54 ' + value;
            if (value.length > 7) {
                value = value.substring(0, 7) + ' ' + value.substring(7);
            }
            if (value.length > 12) {
                value = value.substring(0, 12) + '-' + value.substring(12);
            }
            e.target.value = value;
        }
    });

    // Formulario ahora se envía normalmente sin JavaScript interceptándolo

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

        // Auto-remover después de 5 segundos
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    // Función para resetear el formulario
    function resetForm() {
        document.getElementById('razonSocialForm').reset();
        document.getElementById('razonSocialForm').classList.remove('was-validated');
        document.getElementById('alertContainer').innerHTML = '';
    }

    // Validación en tiempo real
    const inputs = document.querySelectorAll('#razonSocialForm input, #razonSocialForm select');
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

    // Seleccionar provincia en modo edición
    <?php if (isset($datos_formulario['provincia']) && !empty($datos_formulario['provincia'])): ?>
        document.getElementById('provincia').value = '<?= $datos_formulario['provincia'] ?>';
    <?php endif; ?>
</script>

<?php include 'footer.php'; ?>