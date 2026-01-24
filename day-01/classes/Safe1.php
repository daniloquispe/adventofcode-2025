<?php

/**
 * Safe next to the secret entrance to the North Pole [day 1, part 1].
 *
 * This safe keeps the password to open the door. The password is locked, so you need a concrete list of dial rotations
 * to unlock it.
 *
 * Check the {@see ../puzzle.md} file for more details.
 *
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 */
class Safe1
{
	/**
	 * Dial's min position
	 */
	const DIAL_MIN = 0;

	/**
	 * Dial's max position
	 */
	const DIAL_MAX = 99;

	/**
	 * Dial positons count.
	 *
	 * Value is obtained from:
	 *
	 *     DIAL_MAX - DIAL_MIN + 1
	 *
	 * @see DIAL_MIN, DIAL_MAX
	 */
	const DIAL_POSITIONS_COUNT = 100;

	/**
	 * Current dial position (from {@see DIAL_MIN} to {@see DIAL_MAX})
	 */
	protected int $dialPosition;

	/**
	 * Counter for found zeroes in rotations
	 */
	protected int $zeroes;

	/**
	 * Unlock the entrance door's password from a text file.
	 *
	 * The file contains a list of rotations to perform on the safe's dial, one per line.
	 *
	 * @uses $dialPosition Initialize the dial starting position
	 * @uses $zeroes Initialize the counter for zeroes
	 * @uses rotateDial()
	 * @see rotateDial()
	 */
	public function unlockPasswordFromFile(string $filename): void
	{
		$this->dialPosition = 50;
		echo "The dial starts by pointing at {$this->dialPosition}." . PHP_EOL;

		$lines = file($filename);
		echo "Processing file $filename..." . PHP_EOL;

		$this->zeroes = 0;

		foreach ($lines as $line)
			$this->rotateDial($line);

		echo "The password is: {$this->zeroes}" . PHP_EOL;
	}

	/**
	 * Process a single dial rotation.
	 *
	 * Rotation syntax is:
	 *
	 * - The first character is the rotation direction (L = rotate left, R = rotate right)
	 * - The rest of characters are the distance (in steps) to rotate
	 *
	 * Examples:
	 *
	 * - `L68` = rotate left 68 steps
	 * - `R27` = rotate right 27 steps
	 *
	 * @uses $dialPosition Update the dial position
	 * @uses checkIfZero() Verify if the dial is at position 0 after the rotation
	 */
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

		$this->checkIfZero();

		echo "- The dial is rotated $rotation to point at {$this->dialPosition}." . PHP_EOL;
	}

	/**
	 * Check if the dial is at position 0 after a rotation.
	 *
	 * @uses $dialPosition Check the dial's current position
	 * @uses $zeroes Update the counter if the dial is at position 0
	 */
	private function checkIfZero(): void
	{
		// Dial out of bounds?
		if ($this->dialPosition > self::DIAL_MAX)
			while ($this->dialPosition > self::DIAL_MAX)
				$this->dialPosition -= self::DIAL_POSITIONS_COUNT;
		elseif ($this->dialPosition < self::DIAL_MIN)
			while ($this->dialPosition < self::DIAL_MIN)
				$this->dialPosition += self::DIAL_POSITIONS_COUNT;

		// Dial at Zero?
		if ($this->dialPosition == 0)
			$this->zeroes++;
	}
}
