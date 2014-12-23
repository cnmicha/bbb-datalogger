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

<body>
<p>
    [<a href="show.php">Log zeigen</a>]
</p><br>

<table>
    <tr>
        <td><span style="font-weight: bold;">Name</span></td>
        <td><span style="font-weight: bold;">Gpio Nr</span></td>
        <td><span style="font-weight: bold;">Refresh interval</span></td>
        <td><span style="font-weight: bold;">Log threshold</span></td>
        <td><span style="font-weight: bold;">Log turned on</span></td>
    </tr>

    <?php
    print_r($aAllGpios);
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