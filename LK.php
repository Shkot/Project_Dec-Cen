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
    $current_phone = $row["phone"];
    // Добавьте другие поля, если они есть в вашей базе данных
} else {
    echo "Ошибка: Пользователь не найден.";
    exit();
}

// Обработка запроса на изменение данных
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Обработка изменения имени
    if (isset($_POST["new_username"])) {
        $new_username = $_POST["new_username"];
        $sql = "UPDATE users SET username='$new_username' WHERE username='$username'";
        if ($conn->query($sql) === TRUE) {
            $current_username = $new_username; // Обновляем текущее имя пользователя
        } else {
            echo "Ошибка при обновлении имени: " . $conn->error;
        }
    }
}



$sql_user_id = "SELECT user_id FROM users WHERE username='$username'";
$result_user_id = $conn->query($sql_user_id);

if ($result_user_id->num_rows > 0) {
    $row_user_id = $result_user_id->fetch_assoc();
    $user_id = $row_user_id["user_id"];

    // Получаем события пользователя из таблицы events
    $sql_events = "SELECT event, event_date, event_time FROM events WHERE user_id='$user_id'";
    $result_events = $conn->query($sql_events);

    // HTML для отображения календаря событий
    $calendar_html = "<div class='Cal'><h2>Календарь событий</h2></div>";
    $calendar_html .= "<table border='1'>";
    $calendar_html .= "<tr><th>Событие</th><th>Дата</th><th>Время</th></tr>";
    while ($row_event = $result_events->fetch_assoc()) {
        $calendar_html .= "<tr>";
        $calendar_html .= "<td>" . $row_event["event"] . "</td>";
        $calendar_html .= "<td>" . $row_event["event_date"] . "</td>";
        $calendar_html .= "<td>" . $row_event["event_time"] . "</td>";
        $calendar_html .= "</tr>";
    }
    $calendar_html .= "</table>";
} else {
    $calendar_html = "Ошибка: Пользователь не найден.";
    exit();
}
// Получаем список детей пользователя
$sql_children = "SELECT * FROM children WHERE parent_id='$user_id'";
$result_children = $conn->query($sql_children);

// HTML для вывода списка детей
$children_html = "<div class='children'>";
$children_html .= "<h2 class='LKHeader' style=' margin-bottom: 10px;'>Ваши дети</h2>";
$children_html .= "<table class='childrenTable' border='1' >";
$children_html .= "<tr><th>Имя</th><th>Дата рождения</th><th>Пол</th></tr>";
while ($row_child = $result_children->fetch_assoc()) {
    $children_html .= "<tr>";
    $children_html .= "<td>" . $row_child["first_name"] . "</td>";
    $children_html .= "<td>" . $row_child["date_of_birth"] . "</td>";
    $children_html .= "<td>" . $row_child["gender"] . "</td>";
    $children_html .= "</tr>";
}
$children_html .= "</table></div>";
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


    
</head>
<body>
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
                <p><strong>Имя:</strong> <?php echo $current_username; ?></p>
                <p><strong>Телефон:</strong> <?php echo $current_phone; ?></p>
            </div>
            <div class="LKdatachange" >
                <h3 class="LKHeader3" >Изменить данные:</h3>
                <form action="" method="post">
                    <label for="new_username">Имя:</label>
                    <input type="text" id="new_username" name="new_username" required>
                    <button type="submit">Изменить имя</button>
                </form>
            </div>
        </div>
        <div class="imgChildren" >
            <img class="child_img" src="img/srr.png" >
        </div>
        <h3 class="LKHeader" style="font-size: 25px;">Дети</h3>
        <div class="LKfillingChildren" >
            <!-- Вывод списка детей -->
            <?php echo $children_html; ?>
            <!-- HTML форма для добавления нового ребенка -->
            <div class="LKchildren">
                <h3 class="LKHeader3">Добавить ребенка:</h3>
                <form action="add_child.php" method="post">
                    <label for="child_first_name">Имя:</label>
                    <input type="text" id="child_first_name" name="child_first_name" required><br>
                    <label for="child_date_of_birth">Дата рождения:</label>
                    <input type="date" id="child_date_of_birth" name="child_date_of_birth" required><br>
                    <label for="child_gender">Пол:</label>
                    <select id="child_gender" name="child_gender" required>
                        <option value="Мальчик">Мальчик</option>
                        <option value="Девочка">Девочка</option>
                    </select><br>
                    <button type="submit">Добавить ребенка</button>
                </form>
            </div>
        </div>

        <div class="imgChildren2" >
            <img class="child_img" src="img/srr.png" >
        </div>

        <div class="LKfillingCalendar" >
            <!-- Код календаря -->
            <div id="calendar"></div>

            <!-- Кнопка "Следующий месяц" -->
            <button class="nextMonthBtn" id="nextMonthBtn">Следующий месяц</button>
        
            <!-- HTML форма для добавления нового события -->
            <div class="addEventForm">
                <h3 class="LKHeader3">Добавить событие</h3>
                <form action="add_event.php" method="post">
                    <label for="event_name">Название события:</label>
                    <input type="text" id="event_name" name="event_name" required><br>
                    <label for="event_date">Дата события:</label>
                    <input type="date" id="event_date" name="event_date" required><br>
                    <label for="event_time">Время события:</label>
                    <input type="time" id="event_time" name="event_time" required><br>
                    <button type="submit">Добавить событие</button>
                </form>
            </div>
            </div>
    </div>
    
</div>
<script>
    $(document).ready(function(){
        // Функция для загрузки событий через AJAX
        function loadEvents(year, month) {
            $.ajax({
                url: 'load_events.php',
                type: 'POST',
                data: { year: year, month: month },
                success: function(response) {
                    $('#calendar').html(response);
                }
            });
        }

        // Загрузка событий при загрузке страницы
        var currentDate = new Date();
        var currentYear = currentDate.getFullYear();
        var currentMonth = currentDate.getMonth() + 1; // Месяцы в JavaScript начинаются с 0
        loadEvents(currentYear, currentMonth);

        // Обработчик клика на кнопку "Следующий месяц"
        $('#nextMonthBtn').click(function() {
            // Увеличиваем номер текущего месяца
            currentMonth++;
            // Если номер месяца больше 12, переходим на следующий год
            if (currentMonth > 12) {
                currentMonth = 1;
                currentYear++;
            }
            // Загружаем события для нового месяца
            loadEvents(currentYear, currentMonth);
        });
    });
</script>


</body>
</html>
