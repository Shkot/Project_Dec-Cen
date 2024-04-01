<?php
include "register.php";
session_start(); // Начинаем сессию

// Проверяем, авторизован ли пользователь
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    $button_text_dva = 
    $button_text = $username; // Если пользователь авторизован, используем его имя в качестве текста кнопки
    $logout_button = '<a class="regorauth" href="logout.php">Выйти</a>'; // Применяем класс стилей к кнопке "Выйти"
} else {
    $button_enter = "Войти";
    $logout_button = '';
}



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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">

    <title>Детский центр "Островок"</title>
</head>

<body>
<?php
// Проверяем наличие параметра "registration_success" в URL
if (isset($_GET['registration_success']) && $_GET['registration_success'] == 1) {
    echo "<div class='registration-message' id='registrationMessage'>
    <span class='close-btn' onclick='closeMessage()'>×</span>
    Регистрация успешна!
  </div>";
}
?>
<script>
    // JavaScript функция для закрытия сообщения
    function closeMessage() {
        var message = document.getElementById('registrationMessage');
        message.style.display = 'none';
    }
</script>

    <header class="header">
        <div class="header-container">
            <div class="container">
                <div class="header-container--first">
                    <div class="header__burger-nav">
                        <div class="dropdown">
                            <button onclick="myFunction()" class="dropbtn"> Меню</button>
                            <div id="myDropdown" class="dropdown-content">
                                <a href="#">Главная</a>
                                <a href="#programm">Программы</a>
                                <a href="#club-ev">Клуб развития</a>
                                <a href="#price">Прайс</a>
                                <a href="#contacts">Контакты</a>
                            </div>
                        </div>
                    </div>
                    <div class="logo"><img src="img/ДЦ.png" alt=""></div>
                    <div class="header-container__nav">
                        <ul>
                            <li><a href="#">Главная</a></li>
                            <li><a href="#programm">Программы</a></li>
                            <li><a href="#club-ev">Клуб развития</a></li>
                            <li><a href="#price">Прайс</a></li>
                            <li><a href="#contacts">Контакты</a></li>
                        </ul>
                    </div>
                    

                    <div class="header-container__social"><img src="img/vk.png" width="50px" height="50px"></div>
<?php
// Проверяем, авторизован ли пользователь
if (isset($_SESSION["username"])) {
    // Если пользователь авторизован, устанавливаем атрибут onclick для перенаправления на страницу LK.php
    echo '<div class="rega" onclick="location.href=\'LK.php\'">' . $button_text . '</div>';
} else {
    // Если пользователь не авторизован, показываем обычную кнопку "Войти"
    echo '<button class="regorauth " type="button" onclick="showAuth()">' . $button_enter . '</button>';
}
?>
<?php echo $logout_button; ?>
    
    

                    <div class="regist">
                    <form action="register.php" method="POST">
                        <h4>Регистрация</h4>
                        <span class="close-btn" onclick="hideRegist('regist')">✖</span>
                        <div class="input_data_reg">
                            <p>Логин</p>
                            <input type="text" name="username" placeholder="Username" required>
                            <p>Пароль</p>
                            <input type="password" name="password" placeholder="Password" required>
                            <p>Имя</p>
                            <input type="text" name="surename" placeholder="surename" required>
                            <p>Телефон</p>
                            <input type="text" name="phone" placeholder="phone" required>
                        </div>
                        <button class="reg" type="submit">Зарегистрироваться</button>
                        <p class="confidency" >Нажимая кнопку "Зарегистрироваться", Вы соглашаетесь c 
                            <a href="/Det-Cen/polozhenie_po_zawite_personal_nyh_dannyh.pdf" target="_blank">
                                условиями Политики в отношении обработки персональных данных</a></p>
                    </form>
                    </div>
                    <form action="login.php" method="post">
                    <div class="auth" id="auth">
                        <h4>Войти в личный кабинет</h4>
                        <span class="close-btn" onclick="hideAuth('regist')">✖</span>
                        <div class="input_data_auth">
                            <p>Логин</p>
                            <input type="text" name="username" placeholder="Username" required>
                            <p>Пароль</p>
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="policy" >

                        </div>
                        <div class="buttons" >
                            <button class="authphp" name="login" type="submit">Войти</button>
                            <button class="registrphp" type="submit" onclick="showRegist()">Зарегистрироваться</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
       
        <script>
    function showAuth() {
        var authDiv = document.querySelector('.auth');
        var registDiv = document.querySelector('.regist');
        if (authDiv.style.display === "none") {
            authDiv.style.display = "block";
            
        } else {
            authDiv.style.display = "none";
            
        }
    }
    function hideAuth() {
        var authDiv = document.querySelector('.auth');
        var registDiv = document.querySelector('.regist');
        if (authDiv.style.display === "block") {
            authDiv.style.display = "none";
            
        } else {
            authDiv.style.display = "block";
            
        }
    }
    function showRegist() {
        var authDiv = document.querySelector('.auth');
        var registDiv = document.querySelector('.regist');
        if (registDiv.style.display === "none") {
            authDiv.style.display = "none";
            registDiv.style.display = "block";
            
        } else {
            registDiv.style.display = "none";
            
        }
    }
    function hideRegist() {
        var authDiv = document.querySelector('.auth');
        var registDiv = document.querySelector('.regist');
        if (registDiv.style.display === "block") {
            registDiv.style.display = "none";
            
        } else {
            registDiv.style.display = "block";
            
        }
    }
    

    document.querySelector('.regorauth').addEventListener('click', function() {
        var authDiv = document.querySelector('.auth');
        var registDiv = document.querySelector('.regist');
        authDiv.style.display = "block";
        registDiv.style.display = "none";
        
    });
</script>


        <div class="header-container--second">
            <h1>Детский центр <br>“Островок”</h1>
            <h1>Центр семейного досуга</h1>
            <div class="scroll-down">
                <p>Вниз</p>
                <a href="#possible">
                    <div class="down">
                        <div class="arrow"></div>
                    </div>
                </a>
            </div>
        </div>
    </header>
    <main>
        <section class="main-container main-container__programs">
            <div class="container">
                <a id="possible" name="possible"></a>
                <div class="our-programs">
                    <h2>В НАШЕМ ДЦ вы можете</h2>
                    <div class="our-programs__circlues">
                        <div class="our-programs__circlues-content">
                            <div class="crl"></div>
                            <h3>Заказать День Рождения</h3>
                            <p>Мы предлагаем организацию и проведение Дней рождения и праздников для вашего ребёнка. День рождения у нас в центре - это интересно и незабываемо!</p>
                        </div>
                        <div class="our-programs__circlues-content">
                            <div class="crl"></div>
                            <h3>Развивать ребенка</h3>
                            <p>Для самых маленьких мы организовали клубы развития, для детей постарше подготовка к школе, творческие занятия, развитие речи.</p>
                        </div>
                        <div class="our-programs__circlues-content">
                            <div class="crl"></div>
                            <h3>Cмотреть фотографии</h3>
                            <p>Мы ведем фото-съемку праздников, которые мы проводим. Вы всегда можете посмотреть их замечательные фотографии.</p>
                        </div>
                        <div class="our-programs__circlues-content">
                            <div class="crl"></div>
                            <h3>Узнать информацию</h3>
                            <p>Различную контактную информацию, узнать дни и время работы детского центра, наше местоположение и телефон, а так же адрес.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="main-container main-container__possible-program">
            <a id="programm" name="programm"></a>
            <div class="container">
                <div class="possible-program">
                    <div class="possible-program__welcome">
                        <h2>НАШИ РАЗВЛЕКАТЕЛЬНЫЕ ПРОГРАММЫ</h2>
                    </div>
                </div>
                <div class="slider" data-slider="chiefslider">
                    <div class="slider__container">
                        <div class="slider__wrapper">
                            <div class="slider__items">
                                <div class="slider__item">
                                    <div class="slider__item-container">
                                        <div class="slider__item-content">

                                            <div class="slider__content_header">
                                                <img class="slider__content_img" src="img/feya-sajt.jpg" alt="..." width="350" height="250" loading="lazy">
                                                <span class="slider__content_section">ФЕЯ ДИНЬ-ДИНЬ</span>
                                            </div>
                                            <p class="slider__content_title">Игровая программа для детей 3- 10 лет. В гости приходит проказница фея.</p>


                                        </div>
                                    </div>
                                </div>
                                <div class="slider__item">
                                    <div class="slider__item-container">
                                        <div class="slider__item-content">

                                            <div class="slider__content_header">
                                                <img class="slider__content_img" src="img/luntik-sajt.jpg" alt="..." width="350" height="250" loading="lazy">
                                                <span class="slider__content_section">ЛУНТИК</span>
                                            </div>
                                            <p class="slider__content_title">Программа для ребят от 2 до 7 лет Добрый и трогательный герой поиграет с именинником и гостями в веслые игры.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="slider__item">
                                    <div class="slider__item-container">
                                        <div class="slider__item-content">

                                            <div class="slider__content_header">
                                                <img class="slider__content_img" src="img/masha.jpg" alt="..." width="350" height="250" loading="lazy">
                                                <span class="slider__content_section">МАША И МЕДВЕДЬ</span>
                                            </div>
                                            <p class="slider__content_title">Игровая программа для детей 2-5 лет. Праздник по мотивам известной сказки.</p>


                                        </div>
                                    </div>
                                </div>
                                <div class="slider__item">
                                    <div class="slider__item-container">
                                        <div class="slider__item-content">

                                            <div class="slider__content_header">
                                                <img class="slider__content_img" src="img/min_on1.jpg" alt="..." width="350" height="250" loading="lazy">
                                                <span class="slider__content_section">МИНЬОН ДЖЕРРИ</span>
                                            </div>
                                            <p class="slider__content_title">Развлекательная программа для детей 4-10 лет, если Ваш ребенок без ума от маленьких желтых существ под названием Миньоны.</p>>


                                        </div>
                                    </div>
                                </div>
                                <div class="slider__item">
                                    <div class="slider__item-container">
                                        <div class="slider__item-content">

                                            <div class="slider__content_header">
                                                <img class="slider__content_img" src="img/neonovaya_vcherinka.jpg" alt="..." width="350" height="250" loading="lazy">
                                                <span class="slider__content_section">НЕОНОВАЯ ВЕЧЕРИНКА</span>
                                            </div>
                                            <p class="slider__content_title">Для тех кто любит веселые соревнования и зажигательные танцы в свете ультрафиолета. </p>


                                        </div>
                                    </div>
                                </div>

                                <div class="slider__item">
                                    <div class="slider__item-container">
                                        <div class="slider__item-content">

                                            <div class="slider__content_header">
                                                <img class="slider__content_img" src="img/svinka_peppa.jpg" alt="..." width="350" height="250" loading="lazy">
                                                <span class="slider__content_section">СВИНКА ПЕППА</span>
                                            </div>
                                            <p class="slider__content_title">Игровая программа для детей 2-7 лет Мы вместе проведем незабываемый праздник! Будем прыгать и играть и конечно не скучать!</p>


                                        </div>
                                    </div>
                                </div>

                                <div class="slider__item">
                                    <div class="slider__item-container">
                                        <div class="slider__item-content">

                                            <div class="slider__content_header">
                                                <img class="slider__content_img" src="img/kiska-1.jpg" alt="..." width="350" height="250" loading="lazy">
                                                <span class="slider__content_section">КОШЕЧКА БЕТТИ</span>
                                            </div>
                                            <p class="slider__content_title">Игровая программа для детей 2-7 лет Каждый ребенок хочет поиграть с веселой и пушистой кошечкой.</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <a href="#" class="slider__control" data-slide="prev"></a>
                    <a href="#" class="slider__control" data-slide="next"></a>
                    <ol class="slider__indicators">
                        <li data-slide-to="0"></li>
                        <li data-slide-to="1"></li>
                        <li data-slide-to="2"></li>
                        <li data-slide-to="3"></li>
                        <li data-slide-to="4"></li>
                        <li data-slide-to="5"></li>
                        <li data-slide-to="6"></li>
                    </ol>
                </div>

            </div>
        </section>
        <section class="main-container main-container__club">
            <a id="club-ev" name="club-ev"></a>
            <div class="container">
                <div class="evolve-container evolve-fir">
                    <div class="evolve-container__content">
                        <h2>Клубы развития</h2>
                        <p>Клубы развития - это комплекс развивающих занятий, состоящих из нескольких блоков:</p>
                        <p>- Социальное развитие (игры и упражнения на развитие эмоционального общения с окружающими);</p>
                        <p>- Сенсорное развитие (качество, свойство предметов: цвета, формы, размер, представление о количестве и времени;</p>
                        <p>- Физическое развитие;</p>
                    </div>

                </div>
                <div class="evolve-container evolve-sec">
                    <div class="evolve-container__content">
                        <h2>Клубы развития</h2>
                        <p>- Развитие памяти, внимания, восприятия, воображения и мышления;</p>
                        <p>- Развитие мелкой и крупной моторики рук;</p>
                        <p>- Развитие речи;</p>
                        <p>- Развитие ритмических способностей, интереса к музыке;</p>
                        <p>- Лепка, рисование, аппликация.</p>
                        <p>Занятия проводит профессиональный педагог по раннему развитию детей. </p>
                    </div>

                </div>
            </div>
            <div class="evolve-container-back">
                <div class="evolve-container__back-content"><img class="evolve-img" src="img/evolve-first.jpg" alt=""></div>
                <div class="evolve-container__back-content b-c-s"><img src="img/evolve-second.jpg" alt=""></div>
            </div>
        </section>
        <section class="main-container main-container__price">
            <a id="price" name="price"></a>
            <div class="container">
                <div class="price-container">
                    <h2>Прайс цен на предоставляемые услуги</h2>
                    <div class="price-container__content">
                        <div class="price-servises">
                            <div class="price-servises__block">
                                <div class="price-img"></div>
                                <ul>
                                    <li>День рождения в формате "Мастерская" - 2000р./1ч</li>
                                    <li>День рождения в формате "Мини- мастерская" - 1500р./1ч</li>
                                    <li>Аренда центра с 10:00 до 20:00 на группу детей до 10 человек - 2000р./1ч</li>
                                    <li>Аренда центра после 20:00 (не более одного часа) - от 2500р</li>
                                </ul>
                            </div>
                            <div class="price-servises__block">
                                <div class="price-img animator-img"></div>
                                <ul>
                                    <li>Предоставление услуг аниматора в центре "Островок" - 1800р./1ч</li>
                                    <li>Предоставление услуг аниматора с выездом (в черте города) - 3000р./1ч</li>
                                    <li>Привлечение стороннего аниматора - 500р./1ч</li>
                                    <li>Предоставление услуг аниматора с индивидуальной программой - 3500р</li>
                                </ul>
                            </div>
                            <div class="price-servises__block">
                                <div class="price-img bubbles-img"></div>
                                <ul>
                                    <li>Шоу мыльных пузырей с гигантским кругом вне прграммы аниматора - 700р</li>
                                    <li>Шоу мыльных пузырей с гигатским кругом на выезд - 1500р</li>
                                    <li>Аквагамм професииональный (до 10 детей) - от 1000р</li>
                                    <li>Флеш-тату - 1000р</li>
                                </ul>
                            </div>
                            <div class="price-servises__block">
                                <div class="price-img kids-img"></div>
                                <ul>
                                    <li>Услуга по организации подготовки к школе для детей 5- 7 лет - 270р./1ч</li>
                                    <li>Услуга по организации логопедической помощи - 380р./1ч</li>
                                    <li>Услуга по организации занятий по раннему развитию детей - 270р./1ч</li>
                                    <li>Предоставление игровой зоны "Мамин час" - от 200р</li>
                                </ul>
                            </div>
                            <div class="price-servises__block">
                                <div class="price-img prog-img"></div>
                                <ul>
                                    <li>Программа "Бумажное шоу" - 5000р./1ч</li>
                                    <li>Программа "Платиковое шоу" - 2000р./1ч</li>
                                    <li>Программа "Неоновое шоу" - 2500р./1ч</li>
                                    <li>Выпускной - от 12500р</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="main-container main-contact">
            <a id="contacts" name="contacts"></a>
            <div class="container">
                <div class="contact-container">
                    <div class="contact-container__content">
                        <h2 class="own-h2">Хотите оставить сообщение?</h2>
                        <div class="content--contacts">
                            <div class="input-box">
                                <input type="text" required="required">
                                <span>Автор</span>
                            </div>
                            <div class="input-box">
                                <input type="text" required="required">
                                <span>Email</span>
                            </div>
                            <div class="input-box">
                                <input type="text" required="required">
                                <span>Тема письма</span>
                            </div>
                        </div>
                        <div class="content--form">
                            <textarea required="required"></textarea>
                            <span>Сообщение</span>
                        </div>
                        <div class="cont-send--btn">
                            <button>Отправить</button>
                        </div>
                    </div>
                    <h2 class="own-h2">Наши Контакты</h2>

                </div>
                <div class="contact-container__info--map">
                    <div class="contact-info">
                        <p><span>Адрес:</span> г. Нижний Тагил: Тагилстрой, ул. Металлургов, 5А</p>
                        <p><span>Время работы:</span> пн. - вс.: с 10-00 до 20-00</p>
                        <p><span>Телефон:</span> 8 (3435) 92-92-92 или 8- 922-138-92-92</p>
                        <p><span>Вконтакте:</span> http://vk.com/ostrovoknt</p>
                        <p><span>Email:</span> ok@ostrovoknt.ru</p>
                    </div>
                    <div class="contact-map">
                        <div class="contact-map__style" style="position:relative;overflow:hidden;"><a href="https://yandex.ru/maps/org/ostrovok/1202655529/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Островок</a><a href="https://yandex.ru/maps/11168/nizhniy-tagil/category/children_developmental_center/184107204/?utm_medium=mapframe&utm_source=maps"
                                style="color:#eee;font-size:12px;position:absolute;top:14px;">Центр развития ребёнка в Нижнем Тагиле</a><a href="https://yandex.ru/maps/11168/nizhniy-tagil/category/entertainment_center/184106372/?utm_medium=mapframe&utm_source=maps"
                                style="color:#eee;font-size:12px;position:absolute;top:28px;">Развлекательный центр в Нижнем Тагиле</a><iframe class="map-width" src="https://yandex.ru/map-widget/v1/-/CCUN4FXSHC" width="560" height="400" frameborder="1" allowfullscreen="true"
                                style="position:relative;"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>



</body>
<script src="js/main.js"></script>
<script src="js/chief-slider.js"></script>

</html>