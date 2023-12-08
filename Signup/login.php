<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $con = new mysqli("localhost", "root", "", "test");
        if ($con->connect_error) {
            die("Failed to connect: " . $con->connect_error);
        } else {
            $stmt = $con->prepare("SELECT * FROM registration WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt_result = $stmt->get_result();
            if ($stmt_result->num_rows > 0) {
                $data = $stmt_result->fetch_assoc();
                if ($data['password'] === $password) {
                    // Set session variables or tokens as needed
                    $_SESSION['user_id'] = $data['id'];
                    $_SESSION['user_email'] = $data['email'];

                    header("Location: index.html");
                    exit;
                } else {
                    echo "<h2>Invalid Email or password</h2>";
                }
            } else {
                echo "<h2>Invalid Email or Password</h2>";
            }
        }
    }
}
?>
