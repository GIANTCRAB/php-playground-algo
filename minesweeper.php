<?php

class MineSweeper
{
    private $mines;
    private $map = [];
    private $columns;
    private $totalCount;

    public function __construct(int $columns, int $rows, string $mines)
    {
        $this->columns = $columns;
        $this->mines = $mines;
        $this->totalCount = $this->columns * $rows;
    }

    public function parseMines()
    {
        $minesWithoutNewlines = str_replace(["\n\r", "\n", "\r"], '', $this->mines);
        $minesWithZero = str_replace('.', 0, $minesWithoutNewlines);
        $minesAsChars = str_split($minesWithZero);

        for ($i = 0; $i < $this->totalCount; $i++) {
            if ($minesAsChars[$i] === '*') {
                $iPlusOneModuloColumns = ($i + 1) % $this->columns;

                if ($i === 0 || $iPlusOneModuloColumns === 1) {
                    $positions = [$i - 5, $i - 4, $i + 1, $i + 5, $i + 6];
                } elseif($i === $this->totalCount - 1 || $iPlusOneModuloColumns === 0) {
                    $positions = [$i - 6, $i - 5, $i - 1, $i + 4, $i + 5];
                } else {
                    $positions = [$i - 6, $i - 5, $i - 4, $i -1, $i + 1, $i + 4, $i + 5, $i + 6];
                }

                foreach ($positions as $position) {
                    if ($position >= 0 && $position < $this->totalCount && $minesAsChars[$position] !== '*') {
                        $minesAsChars[$position] = (int) $minesAsChars[$position] + 1;
                    }
                }
            }
        }

        $this->map = $minesAsChars;

        return $this;
    }

    public function printMineMap()
    {
        for($i = 0; $i < $this->totalCount; $i++) {
            if($i !== 0 && $i % $this->columns === 0) {
                echo "\n";
            }
            echo $this->map[$i];
        }
    }
}

$mines = "*....
.....
*....
.....";

$mineSweeper = new MineSweeper(5, 4, $mines);
$mineSweeper->parseMines()
    ->printMineMap();

echo "\n\n";

$mines = "....*
.....
....*
.....";

$mineSweeper = new MineSweeper(5, 4, $mines);
$mineSweeper->parseMines()
    ->printMineMap();

echo "\n\n";

$mines = "*....
.....
.*...
.....";

$mineSweeper = new MineSweeper(5, 4, $mines);
$mineSweeper->parseMines()
    ->printMineMap();