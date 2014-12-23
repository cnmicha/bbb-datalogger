<?php
/**
 * Created by PhpStorm.
 * User: micha
 * Date: 23.12.2014
 * Time: 15:14
 */

require_once('config/config.inc.php');
require_once('classes/mysql.class.php');


$oSql = new cMySql();
$aPort = $oSql->selectOne('gpio', ['id' => intval($argv[1])]);

echo('got gpio port ' . $aPort['kernel_path']);




while (true) {
    $aPort = $oSql->selectOne('gpio', ['id' => $argv[1]]); //refresh gpio settings

    $iValue = intval(file_get_contents('/sys/class/gpio/gpio' . $aPort['kernel_path'] . '/value'));

    //check threshold
    $aLastVal = $oSql->selectOne('data', ['gpio_id' => $aPort['id']], null, ['timestamp'], false, 1);

    if ($aPort['log_on'] == 1) {
        if (($iValue >= $aLastVal['value'] + $aPort['log_threshold']) or ($iValue <= $aLastVal['value'] - $aPort['log_threshold'])) {
            $oSql->insertRow('data', ['gpio_id' => $aPort['id'], 'value' => $iValue, 'timestamp' => date('Y-m-d H:i:s')]);
        }
    }

    usleep($aPort['refresh_interval']);
}
