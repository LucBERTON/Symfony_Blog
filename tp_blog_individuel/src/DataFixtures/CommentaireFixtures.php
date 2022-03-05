<?php

namespace App\DataFixtures;

use App\Entity\Commentaire;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentaireFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


        $commentaire1 = new Commentaire();
        $commentaire1
            ->setContenu('articlorem pourripsum')
            ->setDateCreation(new \DateTime())
            ->setAuteur($this->getReference('admin'))
            ->setArticle($this->getReference('article1'))
            ->setValidation(true);
        $manager->persist($commentaire1);

        $commentaire2 = new Commentaire();
        $commentaire2
            ->setContenu('<3<3')
            ->setDateCreation(new \DateTime())
            ->setAuteur($this->getReference('admin'))
            ->setArticle($this->getReference('article1'))
            ->setValidation(true);
        $manager->persist($commentaire2);

        $commentaire3 = new Commentaire();
        $commentaire3
            ->setContenu('Pouce Bleu')
            ->setDateCreation(new \DateTime())
            ->setAuteur($this->getReference('user'))
            ->setArticle($this->getReference('article1'))
            ->setValidation(false);
        $manager->persist($commentaire3);

        $commentaire4 = new Commentaire();
        $commentaire4
            ->setContenu('first!')
            ->setDateCreation(new \DateTime())
            ->setAuteur($this->getReference('user2'))
            ->setArticle($this->getReference('article3'))
            ->setValidation(true);
        $manager->persist($commentaire4);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ArticleFixtures::class,
        ];
    }
}
