<?php

include 'classes/Inventory1.php';

$inventory = new Inventory1();
$inventory->countFreshIngredientsCountFromFile(__DIR__ . '/input');
