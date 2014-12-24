<?php
/**
 * Created by PhpStorm.
 * User: micha
 * Date: 23.12.2014
 * Time: 19:58
 */


require_once('config/config.inc.php');
require_once('classes/mysql.class.php');

$oSql = new cMySql();


if (isset($_GET['clear'])) {
    if ($_GET['clear'] == 'true') {
        $oSql->deleteRows('data');

        header("HTTP/1.1 303 See Other");
        header('Location: show.php');
    }
}

if (isset($_GET['reset'])) {
    if ($_GET['reset'] == 'true') {
        $oSql->truncateTable('data');

        header("HTTP/1.1 303 See Other");
        header('Location: show.php');
    }
}

$aGpioData = $oSql->selectArray('gpio');

if (isset($_GET['id'])) $aData = $oSql->selectArray('data', ['gpio_id' => intval($_GET['id'])]);
else $aData = $oSql->selectArray('data');


$aGpios = array();
foreach ($aGpioData as $aGpio) {
    $aGpios[$aGpio['id']] = $aGpio;
}


?>

<html>
<head>
    <meta charset="utf-8">
    <title>bbb-datablogger</title>
</head>

<style type="text/css">
    table {
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid darkgray;
    }
</style>

<body>
<p>
    [<a href="index.php">Startseite</a>][<a href="show.php?clear=true">Tabelle leeren</a>][<a
        href="show.php?reset=true">Tabelle zurücksetzen</a>]<?php if (isset($_GET['id'])) { ?>[<a href="show.php">Log
        für alle GPIO-Ports zeigen</a>] <?php } ?>
</p><br>

<table>
    <tr>
        <td><span style="font-weight: bold;">Index</span></td>
        <td><span style="font-weight: bold;">Gpio Nr</span></td>
        <td><span style="font-weight: bold;">Gpio Name</span></td>
        <td><span style="font-weight: bold;">Wert</span></td>
        <td><span style="font-weight: bold;">Zeit</span></td>
    </tr>

    <?php
    foreach ($aData as $aSet) {
        echo('<tr>');
        echo('<td>' . $aSet['id'] . '</td>');
        echo('<td>' . $aGpios[$aSet['gpio_id']]['kernel_path'] . '</td>');
        echo('<td>' . $aGpios[$aSet['gpio_id']]['name'] . '</td>');
        echo('<td>' . $aSet['value'] . '</td>');
        echo('<td>' . $aSet['timestamp'] . '</td>');


        echo('<td>[<a href="gpio.php?id=' . $aSet['gpio_id'] . '">Gpio Einstellungen</a>][<a href="show.php?id=' . $aSet['gpio_id'] . '">Nur diesen zeigen</a>]</td>');

        echo('</tr>');
    }
    ?>
</table>
</body>
</html>