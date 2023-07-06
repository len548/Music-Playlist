<?php
include_once('storage.php');
$stor = new JsonStorage('users.json');

$username = $_POST["username"] ?? '';
$password = $_POST["password"] ?? '';
// Check if the form was submitted for login
if ($_POST) {
    
    if(empty($username) || empty($password)){
        $loginError = "All fields required.";
    }
    else{
        $user = $stor -> findOne(['username' => $username]);
        if(!isset($user)|| !password_verify($password, $user['password'])){
            $loginError = "Invalid username or password.";
        }
    }
    
    if (!$loginError) {
        session_start();
        $_SESSION['userid'] = $user['id'];
        if ($user['isAdmin']) {
            header("Location: admin_main.php");
        }else{}
        header("Location: " . $user['isAdmin'] ? "admin_main.php" : "index.php");
        exit();
    } 
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Music Playlist Application</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Login to the Music Playlist Application</h1>
        <a href="index.php">Go back to Main</a>
    </header>

    <main>
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username"><br>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password"><br>
            
            <button type="submit" name="login">Login</button>
        </form>
        <?php if (isset($loginError)) { ?>
            <spanx style="color=red"><?= $loginError ?></span><br>
        <?php } ?>
    </main>
</body>
</html>

