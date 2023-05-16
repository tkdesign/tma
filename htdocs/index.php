<?php
require "App/config.php"; // pripojenie konfiguračného modulu

$app = require $config["app_folder"] . DIRECTORY_SEPARATOR . 'Base.php'; // jediný exemplár triedy Base (Singleton)

/*Pravidlá routovania*/
$app->addRoute('GET /', 'MainController->home');
$app->addRoute('GET /projects.html', 'MainController->projects');
$app->addRoute('GET /prices.html', 'MainController->prices');
$app->addRoute('GET /contacts.html', 'MainController->contacts');
$app->addRoute('POST /confirmation.html', 'MainController->confirmation');
$app->addRoute('GET /login.html', 'MainController->login');
$app->addRoute('GET /logout.html', 'MainController->logout');
$app->addRoute('POST /auth.html', 'MainController->auth');
$app->addRoute('GET /dashboard.html', 'MainController->dashboard');
$app->addRoute('GET /dashboard/delete_request.html', 'MainController->deleteRequest');
$app->addRoute('GET /dashboard/reply_request.html', 'MainController->replyRequest');
$app->addRoute('GET /edit.html', 'MainController->portfolioEdit');
$app->addRoute('GET /edit/details.html', 'MainController->detailsCard');
$app->addRoute('GET /edit/get_categories.html', 'MainController->getCategories');
$app->addRoute('GET /edit/delete_request.html', 'MainController->deleteCard');
$app->addRoute('POST /edit/update_request.html', 'MainController->updateCard');
$app->addRoute('POST /edit/insert_request.html', 'MainController->insertCard');
/*//Pravidlá routovania*/

$app->run($config); // volanie metódy centrálneho kontroléra