<?php

include 'classes/MathWorksheet1.php';

$worksheet = new MathWorksheet1();
$worksheet->calculateGrandTotalFromFile(__DIR__ . '/input');
