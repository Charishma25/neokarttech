<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  $sql = "SELECT id, password FROM users WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();
    if (password_verify($password, $hashed_password)) {
      $_SESSION['user_id'] = $id;
      echo "Login successful!";
    } else {
      echo "Invalid password.";
    }
  } else {
    echo "No user found with that email.";
  }

  $stmt->close();
  $conn->close();
}
?>
