<?php
require "App/config.php"; // pripojenie konfiguračného modulu

$app = require $config["app_folder"].DIRECTORY_SEPARATOR.'Base.php'; // jediný exemplár triedy Base (Singleton)

/*Pravidlá routovania*/
$app->addRoute('GET /', 'MainController->home');
$app->addRoute('GET /projects.html', 'MainController->projects');
$app->addRoute('GET /prices.html', 'MainController->prices');
$app->addRoute('GET /contacts.html', 'MainController->contacts');
$app->addRoute('POST /confirmation.html', 'MainController->confirmation');
$app->addRoute('GET /login.html', 'MainController->login');
$app->addRoute('GET /logout.html', 'MainController->logout');
$app->addRoute('POST /auth.html', 'MainController->auth');
/*//Pravidlá routovania*/

$app->run($config); // volanie metódy centrálneho kontroléra