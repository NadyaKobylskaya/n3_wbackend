<?php

header('Content-Type: text/html; charset=UTF-8');
if (!empty($_POST)) {
	if (empty($_POST["name"])) {
		$errors[] = "Введите имя!";
	}
	if (empty($_POST["mail"])) {
		$errors[] = "Введите e-mail!";
	}
	if (empty($_POST["year"])) {
		$errors[] = "Выберите год рождения!";
	}
	if (!isset($_POST["gend"])) {
		$errors[] = "Выберите пол!";
	}
	if (!isset($_POST["limbs"])) {
		$errors[] = "Выберите кол-во конечностей!";
	}
	if (!isset($_POST["super-powers"])) {
		$errors[] = "Выберите хотя бы одну суперспособность!";
	}
	if (empty($_POST["biography"])) {
		$errors[] = "Расскажите что-нибудь о себе!";
	}
} else {
	$errors[] = "Неверные данные формы!";
}

if (isset($errors)) {
	foreach ($errors as $value) {
		echo "$value<br>";
	}
	exit();
}
$name = htmlspecialchars($_POST["name"]); //игнорирует теги html
$email = htmlspecialchars($_POST["mail"]);
$year = intval(htmlspecialchars($_POST["year"]));//даёт int значение стороки
$gender = htmlspecialchars($_POST["gend"]);
$limbs = intval(htmlspecialchars($_POST["limbs"]));
$superPowers = $_POST["super-powers"];
$biography = htmlspecialchars($_POST["biography"]);
if (!isset($_POST["agree"])) {
	$agree = false;
} else {
	$agree = true;
}
$serverName = 'localhost';
$user = "u40986";
$pass = "2343433";
$dbName = $user;

$db = new PDO("mysql:host=$serverName;dbname=$dbName", $user, $pass, array(PDO::ATTR_PERSISTENT => true));

$lastId = null;
try {
	$stmt = $db->prepare("INSERT INTO user (name, mail, date, gend, limbs, biography, agreement) VALUES (:name, :mail, :date, :gend, :limbs, :biography, :agreement)");
	$stmt->execute(array('name' => $name, 'mail' => $mail, 'date' => $year, 'gend' => $gend, 'limbs' => $limbs, 'biography' => $biography, 'agreement' => $agree));
	$lastId = $db->lastInsertId();
} catch (PDOException $e) {
	print('Error : ' . $e->getMessage());
	exit();
}

try {
	if ($lastId === null) {
		exit();
	}
	foreach ($superPowers as $value) {
		$stmt = $db->prepare("INSERT INTO user_power (id, power) VALUES (:id, :power)");
		$stmt->execute(array('id' => $lastId, 'power' => $value));
	}
} catch (PDOException $e) {
	print('Error : ' . $e->getMessage());
	exit();
}
$db = null;
echo "Спасибо, данные отправлены!";