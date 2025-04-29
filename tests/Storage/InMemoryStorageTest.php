<?php

namespace Storage;

use PHPUnit\Framework\TestCase;
use Recommender\Storage\InMemoryStorage;

class InMemoryStorageTest extends TestCase
{
    public function testAddInteraction(): void
    {
        $storage = new InMemoryStorage();
        $storage->addInteraction(1, 10);
        $storage->addInteraction(1, 12);
        $storage->addInteraction(2, 10);

        $this->assertContains(10, $storage->getItemsByUser(1));
        $this->assertContains(12, $storage->getItemsByUser(1));
        $this->assertContains(10, $storage->getItemsByUser(2));
    }

    public function testGetItemsByUser()
    {
        $storage = new InMemoryStorage();
        $storage->addInteraction(1, 10);
        $storage->addInteraction(1, 12);
        $storage->addInteraction(2, 10);

        $items = $storage->getItemsByUser(1);
        $this->assertCount(2, $items);
        $this->assertContains(10, $items);
        $this->assertContains(12, $items);
    }

    public function testGetUsersByItem()
    {
        $storage = new InMemoryStorage();
        $storage->addInteraction(1, 10);
        $storage->addInteraction(1, 12);
        $storage->addInteraction(2, 10);

        $users = $storage->getUsersByItem(10);
        $this->assertCount(2, $users);
        $this->assertContains(1, $users);
        $this->assertContains(2, $users);

        $users = $storage->getUsersByItem(12);
        $this->assertCount(1, $users);
        $this->assertContains(1, $users);

        $users = $storage->getUsersByItem(99);
        $this->assertCount(0, $users);
    }
}
