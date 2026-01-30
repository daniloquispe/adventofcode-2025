<?php

include 'classes/BatteryBanksSet2.php';

// Main block
$checker = new BatteryBanksSet2();
$checker->findLargestJoltageFromFile(__DIR__ . '/input');
