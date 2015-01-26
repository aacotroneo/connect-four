<?php

//development!!
ini_set('display_errors', 1);
error_reporting(E_ALL);

require('../vendor/autoload.php');

$conf = include_once('../conf/config.php');

$app = new \Aac\Application($conf);

//configure anything else


$app->run();

