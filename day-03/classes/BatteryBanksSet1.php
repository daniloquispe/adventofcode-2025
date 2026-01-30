<?php

/**
 * A full set of batteries [day 3, part 1].
 *
 * You need to turn on a certain combination of batteries in each bank to get the largest possible "joltage".
 *
 * Check the {@see ../puzzle.md} file for more details.
 *
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 */
class BatteryBanksSet1
{
	/**
	 * Max joltage sum that all batteries can generate
	 */
	protected int $maxJoltage;

	/**
	 * Find the max voltage sum that all batteries can generate from a text file.
	 *
	 * The file contains the complete configuration of the batteries, organized in banks (one bank per line).
	 *
	 * @uses $maxJoltage Initialize the max sum accumulator
	 * @uses addLargestJoltageFromBatteryBank()
	 */
	public function findLargestJoltageFromFile(string $filename): void
	{
		$this->maxJoltage = 0;

		echo "Processing file $filename..." . PHP_EOL;
		$banks = file($filename);

		foreach ($banks as $bank)
			$this->addLargestJoltageFromBatteryBank($bank);

		echo "The max joltage sum is {$this->maxJoltage}." . PHP_EOL;
	}

	/**
	 * Find and add the largest possible joltage a single battery bank can produce.
	 *
	 * The bank is a series of digits (0 to 9). Each digit represents the joltage a single battery can produce. To get
	 * the largest joltage, you need to turn on 2 batteries (or select 2 digits)
	 *
	 * Obtained value is added to the {@see $maxJoltage accumulator}.
	 *
	 * @uses $maxJoltage Update the max sum accumulator
	 * @uses getFirstDigitPosition()
	 * @uses getSecondDigit()
	 */
	protected function addLargestJoltageFromBatteryBank(string $bank): void
	{
		$bank = trim($bank);

		// First digit
		$firstDigitPosition = $this->getFirstDigitPosition($bank);
		$firstDigit = $bank[$firstDigitPosition];

		// Second digit
		$secondDigit = $this->getSecondDigit($bank, $firstDigitPosition);

		$max = $firstDigit . $secondDigit;
		$this->maxJoltage += (int)$max;

		echo "- Bank: $bank -> Max: $max" . PHP_EOL;
	}

	/**
	 * Get the position of the first digit of max joltage configuration.
	 *
	 * With this position, you can easily get the first digit of max joltage configuration:
	 *
	 *     $bank = '1234567890';
	 *
	 *     $position = $this->>getFirstDigitPosition($bank);
	 *     $firstDigit = $bank[$position];
	 *
	 * @see getSecondDigit()
	 */
	private function getFirstDigitPosition(string $bank): int
	{
		$bank = substr($bank, 0, strlen($bank) - 1);

		for ($digit = 9; $digit >= 0; $digit--)
		{
			$position = strpos($bank, $digit);

			if ($position !== false)
				return $position;
		}

		return -1;
	}

	/**
	 * Get the second digit of max joltage configuration
	 *
	 * @see getFirstDigitPosition()
	 */
	private function getSecondDigit(string $bank, int $firstDigitPosition): int|null
	{
		$bank = substr($bank, $firstDigitPosition + 1);

		for ($digit = 9; $digit >= 0; $digit--)
		{
			$position = strpos($bank, $digit);

			if ($position !== false)
				return $digit;
		}

		return null;
	}
}
