<?php

include 'classes/Safe2.php';

$safe = new Safe2();
$safe->unlockPasswordFromFile(__DIR__ . '/input');
