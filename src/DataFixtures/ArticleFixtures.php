<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        //Créer 3catégories fake
        for ($j = 1; $j <= 3; $j++){
            $category = new Category();
            $category->setTitle($faker->sentence())
                     ->setDescription($faker->paragraph());

                     $manager->persist($category);

                     //Créer des articles
                     for($i=1;$i<=mt_rand(4, 6);$i++){
                        $article = new article();

                        $content = '<p>' .join($faker->paragraphs(5), '</p><p>') .'</p>'; 

                        $article->setTitle($faker->sentence())
                                ->setContent($content)
                                ->setImage($faker->imageUrl())
                                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                                ->setCategory($category);

                        $manager->persist($article);
                        
                        //Ajout de commentaire
                        for($k = 1;$k <= mt_rand(4, 10);$k++){
                            $comment = new Comment();

                            $content = '<p>' .join($faker->paragraphs(2), '</p><p>') .'</p>';

                            $days = (new \DateTime())->diff($article->getCreatedAt())->days;

                            $comment->setAuthor($faker->name)
                                    ->setContent($content)
                                    ->setCreatedAt($faker->dateTimeBetween('-' .$days . 'days'))
                                    ->setArticle($article);

                            $manager->persist($comment);
                        }
            
                    }
        }

        $manager->flush();
    }
}
