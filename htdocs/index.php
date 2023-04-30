<?php
require "App/config.php";
$app = require $config["app_folder"].DIRECTORY_SEPARATOR.'Base.php';
$app->addRoute('GET /'.$config["app_folder"].'/', 'MainController->main');
$app->addRoute('POST /'.$config["app_folder"].'/projects/', 'MainController->projects');
$app->addRoute('POST /'.$config["app_folder"].'/pricing/', 'MainController->pricing');
$app->addRoute('POST /'.$config["app_folder"].'/contacts/', 'MainController->contacts');
$app->addRoute('POST /'.$config["app_folder"].'/confirmation/', 'MainController->confirmation');
$app->run();