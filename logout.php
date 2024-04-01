<?php
session_start(); // Начинаем сессию

// Удаляем все данные сессии
$_SESSION = array();

// Удаляем куки, связанные с текущей сессией
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Уничтожаем сессию
session_destroy();

// Перенаправляем пользователя на главную страницу
header("Location: index.php");
exit();
?>
