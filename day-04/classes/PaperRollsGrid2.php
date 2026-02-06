<?php

include 'PaperRollsGrid1.php';

/**
 * Grid of cells that contain (or not) a paper roll [day 4, part 2].
 *
 * Various paper rolls are arranged in this grid, with some grid cells empty. You need to find the number of rolls that
 * forklifts can access to optimize their work.
 *
 * Check the {@see ../puzzle.md} file for more details.
 *
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 */
class PaperRollsGrid2 extends PaperRollsGrid1
{
	/**
	 * Process all cells in the grid, row by row.
	 *
	 * This version of the method continuously scans the grid and remove "accesible" paper rolls, until no more paper
	 * rolls can be removed.
	 */
	protected function processRows(): void
	{
		for (;;)
		{
			parent::processRows();

			$noMoreRolls = $this->removePaperRolls();
			if ($noMoreRolls)
				break;

			echo "--- Still rolls to remove... ---" . PHP_EOL;
		}
	}

	/**
	 * Remove all paper rolls in cells marked as accessible.
	 */
	private function removePaperRolls(): bool
	{
		$noMoreRolls = true;

		foreach ($this->rows as $rowIndex => $row)
		{
			$this->rows[$rowIndex] = str_replace(self::ACCESIBLE_CELL, self::EMPTY_CELL, $row);

			$noMoreRolls &= !strcmp($this->rows[$rowIndex], $row);
		}

		return $noMoreRolls;
	}
}
