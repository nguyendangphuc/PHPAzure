<?php
include 'dbConnection.php';
include 'tableSetup.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online Shopping</title>
    <link rel="stylesheet" href="stylesLogin.css">
</head>
<body>
    <div class="login-container">
        <h2>Login to Your Account</h2>
        <?php
        $message = '';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['login'])) {
                $username = $_POST["username"];
                $password = $_POST["password"];
                $sql = "SELECT Password FROM user WHERE userName = '$username'";
                try {
                    $conn = new mysqli($servername, $db_username, $db_password, $database);
                    if ($result = mysqli_query($conn, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            $record = mysqli_fetch_assoc($result);
                            if ($record['Password'] != $password)
                                $message = 'Incorrect password';
                            else {
                                mysqli_close($conn);
                                session_start();
                                $_SESSION['userName'] = $username;
                                header('location:main.php');
                            }
                        } else {
                            $message = 'Username not found';
                        }
                    }
                    mysqli_close($conn);
                } catch (Exception $e) {
                    $message = 'Database connection error';
                    mysqli_close($conn);
                }

            }
            if (isset($_POST['signup'])) {
                header('location:register.php');
            }
        }

        ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
            </div>
            <p><button type="submit" class="login-button" name="login">Login</button></p>
            <p><button type="submit" class="login-button" name="signup">Sign Up</button></P>
        </form>
        <?php
        if (!empty($message)) {
            echo "<script src='message.js'></script><script>showError('$message');</script>";
        }
        ?>
    </div>
    <div>
    <script src="message.js"></script>
    </div>
</body>
</html>

