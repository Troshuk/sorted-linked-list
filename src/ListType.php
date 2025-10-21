<?php

namespace DenysTroshuk\SortedLinkedList;

/**
 * Enum ListType
 *
 * Represents the type of values that a SortedLinkedList can hold.
 */
enum ListType: string
{
    case INT = 'int';
    case STRING = 'string';
}
