<?php
session_start();
require_once("conn.php");

$err = "";
if(isset($_POST["login"])) {
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    if($result->num_rows == 0)
        $err = "Nu exista un cont cu acest email";
    else {
        $row = $result->fetch_assoc();
        // var_dump($row);
        if(password_verify($pass, $row['pass'])) {
            $_SESSION["email"] = $email;
            header("Location: /Proiect/index.php");
        }
        else $err = "Incorrect password";
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
            <h1>Autentificare</h1>
            <div class="formContent">
                <div class="formInput">
                    <label for="email">E-mail</label>
                    <input name="email" type="email" placeholder="Email">
                </div>
                <div class="formInput">
                    <label for="pass">Parola</label>
                    <input name="pass" type="password" placeholder="Parola">
                </div>
                <?php if($err != ""): ?>
                <p style="color: red"><?php echo $err; ?></p>
                <?php endif; ?>
                <input name="login" type="submit" value="AUTENTIFICARE" style="font-weight: bold">
                <p>Nu aveti cont? Creati unul de <a style="color: green; font-weight: bold" href="register.php">aici</a></p>
            </div>
        </form>
    </div>
    <div class="rightLogin"></div>
</body>
</html>