<?php

include 'IdsChecker1.php';

/**
 * IDs checker for gift shop (day 2, part 2).
 *
 * Someone has entered invalid IDs into the shop's database. This class can detect all invalid IDs and calculate the
 * sum of all of them.
 *
 * Check the {@see ../puzzle.md} file for more details.
 *
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 */
class IdsChecker2 extends IdsChecker1
{
	/**
	 * Check if an ID is invalid.
	 *
	 * A numeric ID is invalid if it's made only of some sequence of digits repeated at least twice.
	 *
	 * Examples:
	 * - 5 is valid (number 5 only 1 time)
	 * - 11 is invalid (number 1 twice)
	 * - 4545 is invalid (number 45 twice)
	 * - 123123 is invalid (number 123 twice)
	 * - 1230123 is valid (number 123 twice, but number 0 not repeated)
	 *
	 * Now that definition of invalid ID changed, compared to part-1 solution, there could be IDs that are valid for
	 * part 1 but invalid for part 2.
	 *
	 * Examples:
	 *
	 * - 333 is valid for part 1 (number 3 more than twice), but invalid for part 2 (number 3 repeated 3 times)
	 * - 77777 is valid for part 1 (number 77 twice but one remaining 7 not repeated), but invalid for part 2
	 *   (number 7 repeated 5 times)
	 */
	protected function isInvalidId(int $id): bool
	{
		$length = strlen($id);

		$halfLength = strlen($id) / 2;

		for ($patternLength = 1; $patternLength <= $halfLength; $patternLength++)
		{
			$pattern = substr($id, 0, $patternLength);

			if ($length % $patternLength != 0)
				continue;

			$invalidId = str_pad('', $length, $pattern);

			if (!strcmp($id, $invalidId))
				return true;
		}

		return false;
	}
}
