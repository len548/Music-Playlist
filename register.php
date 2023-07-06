<?php
    include_once("storage.php");
    
    $username = $_POST["username"] ?? '';
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';
    $confirmPassword = $_POST["confirm_password"] ?? '';
    $success = false;
    if ($_POST) {
        // Validate form fields
        $errors = [];

        if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
            $errors[] = "All fields are required.";
        }

        // Check if a username is already existed or not
        $stor = new JsonStorage("users.json");
        $existingUser = $stor->findOne(['username' => $username]);
        //check if a username is already existed or not
        if (isset($existingUser)) {
            $errors[] = "The username already used.";
        }

        $existingEmail = $stor->findOne(['email' => $email]);
        if (isset($existingEmail)) {
            $errors[] = "The email already used.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        if ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        }

        if (empty($errors)) {
            $user = [
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'isAdmin' => false
            ];
            $id = $stor -> add($user);
            $user['id'] = $id;
            print_r($user);
            $stor -> update($id, $user);
            $success = true;
            
        }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Music Playlist Application</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1><?php echo $success ? "Successful Registration!" : "Register for the Music Playlist Application" ?></h1>
        <a href="index.php">Home</a>/<a href="login.php">Login</a>
    </header>

    <main>
        <h2 style="display:<?php echo $success ? "none" : "" ?>">Registration</h2>
        
        <form action="register.php" method="POST" novalidate style="display:<?php echo $success ? "none" : "" ?>">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?php echo isset($username) ? $username : ''; ?>"><br>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo isset($email) ? $email : ''; ?>"><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password"><br>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password"><br>
            <?php if (!empty($errors)) { ?>
                <ul class="error">
                    <?php foreach ($errors as $error) { ?>
                        <span style="color:red"><?php echo $error; ?></span><br>
                    <?php } ?>
                </ul>
            <?php } ?>

            <button type="submit">Register</button><br>
        </form>
        
    </main>
</body>
</html>

