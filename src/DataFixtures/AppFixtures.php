<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Post;
use App\Factory\CategoryFactory;
use App\Factory\ContactFactory;
use App\Factory\PostFactory;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        // for($i=0; $i<10; $i++){
        // $post = new Post;
        // $post->setTitre('Test 1'.($i+1));
        // $post->setDescription('test texte de description 1'.$i .'qui vient de Fixture');
        // $post->setCreatedAt(new DateTime());
        // $manager->persist($post);
        // }

        // $manager->flush();

        CategoryFactory::createMany(5);

        PostFactory::createMany(10,
        function() { // note the callback - this ensures that each of the 5 comments has a different Post
            return ['category' => CategoryFactory::random()]; // each comment set to a random Post from those already in the database
        });

        ContactFactory::createMany(5);

    }
}
