<?php
/**
 * Created by PhpStorm.
 * User: micha
 * Date: 23.12.2014
 * Time: 19:59
 */

require_once('config/config.inc.php');
require_once('classes/mysql.class.php');

$oSql = new cMySql();


//check if form was submitted
if (isset($_POST['name']) and isset($_POST['kernel_path']) and isset($_POST['refresh_interval']) and isset($_POST['log_threshold'])) {

    if (!isset($_POST['log_on'])) $iLogOn = 0; //unchecked
    else $iLogOn = 1;

    if (isset($_GET['id'])) $oSql->insertUpdate('gpio', ['name' => $_POST['name'], 'kernel_path' => $_POST['kernel_path'], 'refresh_interval' => intval($_POST['refresh_interval']), 'log_threshold' => $_POST['log_threshold'], 'log_on' => $iLogOn], ['id' => $_GET['id']]);
    else {
        $oSql->insertRow('gpio', ['name' => $_POST['name'], 'kernel_path' => $_POST['kernel_path'], 'refresh_interval' => intval($_POST['refresh_interval']), 'log_threshold' => $_POST['log_threshold'], 'log_on' => $iLogOn]);
    }

    header("HTTP/1.1 303 See Other");
    header('Location: index.php');
}

if (isset($_GET['id'])) {
    $aGpio = $oSql->selectOne('gpio', ['id' => intval($_GET['id'])]);
    if (!$aGpio['id'] == NULL) {
        //nix^^
    } else die('Wrong gpio id');
}

if (isset($_GET['delete'])) {
    $aGpio = $oSql->deleteRows('gpio', ['id' => intval($_GET['delete'])]);

    header("HTTP/1.1 303 See Other");
    header('Location: index.php');
}

?>

<html>
<head>
    <meta charset="utf-8">
    <title>bbb-datablogger</title>
</head>

<style type="text/css">
    table, th, td {
        border: 1px;
    }
</style>

<body>
<p>
    [<a href="index.php">Startseite</a>][<a href="show.php">Log zeigen</a>]<?php if (isset($_GET['id'])) { ?>[<a
        href="show.php?id=<?php echo($_GET['id']); ?>">Log für diesen GPIO-Port zeigen</a>] [<a
        href="gpio.php?delete=<?php echo($_GET['id']); ?>">GPIO löschen</a>]<?php } ?>
</p><br>

<form action="gpio.php<?php if (isset($_GET['id'])) echo('?id=' . $aGpio['id']); ?>" method="post">
    <table>
        <tr>
            <td><label for="name">Name</label></td>
            <td><input type="text" name="name" placeholder="Name" value="<?php echo($aGpio['name']); ?>"></td>
        </tr>
        <tr>
            <td><label for="kernel_name">Kernel Name<br>z.B. "1" für "gpio1"</label></td>
            <td><input type="text" name="kernel_path" placeholder="Kernel Name"
                       value="<?php echo($aGpio['kernel_path']); ?>"></td>
        </tr>
        <tr>
            <td><label for="refresh_interval">Aktualisierungsintervall (Mikrosekunden)<br>1 Sekunde sind 1.000.000
                    Mikrosekunden</label></td>
            <td><input type="text" name="refresh_interval" placeholder="Refresh interval"
                       value="<?php echo($aGpio['refresh_interval']); ?>"></td>
        </tr>
        <tr>
            <td><label for="log_threshold">Log Schwellwert<br>"0" eingeben für dauerhaften Log</label></td>
            <td><input type="text" name="log_threshold" placeholder="Log threshold"
                       value="<?php echo($aGpio['log_threshold']); ?>"></td>
        </tr>
        <tr>
            <td><label for="log_on">Log ein</label></td>
            <?php
            if ($aGpio['log_on'] == 1) {
                echo('<td><input type="checkbox" name="log_on" checked></td>');
            } else {
                echo('<td><input type="checkbox" name="log_on"></td>');
            }
            ?>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Speichern"></td>
        </tr>
    </table>
</form>
</body>
</html>