<?php include 'dbConnection.php';
session_start();
$username = $_SESSION['userName'];
if (empty($username))
    header('location:login.php')
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
    
        <?php
$message = '';
$walletID = '';
$walletBalance = 0;
$sendTransaction = array();
$receiveTransaction = array();
$sql = "SELECT * FROM wallet WHERE userName = '$username'";
try {
    $conn = new mysqli($servername, $db_username, $db_password, $database);
    if ($result = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($result) > 0) {
            $record = mysqli_fetch_assoc($result);
            $walletID = $record['walletID'];
            $walletBalance = $record['walletBalance'];
            mysqli_close($conn);
        } else {
            $message = 'Your wallet has not been created';
        }
    }
} catch (Exception $e) {
    $message = 'Database connection error';
    mysqli_close($conn);
}

if (!empty($message)) {
    echo "<script src='message.js'></script><script>showError('$message');</script>";
} else {

    //display wallet history(payment history)
    $sendingSql = "SELECT * FROM transaction WHERE senderAddress = '$walletID'";
    try {
        $conn = new mysqli($servername, $db_username, $db_password, $database);
        mysqli_query($conn, $sendingSql);
        if ($result = mysqli_query($conn, $sendingSql))
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($sendTransaction, $row);
                }
            }
        mysqli_close($conn);
    } catch (Exception $e) {
        $error = "<i class='fa fa-exclamation-triangle' aria-hidden='true'>Database connection error</i><br>";
        mysqli_close($conn);
    }
    echo "Your sending history:<br>";
    if (count($sendTransaction) > 0) {
        echo "Receiver Address \t\t\t Transaction Amount \t Transaction Date<br>";
        for ($i = 0; $i < count($sendTransaction); $i++) {
            echo "{$sendTransaction[$i]['receiverAddress']} \t {$sendTransaction[$i]['transactionAmount']} \t {$sendTransaction[$i]['transactionDate']} <br>";
        }
    } else {
        echo "You have no sending transaction<br>";
    }

    //display wallet history(receiving history)
    $receivingSql = "SELECT * FROM transaction WHERE receiverAddress = '$walletID'";
    try {
        $conn = new mysqli($servername, $db_username, $db_password, $database);
        mysqli_query($conn, $receivingSql);
        if ($result = mysqli_query($conn, $receivingSql))
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($receiveTransaction, $row);
                }
            }
        mysqli_close($conn);
    } catch (Exception $e) {
        $error = "<i class='fa fa-exclamation-triangle' aria-hidden='true'>Database connection error</i><br>";
        mysqli_close($conn);
    }
    /*                echo "Your receiving history:<br>";
                    if(count($receiveTransaction) > 0)
                    {
                        echo " Transaction Amount \t\t\t From Address \t\t Transaction Date<br>";
                        for ($i=0; $i < count($receiveTransaction); $i++) { 
                            echo "{$receiveTransaction[$i]['transactionAmount']} \t {$receiveTransaction[$i]['senderAddress']} \t {$receiveTransaction[$i]['transactionDate']} <br>";
                        }
                    }
                    else
                    {
                        echo "You have no receiving transaction<br>";
                    }
    */
}
?>     
    <div class="login-container">
        <h2>Welcome to Online Shop</h2>
        <h3> Your username: <?php echo $username; ?></h3>
        <h3> Your walletID: <?php echo $walletID; ?></h3>
        <h3> Your wallet balance: <?php echo $walletBalance; ?></h3>

        <table>
            <thead>
                <tr> 
                    <th colspan = "3">Your receiving history:</th>
                <tr>
                    <th>Transaction Amount</th>
                    <th>From Address</th>
                    <th>Transaction Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($receiveTransaction) == 0) {
                    echo "<tr>";
                    echo "<td colspan = '3'>You have no receiving transaction</td>";
                    echo "</tr>";
                } else {
                    for ($i = 0; $i < count($receiveTransaction); $i++) {
                        $transactionAmount = $receiveTransaction[$i]['transactionAmount'];
                        $senderAddress = $receiveTransaction[$i]['senderAddress'];
                        $receiveDate = $receiveTransaction[$i]['transactionDate'];
                        //echo "{$receiveTransaction[$i]['transactionAmount']} \t {$receiveTransaction[$i]['senderAddress']} \t {$receiveTransaction[$i]['transactionDate']} <br>";
                        echo "<tr>";
                        echo "<td>{$transactionAmount}</td>";
                        echo "<td>{$senderAddress}</td>";
                        echo "<td>{$receiveDate}</td>";
                        echo "</tr>";
                    }
                }

                ?>
            </tbody>

        </table>

    </div>
    <div>
    <script src="message.js"></script>
    </div>
</body>
</html>
<?php
