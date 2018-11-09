<?php
session_start();

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);

echo $id;
echo $_SESSION[$id];

$s = $_SESSION[$id];



echo $s['login'];
echo $s['password'];
