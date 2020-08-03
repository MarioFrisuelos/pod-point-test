<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Charge;

class ChargeRepository extends ServiceEntityRepository
{
    /** @var EntityManagerInterface */
	private $manager;

    /**
     * @param  ManagerRegistry        $registry
     * @param  EntityManagerInterface $manager
     */
	public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Charge::class);
        $this->manager = $manager;
    }

    /**
     * @param  array $params
     */
    public function patchCharge(array $params)
    {
    	$chargeToPatch = $this->findOneBy([
            'id' => $params['chargeId']
        ]);
    	$chargeToPatch->setEnd($params['end']);
    	$this->manager->persist($chargeToPatch);
        $this->manager->flush();
    }

}
