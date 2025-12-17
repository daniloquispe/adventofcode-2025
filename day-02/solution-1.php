<?php

class IdsChecker
{
	private int $sum = 0;

	public function processRangesFile(string $filename): void
	{
		echo "Processing file $filename..." . PHP_EOL;

		$ranges = file($filename);
		$ranges = explode(',', $ranges[0]);

		foreach ($ranges as $range)
			$this->processRange($range);
	}

	private function processRange(string $range): void
	{
		echo "- $range";

		list($start, $end) = explode('-', $range);

		for ($id = $start; $id <= $end; $id++)
		{
			if ($this->isInvalidId($id))
				$this->sum += $id;
		}

		echo " -> {$this->sum}";
		echo PHP_EOL;
	}

	private function isInvalidId(int $id): bool
	{
		if (strlen($id) % 2 != 0)
			return false;

		$halfLength = strlen($id) / 2;

		$firstHalf = substr($id, 0, $halfLength);
		$secondHalf = substr($id, $halfLength);

		return strcmp($firstHalf, $secondHalf) == 0;
	}

	public function showInvalidIdsSum(): void
	{
		echo "Adding up all the invalid IDs in this example produces {$this->sum}.";
	}
}

// Main block
$checker = new IdsChecker();
$checker->processRangesFile(__DIR__ . '/input-example');
$checker->showInvalidIdsSum();
