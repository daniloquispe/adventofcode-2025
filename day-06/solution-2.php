<?php

include 'classes/MathWorksheet2.php';

$worksheet = new MathWorksheet2();
$worksheet->calculateGrandTotalFromFile(__DIR__ . '/input');
