<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);


$login = filter_input(INPUT_GET, "login", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_GET, "password", FILTER_SANITIZE_STRING);

$id = "123456";

session_start();

echo $id;

$user = array();

$user['login'] = $login;
$user['password'] = $password;
$user['child_ids'] = null;

$_SESSION[$id] = $user;
session_commit();

/*
function parseId($string)
{
$b = stristr($string, "?");
$c = substr($b, 1);

$output = array();
parse_str($c, $output);

return $output['UserId'];
}*/