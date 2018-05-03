<?php


namespace App\PersistenceLayer;


use App\Entity\Trip;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class TripPersistenceLayer
{
    /**
     * @var ObjectManager
     */
    private $manager;
    /**
     * @var ObjectRepository
     */
    private $repository;

    public function _construct(ManagerRegistry $managerRegistry)
    {
        $this->manager = $managerRegistry->getManager();
        $this->repository = $managerRegistry->getRepository(Trip::class);
    }

    /**
     * @return \App\Entity\Trip[]
     */
    public function getAllTrips(): array
    {
        return $this->repository->findAll();
    }

    public function persist(Trip $trip): void
    {
        $this->manager->persist($trip);
        $this->manager->flush();
    }
}