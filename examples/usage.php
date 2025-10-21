<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use DenysTroshuk\SortedLinkedList\SortedLinkedList;
use DenysTroshuk\SortedLinkedList\ListType;

$intList = new SortedLinkedList(ListType::INT);

$intList
    ->add(5)
    ->add(3)
    ->add(9)
    ->add(1)
    ->add(5); // duplicate, ignored

$intList->remove(3);
$intList->pop();
$intList->shift();
$intList->clear();

$stringList = new SortedLinkedList(ListType::STRING);

$stringList
    ->add('banana')
    ->add('apple')
    ->add('cherry')
    ->add('banana'); // duplicate ignored

foreach ($stringList as $item) {
    if ($item === 'apple') {
        $stringList->add('date');
        $stringList->remove('apple');
        $stringList->clear();
    }
}
