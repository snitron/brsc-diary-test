<?php
require __DIR__ . "/../vendor/autoload.php";
use Snoopy\Snoopy;


$login = filter_input(INPUT_GET, "login", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_GET, "password", FILTER_SANITIZE_STRING);

session_start();
$snoopy = new Snoopy();

$post_array = array();
$post_array['Login'] = $login;
$post_array['Password'] = $password;

$snoopy->maxredirs = 2;
$snoopy->cookies = array("PHPSESSID=". session_id());
$snoopy->setcookies();
$snoopy->submit("https://edu.brsc.ru/Logon/Index", $post_array);
$snoopy->results;
$snoopy->cookies = array("PHPSESSID=". session_id());
$snoopy->setcookies();

$snoopy->submit("https://edu.brsc.ru/privateoffice");

echo $snoopy->results;
/*
$user = array();

$user['login'] = $login;
$user['password'] = $password;
$user['child_ids'] = null;

$_SESSION[$id] = $user;
session_commit();
*/
/*
function parseId($string)
{
$b = stristr($string, "?");
$c = substr($b, 1);

$output = array();
parse_str($c, $output);

return $output['UserId'];
}*/