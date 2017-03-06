<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 16.01.2017
 * Time: 16:26
 */
const MD5_ADD = 'lo9g$4&';

try {
    //$mydb = new PDO("mysql:host=localhost;dbname=mboldyrev;charset=UTF8","mboldyrev","neto0801");
    $mydb = new PDO("mysql:host=localhost:8889;dbname=mboldyrev;charset=UTF8","root","root");
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
}

function runSQL($sqlstring){ //, array $params){
    global $mydb;
    //echo $sqlstring;
    $showtables  = $mydb->prepare($sqlstring);
    $showtables->execute();
    $res = $showtables->fetchAll(PDO::FETCH_ASSOC);
    //echo "ВОЗВРАТ: <pre>".print_r($res,true)."</pre>";
    return $res;

}

function userExist($userName) {
    global $mydb;

    $findUser = $mydb->prepare("SELECT id, login FROM user WHERE login = ?");
    $findUser->execute([$userName]);
    $result = $findUser->fetch();
    if ($result) {
        //echo "USer exists";
//        $dbtabl = $mydb->prepare("SHOW TABLES");
//        $dbtabl->execute();
//        $dbs = $dbtabl->fetch();
//        echo "<pre>".print_r($dbs,true)."</pre>";
//        //echo json_encode($dbs);
//        var_dump($result);
        return (int) $result["id"];
    }
    else {
        //echo "no user found";
        return false;
    }
}

function checkPassword ($usr, $psw) {
    global $mydb;
    $sql = "SELECT login, password FROM `user` WHERE login = ?";
    $checkPass = $mydb->prepare($sql);
    $checkPass->execute([$usr]);
    $gotPass = $checkPass->fetch();
    $passdata = md5($usr . $psw . MD5_ADD);
    return strcmp($passdata, $gotPass["password"]) === 0 ? true : false; // true если строки равны

}
