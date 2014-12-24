<?php
/**
 * Created by PhpStorm.
 * User: micha
 * Date: 24.12.2014
 * Time: 15:04
 */


require_once('config/config.inc.php');
require_once('classes/mysql.class.php');

$oSql = new cMySql();

if($oSql->selectOne('sys', ['name' => 'worker_exir'])['value'] == '1') $bRun = false;
else $bRun = true;
/*
while ($bRun) {
    $oSql->updateRows('sys', ['value' => date('Y-m-d H:i:s')], ['name' => 'worker_lastseen']);
    echo('updated.');

    if($oSql->selectOne('sys', ['name' => 'worker_exir'])['value'] == 1) $bRun = false;

    usleep(4000000);
}
*/


if($oSql->selectOne('sys', ['name' => 'worker_exit'])['value'] == '1') $bRun = false;
else $bRun = true;


while ($bRun) {
    $oSql->updateRows('sys', ['value' => date('Y-m-d H:i:s')], ['name' => 'worker_lastseen']);
    echo('updated.');

    if($oSql->selectOne('sys', ['name' => 'worker_exit'])['value'] == 1) $bRun = false;

    usleep(4000000);
}
