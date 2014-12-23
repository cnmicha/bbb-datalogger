<?php
/**
 * Created by PhpStorm.
 * User: micha
 * Date: 21.12.2014
 * Time: 00:36
 */

require_once('config/config.inc.php');
require_once('classes/mysql.class.php');


$oSql = new cMySql();

$aPorts = $oSql->selectArray('gpio');
print_r($aPorts);


foreach ($aPorts as $aPort) {
    if (file_exists('/sys/class/gpio/gpio' . $aPort['kernel_path'] . '/value')) { //gpio was already exported
        exec('echo ' . $aPort['kernel_path'] . ' > /sys/class/gpio/unexport');
    }

    exec('echo ' . $aPort['kernel_path'] . ' > /sys/class/gpio/export');
    exec('echo "in" > /sys/class/gpio/gpio' . $aPort['kernel_path'] . '/direction');

    exec('php worker.php ' . $aPort['id'] . ' > /dev/null 2>/dev/null &');
}
