<?php

include 'connection.php';

session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query_login = "SELECT id, password FROM users WHERE username = ?";
    $stmt_login = $pdo->prepare($query_login);
    $stmt_login->execute([$username]);
    $user = $stmt_login->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
        exit();
    } else {
        $loginError = "Invalid username or password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="Images/fnaflogo.png">
    <title>FAZBEAR LOGIN</title>
    <link rel="stylesheet" href="css/edit.css">
</head>

<body class="body">

    <nav>
        <ul>
        <li><a class="navbar-brand" href="index.php"><img src="Images/fnaflogo.png" alt="logo" width="150" height="150"></a></li>
        </ul>
    </nav>

    <form method="post" class="form">
        <h1>Login</h1>
        <?php if (isset($loginError)) echo '<p style="color: red;">' . $loginError . '</p>'; ?>
        <label for="username" class="label">Username:</label>
        <input type="text" name="username" placeholder="Username" class="input" required>
        <label for="password" class="label">Password:</label>
        <input type="password" name="password" placeholder="Password" class="input" required>
        <input type="submit" value="LOGIN" name="login" class="button">
    </form>
</body>

</html>
