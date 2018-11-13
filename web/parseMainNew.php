<?php

require __DIR__ . "/../vendor/autoload.php";

use Snoopy\Snoopy;
use DiDom\Document;

class DaySheldule
{
    public $count = 0;
    public $lessons = array();
    public $homeworks = array();
    public $marks = array();
    public $isWeekend = false;
    public $dayName = "";
    public $teacherComment = array();
    public $hrefHw = array(
        array()
    );
    public $hrefHwNames = array(
        array()
    );
}
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('session.gc_maxlifetime', 0);
ini_set('session.cookie_lifetime', 0);
session_set_cookie_params(0);

ini_set('session.use_cookies', 1);

session_start();

$userID = filter_input(INPUT_POST, 'userID', FILTER_SANITIZE_STRING);
$version = filter_input(INPUT_POST, 'version', FILTER_SANITIZE_STRING);
$snoopy = new Snoopy();

if($version != null){
    $sess_index = filter_input(INPUT_POST, 'sess_index', FILTER_SANITIZE_STRING);

    $data = $_SESSION[$sess_index];

    $post_array = array();
    $post_array['Login'] = $data['login'];
    $post_array['Password'] = $data['password'];
} else{
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $post_array['Login'] = $login;
    $post_array['Password'] = $password;
}


$snoopy->maxredirs = 2;
$snoopy->submit("https://edu.brsc.ru/Logon/Index", $post_array);
$snoopy->results;

$week = filter_input(INPUT_POST, "week", FILTER_SANITIZE_STRING);
$snoopy->submit("https://edu.brsc.ru/User/Diary?UserId=" . $userID . "&Week=" . $week . "&dep=0");

$html = new Document($snoopy->results);

$elements = $html->find("table");
$days = array();

$daysNames = $html->find("div > h3");

for ($i = 0; $i < count($elements); $i++) {
    $day = new DaySheldule();

    $trS = $elements[$i]->find("tr.tableborder");
    $day->isWeekend = false;
    $day->count = count($trS);

    for ($j = 0; $j < count($trS); $j++) {
        $wasEmpty = false;

        $day->lessons[$j] = count($trS[$j]->find("div[title]")) != 0 ? strip_tags($trS[$j]->find("div[title]")[0]->text()) : $wasEmpty = true;

        if ($wasEmpty) {
            $day->isWeekend = true;
            $day->count = 1;
            break;
        }

        $marks = $trS[$j]->find("td")[4]->text();

        if (strlen($marks) != 0)
            $day->marks[$j] = strip_tags($marks);
        else
            $day->marks[$j] = "";

        $tmp_hw = $trS[$j]->find('td[data-lessonid]')[0]->text();

        if (strlen($tmp_hw) != 0)
            $day->homeworks[$j] = strip_tags($tmp_hw);
        else
            $day->homeworks[$j] = "";

        $a = $trS[$j]->find('td[data-lessonid]')[0]->find('a');

        if (count($a) != 0) {
            for ($k = 1; $k < count($a); $k++)
                if ($a[$k] != null && $a[$k]->attr('href') != "#" && $a[$k]->attr('href') != "") {
                    $day->hrefHw[$j][$k - 1] = $a[$k]->attr("href");
                    $day->hrefHwNames[$j][$k - 1] = trim(strip_tags($a[$k]->text()));
                } else {
                    $day->hrefHw[$j][$k - 1] = null;
                    $days->hrefHwNames[$j][$k - 1] = null;
                }
        } else {
            $day->hrefHw[$j] = null;
            $day->hrefHwNames[$j] = null;
        }

        $day->teacherComment[$j] = trim($trS[$j]->find("td")[5]->text()) != "" ? trim($trS[$j]->find("td")[5]->text()) : null;

        array_filter($day->hrefHw[$j], function ($value) {
            return $value !== '' && $value !== null;
        });
    }


    $day->dayName = strip_tags($daysNames[$i + 1]->text());
    $days[$i] = $day;
}
echo json_encode($days);

session_commit();

