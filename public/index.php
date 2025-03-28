<?php


require_once __DIR__ . "/routeDispatcher.php";

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

getRouteByUrl($url, $method);

