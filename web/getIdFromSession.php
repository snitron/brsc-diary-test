<?php

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);

session_start();

$s = $_SESSION[$id . ""];

echo $s['login'];
echo $s['password'];
