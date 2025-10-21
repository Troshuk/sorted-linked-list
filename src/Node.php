<?php

namespace DenysTroshuk\SortedLinkedList;

/**
 * Class Node
 *
 * Represents a single element in a sorted linked list.
 * Holds a value and references to the next node.
 *
 * @internal
 */
final class Node
{
    /**
     * Node constructor.
     *
     * @param int|string $value The value stored in this node.
     * @param Node|null $next Reference to the next node in the list, or null if this is the tail.
     */
    public function __construct(
        private int|string $value,
        private ?Node $next = null
    ) {
    }

    /**
     * Get the value stored in this node.
     *
     * @return int|string The value of the node.
     */
    public function getValue(): int|string
    {
        return $this->value;
    }

    /**
     * Set the value stored in this node.
     *
     * @param int|string $value The new value for the node.
     * @return Node
     */
    public function setValue(int|string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the next node in the list.
     * @return Node|null The next node, or null if this is the tail.
     */
    public function getNext(): ?Node
    {
        return $this->next;
    }

    /**
     * Set the next node in the list.
     *
     * @param Node|null $next The new next node, or null if it's the end of the list.
     * @return Node
     */
    public function setNext(?Node $next): self
    {
        $this->next = $next;

        return $this;
    }
}
