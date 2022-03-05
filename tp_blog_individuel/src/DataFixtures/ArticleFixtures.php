<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $article1 = new Article();
        $article1

            ->setTitre('Titre 1')
            ->setContenu('Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque a facilis cumque. Facere, facilis? Quam, doloribus soluta animi inventore aperiam officiis repellendus accusamus eum error illum a repudiandae accusantium exercitationem.')
            ->setDateCreation(new \DateTime())
            ->setAuteur($this->getReference('admin'));
        $manager->persist($article1);

        $article2 = new Article();
        $article2
            ->setTitre('Titre 2')
            ->setContenu('C\'est mon 2eme article')
            ->setDateCreation(new \DateTime())
            ->setAuteur($this->getReference('admin'));
        $manager->persist($article2);

        $article3 = new Article();
        $article3
            ->setTitre('Titre 3')
            ->setContenu('le fabuleux 3eme article')
            ->setDateCreation(new \DateTime())
            ->setAuteur($this->getReference('admin'));
        $manager->persist($article3);


        $article4 = new Article();
        $article4
            ->setTitre('Titre de l\'article du user')
            ->setContenu('Le premier article qui n\'est pas de Admin !!')
            ->setDateCreation(new \DateTime())
            ->setAuteur($this->getReference('user2'));
        $manager->persist($article4);

        $article5 = new Article();
        $article5

            ->setTitre('Titre 1')
            ->setContenu('Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque a facilis cumque. Facere, facilis? Quam, doloribus soluta animi inventore aperiam officiis repellendus accusamus eum error illum a repudiandae accusantium exercitationem.')
            ->setDateCreation(new \DateTime())
            ->setAuteur($this->getReference('admin'));
        $manager->persist($article5);


        $article6 = new Article();
        $article6

            ->setTitre('Titre 1')
            ->setContenu('Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque a facilis cumque. Facere, facilis? Quam, doloribus soluta animi inventore aperiam officiis repellendus accusamus eum error illum a repudiandae accusantium exercitationem.')
            ->setDateCreation(new \DateTime())
            ->setAuteur($this->getReference('user2'));
        $manager->persist($article6);

        $article7 = new Article();
        $article7

            ->setTitre('Titre 1')
            ->setContenu('Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque a facilis cumque. Facere, facilis? Quam, doloribus soluta animi inventore aperiam officiis repellendus accusamus eum error illum a repudiandae accusantium exercitationem.')
            ->setDateCreation(new \DateTime())
            ->setAuteur($this->getReference('user'));
        $manager->persist($article7);


        //permet de passer cette fixture à une autre fixture
        $this->addReference('article1', $article1);
        $this->addReference('article2', $article2);
        $this->addReference('article3', $article3);
        $this->addReference('article4', $article4);


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UtilisateurFixtures::class,
        ];
    }
}
