<?php

include 'BatteryBanksSet1.php';

/**
 * A full set of batteries [day 3, part 2].
 *
 * You need to turn on a certain combination of batteries in each bank to get the largest possible "joltage".
 *
 * Check the {@see ../puzzle.md} file for more details.
 *
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 */
class BatteryBanksSet2 extends BatteryBanksSet1
{
	/**
	 * Find and add the largest possible joltage a single battery bank can produce.
	 *
	 * The bank is a series of digits (0 to 9). Each digit represents the joltage a single battery can produce.
	 *
	 * Obtained value is added to the {@see $maxJoltage accumulator}.
	 *
	 * @uses $maxJoltage Update the max sum accumulator
	 * @uses getDigits()
	 */
	protected function addLargestJoltageFromBatteryBank(string $bank): void
	{
		$bank = trim($bank);

		$max = $this->getDigits($bank);
		$this->maxJoltage += (int)$max;

		echo "- Bank: $bank -> Max: $max" . PHP_EOL;
	}

	/**
	 * Get all 12 digits of largest joltage configuration.
	 */
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
				$digit--;
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
}
