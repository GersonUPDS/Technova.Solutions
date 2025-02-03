<?php
$host = 'localhost';
$db = 'technova_solutions';  // Reemplaza con el nombre de tu base de datos
$user = 'root'; // Usuario por defecto de MySQL en XAMPP
$password = ''; // Generalmente vacío en XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>