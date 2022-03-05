<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurFixtures extends Fixture
{

    /** @var UserPasswordHasherInterface */
    private $encoder;


    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);



        $user = new Utilisateur();
        $user->setEmail('user@ex.com')
            ->setPassword($this->encoder->hashPassword($user, 'user'))
            ->setPseudo('user');
        $manager->persist($user);

        $user2 = new Utilisateur();
        $user2->setEmail('user2@ex.com')
            ->setPassword($this->encoder->hashPassword($user2, 'user2'))
            ->setPseudo('user2');
        $manager->persist($user2);

        $admin = new Utilisateur();
        $admin
            ->setEmail('admin@ex.com')
            ->setPassword($this->encoder->hashPassword($admin, 'admin'))
            ->setRoles(['ROLE_ADMIN', 'ROLE_USER'])
            ->setPseudo('admin');
        $manager->persist($admin);


        //permet de passer cette fixture à une autre fixture
        $this->addReference('admin', $admin);
        $this->addReference('user', $user);
        $this->addReference('user2', $user2);


        $manager->flush();
    }
}
