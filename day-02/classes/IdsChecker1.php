<?php

/**
 * IDs checker for gift shop (day 2, part 1).
 *
 * Someone has entered invalid IDs into the shop's database. This class can detect all invalid IDs and calculate the
 * sum of all of them.
 *
 * Check the {@see ../puzzle.md} file for more details.
 *
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 */
class IdsChecker1
{
	/**
	 * Sum of all invalid IDs
	 */
	protected int $sum = 0;

	/**
	 * Sum all invalid IDs from a text file.
	 *
	 * The file contains a list of ID ranges, separated by commas (,).
	 */
	public function sumInvalidIdsFromFile(string $filename): void
	{
		echo "Processing file $filename..." . PHP_EOL;

		$ranges = file($filename);
		$ranges = explode(',', $ranges[0]);

		foreach ($ranges as $range)
			$this->processRange($range);

		echo "Adding up all the invalid IDs in this example produces {$this->sum}.";
	}

	/**
	 * Process a single IDs range.
	 *
	 * @uses $sum
	 * @uses isInvalidId()
	 */
	protected function processRange(string $range): void
	{
		echo "- Range: $range";

		list($start, $end) = explode('-', $range);

		for ($id = $start; $id <= $end; $id++)
		{
			if ($this->isInvalidId($id))
				$this->sum += $id;
		}

		echo " -> Sum: {$this->sum}" . PHP_EOL;
	}

	/**
	 * Check if an ID is invalid.
	 *
	 * A numeric ID is invalid if it's made only of some sequence of digits repeated exactly twice.
	 *
	 * Examples:
	 * - 5 is valid (number 5 only 1 time)
	 * - 11 is invalid (number 1 twice)
	 * - 4545 is invalid (number 45 twice)
	 * - 123123 is invalid (number 123 twice)
	 * - 333 is valid (number 3 more than twice)
	 * - 1230123 is valid (number 123 twice, but number 0 not repeated)
	 */
	protected function isInvalidId(int $id): bool
	{
		// If a number is repeated 2 times, the resulting ID will always have an even length, so
		// if ID length is odd, it will always be valid
		if (strlen($id) % 2 != 0)
			return false;

		$halfLength = strlen($id) / 2;

		$firstHalf = substr($id, 0, $halfLength);
		$secondHalf = substr($id, $halfLength);

		return strcmp($firstHalf, $secondHalf) == 0;
	}
}
