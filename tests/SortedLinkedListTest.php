<?php

declare(strict_types=1);

namespace DenysTroshuk\SortedLinkedList\Tests;

use DenysTroshuk\SortedLinkedList\SortedLinkedList;
use DenysTroshuk\SortedLinkedList\ListType;
use PHPUnit\Framework\TestCase;

final class SortedLinkedListTest extends TestCase
{
    public function testIntegerList(): void
    {
        $list = new SortedLinkedList(ListType::INT);
        $list->add(5)->add(2)->add(7)->add(5); // duplicate ignored

        $this->assertSame([2,5,7], $list->toArray());
        $this->assertTrue($list->contains(5));
        $this->assertFalse($list->contains(3));
        $this->assertSame(3, $list->count());
    }

    public function testStringList(): void
    {
        $list = new SortedLinkedList(ListType::STRING);
        $list->add('banana')->add('apple')->add('cherry');

        $this->assertSame(['apple','banana','cherry'], $list->toArray());
        $this->assertTrue($list->contains('banana'));
        $this->assertFalse($list->contains('date'));
    }


    public function testRemoveFromList(): void
    {
        $list = new SortedLinkedList(ListType::INT);
        $list->add(1)->add(2)->add(3);

        $this->assertTrue($list->contains(1));
        $list->remove(1); // head
        $this->assertFalse($list->contains(1));
        $list->remove(3); // tail
        $this->assertFalse($list->contains(3));
        $this->assertSame([2], $list->toArray());
    }

    public function testPop(): void
    {
        $list = new SortedLinkedList(ListType::INT);
        $list->add(1)->add(2)->add(3);

        $last = $list->pop();
        $this->assertSame(3, $last);
        $this->assertSame([1,2], $list->toArray());
    }

    public function testShift(): void
    {
        $list = new SortedLinkedList(ListType::INT);
        $list->add(1)->add(2)->add(3);

        $list->shift();
        $this->assertSame([2,3], $list->toArray());
    }


    public function testTypeSafety(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $list = new SortedLinkedList(ListType::INT);
        $list->add('string'); // should throw
    }
}
