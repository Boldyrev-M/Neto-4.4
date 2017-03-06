<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 05.03.2017
 * Time: 18:17
 */
include_once "functions.php";
$showtables  = $mydb->prepare("SHOW TABLES");
        $showtables->execute();
        $dbs = $showtables->fetchAll();
//        var_dump($dbs);
//        echo "<pre>".print_r($dbs,true)."</pre>";

$tabhead = <<< TABH
<h1>Список таблиц<h1>
<table border=1>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Действие</th>
    </tr>
<tr>
TABH;
echo $tabhead;

    foreach ($dbs as $key => $row) {
    ?>
<tr><form name="table<?= $key ?>" action ="table.php" method="POST">
        <td><?= $key+1 ?></td>
        <td><?= $row[0]?></td>
        <td><input type="hidden" name="tableSelected" value = "<?= $row[0] ?>">
            <input type="submit" value="Посмотреть"></td></tr></form>
<?php
}
?>
<tr><form name="table<?= $key ?>" action ="table.php" method="POST">
        <td><?= $key+2 ?></td>
        <td><input type="text" name="newTableName" value="Введите название новой таблицы" size="30" autofocus></td>
        <td><input type="hidden" name="tableNew" value = "1">
            <input type="submit" value="Добавить"></td></tr></form>

