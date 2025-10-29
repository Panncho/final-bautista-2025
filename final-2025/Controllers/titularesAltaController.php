<?php
// Controlador para el alta de titulares
// Incluye el modelo
require_once __DIR__ . '/../Models/Titular.php';

//Variables para la vista
$modo = 'crear'; // Definir modo
$error = '';
$success = '';
$datos_formulario = [];

// 3. Procesar formulario(POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Guardar datos
    $datos_formulario = $_POST;

    // Obtener datos del formulario
    $datos = [
        'tipo' => $_POST['tipo'] ?? '',
        'nombre' => $_POST['nombre'] ?? '',
        'email' => $_POST['email'] ?? '',
        'telefono' => $_POST['telefono'] ?? '',
        'fecha_inicio' => $_POST['fecha_inicio'] ?? '',
        'cuit' => $_POST['cuit'] ?? '',
        'celular' => $_POST['celular'] ?? '',
        'web' => $_POST['web'] ?? '',
        'calle' => $_POST['calle'] ?? '',
        'numero' => $_POST['numero'] ?? '',
        'piso' => $_POST['piso'] ?? '',
        'localidad' => $_POST['localidad'] ?? '',
        'provincia' => $_POST['provincia'] ?? '',
        'cod_postal' => $_POST['cod_postal'] ?? '',
        'observaciones' => $_POST['observaciones'] ?? '',
        'estado' => 1 // Activo por defecto
    ];

    // Validaciones básicas
    if (empty($datos['tipo'])) {
        $error = "El tipo de persona es obligatorio";
    } elseif (empty($datos['nombre'])) {
        $error = "El nombre es obligatorio";
    } elseif (empty($datos['email'])) {
        $error = "El email es obligatorio";
    } elseif (empty($datos['cuit'])) {
        $error = "El CUIT es obligatorio";
    } elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
        $error = "El email no tiene un formato válido";
    } else {
        // Si no hay errores de validación, intentar crear
        $titularModel = new Titular();

        if ($titularModel->crear($datos)) {
            // Éxito: redirigir a la lista con mensaje de éxito
            header('Location: titularesIndexController.php?success=creado');
            exit;
        } else {
            $error = "Error al crear el titular. Verifique que el email y CUIT no estén duplicados.";
        }
    }
}

//Mostrar el formulario (la vista tendrá acceso a las variables $error, $success y $datos_formulario)
require_once __DIR__ . '/../Views/titularesAlta.view.php';
