<?php

declare(strict_types=1);

namespace DenysTroshuk\SortedLinkedList;

use InvalidArgumentException;
use IteratorAggregate;
use Traversable;
use Countable;

/**
 * Class SortedLinkedList
 *
 * A sorted singly linked list that holds either int or string values (not both).
 * Maintains elements in ascending order at all times.
 *
 * @implements IteratorAggregate<int, int|string>
 */
final class SortedLinkedList implements IteratorAggregate, Countable
{
    private ?Node $head  = null;
    private int $count = 0;

    /**
     * SortedLinkedList constructor.
     *
     * @param ListType $type The type of items this list will hold (int or string).
     */
    public function __construct(private readonly ListType $type)
    {
    }

    /**
     * Add a value to the sorted linked list.
     * Duplicates are ignored; adding an existing value has no effect.
     *
     * @param int|string $value The value to add to the list.
     * @return $this
     */
    public function add(int|string $value): self
    {
        $this->validateType($value);
        $newNode = new Node($value);

        if ($this->head === null) {
            $this->head = $newNode;
        } elseif (($comparison = $this->compare($value, $this->head->getValue())) <= 0) {
            // Duplicate found, ignore
            if ($comparison === 0) {
                return $this;
            }

            $this->head = $newNode->setNext($this->head);
        } else {
            $current = $this->head;

            // Traverse the list to find the insertion point
            while ($next = $current->getNext()) {
                $comparison = $this->compare($next->getValue(), $value);

                // Duplicate found, ignore
                if ($comparison === 0) {
                    return $this;
                }

                if ($comparison > 0) {
                    // Found the spot — insert here
                    break;
                }

                $current = $next;
            }

            // Insert new node
            $current->setNext($newNode->setNext($next));
        }

        $this->count++;

        return $this;
    }

    /**
     * Remove a value from the sorted list.
     * If the value does not exist, the list remains unchanged.
     *
     * @param int|string $value The value to be removed from the list.
     * @return $this
     */
    public function remove(int|string $value): self
    {
        $this->validateType($value);

        $previous = null;
        $current  = $this->head;

        while ($current !== null) {
            // Node found
            if ($current->getValue() === $value) {
                if ($previous === null) {
                    $this->head = $current->getNext();
                } else {
                    $previous->setNext($current->getNext());
                }

                $this->count--;

                return $this;
            }

            $previous = $current;
            $current  = $current->getNext();
        }

        return $this;
    }

    /**
     * Remove all elements from the list.
     *
     * @return $this
     */
    public function clear(): self
    {
        $current = $this->head;
        while ($current !== null) {
            $next = $current->getNext();
            $current->setNext(null);
            $current = $next;
        }

        $this->head  = null;
        $this->count = 0;

        return $this;
    }

    /**
     * Remove and return the last element of the list.
     *
     * @return int|string|null Returns the last value, or null if the list is empty.
     */
    public function pop(): int|string|null
    {
        $previous = null;
        $current  = $this->head;

        if ($current === null) {
            return null;
        }

        // Traverse to the last node
        while ($current->getNext() !== null) {
            $previous = $current;
            $current  = $current->getNext();
        }

        if ($previous === null) {
            $this->head = null;
        } else {
            $previous->setNext(null);
        }

        $this->count--;

        return $current?->getValue();
    }

    /**
     * Remove the first element of the list.
     *
     * @return $this
     */
    public function shift(): self
    {
        if ($this->head !== null) {
            $this->head = $this->head->getNext();
            $this->count--;
        }

        return $this;
    }

    /**
     * Check if the list contains a specific value.
     *
     * @param int|string $value The value to search for in the list.
     * @return bool True if the value exists in the list, false otherwise.
     */
    public function contains(int|string $value): bool
    {
        $this->validateType($value);

        $current = $this->head;

        while ($current !== null) {
            if ($current->getValue() === $value) {
                return true;
            }

            $current = $current->getNext();
        }

        return false;
    }

    /**
     * Convert the linked list to an array.
     *
     * @return array<int, int|string> An array containing all values in the linked list.
     */
    public function toArray(): array
    {
        return iterator_to_array($this);
    }

    /**
     * Compare two values according to the list type.
     * Case-sensitive searching for strings.
     *
     * @param int|string $a
     * @param int|string $b
     * @return int Returns -1 if $a < $b, 0 if equal, 1 if $a > $b
     */
    private function compare(int|string $a, int|string $b): int
    {
        return $this->type === ListType::INT ? $a <=> $b : strcmp((string) $a, (string) $b);
    }

    /**
     * Validate that the value matches the list type.
     *
     * @param int|string $value
     * @throws InvalidArgumentException if the value type does not match the list type.
     */
    private function validateType(int|string $value): void
    {
        // Type safety check
        $valueType = is_int($value) ? ListType::INT : ListType::STRING;

        if ($this->type !== $valueType) {
            throw new InvalidArgumentException(
                "Value type {$valueType->value} does not match list type {$this->type->value}."
            );
        }
    }

    /**
     * Check if the list is empty.
     *
     * @return bool True if the list is empty, false otherwise.
     */
    public function isEmpty(): bool
    {
        return ! $this->count;
    }

    /**
     * Get the first element of the list.
     *
     * @return int|string|null The first element's value, or null if the list is empty.
     */
    public function first(): int|string|null
    {
        return $this->head?->getValue();
    }

    /**
     * Get the number of elements in the list.
     *
     * @return int The count of elements in the list.
     */
    public function count(): int
    {
        return $this->count;
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        $current = $this->head;

        while ($current !== null) {
            yield $current->getValue();
            $current = $current->getNext();
        }
    }
}
