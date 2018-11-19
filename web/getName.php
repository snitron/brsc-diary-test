<?php
require __DIR__ . "/../vendor/autoload.php";

use Snoopy\Snoopy;
use DiDom\Document;

class PersonOld {
    public $name = "";
    public $img = "";
}

class Person {
    public $child_ids = array();
    public $name = "";
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
        $person = new Person();

        if ($option == "one") {
            $person->child_ids = null;
            $userID = filter_input(INPUT_GET, "child_ids", FILTER_SANITIZE_STRING);
            $snoopy->submit("https://edu.brsc.ru/user/diary/diaryresult?UserId=" . $userID);
            $html = new Document($snoopy->results);

            $person->name = trim(parseName($html->find("tr")[0]->find("th")[0]->text()));

           echo json_encode($person);
        } else {
            $child_ids = json_decode(filter_input(INPUT_GET, "child_ids", FILTER_SANITIZE_STRING));

            for ($i = 0; $i < count($child_ids); $i++) {
                $snoopy->submit("https://edu.brsc.ru/user/diary/diaryresult?UserId=" . $child_ids[$i]);
                $html = new Document($snoopy->results);

                $person->child_ids[$i] = trim(parseName($html->find("tr")[0]->find("th")[0]->text()));

                if($i == count($child_ids) - 1)
                    $person->name = trim($html->find("div.pull-right")[0]->find("h5")[0]->text());
            }

            echo json_encode($person);
        }
    } else {
        $userID = filter_input(INPUT_GET, "child_ids", FILTER_SANITIZE_STRING);
        $snoopy->submit("https://edu.brsc.ru/user/diary/diaryresult?UserId=" . $userID);
        $html = new Document($snoopy->results);
        $result = new PersonOld();
        $result->name = trim(parseName($html->find("tr")[0]->find("th")[0]->text()));
        $result->img = $html->find("span.pull-left")[1]->first("img")->attr("src");
        echo json_encode($result);
    }
}

function parseName($string)
{
    return prepareName(substr($string, 0, strpos($string, ',')));
}

function prepareName($string){
    if($string{0} == '"')
        $string = substr($string, 1);

    if($string{strlen($string) - 1} == '"')
        $string = substr($string, 0, strlen($string) - 1);

    return $string;
}