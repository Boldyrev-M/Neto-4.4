<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 13.02.2017
 * Time: 14:00
 */
error_reporting(E_ALL & E_NOTICE & E_DEPRECATED & E_STRICT);
ini_set('display_errors',1);
include_once "functions.php";

echo "<h3>Домашнее задание к лекции 4.4 «Управление таблицами и базами данных»</h3>";

$html = '';
setcookie('logged_user',"",-1); // обнуляем куку если была
session_start();

if ( !empty($_POST) && ($_POST['login'] != "") ) {
    // имя уже получено, проверяем пароль

    $not_valid_chars = preg_match('/[^a-zA-Z0-9]/',$_POST['login']);
    if ( $not_valid_chars == 1 ) {
        $html = <<<INVALID_NAME
        <form action="" method = "post" >
        <p><p><b>Введите имя (только латиница без пробелов):</b><br><input name="login" type="text" autofocus></p>
        <p><input type="submit" value="Войти"></p>
        </form>
INVALID_NAME;
        echo $html;
    } // в имени чтото кроме латиницы и цифр
    else // имя подходящее
    {
        $login = $_POST['login'];
        if (userExist($login)) { // пользователь найден
            if (!empty($_POST['pass'])) {
                if (checkPassword($login, $_POST['pass'])) {
                    setcookie('logged_user', userExist($login)); // установлена кука
                    header('location: tables.php '); // переход на страницу с тасками
                } // пароль проверен
                else { // введен неверный пароль, заново
                    $html = <<<WRONG_PASS
                    <form action="" method = "post" >
                    <p><p><b>Ваше имя: $login </b><br>
                    <input type="hidden" name="login" value="$login">
                    <label for="pass">Пароль неверный!</label>
                    <input id= "pass" name="pass" type="password" placeholder="Введите пароль" autofocus><br>
                    <input type="submit" value="Отправить">
                    </form>
WRONG_PASS;

                } // пароль неверный
                echo $html;
            }
            else {
                $html = <<<LOGIN_EXISTS
            <form action="" method = "post" >
            <p><p><b>Ваше имя: $login </b><br>
            <input type="hidden" name="login" value="$login">
            <label for="pass">Пароль:</label>
            <input id= "pass" name="pass" type="password" placeholder="Введите пароль" autofocus><br>
            <input type="submit" value="Отправить">
            </form>
LOGIN_EXISTS;
                echo $html;

            } //echo "ЗАПРОС ПАРОЛЯ";
        } // пользователь такой найден
        else { // пользователь НЕ найден
            header("location:index.php");
            exit;
        } // пользователь не найден
    }
} // имя уже получено, проверяем пароль
else {

    // <p><p><b>Ваше имя:</b><br><input name="user_name" type="text"></p>
    $html = <<<NO_NAME
        <form action="" method = "post">
        <p><p><b>Ваше имя (только латиница):</b><br><input name="login" type="text" autofocus></p>
        <p><input type="submit" value="Войти"></p>
    </form>
NO_NAME;
    echo $html;
} // имя еще не введено! Как вас зовут