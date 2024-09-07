<?php
session_start(); // Начинаем сессию

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION["username"])) {
    header("Location: login.php"); // Если не авторизован, перенаправляем на страницу входа
    exit();
}

include 'connection_db.php'; // Подключение к базе данных

$username = $_SESSION["username"];

// Получаем данные пользователя из базы данных
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $current_username = $row["username"];
    $current_name = $row["name"];
    $current_familiya = $row["familiya"];
    $current_otchestvo = $row["otchestvo"];
    $current_phone = $row["phone"];
} else {
    echo "Ошибка: Пользователь не найден.";
    exit();
}

// Получаем список пользователей
$sql = "SELECT user_id, username, name, familiya, otchestvo, phone FROM users";
$result = $conn->query($sql);

// Получаем список детей
$sql_children = "SELECT child_id, parent_id, first_name, second_name, date_of_birth, gender FROM children";
$result_children = $conn->query($sql_children);

// Получаем все события из таблицы events
$sql_events = "SELECT event_id, event, event_date, event_time, user_id FROM events";
$result_events = $conn->query($sql_events);

// Обработка запроса на изменение данных
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    // Обработка изменения данных пользователя
    if (isset($_POST["edit_user"])) {
        $edit_user_id = $_POST["edit_user_id"];
        $new_username = $_POST["new_username"];
        $new_name = $_POST["new_name"];
        $new_familiya = $_POST["new_familiya"];
        $new_otchestvo = $_POST["new_otchestvo"];
        $new_phone = $_POST["new_phone"];
        $sql = "UPDATE users SET username='$new_username', name='$new_name', familiya='$new_familiya', otchestvo='$new_otchestvo', phone='$new_phone' WHERE user_id='$edit_user_id'";
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php"); // Перенаправляем для обновления страницы
            exit();
        } else {
            echo "Ошибка при обновлении данных пользователя: " . $conn->error;
        }
    }
    // Обработка изменения данных ребенка
    if (isset($_POST["edit_child"])) {
        $edit_child_id = $_POST["edit_child_id"];
        $new_first_name = $_POST["new_first_name"];
        $new_second_name = $_POST["new_second_name"];
        $new_date_of_birth = $_POST["new_date_of_birth"];
        $new_gender = $_POST["new_gender"];
        $sql = "UPDATE children SET first_name='$new_first_name', second_name='$new_second_name', date_of_birth='$new_date_of_birth', gender='$new_gender' WHERE child_id='$edit_child_id'";
        if ($conn->query($sql) === TRUE) {
            header("Location: index_admin.php"); // Перенаправляем для обновления страницы
            exit();
        } else {
            echo "Ошибка при обновлении данных ребенка: " . $conn->error;
        }
    }
    // Обработка изменения данных события
    if (isset($_POST["edit_event"])) {
        $edit_event_id = $_POST["edit_event_id"];
        $new_event = $_POST["new_event"];
        $new_event_date = $_POST["new_event_date"];
        $new_event_time = $_POST["new_event_time"];
        $sql = "UPDATE events SET event='$new_event', event_date='$new_event_date', event_time='$new_event_time' WHERE event_id='$edit_event_id'";
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php"); // Перенаправляем для обновления страницы
            exit();
        } else {
            echo "Ошибка при обновлении данных события: " . $conn->error;
        }
    }
}

// HTML для вывода списка пользователей
$users_html = "<div class='users'>";
$users_html .= "<h2 class='LKHeader' style=' margin-bottom: 10px;'>Пользователи</h2>";
$users_html .= "<table border='1'>";
$users_html .= "<thead><tr><th>ID</th><th>Логин</th><th>Имя</th><th>Фамилия</th><th>Отчество</th><th>Телефон</th><th>Редактирование</th></tr></thead>";
$users_html .= "<tbody>";

if ($result->num_rows > 0) {
    // Вывод данных каждой строки
    while($row_user = $result->fetch_assoc()) {
        $users_html .= "<tr>";
        $users_html .= "<td>" . $row_user['user_id'] . "</td>";
        $users_html .= "<td>" . $row_user['username'] . "</td>";
        $users_html .= "<td>" . $row_user['name'] . "</td>";
        $users_html .= "<td>" . $row_user['familiya'] . "</td>";
        $users_html .= "<td>" . $row_user['otchestvo'] . "</td>";
        $users_html .= "<td>" . $row_user['phone'] . "</td>";
        $users_html .= "<td><button onclick=\"showEditUserForm('{$row_user['user_id']}', '{$row_user['username']}', '{$row_user['name']}', '{$row_user['familiya']}', '{$row_user['otchestvo']}', '{$row_user['phone']}'); showDark2()\">Редактировать</button></td>";
        $users_html .= "</tr>";
    }
} else {
    $users_html .= "<tr><td colspan='6'>No results found</td></tr>";
}
$users_html .= "</tbody></table></div>";

// HTML для вывода списка детей
$children_html = "<div class='children'>";
$children_html .= "<h2 class='LKHeader' style=' margin-bottom: 10px;'>Дети</h2>";
$children_html .= "<table class='childrenTable' border='1' >";
$children_html .= "<tr><th>Имя</th><th>Фамилия</th><th>Дата рождения</th><th>Пол</th><th>Редактирование</th></tr>";
while ($row_child = $result_children->fetch_assoc()) {
    $children_html .= "<tr>";
    $children_html .= "<td>" . $row_child["first_name"] . "</td>";
    $children_html .= "<td>" . $row_child["second_name"] . "</td>";
    $children_html .= "<td>" . $row_child["date_of_birth"] . "</td>";
    $children_html .= "<td>" . $row_child["gender"] . "</td>";
    $children_html .= "<td><button onclick=\"showEditChildForm('{$row_child['child_id']}', '{$row_child['first_name']}', '{$row_child['second_name']}', '{$row_child['date_of_birth']}', '{$row_child['gender']}'); showDark2()\">Редактировать</button></td>";
    $children_html .= "</tr>";
}
$children_html .= "</table></div>";

// HTML для отображения календаря событий
$calendar_html = "<div class='events'>";
$calendar_html .= "<h2 class='LKHeader' style=' margin-bottom: 10px;'>События</h2>";
$calendar_html .= "<table border='1'>";
$calendar_html .= "<thead><tr><th>Событие</th><th>Дата</th><th>Время</th><th>Пользователь ID</th><th>Редактирование</th></tr></thead>";
$calendar_html .= "<tbody>";

if ($result_events->num_rows > 0) {
    while ($row_event = $result_events->fetch_assoc()) {
        $calendar_html .= "<tr>";
        $calendar_html .= "<td>" . $row_event["event"] . "</td>";
        $calendar_html .= "<td>" . $row_event["event_date"] . "</td>";
        $calendar_html .= "<td>" . $row_event["event_time"] . "</td>";
        $calendar_html .= "<td>" . $row_event["user_id"] . "</td>";
        $calendar_html .= "<td><button onclick=\"showEditEventForm('{$row_event['event_id']}', '{$row_event['event']}', '{$row_event['event_date']}', '{$row_event['event_time']}'); showDark2()\">Редактировать</button></td>";
        $calendar_html .= "</tr>";
    }
} else {
    $calendar_html .= "<tr><td colspan='4'>Нет событий</td></tr>";
}
$calendar_html .= "</tbody></table></div>";
$conn->close();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/chief-slider.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">

    <title>Детский центр "Островок"</title>

    <script src="js/main.js"></script>
    <script src="js/chief-slider.js"></script>
</head>
<body>
<div class="dark"> </div>
<header class="headerr">
        <div class="header-container LK">
            <div class="container">
                <div class="header-container--first">
                    <div class="logo"><img src="img/ДЦ.png" alt=""></div>
                    <div class="header-container__navLK">
                        <ul style="display: flex; justify-content: center;" >
                            <li><a href="index.php">Главная</a></li>
                        </ul>
                    </div>
                    <div class="header-container__social"> <a href="https://vk.com/ostrovoknt" ><img src="img/vk.png" width="50px" min-height="50px" > </a> </div>
</header>
<div class="LKcontainer" >
    <h2 class="LKHeader2" >Личный кабинет</h2>
    <div class="LKfilling" >
        <div class="LKfillingData" >
            <div class="LKdata" >
                <h3 class="LKHeader3" >Данные пользователя:</h3>
                <p><strong>Имя:</strong> <?php echo $current_name; ?></p>
                <p><strong>Фамилия:</strong> <?php echo $current_familiya; ?></p>
                <p><strong>Отчество:</strong> <?php echo $current_otchestvo; ?></p>
                <p><strong>Телефон:</strong> <?php echo $current_phone; ?></p>
            </div>
            <div class="LKdatachange" >
                <h3 class="LKHeader3" style="text-align: center;">Изменить данные:</h3>
                <form action="update_user.php" method="post">
                    <div class="label_change">
                        <label for="new_username">Логин:</label>
                        <label for="new_name">Имя:</label>
                        <label for="new_familiya">Фамилия:</label>
                        <label for="new_otchestvo">Отчество:</label>
                        <label for="new_phone">Телефон:</label>
                    </div>
                    <div>
                        <input type="text" id="new_username" name="new_username">
                        <input type="text" id="new_name" name="new_name">
                        <input type="text" id="new_familiya" name="new_familiya">
                        <input type="text" id="new_otchestvo" name="new_otchestvo">
                        <input type="text" id="new_phone" name="new_phone">
                    </div>
                    <div>
                        <button type="submit" name="update_field" value="username">Изменить логин</button>
                        <button type="submit" name="update_field" value="name">Изменить имя</button>
                        <button type="submit" name="update_field" value="familiya">Изменить фамилию</button>
                        <button type="submit" name="update_field" value="otchestvo">Изменить отчество</button>
                        <button type="submit" name="update_field" value="phone">Изменить телефон</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="imgChildren" >
            <img class="child_img" src="img/srr.png" >
        </div>

        <div class="LKadmin" >
            <?php echo $users_html; ?> 
            <button type="submit" class="otchet">Выгрузить отчет</button>
           
            <!-- Форма для редактирования пользователя -->
            <div class="editFormWindow" id="editUserModal" style="display:none;">
                <form class="editForm" id="editUserForm" action="admin_edit_user.php" method="post">
                    <h4>Редактирование данных пользователя</h4>
                    <div class="edit_data">
                        <div class="edit_label" style="width: 100px;">
                            <label for="username">Логин:</label>
                            <label for="name">Имя:</label>
                            <label for="familiya">Фамилия:</label>
                            <label for="otchestvo">Отчество:</label>
                            <label for="phone">Телефон:</label>
                        </div>
                        <div class="edit_input_user">
                            <input type="hidden" id="user_id" name="user_id">
                            <input type="text" id="username" name="username" required>
                            <input type="text" id="name" name="name" required>
                            <input type="text" id="familiya" name="familiya" required>
                            <input type="text" id="otchestvo" name="otchestvo" required>
                            <input type="text" id="phone" name="phone" required>
                        </div>
                    </div>    
                    <button class="edit_save" type="submit" onclick="hideDark2()">Сохранить</button>
                    <button class="edit_cancel" type="button" onclick="closeModal('editUserModal'); hideDark2()">Отмена</button>
                </form>
            </div>
        </div>

        <div class="imgChildren2" >
            <img class="child_img" src="img/srr.png" >
        </div>

        <div class="LKadmin" >
            <?php echo $children_html; ?>
            <button type="submit" class="otchet">Выгрузить отчет</button>
            <!-- Форма для редактирования ребенка -->
            <div class="editFormWindow" id="editChildModal" style="display:none;">
                <form class="editForm" id="editChildForm" action="admin_edit_child.php" method="post">
                    <h4>Редактирование данных ребенка</h4>
                    <div class="edit_data">
                        <div class="edit_label">
                            <label for="first_name">Имя:</label>
                            <label for="second_name">Фамилия:</label>
                            <label for="date_of_birth" style="width: 140px">Дата рождения:</label>
                            <label for="gender">Пол:</label>
                        </div>
                        <div class="edit_input">
                            <input type="hidden" id="child_id" name="child_id">
                            <input type="text" id="first_name" name="first_name" style="width: 130px;" required>
                            <input type="text" id="second_name" name="second_name" style="width: 130px;" required>
                            <input type="date" id="date_of_birth" name="date_of_birth" required>
                            <select id="gender" name="gender" required>
                                <option value="Мальчик">Мальчик</option>
                                <option value="Девочка">Девочка</option>
                            </select>
                        </div>
                    </div>
                    <button class="edit_save" type="submit" onclick="hideDark2()">Сохранить</button>
                    <button class="edit_cancel" type="button" onclick="closeModal('editChildModal'); hideDark2()">Отмена</button>
                </form>
            </div>
        </div>

        <div class="imgChildren" >
            <img class="child_img" src="img/srr.png" >
        </div>

        <div class="LKadmin" >
            <?php echo $calendar_html; ?>
            <button type="submit" class="otchet">Выгрузить отчет</button>
            <!-- Форма для редактирования события -->
            <div class="editFormWindow" id="editEventModal" style="display:none;">
                <form class="editForm" id="editEventForm" action="admin_edit_event.php" method="post">
                    <h4>Редактирование данных события</h4>
                    <div class="edit_data">
                        <div class="edit_label" style="width: 90px;">
                            <label for="event">Событие:</label>
                            <label for="event_date">Дата:</label>
                            <label for="event_time">Время:</label>
                        </div>
                        <div class="edit_input">
                            <input type="hidden" id="event_id" name="event_id">
                            <input type="text" id="event" name="event" style="width: 175px;" required>
                            <input type="date" id="event_date" name="event_date" required>
                            <input type="time" id="event_time" name="event_time" required>
                        </div>
                    </div>    
                    <button class="edit_save" type="submit" onclick="hideDark2()">Сохранить</button>
                    <button class="edit_cancel" type="button" onclick="closeModal('editEventModal'); hideDark2()">Отмена</button>
                </form>
            </div>
        </div>
    </div>
    
</div>
</body>
</html>
