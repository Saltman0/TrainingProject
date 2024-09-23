<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const string CATEGORY_REFERENCE = 'category';

    public function __construct(private readonly CategoryFactory $categoryFactory) {}

    public function load(ObjectManager $manager): void
    {
        $category = $this->categoryFactory->create("Test Category", []);
        $manager->persist($category);
        $manager->flush();

        $this->addReference(self::CATEGORY_REFERENCE, $category);
    }
}
