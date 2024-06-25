//  ПЛАВНАЯ ПРОКРУТКА 

const anchors = [].slice.call(document.querySelectorAll('a[href*="#"]')),
    animationTime = 400,
    framesCount = 60;

anchors.forEach(function(item) {
    // каждому якорю присваиваем обработчик события
    item.addEventListener('click', function(e) {
        // убираем стандартное поведение
        e.preventDefault();

        // для каждого якоря берем соответствующий ему элемент и определяем его координату Y
        let coordY = document.querySelector(item.getAttribute('href')).getBoundingClientRect().top + window.pageYOffset;

        // запускаем интервал, в котором
        let scroller = setInterval(function() {
            // считаем на сколько скроллить за 1 такт
            let scrollBy = coordY / framesCount;

            // если к-во пикселей для скролла за 1 такт больше расстояния до элемента
            // и дно страницы не достигнуто
            if (scrollBy > window.pageYOffset - coordY && window.innerHeight + window.pageYOffset < document.body.offsetHeight) {
                // то скроллим на к-во пикселей, которое соответствует одному такту
                window.scrollBy(0, scrollBy);
            } else {
                // иначе добираемся до элемента и выходим из интервала
                window.scrollTo(0, coordY);
                clearInterval(scroller);
            }
            // время интервала равняется частному от времени анимации и к-ва кадров
        }, animationTime / framesCount);
    });
});

// Burger menu

/* Когда пользователь нажимает на кнопку, переключаться раскрывает содержимое */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}
// Закрыть раскрывающийся список, если пользователь щелкнет за его пределами.
window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
 
    // SLIDER
document.addEventListener('DOMContentLoaded', function() {
    new ChiefSlider('.slider', {
        loop: true,
        autoplay: true,
        interval: 5000,
        refresh: true,
    });
});




// Функция для закрытия сообщения об успешной регистрации
function closeMessage() {
    var message = document.getElementById('registrationMessage');
    message.style.display = 'none';
}

// Функция для закрытия сообщения об успешной отправке сообщения
function closeMessage() {
    document.getElementById('messageSent').style.display = 'none';
}

//Функция показать окно входа
function showAuth() {
    var authDiv = document.querySelector('.auth');
    var registDiv = document.querySelector('.regist');
    var darkDiv = document.querySelector('.dark');
    if (authDiv.style.display === "none") {
        authDiv.style.display = "block";
        darkDiv.style.display = "block";
    } else {
        authDiv.style.display = "none";
        darkDiv.style.display = "none";
    }
}
//Функция скрыть окно входа
function hideAuth() {
    var authDiv = document.querySelector('.auth');
    var registDiv = document.querySelector('.regist');
    var darkDiv = document.querySelector('.dark');
    if (authDiv.style.display === "block") {
        authDiv.style.display = "none";
        darkDiv.style.display = "none";
    } else {
        authDiv.style.display = "block";
        darkDiv.style.display = "block";
    }
}
//Функция показать окно регистрации
function showRegist() {
    var authDiv = document.querySelector('.auth');
    var registDiv = document.querySelector('.regist');
    var darkDiv = document.querySelector('.dark');
    if (registDiv.style.display === "none") {
        authDiv.style.display = "none";
        registDiv.style.display = "block";
        darkDiv.style.display = "block";
    } else {
        registDiv.style.display = "none";
        darkDiv.style.display = "none";
    }
}

//Функция скрыть окно регистрации
function hideRegist() {
    var authDiv = document.querySelector('.auth');
    var registDiv = document.querySelector('.regist');
    var darkDiv = document.querySelector('.dark');
    if (registDiv.style.display === "block") {
        registDiv.style.display = "none";
        darkDiv.style.display = "none";
    } else {
        registDiv.style.display = "block";
        darkDiv.style.display = "block";
    }
}


document.querySelector('.regorauth').addEventListener('click', function() {
    var authDiv = document.querySelector('.auth');
    var registDiv = document.querySelector('.regist');
    authDiv.style.display = "block";
    registDiv.style.display = "none";   
});       

//Функция скрыть темный экран
function hideDark() {
    var editFormWindowDiv  = document.querySelector('.editFormWindow');
    var darkDiv = document.querySelector('.dark');
    if (editFormWindowDiv.style.display === "block") {
        editFormWindowDiv.style.display = "none";
        darkDiv.style.display = "none";
    } else {
        editFormWindowDiv.style.display = "block";
        darkDiv.style.display = "block";
    }
}

//Функция показать темный экран
function showDark() {
    var editFormWindowDiv  = document.querySelector('.editFormWindow');
    var darkDiv = document.querySelector('.dark');
    if (editFormWindowDiv.style.display === "none") {
        editFormWindowDiv.style.display = "block";
        darkDiv.style.display = "block";
    } else {
        editFormWindowDiv.style.display = "none";
        darkDiv.style.display = "none";
    }
}

//Функция показать темный экран
function showDark2() {
    var darkDiv = document.querySelector('.dark');
        darkDiv.style.display = "block";
}

//Функция скрыть темный экран
function hideDark2() {
    var darkDiv = document.querySelector('.dark');
        darkDiv.style.display = "none";
}

function showEditUserForm(userId, username, name, familiya, otchestvo, phone) {
    $('#editUserForm #user_id').val(userId);
    $('#editUserForm #username').val(username);
    $('#editUserForm #name').val(name);
    $('#editUserForm #familiya').val(familiya);
    $('#editUserForm #otchestvo').val(otchestvo);
    $('#editUserForm #phone').val(phone);
    $('#editUserModal').show();
}    

function showEditChildForm(childId, firstName, secondName, dateOfBirth, gender) {
    $('#editChildForm #child_id').val(childId);
    $('#editChildForm #first_name').val(firstName);
    $('#editChildForm #second_name').val(secondName);
    $('#editChildForm #date_of_birth').val(dateOfBirth);
    $('#editChildForm #gender').val(gender);
    $('#editChildModal').show();
}

function showEditEventForm(eventId, event, eventDate, eventTime) {
    $('#editEventForm #event_id').val(eventId);
    $('#editEventForm #event').val(event);
    $('#editEventForm #event_date').val(eventDate);
    $('#editEventForm #event_time').val(eventTime);
    $('#editEventModal').show();
}

function closeModal(modalId) {
    $('#' + modalId).hide();
}

$(document).ready(function() {
    $('#editUserForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'admin_edit_user.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert(response);
                location.reload();
            }
        });
    });

    $('#editChildForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'admin_edit_child.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert(response);
                location.reload();
            }
        });
    });

    $('#editEventForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'admin_edit_event.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert(response);
                location.reload();
            }
        });
    });
});    
                    

