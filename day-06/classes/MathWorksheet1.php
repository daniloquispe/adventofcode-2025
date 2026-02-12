<?php

/**
 * Math worksheet for cephalopods [day 6, part 1].
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
class MathWorksheet1
{
	/**
	 * Load the worksheet data from a text file and calculate the grand total.
	 */
	public function calculateGrandTotalFromFile(string $filename): void
	{
		echo "Processing file $filename..." . PHP_EOL;
		$lines = file($filename);

		$grandTotal = $this->calculateGrandTotalFromStrings($lines);

		echo "The grand total is: {$grandTotal}" . PHP_EOL;
	}

	/**
	 * Calculate the grand total from a list of text lines.
	 *
	 * @param string[] $lines
	 * @see calculateGrandTotalFromFile()
	 */
	protected function calculateGrandTotalFromStrings(array $lines): int
	{
		$problems = [];

		$lastLineNumber = count($lines) - 1;

		for ($i = 0; $i <= $lastLineNumber; $i++)
		{
			$lineTokens = $this->getTokens($lines[$i]);

			foreach ($lineTokens as $problemNumber => $token)
			{
				$problems[$problemNumber][] = $i < $lastLineNumber
					? (int)$token
					: $token;
			}
		}

		$grandTotal = 0;

		foreach ($problems as $problem)
			$grandTotal += $this->solve($problem);

		return $grandTotal;
	}

	/**
	 * Extract the tokens from a text line.
	 *
	 * A token can be an integer number or an operator (+ or *). Text line can contain a list of tokens (one per
	 * problem), separated by a variable number of spaces.
	 *
	 * **Warning:** This method doesn't perform any string-to-integer typecast.
	 *
	 * @return string[] An array containing all separated tokens
	 */
	private function getTokens(string $text): array
	{
		return preg_split('/\s+/', trim($text), null, PREG_SPLIT_NO_EMPTY);
	}

	/**
	 * Solve a single math problem.
	 *
	 * A math problem is an array containing a list of numbers and an arithmetic operator (+ or *) as the array's last
	 * element.
	 *
	 * @return int|null The result of the arithmetic operation, or `null` if the operator is not supported
	 */
	protected function solve(array $problem): ?int
	{
		$operator = array_pop($problem);

		return match ($operator)
		{
			'+' => array_sum($problem),
			'*' => array_product($problem),
			default => null
		};
	}
}
