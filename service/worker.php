<?php
/**
 * Created by PhpStorm.
 * User: micha
 * Date: 23.12.2014
 * Time: 15:14
 */

require_once('config/config.inc.php');
require_once('classes/mysql.class.php');


echo('got gpio port ' . $argv[1]);

$oSql = new cMySql();

$aPort = $oSql->selectOne('gpio', ['id' => $argv[1]]);



while(true) {
    $sValue = file_get_contents('/sys/class/gpio/gpio' . $argv[1] . '/value');
    echo('value=' . $sValue);
    usleep($aPort['refresh_interval']);
}
