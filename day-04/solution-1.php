<?php

include 'classes/PaperRollsGrid1.php';

$grid = new PaperRollsGrid1();
$grid->findAccesibleRollsCountFromFile(__DIR__ . '/input');
