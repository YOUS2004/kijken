

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .login-box {
            width: 300px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: calc(100% - 20px);
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .login-box input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 3px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login</h2>
    <form method="post">
        <div class="user-box">
            <input type="text" name="username" required>
            <label>Username</label>
        </div>
        <div class="user-box">
            <input type="password" name="password" required>
            <label>Password</label>
        </div>
        <input type="submit" value="Login">
    </form>
</div>

</body>
</html>

<?php
session_start(); 

$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "CashFlow";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role = $row['role'];

        
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        switch ($role) {
            case 'admin':
                header("Location: admin_page.php");
                break;
            case 'manager':
                header("Location: manager_page.php");
                break;
            case 'cashier':
                header("Location: cashier_page.php");
                break;
            case 'warehouse':
                header("Location: warehouse_page.php");
                break;
            default:
                header("Location: default_page.php");
                break;
        }
        exit();
    } else {
        echo "<script>alert('Fout wachtwoord of gebruikersnaam');</script>";
    }
}
?>
