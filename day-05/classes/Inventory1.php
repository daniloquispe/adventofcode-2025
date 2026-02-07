<?php

/**
 * Inventory of ingredients in the cafeteria [day 5, part 1].
 *
 * Not all the ingredients are fresh. However, the new inventory management system makes it complicated to figure out
 * which ones are fresh and which ones are spoiled.
 *
 * Check the {@see ../puzzle.md} file for more details.
 *
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 */
class Inventory1
{
	/**
	 * List of fresh ingredients IDs ranges.
	 *
	 * Each range is represented as a string in the format `min-max`, where `min` and `max` are the lower and upper
	 * bounds of the range, respectively.
	 *
	 * @var string[]
	 */
	private array $freshIdRanges;

	/**
	 * List of available ingredient IDs
	 *
	 * @var int[]
	 */
	private array $availableIds;

	/**
	 * Count of fresh ingredients in the inventory.
	 */
	private int $freshIngredientsCount;

	/**
	 * Load the ingredients database from a plain-text file and count how many fresh ingredients are in the inventory.
	 */
	public function countFreshIngredientsCountFromFile(string $filename): void
	{
		$this->loadDatabaseFromFile($filename);
		$this->countFreshIngredients();

		echo "There are {$this->freshIngredientsCount} fresh ingredients in the inventory." . PHP_EOL;
	}

	/**
	 * Load the ingredients database from a plain-text file.
	 *
	 * File structure is:
	 *
	 * 1. A list of fresh ingredients ranges, separated by newlines. Each range is represented as `min-max`, where `min`
	 *    and `max` are the lower and upper bounds of the range, respectively.
	 * 2. A separator (blank line)
	 * 3. A list of available ingredient IDs, separated by newlines. Each ID is an integer number.
	 */
	private function loadDatabaseFromFile(string $filename): void
	{
		echo "Processing file $filename..." . PHP_EOL;
		$lines = file($filename);
		$lines = array_map('trim', $lines);

		$linesCount = count($lines);

		$separatorPosition = array_search('', $lines);

		// Load fresh ingredient ID ranges
		for ($i = 0; $i < $separatorPosition; $i++)
			$this->freshIdRanges[] = $lines[$i];

		// Load available ingredient IDs
		for ($i = $separatorPosition + 1; $i < $linesCount; $i++)
			$this->availableIds[] = (int)$lines[$i];
	}

	/**
	 * Count the available ingredients in the inventory that are fresh.
	 *
	 * An ingredient is fresh if its ID is within any range of fresh IDs.
	 *
	 * @see $freshIdRanges
	 */
	private function countFreshIngredients(): void
	{
		$this->freshIngredientsCount = 0;

		foreach ($this->availableIds as $id)
		{
			$freshRange = $this->getFreshRange($id);

			if ($freshRange !== null)
			{
				$this->freshIngredientsCount++;
				echo "- ID $id is fresh because it falls into range $freshRange.";
			}
			else
				echo "- ID $id is spoiled.";

			echo PHP_EOL;
		}
	}

	/**
	 * Indicate if an ingredient is fresh or spoiled.
	 *
	 * An ingredient is fresh if its ID is within any range of fresh IDs.
	 *
	 * @return string|null If the ingredient is fresh, return the first range of fresh ingredients IDs that contains the
	 * ingredient ID. If the ingredient is spoiled, return `null`.
	 * @see $freshIdRanges
	 */
	private function getFreshRange(int $id): string|null
	{
		foreach ($this->freshIdRanges as $range)
		{
			list($min, $max) = explode('-', $range);

			if ($id >= $min && $id <= $max)
				return $range;
		}

		return null;
	}
}
