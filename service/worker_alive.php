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


while (true) {
    $oSql->updateRows('alive', ['worker_lastseen' => date('Y-m-d H:i:s')], ['id' => 1]);
    echo('updated.');

    usleep(4000000);
}