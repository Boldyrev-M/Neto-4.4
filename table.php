<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 06.03.2017
 * Time: 10:09
 */
include_once "functions.php";
$lastrow = 1;
// что-то изменилось
if (isset($_POST["editTableName"])) {
    $sqlstr = "ALTER TABLE ".$_POST["tableSelected"]." RENAME ".$_POST["editTableName"];
    //echo $sqlstr;
    runSQL($sqlstr);
    header("location:tables.php");
    exit;
}// изменяю имя таблицы
if (isset($_POST["fieldSelected"])) {
    $sqlstr = "ALTER TABLE ".$_POST["tableSelected"]." CHANGE ".$_POST["fieldSelected"]." ". $_POST["FieldName"]." ". $_POST["FieldType"];
    //echo $sqlstr;
    runSQL($sqlstr);
    header("location:tables.php");
    exit;
} // меняем старое поле в старой таблице

if (isset($_POST["newFieldName"])) {
    if ($_POST["createTable"]) {
        $sqlstr = "CREATE TABLE ".  $_POST["tableSelected"]. " ( ".$_POST["newFieldName"]." ". $_POST["FieldType"].")";
        //echo $sqlstr;
        runSQL($sqlstr);
        header("location:tables.php");
        exit;
    }// создаем таблицу
    else {
        $sqlstr = "ALTER TABLE ".$_POST["tableSelected"]." ADD ".$_POST["newFieldName"]." ". $_POST["FieldType"];
        //echo $sqlstr;
        runSQL($sqlstr);
        header("location:tables.php");
        exit;
    } // создаем новое поле в старой таблице
// изменяю данные поля
}

if (isset($_POST["tableNew"])) {
    $tabname = $_POST["newTableName"];
    echo "Создаем таблицу: ".$tabname;
} // готовимся создать новую таблицу

if (isset($_POST["tableSelected"])) {
    $tabname = $_POST["tableSelected"];
    ?>
    <form name="tableName" action ="" method="POST">
        Название таблицы: <input type="text" name="editTableName" value=" <?= $tabname ?>">
        <input type="hidden" name="tableSelected" value="<?= $tabname ?>">
        <input type="submit" value="Изменить">
    </form>
    <?php
    //echo "to run: ".$sqlToRun;
    $sqlToRun = "DESCRIBE ".$tabname;
$show  = runSQL( (string) $sqlToRun);

//        echo "<pre>".print_r($show,true)."</pre>";

$tabhead = <<< TABH
<table border=1>
    <tr>
        <th>№</th>
        <th>Название поля</th>
        <th>Тип --> Изменить</th>
        <th>Null</th>
        <th>Key</th>
        <th>Default</th>
        <th>Extra</th>
        <th>Действие</th>
    </tr>
<tr>
TABH;
echo $tabhead;

/*
            [Field] => id
            [Type] => int(11)
            [Null] => NO
            [Key] => PRI
            [Default] =>
            [Extra] => auto_increment
*/
foreach ($show as $key => $row) {

    ?>
    <tr><form name="table<?= $key ?>" action ="" method="POST">
            <td><?= $key+1 ?></td>
            <td><input type="text" name="FieldName" value="<?= $row['Field']?>"</td>
            <td align="right"><?= $row['Type']?>
                --><select name="FieldType">
                <optgroup label="Число">
                    <option value="tinyint">tinyint</option>
                    <option value="int">int</option>
                    <option value="float">float</option>
                    <option value="double">double</option>
                </optgroup>
                <optgroup label="Дата и время">
                    <option value="date">date</option>
                    <option value="datetime">datetime</option>
                    <option value="timestamp">timestamp</option>
                    <option value="time">time</option>
                </optgroup>
                <optgroup label="Строки">
                    <option value="CHAR(255)">char</option>
                    <option value="VARCHAR(255)">varchar</option>
                    <option value="TEXT">text</option>
                </optgroup>
                </select>
                </td>

            <td><?= $row['Null']?></td>
            <td><?= $row['Key']?></td>
            <td><?= $row['Default']?></td>
            <td><?= $row['Extra']?></td>
            <td><input type="hidden" name="fieldSelected" value = "<?= $row['Field'] ?>">
                <input type="hidden" name="tableSelected" value="<?= $tabname ?>">
                <input type="submit" value="Изменить"></td></tr>

    </form>
    <?php
}
$lastrow=$key+2;
} // изменяем старые таблицы
// дальше пойдет ПОЛЕ для добавления
?>

<form name="table<?= $key ?>" action ="" method="POST">
<td><?= $lastrow ?></td>
<td><input type="text" name="newFieldName" value="Введите название поля"</td>
<td>Выберите тип поля<select name="FieldType">
        <optgroup label="Число">
            <option value="tinyint">tinyint</option>
            <option value="int">int</option>
            <option value="float">float</option>
            <option value="double">double</option>
        </optgroup>
        <optgroup label="Дата и время">
            <option value="date">date</option>
            <option value="datetime">datetime</option>
            <option value="timestamp">timestamp</option>
            <option value="time">time</option>
        </optgroup>
        <optgroup label="Строки">
            <option value="CHAR(255)">char</option>
            <option value="VARCHAR(255)">varchar</option>
            <option value="TEXT">text</option>
        </optgroup>
        </select></td>

<td> - </td>
<td> - </td>
<td> - </td>
<td> - </td>
<td><input type="hidden" name="tableSelected" value="<?= $tabname ?>">
    <input type="hidden" name="createTable" value="<?= (isset($_POST["tableNew"])) ?>">
    <input type="submit" value="Добавить"></td></tr>
</form>
