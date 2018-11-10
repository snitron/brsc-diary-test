<?php
require __DIR__ . "/../vendor/autoload.php";
require "User.php";

use Snoopy\Snoopy;
use \DiDom\Document;

$login = filter_input(INPUT_GET, "login", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_GET, "password", FILTER_SANITIZE_STRING);

session_start();
$snoopy = new Snoopy();

$post_array = array();
$post_array['Login'] = $login;
$post_array['Password'] = $password;

$snoopy->maxredirs = 2;
$snoopy->submit("https://edu.brsc.ru/Logon/Index", $post_array);
$snoopy->submit("https://edu.brsc.ru/User/Diary");
echo $snoopy->results;



$html = new Document($snoopy->results);
$user = new User();

$child_ids = $html->find("div.btn-group");
if (count($child_ids) != 0) {
    $child_ids = $child_ids[0]->find("a");
    if (count($child_ids) != 0) {
        for ($i = 0; $i < count($child_ids); $i++)
            $user->child_ids[$i] = parseId($child_ids[$i]->getAttribute("href"));
        $user->id = null;
    } else {
        $user->child_ids = null;
        $user->id = parseId($html->find("a.h5")[0]->getAttribute("href"));
    }
} else {
    $user->child_ids = null;
    $user->id = parseId($html->find("a.h5")[0]->getAttribute("href"));
}

$user->session_id = "PHPSESSID=". session_id();

$sess_data = array();

$sess_data['login'] = $login;
$sess_data['password'] = $password;
$_SESSION[$id] = $sess_data;
session_commit();

return json_encode($user);

function parseId($string)
{
    $b = stristr($string, "?");
    $c = substr($b, 1);

    $output = array();
    parse_str($c, $output);

    return $output['UserId'];
}