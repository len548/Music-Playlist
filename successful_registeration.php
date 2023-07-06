<?php
    include_once("storage.php");
    
    // Validate and process registration data
    $username = $_POST["username"] ?? '';
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';
    $confirmPassword = $_POST["confirm_password"] ?? '';
    
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
        if($existingUser){
            $error[] = "The username already used.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        if ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        }

        // If there are no errors, save the registration data and redirect to the login page
        if (empty($errors)) {
            // TODO: Save registration data to database or file
            $user = [
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'isAdmin' => false
            ];
            $stor -> add($user);
            // Redirect to the login page
            header("Location: successful_registeration.php");
            exit();
        }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Successful Registration - Music Playlist Application</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Successful Registration for the Music Playlist Application</h1>
        <a href="index.php">Go back to Main</a>
        
    </header>

    <main>
        <h2>Registration</h2>
        
        <form action="register.php" method="POST" novalidate>
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

