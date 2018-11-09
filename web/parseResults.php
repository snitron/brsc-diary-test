<?php
require __DIR__ . "/../vendor/autoload.php";

use Snoopy\Snoopy;
use DiDom\Document;

class Result
{
    public $lesson = "";
    public $m1 = "";
    public $m2 = "";
    public $m3 = "";
    public $m4 = "";
    public $y = "";
    public $res = "";
    public $isHalfYear = false;
}

$headers = getallheaders();
if ($headers['User-Agent'] == 'Nitron Apps BRSC Diary Http Connector') {
    $login = filter_input(INPUT_GET, "login", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_GET, "password", FILTER_SANITIZE_STRING);
    $userID = filter_input(INPUT_GET, "userID", FILTER_SANITIZE_STRING);

    $snoopy = new Snoopy();

    $post_array = array();
    $post_array['Login'] = $login;
    $post_array['Password'] = $password;

    $snoopy->maxredirs = 2;
    $snoopy->submit("https://edu.brsc.ru/Logon/Index", $post_array);
    $snoopy->results;

    $snoopy->submit("https://edu.brsc.ru/user/diary/diaryresult?UserId=" . $userID);
    $html = new Document($snoopy->results);

    $tables = $html->find("table");
    $results = array();

    $trS = $tables[0]->find("tr");

    for ($i = 2; $i < count($trS); $i++) {
        $tdS = $trS[$i]->find("td");
        $result = new Result();

        for ($j = 0; $j < count($tdS); $j++) {
            switch ($j) {
                case 1:
                    $result->lesson = strip_tags($tdS[$j]->text());
                    break;
                case 2:
                    $result->m1 = strip_tags($tdS[$j]->text());
                    break;
                case 3:
                    $result->m2 = strip_tags($tdS[$j]->text());
                    break;
                case 4:
                    $result->m3 = strip_tags($tdS[$j]->text());
                    break;
                case 5:
                    $result->m4 = strip_tags($tdS[$j]->text());
                    break;
                case 6:
                    $result->y = strip_tags($tdS[$j]->text());
                    break;
                case 7:
                    $result->res = strip_tags($tdS[$j]->text());
                    break;
                default:
                    break;
            }
        }

        $results[$i - 2] = $result;
    }


    if (count($tables) == 2) {
        $trS = $tables[1]->find("tr");
        $length = count($results);
        for ($i = $length + 1; $i < count($trS) + $length; $i++) {
            $tdS = $trS[$i - $length]->find("td");
            $result = new Result();
            for ($j = 0; $j < count($tdS); $j++) {
                switch ($j) {
                    case 1:
                        $result->lesson = strip_tags($tdS[$j]->text());
                        break;
                    case 2:
                        $result->m1 = strip_tags($tdS[$j]->text());
                        break;
                    case 3:
                        $result->m2 = strip_tags($tdS[$j]->text());
                        break;
                    case 4:
                        $result->y = strip_tags($tdS[$j]->text());
                        break;
                    case 5:
                        $result->res = strip_tags($tdS[$j]->text());
                        break;
                    default:
                        break;
                }
            }
            $result->isHalfYear = true;
            $results[$i - 1] = $result;
        }
    }

    echo json_encode($results);

}