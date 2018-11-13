<?php
require __DIR__ . "/../vendor/autoload.php";

use Snoopy\Snoopy;
use DiDom\Document;

class Person
{
    public $name = "";
    public $img = "";
}

$headers = getallheaders();
if ($headers['User-Agent'] == 'Nitron Apps BRSC Diary Http Connector') {

    $login = filter_input(INPUT_GET, "login", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_GET, "password", FILTER_SANITIZE_STRING);
    $version = filter_input(INPUT_GET, "version", FILTER_SANITIZE_STRING);

    $snoopy = new Snoopy();

    $post_array = array();
    $post_array['Login'] = $login;
    $post_array['Password'] = $password;

    $snoopy->maxredirs = 2;
    $snoopy->submit("https://edu.brsc.ru/Logon/Index", $post_array);
    $snoopy->results;

    if ($version != null) {
        $option = filter_input(INPUT_GET, "option", FILTER_SANITIZE_STRING);

        if ($option == "one") {
            $userID = filter_input(INPUT_GET, "child_ids", FILTER_SANITIZE_STRING);
            $snoopy->submit("https://edu.brsc.ru/user/diary/diaryresult?UserId=" . $userID);
            $html = new Document($snoopy->results);

           $name = parseName($html->find("tr")[0]->find("th")[0]->text());

           echo trim($name);
        } else {
            $child_ids = json_decode(filter_input(INPUT_GET, "child_ids", FILTER_SANITIZE_STRING));

            $names = array();

            for ($i = 0; $i < count($child_ids); $i++) {
                $snoopy->submit("https://edu.brsc.ru/user/diary/diaryresult?UserId=" . $userID);
                $html = new Document($snoopy->results);

                $names = parseName($html->find("tr")[0]->find("th")[0]->text());
            }

            echo json_encode($names);
        }
    } else {
        $userID = filter_input(INPUT_GET, "child_ids", FILTER_SANITIZE_STRING);
        $snoopy->submit("https://edu.brsc.ru/user/diary/diaryresult?UserId=" . $userID);
        $html = new Document($snoopy->results);
        $result = new Person();
        $result->name = trim(parseName($html->find("tr")[0]->find("th")[0]->text()));
        $result->img = $html->find("span.pull-left")[1]->first("img")->attr("src");
        echo json_encode($result);
    }
}

function parseName($string)
{
    return substr($string, 0, strpos($string, ','));
}