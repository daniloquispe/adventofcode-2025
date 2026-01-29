<?php

include 'classes/IdsChecker1.php';

$checker = new IdsChecker1();
$checker->sumInvalidIdsFromFile(__DIR__ . '/input');
