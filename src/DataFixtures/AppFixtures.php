<?php

namespace App\DataFixtures;

use App\DataTransferObject\DummyDto;
use App\Entity\DummyEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $dto = new DummyDto();
        $dto->name = 'Parent Entity';
        $dto->age = 99;
        $dto->isBeautiful = true;
        $dto->links = [];

        $parentEntity = DummyEntity::createFromDto($dto);
        $manager->persist($parentEntity);

        $dto->name = 'Child Entity';
        $dto->age = 78;
        $dto->isBeautiful = false;
        $dto->links = [$parentEntity];

        $entity = DummyEntity::createFromDto($dto);
        $manager->persist($entity);

        $dto->name = 'Entity 2';
        $dto->age = 81;
        $dto->isBeautiful = true;
        $dto->links = [];

        $entity = DummyEntity::createFromDto($dto);
        $manager->persist($entity);

        $manager->flush();
    }
}
