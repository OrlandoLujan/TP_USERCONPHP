<?php
session_start();

require 'database.php';

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    
    // Verificar si el correo electrónico está vacío
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare('SELECT usuario_id, email, password FROM usuarios WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0 && password_verify($_POST['password'], $results['password'])) {
            $_SESSION['usuario_id'] = $results['usuario_id'];
            header('Location: /PHP_LOGIN_2023');
            exit;
        } else {
            $message = 'La contraseña no coincide';
        }
    } else {
        $message = 'Por favor, ingrese una dirección de correo electrónico válida.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto"  rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require 'partials/header.php'; ?>

    <h1>Ingrese sus Credenciales</h1>
    <span> o <a href="signup.php">Regístrese</a></span>

    <?php if (!empty($message)) : ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <form action="login.php" method="post">
        <input type="text" name="email" placeholder="Ingrese su correo" required>
        <input type="password" name="password" placeholder="Ingrese su contraseña" required>
        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>
