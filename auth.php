<?php
//Este archivo verifica si el usuario está autenticado y si tiene el permiso necesario.
session_start();
require 'conexion.php';

// Verifica si el usuario está autenticado
function autenticarUsuario() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.html');
        exit;
    }
}

// Verifica si el usuario tiene un permiso específico
function verificarPermiso($permiso) {
    global $pdo;

    $userId = $_SESSION['user_id'];
    $stmt = $pdo->prepare("
        SELECT p.Descripcion
        FROM Permiso p
        INNER JOIN Roles r ON p.Id_Roles = r.Id_Roles
        INNER JOIN Usuario u ON r.Id_Usuario = u.Id_Usuario
        WHERE u.Id_Usuario = ? AND p.Descripcion = ?
    ");
    $stmt->execute([$userId, $permiso]);
    return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
}
?>