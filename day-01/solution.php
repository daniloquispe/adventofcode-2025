<?php

const HEAD_START = 50;

class Safe
{
	private readonly int $headMin;
	private readonly int $headMax;
	private readonly int $dialSteps;

	private int $headPosition;

	private int $zeroes;

	public function __construct()
	{
		$this->headMin = 0;
		$this->headMax = 99;

		$this->dialSteps = $this->headMax - $this->headMin + 1;

		$this->headPosition = HEAD_START;

		$this->zeroes = 0;

		echo "The dial starts by pointing at {$this->headPosition}." . PHP_EOL;
	}

	private function rotateDial(string $movement): void
	{
		$movement = trim($movement);

		$direction = $movement[0];  // L or R
		$distance = (int)substr($movement, 1);

		// Rotate
		$this->headPosition = match ($direction)
		{
			'L' => $this->headPosition - $distance,
			'R' => $this->headPosition + $distance,
		};

		$this->checkHeadPositionBounds();

		// Zero?
		if ($this->headPosition == 0)
			$this->zeroes++;

		echo "The dial is rotated $movement to point at {$this->headPosition}." . PHP_EOL;
	}

	private function checkHeadPositionBounds(): void
	{
		if ($this->headPosition > $this->headMax)
			while ($this->headPosition > $this->headMax)
				$this->headPosition -= $this->dialSteps;
		elseif ($this->headPosition < $this->headMin)
			while ($this->headPosition < $this->headMin)
				$this->headPosition += $this->dialSteps;
	}

	public function processInput(string $movementsFile): void
	{
		$movements = file($movementsFile);

		foreach ($movements as $movement)
			$this->rotateDial($movement);
	}

	public function showPassword(): void
	{
		echo "The password is: {$this->zeroes}" . PHP_EOL;
	}
}

// Main block
$safe = new Safe();
$safe->processInput(__DIR__ . '/input');
$safe->showPassword();
