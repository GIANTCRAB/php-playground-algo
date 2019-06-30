<?php

class LinkedNode
{
    /**
     * @var int $data
     */
    public $data;
    /**
     * @var LinkedNode $next
     */
    public $next;
}

class LinkedList
{
    /**
     * @var LinkedNode $firstNode
     */
    public $firstNode;
    /**
     * @var LinkedNode $lastNode
     */
    public $lastNode;
    /**
     * @var int $size
     */
    public $size;

    public function __construct($values, int $size)
    {
        $this->size = $size;
        /**
         * @var LinkedNode $previousNode
         */
        $previousNode = null;
        for ($i = 0; $i < $size; $i++) {
            $iPlusOne = $i + 1;


            $newNode = new LinkedNode();
            $newNode->data = (int) $values[$i];

            if ($previousNode) {
                $previousNode->next = $newNode;
            }

            if ($i === 0) {
                $this->firstNode = $newNode;
            }

            if ($iPlusOne === $size) {
                $this->lastNode = &$newNode;
            }

            $previousNode = $newNode;
        }
    }

    public function moveToFront(int $startPos, int $endPos): void
    {
        --$startPos;
        --$endPos;

        if ($startPos !== 0) {
            $currentNode = $this->firstNode;
            /** @var LinkedNode $previousNode */
            $previousNode = null;
            /** @var LinkedNode $startNode */
            $startNode = null;
            /** @var LinkedNode $startPreviousNode */
            $startPreviousNode = null;
            /** @var LinkedNode $endNode */
            $endNode = null;
            /** @var LinkedNode $endNextNode */
            $endNextNode = null;
            for ($i = 0; $i <= $endPos; $i++) {
                if ($currentNode === null) {
                    throw new Exception('lul');
                }

                if ($i === $startPos && $previousNode !== null) {
                    $startNode = $currentNode;
                    $startPreviousNode = $previousNode;
                }

                if ($i === $endPos) {
                    $endNode = $currentNode;
                    $endNextNode = $endNode->next;
                } else {
                    $previousNode = $currentNode;
                    $currentNode = $previousNode->next;
                }
            }

            if ($endPos === $this->size) {
                $this->lastNode = &$startPreviousNode;
                $startPreviousNode->next = null;
            } else {
                $startPreviousNode->next = $endNextNode;
            }
            $endNode->next = $this->firstNode;
            $this->firstNode = &$startNode;
        }
    }

    public function moveToBack(int $startPos, int $endPos): void
    {
        --$startPos;
        --$endPos;

        if ($endPos !== $this->size - 1) {
            $currentNode = $this->firstNode;
            /** @var LinkedNode $previousNode */
            $previousNode = null;
            /** @var LinkedNode $startNode */
            $startNode = null;
            /** @var LinkedNode $startPreviousNode */
            $startPreviousNode = null;
            /** @var LinkedNode $endNode */
            $endNode = null;
            /** @var LinkedNode $endNextNode */
            $endNextNode = null;
            for ($i = 0; $i <= $endPos; $i++) {
                if ($currentNode === null) {
                    throw new Exception('lul');
                }

                if ($i === $startPos) {
                    $startNode = $currentNode;
                    if ($previousNode !== null) {
                        $startPreviousNode = $previousNode;
                    }
                }

                if ($i === $endPos) {
                    $endNode = $currentNode;
                    $endNextNode = $endNode->next;
                } else {
                    $previousNode = $currentNode;
                    $currentNode = $previousNode->next;
                }
            }

            if ($startPreviousNode) {
                $startPreviousNode->next = &$endNextNode;
            } else {
                $this->firstNode = &$endNextNode;
            }

            $endNode->next = null;
            $this->lastNode->next = &$startNode;
            $this->lastNode = &$endNode;
        }
    }

    public function firstMinusLast(): int
    {
        return abs($this->firstNode->data - $this->lastNode->data);
    }

    public function toString(): string
    {
        $result = '';
        $maxSize = $this->size;
        $currentNode = $this->firstNode;
        for ($i = 0; $i < $maxSize; $i++) {
            $result .= $currentNode->data;
            if ($i + 1 !== $maxSize) {
                $result .= ' ';
            }
            $currentNode = $currentNode->next;
        }

        return $result;
    }
}

function parseInput()
{
    $_fp = fopen('php://stdin', 'rb');
    /* Enter your code here. Read input from STDIN. Print output to STDOUT */

    $stream = stream_get_contents($_fp);

    fclose($_fp);

    $parsedStream = explode("\n", $stream);

    $lineOne = $parsedStream[0];
    [$n, $m] = explode(' ', $lineOne);
    $lineTwo = $parsedStream[1];
    $values = explode(' ', $lineTwo);

    $maxLines = $m + 2;

    $linkedList = new LinkedList($values, $n);

    for ($i = 2; $i < $maxLines; $i++) {
        $currentLine = $parsedStream[$i];
        [$type, $startPos, $endPos] = explode(' ', $currentLine);

        if ($type === '1') {
            $linkedList->moveToFront($startPos, $endPos);
        } elseif ($type === '2') {
            $linkedList->moveToBack($startPos, $endPos);
        }
    }

    echo $linkedList->firstMinusLast() . "\n";
    echo $linkedList->toString();
}

parseInput();