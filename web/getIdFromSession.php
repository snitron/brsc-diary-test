<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING) . "";

$test = filter_input(INPUT_GET, "test", FILTER_SANITIZE_STRING);

$s = $_SESSION[$id];

echo $test == null;
