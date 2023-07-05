<?php
require 'database.php';

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = $_POST['email'];
    
    // Verificar si el correo electrónico contiene un símbolo "@"
    if (strpos($email, '@') === false) {
        $message = 'El correo electrónico debe contener el símbolo "@".';
    } else {
        $sql = "INSERT INTO usuarios (email, password) VALUES (:email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            $message = 'Usuario creado satisfactoriamente';
        } else {
            $message = 'Ha ocurrido un error creando tu contraseña';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto"  rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require 'partials/header.php'; ?>

    <?php if (!empty($message)) : ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <h1>Registrarse</h1>
    <span> o <a href="login.php">Inicie Sesión</a></span>

    <form action="signup.php" method="post">
        <input type="text" name="email" placeholder="Ingrese su correo">
        <input type="password" name="password" placeholder="Ingrese su contraseña">
        <input type="password" name="confirm_password" placeholder="Confirme su contraseña">
        <input type="submit" value="Registrarse">
    </form>
</body>
</html>
