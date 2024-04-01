<?php
// Подключение к базе данных
include 'connection_db.php';

// Получение username из сессии
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Получение user_id по username
    $sql_user_id = "SELECT user_id FROM users WHERE username=?";
    $stmt_user_id = $conn->prepare($sql_user_id);
    $stmt_user_id->bind_param("s", $username);
    $stmt_user_id->execute();
    $result_user_id = $stmt_user_id->get_result();

    if ($result_user_id->num_rows > 0) {
        $row_user_id = $result_user_id->fetch_assoc();
        $user_id = $row_user_id["user_id"];

        // Получение данных из формы
        $child_first_name = $_POST['child_first_name'];
        $child_date_of_birth = $_POST['child_date_of_birth'];
        $child_gender = $_POST['child_gender'];

        // Проверка наличия данных
        if(empty($child_first_name) || empty($child_date_of_birth) || empty($child_gender)) {
            echo "Пожалуйста, заполните все поля.";
            exit();
        }

        // Запрос для добавления нового ребенка
        $sql_add_child = "INSERT INTO children (parent_id, first_name, date_of_birth, gender) VALUES (?, ?, ?, ?)";
        $stmt_add_child = $conn->prepare($sql_add_child);
        $stmt_add_child->bind_param("isss", $user_id, $child_first_name, $child_date_of_birth, $child_gender);

        // Выполнение запроса
        if ($stmt_add_child->execute()) {
            echo "Ребенок успешно добавлен.";
        } else {
            echo "Ошибка при добавлении ребенка: " . $conn->error;
        }

        // Закрытие подготовленного запроса
        $stmt_add_child->close();
    } else {
        echo "Ошибка: Не удалось найти пользователя с таким username.";
    }

    // Закрытие подготовленного запроса и соединения с базой данных
    $stmt_user_id->close();
    $conn->close();
} else {
    echo "Ошибка: Не удалось получить username из сессии.";
}
?>
