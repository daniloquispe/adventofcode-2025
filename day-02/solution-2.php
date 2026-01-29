<?php

include 'classes/IdsChecker2.php';

$checker = new IdsChecker2();
$checker->sumInvalidIdsFromFile(__DIR__ . '/input');
