<?php
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
    header('Content-Type: text/html; charset=UTF-8');


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
    print('Спасибо, данные сохранены.');
  }
  // Включаем содержимое файла form.php.
  include('form.html');
  // Завершаем работу скрипта.
  exit();
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.
$errors = FALSE;
if (empty($_POST['fio'])) {
  print('Заполните поле "Имя".<br/>');
  $errors = TRUE;
}

if (empty($_POST['mail'])) {
        print('Заполните поле "E-mail".<br/>');
        $errors = TRUE;
    }

    if (empty($_POST['date'])) {
        print('Заполните поле "Дата рождения".<br/>');
        $errors = TRUE;
    }

    if ( empty($_POST['gend']) ) {
        print('Укажите пол.<br/>');
        $errors = TRUE;
    }

    switch($_POST['gend']) {
        case 'm': {
            $gend='m';
            break;
        }
        case 'f':{
            $gend='f';
            break;
        }
    };


    if (empty($_POST['limbs'])) {
        print('Укажите количество конечностей.<br/>');
        $errors = TRUE;
    }

    switch($_POST['limbs']) {
        case '1': {
            $limbs='1';
            break;
        }
        case '2':{
            $limbs='2';
            break;
        }
        case '3':{
            $limbs='3';
            break;
        }
        case '4':{
            $limbs='4';
            break;
        }
    };

    if (empty($_POST['super'])) {
        print('Укажите хотя бы одну суперспособность.<br/>');
        $errors = TRUE;
    }
    
    switch($_POST['super']) {
        case 'Бессмертие': {
            $super='Бессмертие';
            break;
        }
        case 'Прохожление сквозь стены':{
            $super='Прохожление сквозь стены';
            break;
        }
        case 'Левитация':{
            $super='Левитация';
            break;
        }
    };
    

    if (empty($_POST['biography'])) {
        print('Заполните поле "Биография".<br/>');
        $errors = TRUE;
    }

    if (empty($_POST['agree'])) {
        print('Вы не согласились с условиями контракта!<br/>');
        $errors = TRUE;
    }
    $agree = 'agree';

if ($errors) {
  // При наличии ошибок завершаем работу скрипта.
  exit();
}

// Сохранение в базу данных.

$user = 'u40986';
$pass = '2343433';
    $db = new PDO('mysql:host=localhost;dbname=u41033', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

// Подготовленный запрос. Не именованные метки.
try {
  $stmt = $db->prepare("INSERT INTO application SET fio = ?, mail = ?, date = ? ,gend = ?, limbs = ?, super = ?, biography = ?, agree = ?");
  $stmt -> execute(array($_POST['fio'],$_POST['mail'],$_POST['date'],$gend,$limbs,$super, $_POST['biography'], $agree)));
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}
header('Location: ?save=1');
    ?>
