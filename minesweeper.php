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
        $this->totalCount = ($this->columns + 1) * $rows - 1;
    }

    public function parseMines()
    {
        $minesAsChars = str_split($this->mines);

        for ($i = 0; $i < $this->totalCount; $i++) {
            if ($minesAsChars[$i] === '*') {
                $columnsPlusOne = $this->columns + 1;
                $iPlusOneModuloColumns = ($i + 1) % $columnsPlusOne;

                if ($i === 0 || $iPlusOneModuloColumns === 1) {
                    $positions = [$i - $this->columns - 1, $i - $this->columns, $i + 1, $i + $this->columns + 1, $i + $this->columns + 2];
                } elseif ($i === $this->columns || $iPlusOneModuloColumns === $this->columns) {
                    $positions = [$i - $this->columns - 2, $i - $this->columns - 1, $i - 1, $i + $this->columns, $i + $this->columns + 1];
                } else {
                    $positions = [$i - $this->columns - 2, $i - $this->columns - 1, $i - $this->columns, $i - 1, $i + 1, $i + $this->columns, $i + $this->columns + 1, $i + $this->columns + 2];
                }

                foreach ($positions as $position) {
                    if ($position >= 0 && $position < $this->totalCount && $minesAsChars[$position] !== '*') {
                        if ($minesAsChars[$position] === '.') {
                            $minesAsChars[$position] = 1;
                        } else {
                            ++$minesAsChars[$position];
                        }
                    }
                }
            } elseif ($minesAsChars[$i] === '.') {
                $minesAsChars[$i] = 0;
            }
        }

        $this->map = $minesAsChars;

        return $this;
    }

    public function getMineMap(): string
    {
        $result = '';

        for ($i = 0; $i < $this->totalCount; $i++) {
            $result .= $this->map[$i];
        }

        return $result;
    }
}

$mines = "*....
.....
*....
.....";

$mineSweeper = new MineSweeper(5, 4, $mines);
$mineMap = $mineSweeper->parseMines()->getMineMap();

$expectedResult = "*1000
22000
*1000
11000";

if ($mineMap === $expectedResult) {
    echo 'test 1 passed';
}

echo "\n\n";

$mines = "....*
.....
....*
.....";

$mineSweeper = new MineSweeper(5, 4, $mines);
$mineMap = $mineSweeper->parseMines()->getMineMap();

$expectedResult = "0001*
00022
0001*
00011";

if ($mineMap === $expectedResult) {
    echo 'test 2 passed';
}


echo "\n\n";

$mines = "*....
.....
.*...
.....";

$mineSweeper = new MineSweeper(5, 4, $mines);
$mineMap = $mineSweeper->parseMines()->getMineMap();

$expectedResult = "*1000
22100
1*100
11100";

if ($mineMap === $expectedResult) {
    echo 'test 3 passed';
}

echo "\n\n";

$mines = "*.....
......
.*....
......
.....*";

$mineSweeper = new MineSweeper(6, 5, $mines);
$mineMap = $mineSweeper->parseMines()->getMineMap();

$expectedResult = "*10000
221000
1*1000
111011
00001*";

if ($mineMap === $expectedResult) {
    echo 'test 4 passed';
}

echo "\n\n";

$mines = "*......
.......
.*.....
.......
.....*.
.......";

$mineSweeper = new MineSweeper(7, 6, $mines);
$mineMap = $mineSweeper->parseMines()->getMineMap();

$expectedResult = "*100000
2210000
1*10000
1110111
00001*1
0000111";

if ($mineMap === $expectedResult) {
    echo 'test 5 passed';
}