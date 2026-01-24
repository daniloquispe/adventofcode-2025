<?php

include 'Safe1.php';

/**
 * Safe next to the secret entrance door [day 1, part 2].
 *
 * This safe keeps the password to open the door. The password is locked, so you need a concrete list of dial rotations
 * to unlock it.
 *
 * Check the {@see ../puzzle.md} file for more details.
 *
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 */
class Safe2 extends Safe1
{
	/**
	 * Unlock the entrance door's password from a text file.
	 *
	 * The file contains a list of rotations to perform on the safe's dial, one per line.
	 *
	 * @uses $dialPosition Set the dial's starting position
	 * @uses $zeroes Initialize the counter for zeroes
	 * @uses processRotation()
	 * @see processRotation(), rotateDial()
	 */
	public function unlockPasswordFromFile(string $filename): void
	{
		$this->dialPosition = 50;
		echo "The dial starts by pointing at {$this->dialPosition}." . PHP_EOL;

		$lines = file($filename);
		echo "Processing file $filename..." . PHP_EOL;

		$this->zeroes = 0;

		foreach ($lines as $line)
			$this->processRotation($line);

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
	 * @uses  rotateDial()
	 */
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

	/**
	 * Perform a dial rotation using a direction and distance.
	 *
	 * @uses $dialPosition Check the dial's current position
	 * @uses $zeroes Update the counter if the dial passes over position 0 after the rotation
	 */
	private function rotateDial(string $direction, int $distance): void
	{
		$newPosition = $this->dialPosition;
		$zeroes = 0;

		while ($distance >= self::DIAL_POSITIONS_COUNT)
		{
			$distance -= self::DIAL_POSITIONS_COUNT;
			$zeroes++;
		}

		// Rotate right?
		if ($direction == 'R')
		{
			$newPosition = $this->dialPosition + $distance;

			if ($newPosition > self::DIAL_MAX)
			{
				$newPosition -= self::DIAL_POSITIONS_COUNT;

				if ($this->dialPosition != 0)
					$zeroes++;
			}
		}
		// Rotate left?
		elseif ($direction == 'L')
		{
			$newPosition = $this->dialPosition - $distance;

			if ($newPosition <= self::DIAL_MIN)
			{
				if ($newPosition < self::DIAL_MIN)
					$newPosition += self::DIAL_POSITIONS_COUNT;

				if ($this->dialPosition != 0)
					$zeroes++;
			}
		}

		$this->dialPosition = $newPosition;
		$this->zeroes += $zeroes;
	}
}
