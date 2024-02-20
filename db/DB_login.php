<?php
session_start();
require_once('DB_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $_SESSION['loggedin'] = true;
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $userl['id'];
        header ("location: ./pages/dashboard.php") ;
    } else {
        echo "Invalid username or password.";
    }
}
?>