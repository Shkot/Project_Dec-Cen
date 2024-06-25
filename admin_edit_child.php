<?php
include 'connection_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $child_id = $_POST['child_id'];
    $first_name = $_POST['first_name'];
    $second_name = $_POST['second_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];

    $sql = "UPDATE children SET first_name=?, second_name=?, date_of_birth=?, gender=? WHERE child_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $first_name, $second_name, $date_of_birth, $gender, $child_id);

    if ($stmt->execute()) {
        echo '<!DOCTYPE html>
            <html lang="ru">
            <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/main.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
            </head>
            <body>
            <div style="display: flex; justify-content: center; align-items: center; margin-top: 40vh; flex-direction: column;">
            <a style="font-size: 25px; color: #000000; text-align: center;"> 
            Данные ребенка успешно обновлены. </a>
            <button onclick="history.go(-1);" style=" margin: 15px; width: 200px; height: 60px; border: none; text-decoration: none; background: #a9def8; font-size: 1.2em; border: 1px solid #000; border-radius: 3px; display: flex; align-items: center; justify-content: center; color: #000; font: 14px / 1.6 "Comfortaa";"> 
            Вернуться на страницу личного кабинета </button>
            </div>
            </body>
            </html>';
    } else {
        echo '<!DOCTYPE html>
            <html lang="ru">
            <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/main.css">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
            </head>
            <body>
            <div style="display: flex; justify-content: center; align-items: center; margin-top: 40vh; flex-direction: column;">
            <a style="font-size: 25px; color: #000000; text-align: center;"> 
            Ошибка при обновлении данных ребенка. </a>
            <button onclick="history.go(-1);" style=" margin: 15px; width: 200px; height: 60px; border: none; text-decoration: none; background: #a9def8; font-size: 1.2em; border: 1px solid #000; border-radius: 3px; display: flex; align-items: center; justify-content: center; color: #000; font: 14px / 1.6 "Comfortaa";"> 
            Вернуться на страницу личного кабинета </button>
            </div>
            </body>
            </html>';
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Ошибка: Неверный метод запроса.";
}
?>