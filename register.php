<?php
include 'connection_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $surename = $_POST['surename']; // Добавляем обработку поля "surename"
    $phone = $_POST['phone']; // Добавляем обработку поля "phone"

    // Check if the connection is valid
    if ($conn === false) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and execute the SELECT query
    $check_stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    if ($check_stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_stmt->store_result();
    
    if ($check_stmt->num_rows > 0) {
        echo "Пользователь с таким именем уже существует!";
        exit;
    }
    $check_stmt->close();

    // Prepare and execute the INSERT query
    $insert_stmt = $conn->prepare("INSERT INTO users (username, password, name, phone) VALUES (?, ?, ?, ?)");
    if ($insert_stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    
    $insert_stmt->bind_param("ssss", $username, $password, $surename, $phone);
    if ($insert_stmt->execute()) {
        header("Location: index.php?registration_success=1");
        exit();
    } else {
        echo "Ошибка при регистрации: " . $insert_stmt->error;
    }
    $insert_stmt->close();
}
?>
