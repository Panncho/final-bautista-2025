<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 70px;
            --header-height: 60px;
            --transition-speed: 0.3s;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        #sidebar {
            position: fixed;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
            color: white;
            transition: all var(--transition-speed) ease;
            z-index: 1000;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-collapsed #sidebar {
            width: var(--sidebar-collapsed-width);
        }
        
        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            height: var(--header-height);
            display: flex;
            align-items: center;
        }
        
        .sidebar-header h3 {
            font-size: 1.2rem;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
        }
        
        .sidebar-menu {
            padding: 1rem 0;
            height: calc(100vh - var(--header-height));
            overflow-y: auto;
        }
        
        .sidebar-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            margin: 0;
        }
        
        .sidebar-menu a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            transition: all 0.2s;
            white-space: nowrap;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 4px solid white;
        }
        
        .sidebar-menu i {
            margin-right: 0.8rem;
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }
        
        .sidebar-collapsed .sidebar-menu span {
            display: none;
        }
        
        .sidebar-collapsed .sidebar-header h3 {
            display: none;
        }
        
        /* Main Content */
        #content {
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition-speed) ease;
            min-height: 100vh;
        }
        
        .sidebar-collapsed #content {
            margin-left: var(--sidebar-collapsed-width);
        }
        
        /* Header */
        #header {
            height: var(--header-height);
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .toggle-sidebar {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #6c757d;
            cursor: pointer;
        }
        
        /* Dashboard Content */
        .dashboard-content {
            padding: 1.5rem;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 1.5rem;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card {
            text-align: center;
            padding: 1.5rem;
        }
        
        .stat-card i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }
        
        .stat-card h2 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-card p {
            color: #6c757d;
            margin: 0;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            #sidebar {
                width: var(--sidebar-collapsed-width);
                text-align: center;
            }
            
            #sidebar .sidebar-header h3,
            #sidebar .sidebar-menu span {
                display: none;
            }
            
            #content {
                margin-left: var(--sidebar-collapsed-width);
            }
            
            .sidebar-expanded #sidebar {
                width: var(--sidebar-width);
            }
            
            .sidebar-expanded #sidebar .sidebar-header h3,
            .sidebar-expanded #sidebar .sidebar-menu span {
                display: block;
            }
            
            .sidebar-expanded #content {
                margin-left: var(--sidebar-width);
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">