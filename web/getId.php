<?php
require __DIR__ . "/../vendor/autoload.php";
require "User.php";

use Snoopy\Snoopy;
use \DiDom\Document;

$headers = getallheaders();
//if ($headers['User-Agent'] == 'Nitron Apps BRSC Diary Http Connector') {
$login = filter_input(INPUT_GET, "login", FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_GET, "password", FILTER_SANITIZE_STRING);
$version = filter_input(INPUT_GET, "version", FILTER_SANITIZE_STRING);

if ($version != null) { //for eldery version support. delete in the future
  //  session_start();

    $snoopy = new Snoopy();

    $post_array = array();
    $post_array['Login'] = $login;
    $post_array['Password'] = $password;

    $snoopy->maxredirs = 2;
    $snoopy->submit("https://edu.brsc.ru/Logon/Index", $post_array);
    $snoopy->submit("https://edu.brsc.ru/User/Diary");

    $html = new Document($snoopy->results);

    $user = new User();
    $check_login = $html->find("tr");
    if (count($check_login) != 0) {
        $check = $html->find("th");
        $child_ids = $html->find("ul.dropdown-menu")[1]->find("li");
       /* if (count($child_ids) != 0) {
            $child_ids = $child_ids[0]->find("a");
            if (count($child_ids) != 0) {
                for ($i = 0; $i < count($child_ids); $i++)
                    $user->child_ids[$i] = parseId($child_ids[$i]->getAttribute("href"));
                $user->id = null;
                $user->parent_id = parseId($html->find("a.h5")[0]->getAttribute("href"));
                $user->sess_index = "user_index" . $user->child_ids[0];
            } else {
                $user->child_ids = null;
                $user->id = parseId($html->find("a.h5")[0]->getAttribute("href"));
                $user->sess_index = "user_index" . $user->id;
                $user->parent_id = null;
            }*/

       $user->child_ids[0] = parseId($html->find("a.h5")[0]->getAttribute("href"));

       if(count($check) != 0){
           for($i = 1; $i < count($child_ids) + 1; $i++)
               $user->child_ids[$i] = parseId($child_ids[$i - 1]->find("a")[0]->getAttribute("href"));

           $user->id = null;
           $user->sess_index = "user_index" . $user->id;
           $user->parent_id = $user->parent_id[0];
        } else {
            $user->child_ids = null;
            $user->id = parseId($html->find("a.h5")[0]->getAttribute("href"));
            $user->sess_index = "user_index" . $user->id;
            $user->parent_id = null;
        }

        $user->sess_id = "PHPSESSID=" . session_id();
/*
        $sess_data = array();

        $sess_data['login'] = $login;
        $sess_data['password'] = $password;
        $_SESSION[$id] = $sess_data;*/

    } else
        $user = null;


    echo json_encode($user);
    echo $html->html();
} else {
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
//}
}

function parseId($string)
{
    $b = stristr($string, "?");
    $c = substr($b, 1);

    $output = array();
    parse_str($c, $output);

    return $output['UserId'];
}