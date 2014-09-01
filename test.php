<?php
require "NotORM.php";
 
$dsn="mysql:host=127.0.0.1;dbname=test";
$username="root";
$password="";
$pdo = new PDO($dsn, $username, $password);
$db = new NotORM($pdo);


require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->config(array(
    'templates.path' => '.'
));

$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});


$app->get("/cuisions", function () use ($app, $db) {
    $cuisions = array();
    foreach ($db->cuision() as $c) {
        $cuisions[]  = array(
            "id" => $c["id"],
            "name" => $c["name"]
        );
    }
    $app->response()->header("Content-Type", "application/json");
    echo json_encode($cuisions, JSON_PRETTY_PRINT);
});

$app->get("/cuisions-html", function () use ($app, $db) {
    $cuisions = array();
    foreach ($db->cuision() as $c) {
        $cuisions[]  = array(
            "id" => $c["id"],
            "name" => $c["name"]
        );
    }
    $app->view->setData("obj", $cuisions);
    $app->render("view1.php", array("obj" => $cuisions));
});

$app->run();

?>
