<?php
//FOMRMULARIO PARA CREAR USUARIOS Y ASIGNAR ROLES
require 'auth.php';
autenticarUsuario();
if (!verificarPermiso('Gestionar usuarios')) {
    echo "Acceso denegado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="tablas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
                    <header class="navbar">
                        <div class="logo">
                            <img src="logo2.png" alt="TechNova">
                        </div>
                        <nav>
                            <ul class="nav-links">
                            <li><a href="dashboard.php">Inicio</a></li>

                <li>
                    <?php if (verificarPermiso('Gestionar usuarios')): ?>
                    <a href="#">Gestionar Usuarios</a>
                    <?php endif; ?>
                    <ul class="submenu">
                        <li><a href="usuarios.php">Gestionar Usuarios</a></li>
                        <li><a href="#">Roles</a></li>
                    </ul>
                </li>
                <li>
                    <?php if (verificarPermiso('Gestionar Inventario')): ?>
                    <a href="#">Gestionar Inventario</a>
                    <?php endif; ?>
                    <ul class="submenu">
                        <li><a href="lista_productos.php">Productos</a></li>
                        <li><a href="registrar_productos.php">Compras</a></li>
                        <li><a href="registrar_proveedor.php">Proveedores</a></li>
                    </ul>
                </li>
                <li>
                    <?php if (verificarPermiso('Ver reportes')): ?>
                    <a href="#">Ver reportes</a>
                    <?php endif; ?>
                    <ul class="submenu">
                        <li><a href="#">Detalle de Ventas</a></li>
                        <li><a href="lista_proveedores.php">Lista de Proveedores</a></li>
                        
                    </ul>
                </li>
                <li>
                    <?php if (verificarPermiso('Registrar ventas')): ?>
                    <a href="#">Registrar ventas</a>
                    <?php endif; ?>
                    <ul class="submenu">
                        <li><a href="realizar_venta.php">Ventas</a></li>
                        <li><a href="#">Promociones</a></li>
                        
                    </ul>
                </li>
                <li><a href="#">Soporte</a></li>
                            </ul>
                        </nav>
                    </header>
    <!-- Hero Section -->
    <section class="hero">
        <h1>TechNova Solutions</h1>
        <p><h2>Bienvenido: <?php echo $_SESSION['role']; ?></h2> </p>
    </section>
    <!-- Hero Section -->

    <!-- Main Content -->
    <div class="container">
        <!-- Form Section -->
        <div class="form-section">
            <h2><i class="fas fa-edit"></i> Gestion de Personal</h2>
            <form action="registrar_usuario.php" method="POST">
                <table>
                    <tr>
                        <td>Nombre:</td>
                        <td><input type="text" name="nombre" required></td>
                    </tr>
                    <tr>
                        <td>Apellidos:</td>
                        <td><input type="text" name="apellidos" required></td>
                    </tr>
                    <tr>
                        <td>Dirección:</td>
                        <td><input type="text" name="direccion" require></td>
                    </tr>
                    <tr>
                        <td>Teléfono:</td>
                        <td><input type="text" name="telefono" require></td>
                    </tr>
                    <tr>
                        <td>Fecha Nacimiento:</td>
                        <td><input type="date" name="fecha_nacimiento" require></td>
                    </tr>
                    <tr>
                        <td>Género:</td>
                        <td>
                            <select name="género" required>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Estado Civil:</td>
                        <td>
                            <select name="estado_civil" required>
                                <option value="Soltero(a)">Soltero(a)</option>
                                <option value="Casado(a)">Casado(a)</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="text" name="email" require></td>
                    </tr>
                    <tr>
                        <td>Contraseña:</td>
                        <td><input type="text" name="password" require></td>
                    </tr>
                    <tr>
                        <td>Cargo:</td>
                        <td>
                            <select name="cargo" required>
                                <option value="Administrador">Administrador</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Cajero">Cajero</option>
                            </select>
                        </td>
                    </tr>
                    </tr>
                        <td><input type="submit" value="Registrar"></td>
                        <td><input type="reset" value="Limpiar"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>
