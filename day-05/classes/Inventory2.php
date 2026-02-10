<?php

include 'Inventory1.php';

/**
 * Inventory of ingredients in the cafeteria [day 5, part 2].
 *
 * Not all the ingredients are fresh. However, the new inventory management system makes it complicated to figure out
 * which ones are fresh and which ones are spoiled.
 *
 * Check the {@see ../puzzle.md} file for more details.
 *
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 */
class Inventory2 extends Inventory1
{
	/**
	 * Count all fresh ingredient ID in the inventory.
	 *
	 * This method counts all IDs contained in the {@see $freshIdRanges list of fresh IDs}. However, some of these
	 * ranges overlap, so they must be "reduced" to avoid overlapping and, therefore, counting the same ingredient more
	 * than once.
	 *
	 * The list of available ingredients (used in the {@see Inventory1::countFreshIngredients() part-1 solution}) is
	 * ignored in this version.
	 *
	 * @see $freshIdRanges
	 */
	protected function countFreshIngredients(): void
	{
		// Array of "reduced" ranges (it avoids ranges overlapping)
		$reducedRanges = [];

		foreach ($this->freshIdRanges as $range)
		{
			$isRedundant = false;

			for ($i = 0; $i < count($reducedRanges); $i++)
			{
				$reducedRange = $reducedRanges[$i];

				// Overlapping test 1:
				// If the current range is fully contained by previously analyzed ranges
				if ($this->contains($reducedRange, $range))
				{
					$isRedundant = true;
					break;
				}

				// Overlapping test 2:
				// If the current range fully contains a previously analyzed range
				if ($this->contains($range, $reducedRange))
				{
					// The current range replaces the overlapped one
					$reducedRanges = array_replace($reducedRanges, [$i => $range]);

					$isRedundant = true;
					break;
				}

				list($min, $max) = explode('-', $range);
				list($reducedMin, $reducedMax) = explode('-', $reducedRange);

				// Overlapping test 3:
				// If the current range partially overlaps a previously analyzed range,
				// current range boundaries are adjusted to avoid overlapping
				if ($min >= $reducedMin && $min <= $reducedMax)
					$min = (int)$reducedMax + 1;
				if ($max <= $reducedMax && $max >= $reducedMin)
					$max = (int)$reducedMin - 1;

				$range = "$min-$max";
			}

			if ($isRedundant)
				continue;

			$reducedRanges[] = $range;
		}

		$this->freshIngredientsCount = 0;

		// Count fresh ingredients using reduced (not overlapped) ranges
		foreach ($reducedRanges as $range)
		{
			list($min, $max) = explode('-', $range);
			$this->freshIngredientsCount += ((int)$max - $min + 1);
		}
	}

	/**
	 * Indicate if the first range contains the second one.
	 *
	 * Each range is represented as `min-max`, where `min` and `max` are the lower and upper bounds of the range,
	 * respectively.
	 */
	private function contains(string $range1, string $range2): bool
	{
		list($min1, $max1) = explode('-', $range1);
		list($min2, $max2) = explode('-', $range2);

		return $min1 <= $min2 && $max1 >= $max2;
	}
}
