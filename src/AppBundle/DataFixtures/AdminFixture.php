<?php
/**
 * Created by PhpStorm.
 * User: harmakit
 * Date: 12/11/2018
 * Time: 20:34
 */

namespace AppBundle\DataFixtures;


use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AdminFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setEmail('admin@mail.com');
        $admin->setPassword('$2y$15$s68uzoKq.O6Ou2pbZMLgaOZTJcOtoVwxZtWiUE7zK1E6V9OW.F5py');
        $admin->setSecurityRoles([
            'ROLE_ADMIN'
        ]);

        $manager->persist($admin);
        $manager->flush();
    }
}