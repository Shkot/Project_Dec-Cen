<?php
include 'connection_db.php'; // Подключение к базе данных

// Получение параметров года и месяца
$year = $_POST['year'];
$month = $_POST['month'];

// Получение номера дня недели для первого дня месяца
$first_day_of_week = date('N', strtotime("$year-$month-01"));

// Массив с названиями дней недели
$weekdays = array("Пн", "Вт", "Ср", "Чт", "Пт", "Сб", "Вс");

// Вывод параметров для отладки



// Получаем события для выбранного месяца и года
$sql_events = "SELECT event, event_date, event_time FROM events WHERE YEAR(event_date) = $year AND MONTH(event_date) = $month";
$result_events = $conn->query($sql_events);

// Проверка наличия событий
if ($result_events->num_rows == 0) {
    echo "Нет событий для выбранного месяца и года.";
    exit;
}


// Создаем календарь и заполняем событиями
$calendar_html = "<div class='Cal'><h2>Календарь событий</h2></div><p class='LKHeader4 margin'>Год: $year, Месяц: $month</p>";

$calendar_html .= "<div class='calendar'>";

// Добавляем дни недели сверху
$calendar_html .= "<div class='weekdays'>";
for ($i = 0; $i < 7; $i++) {
    // Используем цикл для корректного отображения дней недели, начиная с понедельника
    $weekday_index = ($i) % 7;
    $calendar_html .= "<div class='weekday'>$weekdays[$weekday_index]</div>";
}
$calendar_html .= "</div>";

// Добавляем пустые ячейки перед первым днем месяца
for ($i = 1; $i < $first_day_of_week; $i++) {
    $calendar_html .= "<div class='day'></div>";
}

// Добавляем дни месяца
for ($day = 1; $day <= cal_days_in_month(CAL_GREGORIAN, $month, $year); $day++) {
    $calendar_html .= "<div class='day'>$day";
    // Перемещаем курсор в начало результата запроса
    $result_events->data_seek(0);
    while ($row_event = $result_events->fetch_assoc()) {
        $event_date = date('j', strtotime($row_event["event_date"])); // Преобразуем дату
        $event_time = date('H:i', strtotime($row_event["event_time"])); // Преобразуем время
        if ($event_date == $day) {
            $calendar_html .= "<div class='active_eve'></div><div class='event'>$event_time - " . $row_event["event"] . "</div>"; // Выводим дату и время
        }
    }
    $calendar_html .= "</div>";
}
$calendar_html .= "</div>";

echo $calendar_html;
$conn->close();
?>
