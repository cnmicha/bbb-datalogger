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


while (true) {
    $aPort = $oSql->selectOne('gpio', ['id' => $argv[1]]); //refresh gpio settings

    $iValue = intval(file_get_contents('/sys/class/gpio/gpio' . $argv[1] . '/value'));

    //check threshold
    $aLastVal = $oSql->selectOne('data', ['gpio_id' => $argv[1]], null, ['timestamp'], false, 1);

    if ($aPort['log_on'] == 1) {
        if (($iValue >= $aLastVal['value'] + $aPort['log_threshold']) or ($iValue <= $aLastVal['value'] - $aPort['log_threshold'])) {
            $oSql->insertRow('data', ['gpio_id' => intval($argv[1]), 'value' => $iValue, 'timestamp' => date('Y-m-d H:i:s')]);
        }
    }

    usleep($aPort['refresh_interval']);
}
