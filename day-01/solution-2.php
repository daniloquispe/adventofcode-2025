<?php

class Safe2
{
	private readonly int $dialPositions;

	private int $zeroes;

	public function __construct(private readonly int $dialMin = 0, private readonly int $dialMax = 99, private int $dialPosition = 50)
	{
		echo "The dial starts by pointing at {$this->dialPosition}." . PHP_EOL;

		$this->dialPositions = $this->dialMax - $this->dialMin + 1;

		$this->zeroes = 0;
	}

	private function processRotation(string $rotation): void
	{
		// Sanitize rotation string
		$rotation = trim(strtoupper($rotation));

		$direction = $rotation[0];  // L or R
		$distance = (int)substr($rotation, 1);

		// Rotate
		$this->rotateDial($direction, $distance);

		echo "- The dial is rotated $rotation to point at {$this->dialPosition}." . PHP_EOL;
	}

	public function processRotationsFile(string $filename): void
	{
		echo "Processing file $filename..." . PHP_EOL;

		$lines = file($filename);

		foreach ($lines as $line)
			$this->processRotation($line);
	}

	private function rotateDial(string $direction, int $distance): void
	{
		$newPosition = $this->dialPosition;
		$zeroes = 0;

		while ($distance >= $this->dialPositions)
		{
			$distance -= $this->dialPositions;
			$zeroes++;
		}

		// Rotate right?
		if ($direction == 'R')
		{
			$newPosition = $this->dialPosition + $distance;

			if ($newPosition > $this->dialMax)
			{
				$newPosition -= $this->dialPositions;

				if ($this->dialPosition != 0)
					$zeroes++;
			}
		}
		// Rotate left?
		elseif ($direction == 'L')
		{
			$newPosition = $this->dialPosition - $distance;

			if ($newPosition <= $this->dialMin)
			{
				if ($newPosition < $this->dialMin)
					$newPosition += $this->dialPositions;

				if ($this->dialPosition != 0)
					$zeroes++;
			}
		}

		$this->dialPosition = $newPosition;
		$this->zeroes += $zeroes;
	}

	public function showPassword(): void
	{
		echo "The password is: {$this->zeroes}" . PHP_EOL;
	}
}

// Main block
$safe = new Safe2();
$safe->processRotationsFile(__DIR__ . '/input');
$safe->showPassword();
