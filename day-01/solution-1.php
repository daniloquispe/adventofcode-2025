<?php

include 'classes/Safe1.php';

$safe = new Safe1();
$safe->unlockPasswordFromFile(__DIR__ . '/input');
