<?php
require __DIR__ . "/../vendor/autoload.php";

use Snoopy\Snoopy;
use \DiDom\Document;
use Behat\Mink\Session;
use Behat\Mink\Driver\GoutteDriver;

    $login = filter_input(INPUT_GET, "login", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_GET, "password", FILTER_SANITIZE_STRING);

   /* $snoopy = new Snoopy();

    $post_array = array();
    $post_array['Login'] = $login;
    $post_array['Password'] = $password;

    $snoopy->maxredirs = 2;
    $snoopy->submit("https://edu.brsc.ru/Logon/Index", $post_array);
    $snoopy->results;

    $snoopy->submit("https://edu.brsc.ru/User/Diary");
    $html = new Document($snoopy->results);

    $id = parseId($html->find("a.h5")[0]->getAttribute("href"));*/

    require "User.php";

    $id = 123456;
    
    if($id == ""){
        echo "";
        session_register_shutdown();
    }else{
        echo $id;

        $user = new User();
        $user->login = $login;
        $user->password = $password;
        $user->child_ids = null;

        $_SESSION[$id . ""] = json_encode($user);
    }



function parseId($string)
{
    $b = stristr($string, "?");
    $c = substr($b, 1);

    $output = array();
    parse_str($c, $output);

    return $output['UserId'];
}