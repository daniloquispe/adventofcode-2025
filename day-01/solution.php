<?php

class Safe
{
	private readonly int $dialPositions;

	private int $zeroes;

	public function __construct(private readonly int $dialMin = 0, private readonly int $dialMax = 99, private int $dialPosition = 50)
	{
		echo "The dial starts by pointing at {$this->dialPosition}." . PHP_EOL;

		$this->dialPositions = $this->dialMax - $this->dialMin + 1;

		$this->zeroes = 0;
	}

	private function rotateDial(string $rotation): void
	{
		// Sanitize rotation string
		$rotation = trim(strtoupper($rotation));

		$direction = $rotation[0];  // L or R
		$distance = (int)substr($rotation, 1);

		// Rotate
		$this->dialPosition = match ($direction)
		{
			'L' => $this->dialPosition - $distance,
			'R' => $this->dialPosition + $distance,
		};

		$this->checkZeroes();

		echo "- The dial is rotated $rotation to point at {$this->dialPosition}." . PHP_EOL;
	}

	public function processRotationsFile(string $filename): void
	{
		$lines = file($filename);

		foreach ($lines as $line)
			$this->rotateDial($line);
	}

	private function checkZeroes(): void
	{
		// Dial out of bounds?
		if ($this->dialPosition > $this->dialMax)
			while ($this->dialPosition > $this->dialMax)
				$this->dialPosition -= $this->dialPositions;
		elseif ($this->dialPosition < $this->dialMin)
			while ($this->dialPosition < $this->dialMin)
				$this->dialPosition += $this->dialPositions;

		// Dial at Zero?
		if ($this->dialPosition == 0)
			$this->zeroes++;
	}

	public function showPassword(): void
	{
		echo "The password is: {$this->zeroes}" . PHP_EOL;
	}
}

// Main block
$safe = new Safe();
$safe->processRotationsFile(__DIR__ . '/input');
$safe->showPassword();
