<?php
    session_start();
    // unset($_SESSION['user_id']);
    $success_loggedout = session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>
<body>
    <h1>Logout</h1>
    <?php if($success_loggedout): ?>
        <span style="color=grey">Successfully logged out!</span><br>
        <a href="index.php">Main page</a>/<a href="login.php">Log in</a><br>
    <?php endif; ?>
</body>
</html>