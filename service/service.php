<?php
/**
 * Created by PhpStorm.
 * User: micha
 * Date: 21.12.2014
 * Time: 00:36
 */

require_once('config/config.inc.php');
require_once('classes/mysql.class.php');



init();
run();



//functions

function init() {
    $oSql = new cMySql();

    $oSql->selectArray('gpio');
}

function run() {

}