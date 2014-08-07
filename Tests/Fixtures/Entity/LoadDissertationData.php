<?php

namespace N1c0\OfficialtextBundle\Tests\Fixtures\Entity;

use N1c0\OfficialtextBundle\Entity\Officialtext;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadOfficialtextData implements FixtureInterface
{
    static public $officialtexts = array();

    public function load(ObjectManager $manager)
    {
        $officialtext = new Officialtext();
        $officialtext->setTitle('title');
        $officialtext->setBody('body');

        $manager->persist($officialtext);
        $manager->flush();

        self::$officialtexts[] = $officialtext;
    }
}
