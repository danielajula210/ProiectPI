<?php
require_once("conn.php");

$err = "";
if(isset($_POST["register"])) {
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $rpass = $_POST["rpass"];

    if($pass != $rpass)
        $err = "Parolele nu se potrivesc";
    else if(strlen($pass) < 6)
        $err = "Parola trebuie sa contina cel putin 6 caractere";
    else {

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);
        if($result->num_rows != 0)
            $err = "Exista deja un cont cu acest email";
        else {
            $hpass = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users(email,pass) VALUES ('$email', '$hpass')";
            $conn->query($sql);
            header("Location: login.php");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="left">
        <form method="POST">
            <h1>Inregistrare</h1>
            <div class="formContent">
                <div class="formInput">
                    <label for="email">E-mail</label>
                    <input name="email" type="email" placeholder="Email" required>
                </div>
                <div class="formInput">
                    <label for="pass">Parola</label>
                    <input name="pass" type="password" placeholder="Parola" required>
                </div>
                <div class="formInput">
                    <label for="rpass">Repetare parola</label>
                    <input name="rpass" type="password" placeholder="Repetare parola" required>
                </div>
                <?php if($err != ""): ?>
                <p style="color: red"><?php echo $err; ?></p>
                <?php endif; ?>
                <input name="register" type="submit" value="INREGISTRARE" style="font-weight: bold">
                <p>Aveti deja cont? Autentificati-va de <a style="color: green; font-weight: bold" href="login.php">aici</a></p>
            </div>
        </form>
    </div>
    <div class="rightRegister"></div>
</body>
</html>