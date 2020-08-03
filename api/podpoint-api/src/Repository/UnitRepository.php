<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Unit;
use App\Entity\Charge;

class UnitRepository extends ServiceEntityRepository
{
	/** @var EntityManagerInterface */
	private $manager;

	/**
     * @param  ManagerRegistry 		  $registry
     * @param  EntityManagerInterface $manager
     */
	public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Unit::class);
        $this->manager = $manager;
    }

    /**
     * @param  array $params
     *
     * @return int
     */
    public function createnewUnit(array $params): int
    {
		$newUnit = new Unit();    	
		$newUnit->setAddress($params['address']);
		$newUnit->setPostcode($params['postcode']);
		$newUnit->setName($params['name']);
		$newUnit->setStatus($params['status']);

		$newCharge = new Charge();
		$newCharge->setStart($params['start']);
		$newCharge->setEnd($params['end']);
		$newCharge->setUnit($newUnit);

        $this->manager->persist($newCharge);

        $this->manager->flush();

        return $newUnit->getId();
    }

    /**
     * @param  array $params
     */
    public function patchUnit(array $params)
    {
        $unitToPatch = $this->findOneBy([
            'id' => $params['unitId']
        ]);
        $unitToPatch->setStatus($params['status']);
        $this->manager->persist($unitToPatch);

        $this->manager->flush();
    }
}