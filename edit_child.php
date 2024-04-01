<?php
session_start();
include 'connection_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем, все ли данные о ребенке переданы
    if (empty($_POST["child_name"]) || empty($_POST["child_dob"]) || empty($_POST["child_gender"])) {
        echo "Ошибка: Не все данные о ребенке были переданы.";
        exit();
    }

    // Получаем данные из формы
    $child_name = $_POST["child_name"];
    $child_dob = $_POST["child_dob"];
    $child_gender = $_POST["child_gender"];

    // Получаем ID родителя
    $username = $_SESSION["username"];
    $sql_user_id = "SELECT user_id FROM users WHERE username='$username'";
    $result_user_id = $conn->query($sql_user_id);
    if ($result_user_id->num_rows > 0) {
        $row_user_id = $result_user_id->fetch_assoc();
        $parent_id = $row_user_id["user_id"];

        // Вставляем данные о новом ребенке в таблицу children
        $sql_insert_child = "INSERT INTO children (parent_id, first_name, date_of_birth, gender) VALUES ('$parent_id', '$child_name', '$child_dob', '$child_gender')";
        if ($conn->query($sql_insert_child) === TRUE) {
            echo "Новый ребенок успешно добавлен.";
        } else {
            echo "Ошибка при добавлении ребенка: " . $conn->error;
        }
    } else {
        echo "Ошибка: Пользователь не найден.";
    }
} else {
    echo "Ошибка: Неверный метод запроса.";
}

$conn->close();
?>
