<?php

include 'classes/Inventory2.php';

$inventory = new Inventory2();
$inventory->countFreshIngredientsCountFromFile(__DIR__ . '/input');
