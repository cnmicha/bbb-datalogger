<?php
/**
 * Created by PhpStorm.
 * User: micha
 * Date: 24.12.2014
 * Time: 15:12
 */

const TIMEOUT_SEC = 4;

require_once('config/config.inc.php');
require_once('classes/mysql.class.php');

$oSql = new cMySql();

$aWorkers = $oSql->selectArray('alive');

$bAlive = true;

foreach ($aWorkers as $aWorker) {
    if (strtotime(date('Y-m-d H:i:s')) > (strtotime($aWorker['worker_lastseen']) + TIMEOUT_SEC)) {
        $bAlive = false;
    }
}


if($bAlive) echo('<span style="color: green;">Dienst läuft.</span>');
else echo('<span style="color: red;">Dienst gestoppt.</span>');
