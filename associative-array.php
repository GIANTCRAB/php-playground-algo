<?php

class AssociativeArray
{
    private array $keys;
    private array $values;
    private int $size;

    public function __construct()
    {
    }

    public function getKeyValue(string $key): string
    {
        $keyIndex = $this->getKeyIndex($key);
        if ($keyIndex === -1) {
            // Does not exists
            return null;
        }

        return $this->getValue($keyIndex);
    }

    public function setKeyValue(string $key, string $value): void
    {
        $keyIndex = $this->getKeyIndex($key);
        if ($keyIndex === -1) {
            // Does not exists, do insertion
            $this->insertPair($key, $value);
        } else {
            $this->setValue($keyIndex, $value);
        }
    }

    public function setKey(int $index, string $key): void
    {
        $this->keys[$index] = $key;
    }

    public function getValue(int $index): string
    {
        return $this->values[$index];
    }

    public function setValue(int $index, string $value): void
    {
        $this->values[$index] = $value;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    private function getKeyIndex(string $key): int
    {
        foreach ($this->keys as $keyIndex => $keyValue) {
            if ($keyValue === $key) {
                return $keyIndex;
            }
        }

        return -1;
    }

    private function insertPair(string $key, string $value): int
    {
        $currentSize = $this->getSize();
        $this->setKey($currentSize, $key);
        $this->setValue($currentSize, $value);
        $newSize = $currentSize + 1;
        $this->setSize($newSize);

        return $currentSize;
    }
}