<?php
declare(strict_types=1);

namespace App\Fixture;

use App\Entity\Crew;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CrewFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $jeanLuc = new Crew();
        $jeanLuc->setFullname('Jean Luc Picard');
        $manager->persist($jeanLuc);
        $manager->flush();

        $william = new Crew();
        $william->setFullname('William Riker');
        $william->setParent($jeanLuc);
        $manager->persist($william);
        $manager->flush();

        $deana = new Crew();
        $deana->setFullname('Deana Troi');
        $deana->setParent($jeanLuc);
        $manager->persist($deana);
        $manager->flush();

        $jordi = new Crew();
        $jordi->setFullname('Jordi La Forge');
        $jordi->setParent($jeanLuc);
        $manager->persist($jordi);
        $manager->flush();

        $data = new Crew();
        $data->setFullname('Mr.Data');
        $data->setParent($jordi);
        $manager->persist($data);
        $manager->flush();

        $miles = new Crew();
        $miles->setFullname('Miles O\'Brien');
        $miles->setParent($jordi);
        $manager->persist($miles);
        $manager->flush();

        $worf = new Crew();
        $worf->setFullname('Worf son of Mog');
        $worf->setParent($william);
        $manager->persist($worf);

        $guinan = new Crew();
        $guinan->setFullname('Guinan');
        $guinan->setParent($william);
        $manager->persist($guinan);

        $beverly = new Crew();
        $beverly->setFullname('Beverly Crusher');
        $beverly->setParent($william);
        $manager->persist($beverly);

        $lwaxana = new Crew();
        $lwaxana->setFullname('Lwaxana Troi');
        $lwaxana->setParent($deana);
        $manager->persist($lwaxana);

        $reginald = new Crew();
        $reginald->setFullname('Reginald Barkley');
        $reginald->setParent($deana);
        $manager->persist($reginald);

        $tasha = new Crew();
        $tasha->setFullname('Tasha Yar');
        $tasha->setParent($worf);
        $manager->persist($tasha);

        $kehleyr = new Crew();
        $kehleyr->setFullname("K'Ehleyr");
        $kehleyr->setParent($worf);
        $manager->persist($kehleyr);

        $wesley = new Crew();
        $wesley->setFullname('Wesley Crusher');
        $wesley->setParent($beverly);
        $manager->persist($wesley);

        $alyssa = new Crew();
        $alyssa->setFullname('Alyssa Ogawa');
        $alyssa->setParent($beverly);
        $manager->persist($alyssa);

        $alexander = new Crew();
        $alexander->setFullname('Alexander Rozhenko');
        $alexander->setParent($kehleyr);
        $manager->persist($alexander);

        $julian = new Crew();
        $julian->setFullname('Julian Bashir');
        $julian->setParent($alyssa);
        $manager->persist($julian);

        $manager->flush();
    }
}
