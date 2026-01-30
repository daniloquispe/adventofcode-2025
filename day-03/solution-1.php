<?php

include 'classes/BatteryBanksSet1.php';

// Main block
$checker = new BatteryBanksSet1();
$checker->findLargestJoltageFromFile(__DIR__ . '/input');
