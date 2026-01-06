<?php

class IdsChecker2
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

	public function showInvalidIdsSum(): void
	{
		echo "Adding up all the invalid IDs in this example produces {$this->sum}.";
	}
}

// Main block
$checker = new IdsChecker2();
$checker->processRangesFile(__DIR__ . '/input');
$checker->showInvalidIdsSum();
