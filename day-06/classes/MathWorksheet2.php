<?php

include 'MathWorksheet1.php';

/**
 * Math worksheet for cephalopods [day 6, part 2].
 *
 * This worksheet contains a list of arithmetic problems, each one with a different operator (+ or *). To solve the
 * worksheet, you need to:
 *
 * 1. Solve each problem separately;
 * 2. Sum the "grand total" of all solved problems.
 *
 * Check the {@see ../puzzle.md} file for more details.
 *
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 */
class MathWorksheet2 extends MathWorksheet1
{
	/**
	 * Calculate the grand total from a list of text lines.
	 *
	 * This new version apples cephalopod's math rules when reading the worksheet: It's read from right to left, and
	 * each problem numeric parameter is written in columns. Check the {@see ../puzzle.md} file for more details.
	 *
	 * @param string[] $lines
	 * @see calculateGrandTotalFromFile()
	 */
	protected function calculateGrandTotalFromStrings(array $lines): int
	{
		// Sanitize input
		$lines = array_map('rtrim', $lines);

		// Find the longest line length
		$maxLineLength = max(array_map('strlen', $lines));

		foreach ($lines as $i => $line)
		{
			// The same length for all lines
			if (strlen($line) != $maxLineLength)
				$lines[$i] = $line . str_repeat(' ', $maxLineLength - strlen($line));
		}

		$problems = [];
		$problemIndex = 0;

		// Scan lines and extract tokens
		for ($columnIndex = $maxLineLength - 1; $columnIndex >= 0; $columnIndex--)
		{
			$number = '';
			$problemParsing = true;

			foreach ($lines as $line)
			{
				$char = $line[$columnIndex];

				// Operator? Problem information complete
				if ($char == '+' || $char == '*')
				{
					$problems[$problemIndex][] = intval($number);
					$problems[$problemIndex][] = $char;  // Operator

					$problemParsing = false;
					$problemIndex++;

					// Next-column characters are all spaces only, no need to parse
					$columnIndex--;
				}
				else
					$number .= $char;
			}

			if ($problemParsing)
				$problems[$problemIndex][] = intval($number);
		}

		$grandTotal = 0;

		foreach ($problems as $problem)
			$grandTotal += $this->solve($problem);

		return $grandTotal;
	}
}
