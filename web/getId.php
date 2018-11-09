<?php
require __DIR__ . "/../vendor/autoload.php";

use Snoopy\Snoopy;
use \DiDom\Document;

$headers = getallheaders();
if ($headers['User-Agent'] == 'Nitron Apps BRSC Diary Http Connector') {
    $login = filter_input(INPUT_GET, "login", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_GET, "password", FILTER_SANITIZE_STRING);

    $snoopy = new Snoopy();

    $post_array = array();
    $post_array['Login'] = $login;
    $post_array['Password'] = $password;

    $snoopy->maxredirs = 2;
    $snoopy->submit("https://edu.brsc.ru/Logon/Index", $post_array);
    $snoopy->results;

    $snoopy->submit("https://edu.brsc.ru/User/Diary");
    $html = new Document($snoopy->results);

    echo parseId($html->find("a.h5")[0]->getAttribute("href"));

}
function parseId($string)
{
    $b = stristr($string, "?");
    $c = substr($b, 1);

    $output = array();
    parse_str($c, $output);

    return $output['UserId'];
}