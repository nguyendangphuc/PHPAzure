<?php 
include 'dbConnection.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Online Shopping</title>
    <link rel="stylesheet" href="stylesLogin.css">
</head>
<body>
    <div class="login-container">
        <h2>Register for Your Account</h2>
        <?php
            $message = '';
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['register'])){
                    $username = $_POST["username"];
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    $confirmPassword = $_POST["confirm_password"];
                    if ($password !== $confirmPassword) {
                        $message = "Passwords do not match.";
                    } else {
                        // Insert data into user table
                        try {
                            $conn = new mysqli($servername, $db_username, $db_password, $database);

                            //check if username exist
                            $usernameSql = "SELECT userName FROM user WHERE userName = '$username'";
                            if ($result = mysqli_query($conn,$usernameSql)){
                                if (mysqli_num_rows($result)>0){
                                    $message = 'Username has been existed';
                                    mysqli_close($conn);
                                }   
                                else
                                {
                                    $sql = "INSERT INTO user (userName, email, Password) VALUES ('$username', '$email', '$password')";
                                    mysqli_query($conn, $sql);
                                    mysqli_close($conn);
                                    $message = "Registration successful. You can now log in.";
                                }                            
                            }                           
                        } catch (Exception $e) {
                            $message = "Error: " . $e->getMessage();
                        }
                    }
                }
                if (isset($_POST['signin'])){
                    header('location:login.php');
                }
            }
        ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password">
            </div>
            <p><button type="submit" class="login-button" name="register">Register</button></p>
            <p><button type="submit" class="login-button" name="signin">Sign In</button></P>
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
