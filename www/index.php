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


if (isset($_GET['restart'])) {
    if ($_GET['restart'] == 'true') {
        exec('sudo reboot');

        header("HTTP/1.1 303 See Other");
        header('Location: index.php');
    }
}

if (isset($_GET['start'])) {
    if ($_GET['start'] == 'true') {
        exec('sudo sh /root/datalogger/start_service.sh');

        header("HTTP/1.1 303 See Other");
        header('Location: index.php');
    }
}

if (isset($_GET['stop'])) {
    if ($_GET['stop'] == 'true') {
        $oSql->updateRows('sys', ['value' => '1'], ['name' => 'worker_exit']);


        header("HTTP/1.1 303 See Other");
        header('Location: index.php');
    }
}

if (isset($_GET['shutdown'])) {
    if ($_GET['shutdowm'] == 'true') {
        exec('sudo shutdown -h now');

        header("HTTP/1.1 303 See Other");
        header('Location: index.php');
    }
}


$aAllGpios = $oSql->selectArray('gpio');


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

<script type="text/javascript">
    setTimeout(function () {
        window.location.reload(1);
    }, 5000);
</script>

<body>
<p>
    [<a href="show.php">Log zeigen</a>]<br>
    [<a href="index.php?stop=true">Dienst stoppen</a>]<br>
    [<a href="index.php?restart=true">Beaglebone neustarten</a>][<a href="index.php?shutdown=true">Beaglebone
        herunterfahren</a>]
</p><br>

<iframe src="worker_alive.php" style="width: 300px; height: 50px; border: none;"></iframe>

<br>
[<a href="gpio.php">Neuer GPIO</a>]

<table>
    <tr>
        <td><span style="font-weight: bold;">Name</span></td>
        <td><span style="font-weight: bold;">Gpio Nr</span></td>
        <td><span style="font-weight: bold;">Aktualisierungsintervall</span></td>
        <td><span style="font-weight: bold;">Log Schwellwert</span></td>
        <td><span style="font-weight: bold;">Log ein</span></td>
    </tr>

    <?php
    foreach ($aAllGpios as $aGpio) {
        echo('<tr>');
        echo('<td>' . $aGpio['name'] . '</td>');
        echo('<td>' . $aGpio['kernel_path'] . '</td>');
        echo('<td>' . $aGpio['refresh_interval'] . '</td>');
        echo('<td>' . $aGpio['log_threshold'] . '</td>');

        if ($aGpio['log_on'] == 1) echo('<td>yes</td>');
        else echo('<td>no</td>');

        echo('<td>[<a href="show.php?id=' . $aGpio['id'] . '">Show</a>]</td>');
        echo('<td>[<a href="gpio.php?id=' . $aGpio['id'] . '">Edit</a>]</td>');

        echo('</tr>');
    }
    ?>
</table>
</body>
</html>