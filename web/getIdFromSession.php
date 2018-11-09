<?php

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);

session_start();

$s = $_SESSION[$id . ""];

$user = json_decode($u);

echo $user['login'];
echo $user['password'];
