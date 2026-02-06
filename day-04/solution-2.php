<?php

include 'classes/PaperRollsGrid2.php';

$grid = new PaperRollsGrid2();
$grid->findAccesibleRollsCountFromFile(__DIR__ . '/input');
