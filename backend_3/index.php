<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  // В суперглобальном массиве $_GET PHP хранит все параметры, переданные в текущем запросе через URL.
  if (!empty($_GET['save'])) {
    // Если есть параметр save, то выводим сообщение пользователю.
    print('Спасибо, данные сохранены.');
  }
  // Включаем содержимое файла form.php.
  include('index.html');
  // Завершаем работу скрипта.
  exit();
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.

// Проверяем ошибки.
$errors = FALSE;
if (empty($_POST['fio'])) {
  print('Заполните поле "ФИО".<br/>');
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

    if ( empty($_POST['sex']) ) {
        print('Укажите пол.<br/>');
        $errors = TRUE;
    }

    switch($_POST['sex']) {
        case 'm': {
            $sex='m';
            break;
        }
        case 'f':{
            $sex='f';
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

    if (empty($_POST['Superpowers'])) {
        print('Укажите хоть одну суперспособность.<br/>');
        $errors = TRUE;
    }

    $power1=in_array('fly',$_POST['Superpowers']) ? '1' : '0';
    $power2=in_array('transparency',$_POST['Superpowers']) ? '1' : '0';
    $power3=in_array('get5',$_POST['Superpowers']) ? '1' : '0';
    $power4=in_array('mind reading',$_POST['Superpowers']) ? '1' : '0';

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
$db = new PDO('mysql:host=localhost;dbname=test', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

// Подготовленный запрос. Не именованные метки.
try {
  $stmt = $db->prepare("INSERT INTO application SET fio = ?, mail = ?, date = ? ,sex = ?, limbs = ?, fly = ?, transparency = ? ,get5 =?,mind reading = ?, biography = ?, agree = ?");
  $stmt -> execute(array($_POST['fio'],$_POST['mail'],$_POST['date'],$sex,$limbs,$power1,$power2,$power3, $power4, $_POST['biography'], $agree)));
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}

//  stmt - это "дескриптор состояния".
 
//  Именованные метки.
//$stmt = $db->prepare("INSERT INTO test (label,color) VALUES (:label,:color)");
//$stmt -> execute(array('label'=>'perfect', 'color'=>'green'));
 
//Еще вариант
/*$stmt = $db->prepare("INSERT INTO users (firstname, lastname, email) VALUES (:firstname, :lastname, :email)");
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':email', $email);
$firstname = "John";
$lastname = "Smith";
$email = "john@test.com";
$stmt->execute();
*/

// Делаем перенаправление.
// Если запись не сохраняется, но ошибок не видно, то можно закомментировать эту строку чтобы увидеть ошибку.
// Если ошибок при этом не видно, то необходимо настроить параметр display_errors для PHP.
header('Location: ?save=1');
    ?>
