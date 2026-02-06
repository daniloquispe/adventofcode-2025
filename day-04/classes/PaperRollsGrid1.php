<?php

/**
 * Grid of cells that contain (or not) a paper roll [day 4, part 1].
 *
 * Various paper rolls are arranged in this grid, with some grid cells empty. You need to find the number of rolls that
 * forklifts can access to optimize their work.
 *
 * Check the {@see ../puzzle.md} file for more details.
 *
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 */
class PaperRollsGrid1
{
	/**
	 * Character that represents an empty cell.
	 */
	const string EMPTY_CELL = '.';

	/**
	 * Character that represents a cell with a paper roll.
	 */
	const string PAPER_ROLL = '@';

	/**
	 * Character that represents an accesible cell.
	 */
	const string ACCESIBLE_CELL = 'x';

	/**
	 * Grid of cells that contain (or not) a paper roll
	 *
	 * @var string[]
	 */
	protected array $rows;

	/**
	 * Number of rows in the grid
	 */
	private int $rowsCount;

	/**
	 * Number of columns in the grid
	 */
	private int $columnsCount;

	/**
	 * Number of cells that can be accessed by the forklift
	 */
	private int $accesibleRollsCount;

	/**
	 * Load the grid configuration from a text file and find how many accesible cells are.
	 *
	 * @see isAccessible()
	 */
	public function findAccesibleRollsCountFromFile(string $filename): void
	{
		$this->accesibleRollsCount = 0;

		echo "Processing file $filename..." . PHP_EOL;
		$this->rows = file($filename);
		$this->rowsCount = count($this->rows);

		// Sanitize input
		foreach ($this->rows as $i => $row)
			$this->rows[$i] = trim($row);

		$this->processRows();

		echo "Forklift can access to {$this->accesibleRollsCount} paper rolls." . PHP_EOL;
	}

	/**
	 * Process all cells in the grid, row by row.
	 */
	protected function processRows(): void
	{
		for ($rowIndex = 0; $rowIndex < $this->rowsCount; $rowIndex++)
		{
			if (!isset($this->columnsCount))
				$this->columnsCount = strlen($this->rows[$rowIndex]);

			for ($columnIndex = 0; $columnIndex < $this->columnsCount; $columnIndex++)
			{
				if ($this->rows[$rowIndex][$columnIndex] == self::EMPTY_CELL)
					continue;  // No paper roll here

				// Mark cell as accessible?
				if ($this->isAccessible($rowIndex, $columnIndex))
				{
					$this->accesibleRollsCount++;
					$this->rows[$rowIndex][$columnIndex] = self::ACCESIBLE_CELL;
				}
			}

			echo $this->rows[$rowIndex] . PHP_EOL;
		}
	}

	/**
	 * Determine if a cell is accessible by the forklift.
	 *
	 * A cell is accessible if it has less than 4 adjacent cells with paper rolls.
	 */
	private function isAccessible(int $rowIndex, int $columnIndex): bool
	{
		$adjacentCells = [];

		$cellsWithPaperRoll = 0;

		$aboveRowIndex = $rowIndex - 1;
		$belowRowIndex = $rowIndex + 1;
		$leftColumnIndex = $columnIndex - 1;
		$rightColumnIndex = $columnIndex + 1;

		// Above row
		if ($aboveRowIndex >= 0)
		{
			if ($leftColumnIndex >= 0)
				$adjacentCells[] = $this->rows[$aboveRowIndex][$leftColumnIndex];

			$adjacentCells[] = $this->rows[$aboveRowIndex][$columnIndex];

			if ($rightColumnIndex < $this->columnsCount)
				$adjacentCells[] = $this->rows[$aboveRowIndex][$rightColumnIndex];
		}

		// Current row
		if ($leftColumnIndex >= 0)
			$adjacentCells[] = $this->rows[$rowIndex][$leftColumnIndex];
		if ($rightColumnIndex < $this->columnsCount)
			$adjacentCells[] = $this->rows[$rowIndex][$rightColumnIndex];

		// Below row
		if ($belowRowIndex < $this->rowsCount)
		{
			if ($leftColumnIndex >= 0)
				$adjacentCells[] = $this->rows[$belowRowIndex][$leftColumnIndex];

			$adjacentCells[] = $this->rows[$belowRowIndex][$columnIndex];

			if ($rightColumnIndex < $this->columnsCount)
				$adjacentCells[] = $this->rows[$belowRowIndex][$rightColumnIndex];
		}

		// Paper rolls in adjacent cells?
		foreach ($adjacentCells as $adjacentCell)
			if ($adjacentCell == self::PAPER_ROLL || $adjacentCell == self::ACCESIBLE_CELL)
				$cellsWithPaperRoll++;

		return $cellsWithPaperRoll < 4;
	}
}
