<?php
$tableList = array();
$sqlTableList = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE (TABLE_SCHEMA ='$database') ORDER BY table_name ASC";
try {
    $conn = new mysqli($servername, $db_username, $db_password, $database);
    mysqli_query($conn, $sqlTableList);
    if ($result = mysqli_query($conn, $sqlTableList))
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $tableName = $row['TABLE_NAME'];
                array_push($tableList, $tableName);
            }
        }
    mysqli_close($conn);
} catch (Exception $e) {
    $error = "<i class='fa fa-exclamation-triangle' aria-hidden='true'>Database connection error</i><br>";
    mysqli_close($conn);
}
// Create user table and initialize data if user table does not exist in database
if (!in_array('user', $tableList)) {
    try {
        $conn = new mysqli($servername, $db_username, $db_password, $database);

        // SQL query to create the user table
        $sqlTable = "CREATE TABLE IF NOT EXISTS user (
        ID INT(10) AUTO_INCREMENT PRIMARY KEY,
        userName VARCHAR(30) NOT NULL UNIQUE,
        email VARCHAR(30) NOT NULL UNIQUE,
        Password VARCHAR(30) NOT NULL
    )";
        mysqli_query($conn, $sqlTable);

        $userName = 'cos30049a';
        $email = 'cos30049a@swinburn.edu.vn';
        $password = '12345678';
        $sql = "INSERT INTO user (userName,email, Password) VALUES ('$userName','$email', '$password')";
        mysqli_query($conn, $sql);

        $userName = 'cos30049b';
        $email = 'cos30049b@swinburn.edu.vn';
        $password = '12345678';
        $sql = "INSERT INTO user (userName,email, Password) VALUES ('$userName','$email', '$password')";
        mysqli_query($conn, $sql);


        mysqli_close($conn);
    } catch (Exception $e) {
        echo "Error creating user table: " . $e->getMessage();
    }
}

// Create wallet table and initialize data if wallet table does not exist in database
if (!in_array('wallet', $tableList)) {
    try {
        $conn = new mysqli($servername, $db_username, $db_password, $database);

        // SQL query to create the wallet table
        $sqlTable = "CREATE TABLE IF NOT EXISTS wallet (
        walletID VARCHAR(40) PRIMARY KEY,
        userName VARCHAR(30) NOT NULL UNIQUE,
        walletBalance FLOAT,
        FOREIGN KEY (userName) REFERENCES user(userName)
    )";
        mysqli_query($conn, $sqlTable);

        $userName = 'cos30049a';
        $walletID = '1Lbcfr7sAHTD9CgdQo3HTMTkV8LK4ZnX71';
        $walletBalance = 4.6;
        $sql = "INSERT INTO wallet VALUES ('$walletID','$userName','$walletBalance')";
        mysqli_query($conn, $sql);

        $walletID = '1Lbcfr7sAHTD9CgdQo3HTMTkV8LK4ZnX72';
        $userName = 'cos30049b';
        $walletBalance = 3.5;
        $sql = "INSERT INTO wallet VALUES ('$walletID','$userName','$walletBalance')";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
    } catch (Exception $e) {
        echo "Error creating wallet table: " . $e->getMessage();
    }
}

// Create transaction table and initialize data if transaction table does not exist in database
if (!in_array('transaction', $tableList)) {
    try {
        $conn = new mysqli($servername, $db_username, $db_password, $database);

        // SQL query to create the wallet table
        $sqlTable = "CREATE TABLE IF NOT EXISTS transaction (
        transactionID INT(10) AUTO_INCREMENT PRIMARY KEY,
        senderAddress VARCHAR(40),
        receiverAddress VARCHAR(40),
        transactionAmount FLOAT,
        transactionDate DATE,
        FOREIGN KEY (senderAddress) REFERENCES wallet(walletID)
        FOREIGN KEY (receiverAddress) REFERENCES wallet(walletID)
    )";
        mysqli_query($conn, $sqlTable);

        $sender = '1Lbcfr7sAHTD9CgdQo3HTMTkV8LK4ZnX71';
        $receiver = '1Lbcfr7sAHTD9CgdQo3HTMTkV8LK4ZnX72';
        $tranctionAmount = 1.5;
        $transactionDate = date("Y-m-d");
        $sql = "INSERT INTO transaction(senderAddress,receiverAddress,transactionAmount,transactionDate) 
            VALUES ('$sender','$receiver','$tranctionAmount','$transactionDate')";
        mysqli_query($conn, $sql);

        $sender = '1Lbcfr7sAHTD9CgdQo3HTMTkV8LK4ZnX71';
        $receiver = '1Lbcfr7sAHTD9CgdQo3HTMTkV8LK4ZnX72';
        $tranctionAmount = 1;
        $transactionDate = date("Y-m-d");
        $sql = "INSERT INTO transaction(senderAddress,receiverAddress,transactionAmount,transactionDate) 
            VALUES ('$sender','$receiver','$tranctionAmount','$transactionDate')";
        mysqli_query($conn, $sql);

        mysqli_close($conn);
    } catch (Exception $e) {
        echo "Error creating wallet table: " . $e->getMessage();
    }
}
?>
<?php
