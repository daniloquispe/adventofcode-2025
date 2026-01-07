<?php

class JoltageChecker1
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

		// First digit
		$firstDigitPosition = $this->getFirstDigitPosition($bank);
		$firstDigit = $bank[$firstDigitPosition];

		// Second digit
		$secondDigit = $this->getSecondDigit($bank, $firstDigitPosition);

		$max = $firstDigit . $secondDigit;
		$this->max += $max;

		echo "- $bank -> $max" . PHP_EOL;
	}

	private function getFirstDigitPosition(string $bank): int
	{
		$bank = substr($bank, 0, strlen($bank) - 1);

		for ($i = 9; $i >= 0; $i--)
		{
			$position = strpos($bank, $i);

			if ($position !== false)
				return $position;
		}

		return -1;
	}

	private function getSecondDigit(string $bank, int $firstDigitPosition): int
	{
		$bank = substr($bank, $firstDigitPosition + 1);

		for ($i = 9; $i >= 0; $i--)
		{
			$position = strpos($bank, $i);

			if ($position !== false)
				return $i;
		}

		return -1;
	}

	public function showMaxValue(): void
	{
		echo "The max joltage sum is {$this->max}." . PHP_EOL;
	}
}

// Main block
$checker = new JoltageChecker1();
$checker->processBatteryBanksFile(__DIR__ . '/input');
$checker->showMaxValue();
