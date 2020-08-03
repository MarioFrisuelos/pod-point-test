<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Unit;
use App\Entity\Charge;

class PodpointapiFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    	$statusAllowed = ['available', 'charging'];
    	for ($u=1; $u <= 20 ; $u++) {
    		# New Fake Unit
			$newUnit = new Unit();    	
			$newUnit->setAddress("Fake address number: ".$u);
			$newUnit->setPostcode("Fake postcode number: ".$u);
			$newUnit->setName("Fake name number: ".$u);
			$status = array_rand($statusAllowed, 1);
			$newUnit->setStatus($statusAllowed[$status]);
			# New Fake Charge1
			$newCharge1 = new Charge();
			$newCharge1->setStart(new \DateTime());
			$newCharge1->setEnd(new \DateTime());
			$newCharge1->setUnit($newUnit);
			$manager->persist($newCharge1);
			# New Fake Charge2
			$newCharge2 = new Charge();
			$newCharge2->setStart(new \DateTime());
			$newCharge2->setEnd(new \DateTime());
			$newCharge2->setUnit($newUnit);
			$manager->persist($newCharge2);
    	}

        $manager->flush();
    }
}
