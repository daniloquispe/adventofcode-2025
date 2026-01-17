<?php

class JoltageChecker2
{
	public function __construct(private int $max = 0)
	{
		;
	}

	public function processBatteryBanksFile(string $filename): void
	{
		echo "Processing file $filename..." . PHP_EOL;

		$banks = file($filename);

		foreach ($banks as $bank)
			$this->processBatteryBank($bank);
	}

	private function processBatteryBank(string $bank): void
	{
		$bank = trim($bank);

		$max = $this->getDigits($bank);
		$this->max += $max;

		echo "- Bank: $bank -> Max: $max" . PHP_EOL;
	}

	private function getDigits(string $bank): string
	{
		$digits = '';

		$digit = 9;
		$digitsToFind = 12;

		while ($digitsToFind)
		{
			$position = strpos($bank, $digit);
			if ($position === false)
			{
				$digit--;
				continue;
			}

			$chunk = substr($bank, $position);

			if (strlen($chunk) == $digitsToFind)
			{
				$digits .= $chunk;
				break;
			}
			elseif (strlen($chunk) < $digitsToFind)
			{
				$digit--;
				continue;
			}
			else
			{
				$digits .= $digit;

				$digit = 9;
				$bank = substr($chunk, 1);
				$digitsToFind--;
			}
		}

		return $digits;
	}

	public function showMaxValue(): void
	{
		echo "The max joltage sum is {$this->max}." . PHP_EOL;
	}
}

// Main block
$checker = new JoltageChecker2();
$checker->processBatteryBanksFile(__DIR__ . '/input');
$checker->showMaxValue();
